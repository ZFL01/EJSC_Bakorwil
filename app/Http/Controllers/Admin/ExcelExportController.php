<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mentor;
use App\Models\Talent;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExcelExportController extends Controller
{
    public function index()
    {
        $currentYear = now()->year;
        $years = [];
        // Rentang 6 tahun terakhir (auto-update bersama waktu) agar dropdown
        // tetap pendek dan selalu mengandung tahun yang ada data.
        for ($y = $currentYear; $y >= $currentYear - 5; $y--) {
            $years[] = $y;
        }

        return view('admin.excel-export', compact('currentYear', 'years'));
    }

    public function preview(Request $request)
    {
        $year = $request->input('tahun', now()->year);

        // Get projects for the year
        $projects = DB::table('project')
            ->where('tahun', (int)$year)
            ->get();

        $rows = [];
        $totalMentors = 0;
        $totalTalentas = 0;
        $totalClients = 0;

        foreach ($projects as $project) {
            $mentors = DB::table('project_mentor')
                ->join('mentor', 'mentor.id_mentor', '=', 'project_mentor.id_mentor')
                ->where('project_mentor.id_project', $project->id_project)
                ->get();

            $talentas = DB::table('project_talenta')
                ->join('talenta', 'talenta.id_talenta', '=', 'project_talenta.id_talenta')
                ->where('project_talenta.id_project', $project->id_project)
                ->get();

            $clients = DB::table('project_client')
                ->join('client', 'client.id_client', '=', 'project_client.id_client')
                ->where('project_client.id_project', $project->id_project)
                ->get();

            $totalMentors += $mentors->count();
            $totalTalentas += $talentas->count();
            $totalClients += $clients->count();

            // Layout & pairing IDENTIEK aan het Sheet 1 Excel via blockRows() —
            // geen cartesiaans product meer (was mentor × talenta × UKM),
            // zodat het aantal preview-rijen gelijk is aan het aantal
            // geëxporteerde rijen (compare / vergelijking consistent).
            foreach ($this->blockRows($mentors, $talentas, $clients) as $b) {
                $mentor  = $b['mentor'];
                $talenta = $b['talenta'];
                $client  = $b['client'];
                $i       = $b['index'];

                $rows[] = [
                    'project_opd' => $project->opd ?? '',
                    'project_bidang' => $project->bidang ?? '',
                    'project_tanggal' => $project->tanggal ?? '',
                    'mentor_nama' => $mentor ? ($mentor->nama ?? '-') : '-',
                    'mentor_jk' => $mentor ? ($mentor->jenis_kelamin ?? '-') : '-',
                    'mentor_domisili' => $mentor ? ($mentor->domisili ?? '-') : '-',
                    'mentor_alamat' => $mentor ? ($mentor->alamat_lengkap ?? '-') : '-',
                    'mentor_no_wa' => $mentor ? ($mentor->no_wa ?? '-') : '-',
                    'talenta_nama' => $talenta ? ($talenta->nama ?? '-') : '-',
                    'talenta_jk' => $talenta ? ($talenta->jenis_kelamin ?? '-') : '-',
                    'talenta_domisili' => $talenta ? ($talenta->domisili ?? '-') : '-',
                    'talenta_alamat' => $talenta ? ($talenta->alamat_lengkap ?? '-') : '-',
                    'talenta_no_wa' => $talenta ? ($talenta->no_wa ?? '-') : '-',
                    'talenta_bidang_pekerjaan' => $talenta ? ($talenta->bidang_pekerjaan ?? '-') : '-',
                    'client_nama_ukm' => $client ? ($client->nama_ukm ?? '-') : '-',
                    'client_alamat_lengkap' => $client ? ($client->alamat_lengkap ?? '-') : '-',
                    'client_domisili' => $client ? ($client->domisili ?? '-') : '-',
                    'client_nama_produk' => $client ? ($client->nama_produk ?? '-') : '-',
                    'client_nama_pemilik' => $client ? ($client->nama_pemilik ?? '-') : '-',
                    'client_no_hp' => $client ? ($client->no_hp ?? '-') : '-',
                    // Extra velden die de blade (addRow) rechtstreeks gebruikt.
                    'kategori' => $i === 0 ? (($project->opd ?? '') . ' / ' . ($project->bidang ?? '')) : '',
                    'nama' => $talenta ? ($talenta->nama ?? '-') : ($mentor ? ($mentor->nama ?? '-') : ($client ? ($client->nama_ukm ?? '-') : '-')),
                    'jk' => $talenta ? ($talenta->jenis_kelamin ?? '-') : ($mentor ? ($mentor->jenis_kelamin ?? '-') : '-'),
                    'domisili' => $talenta ? ($talenta->domisili ?? '-') : ($mentor ? ($mentor->domisili ?? '-') : ($client ? ($client->domisili ?? '-') : '-')),
                    'alamat' => $talenta ? ($talenta->alamat_lengkap ?? '-') : ($mentor ? ($mentor->alamat_lengkap ?? '-') : ($client ? ($client->alamat_lengkap ?? '-') : '-')),
                    'noWa' => $talenta ? ($talenta->no_wa ?? '-') : ($mentor ? ($mentor->no_wa ?? '-') : ($client ? ($client->no_hp ?? '-') : '-')),
                    'status' => $i === 0 ? ($project->status ?? 'aktif') : '',
                ];
            }
        }

        return response()->json([
            'rows' => $rows,
            'mentors' => $totalMentors,
            'talents' => $totalTalentas,
            'clients' => $totalClients,
            'year' => $year,
        ]);
    }

    public function export(Request $request)
    {
        $year = $request->input('tahun', now()->year);

        return $this->generateCombinedExcel($year);
    }

    /**
     * Layout rekap voor één project-blok — EÉN bron, gebruikt door zowel de
     * preview als de Sheet 1 export, zodat het aantal rijen én de koppeling
     * mentor↔talenta↔UKM in de preview IDENTIEK zijn aan de gegenereerde
     * Excel (compare / vergelijking consistent).
     *
     * Template: per blok max(mentors, talentas, clients) rijen, met op elke
     * rij dezelfde index (mentor[i], talenta[i], client[i]); minimum 1 rij
     * zodat ook een leeg blok één rij met '—' oplevert in de sheet.
     */
    protected function blockRows($mentors, $talentas, $clients): array
    {
        $maxRows = max($mentors->count(), $talentas->count(), $clients->count(), 1);

        $rows = [];
        for ($i = 0; $i < $maxRows; $i++) {
            $rows[] = [
                'index'   => $i,
                'mentor'  => $mentors[$i] ?? null,
                'talenta' => $talentas[$i] ?? null,
                'client'  => $clients[$i] ?? null,
            ];
        }

        return $rows;
    }

        protected function generateCombinedExcel(string $year)
    {
        $filename = 'Data_Laporan_Bakorwil_' . $year . '.xlsx';

        $spreadsheet = new Spreadsheet();

        // SHEET 1: Rekap Project / Kegiatan
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Rekap Project ' . $year);

        $headers = [
            'NO', 'OPD / DINAS', 'BIDANG', 'TANGGAL', 
            'NAMA MENTOR', 'JK MENTOR', 'DOMISILI MENTOR', 'NO WA MENTOR',
            'NAMA TALENTA', 'JK TALENTA', 'DOMISILI TALENTA', 'NO WA TALENTA', 'BIDANG TALENTA',
            'NAMA UKM/CLIENT', 'NAMA PRODUK', 'NAMA PEMILIK', 'DOMISILI UKM', 'NO HP UKM'
        ];

        $sheet1->fromArray($headers, null, 'A1');
        $this->styleHeader($sheet1, 'A1:R1');

        $projects = DB::table('project')->where('tahun', (int)$year)->get();
        $rowNum = 2;
        $no = 1;

        foreach ($projects as $project) {
            $mentors = DB::table('project_mentor')
                ->join('mentor', 'mentor.id_mentor', '=', 'project_mentor.id_mentor')
                ->where('project_mentor.id_project', $project->id_project)
                ->get();

            $talentas = DB::table('project_talenta')
                ->join('talenta', 'talenta.id_talenta', '=', 'project_talenta.id_talenta')
                ->where('project_talenta.id_project', $project->id_project)
                ->get();

            $clients = DB::table('project_client')
                ->join('client', 'client.id_client', '=', 'project_client.id_client')
                ->where('project_client.id_project', $project->id_project)
                ->get();

            // Zelfde layout als preview (blockRows) — één bron zodat het aantal
            // rijen en de koppeling mentor↔talenta↔UKM gelijk zijn.
            // Null-guards: bij een ongelijk aantal (bv. minder mentors dan
            // UKM-rijen) worden de lege cellen '-' i.p.v. een crash.
            foreach ($this->blockRows($mentors, $talentas, $clients) as $b) {
                $m = $b['mentor'];
                $t = $b['talenta'];
                $c = $b['client'];

                $sheet1->fromArray([
                    $b['index'] === 0 ? $no++ : '',
                    $b['index'] === 0 ? ($project->opd ?? '-') : '',
                    $b['index'] === 0 ? ($project->bidang ?? '-') : '',
                    $b['index'] === 0 ? ($project->tanggal ?? '-') : '',
                    $m ? ($m->nama ?? '-') : '-',
                    $m ? ($m->jenis_kelamin ?? '-') : '-',
                    $m ? ($m->domisili ?? '-') : '-',
                    $m ? ($m->no_wa ?? '-') : '-',
                    $t ? ($t->nama ?? '-') : '-',
                    $t ? ($t->jenis_kelamin ?? '-') : '-',
                    $t ? ($t->domisili ?? '-') : '-',
                    $t ? ($t->no_wa ?? '-') : '-',
                    $t ? ($t->bidang_pekerjaan ?? '-') : '-',
                    $c ? ($c->nama_ukm ?? '-') : '-',
                    $c ? ($c->nama_produk ?? '-') : '-',
                    $c ? ($c->nama_pemilik ?? '-') : '-',
                    $c ? ($c->domisili ?? '-') : '-',
                    $c ? ($c->no_hp ?? '-') : '-',
                ], null, 'A' . $rowNum);

                $rowNum++;
            }
        }
        $this->autoSizeColumns($sheet1, 'A', 'R', $rowNum - 1);

        // SHEET 2: Master Data Mentors
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Data Mentors');
        $headerMentors = ['NO', 'NAMA MENTOR', 'JENIS KELAMIN', 'DOMISILI', 'ALAMAT LENGKAP', 'NO WA', 'EMAIL', 'KEAHLIAN', 'PENGALAMAN', 'BIDANG', 'STATUS'];
        $sheet2->fromArray($headerMentors, null, 'A1');
        $this->styleHeader($sheet2, 'A1:K1');


        $mentorsData = Mentor::query()->whereYear('created_at', $year)->get();
        if ($mentorsData->isEmpty()) {
            $mentorsData = Mentor::all();
        }

        $r2 = 2;
        $idx = 1;
        foreach ($mentorsData as $m) {
            $sheet2->fromArray([
                $idx++,
                $m->nama ?? '-',
                $m->jenis_kelamin ?? '-',
                $m->domisili ?? '-',
                $m->alamat_lengkap ?? '-',
                $m->no_wa ?? '-',
                $m->email ?? '-',
                $m->keahlian ?? '-',
                $m->pengalaman ?? '-',
                $m->bidang ?? '-',
                $m->is_available ? 'Aktif / Tersedia' : 'Sibuk',
            ], null, 'A' . $r2++);
        }
        $this->autoSizeColumns($sheet2, 'A', 'K', $r2 - 1);

        // SHEET 3: Master Data Talents
        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('Data Talents');
        $headerTalents = ['NO', 'NAMA TALENTA', 'JENIS KELAMIN', 'DOMISILI', 'ALAMAT LENGKAP', 'NO WA', 'EMAIL', 'BIDANG PEKERJAAN', 'KEAHLIAN', 'PENGALAMAN', 'STATUS PEKERJAAN'];
        $sheet3->fromArray($headerTalents, null, 'A1');
        $this->styleHeader($sheet3, 'A1:K1');

        $talentsData = Talent::query()->whereYear('created_at', $year)->get();
        if ($talentsData->isEmpty()) {
            $talentsData = Talent::all();
        }

        $r3 = 2;
        $idx = 1;
        foreach ($talentsData as $t) {
            $sheet3->fromArray([
                $idx++,
                $t->nama ?? '-',
                $t->jenis_kelamin ?? '-',
                $t->domisili ?? '-',
                $t->alamat_lengkap ?? '-',
                $t->no_wa ?? '-',
                $t->email ?? '-',
                $t->bidang_pekerjaan ?? '-',
                $t->keahlian ?? '-',
                $t->pengalaman ?? '-',
                $t->status_pekerjaan ?? '-',
            ], null, 'A' . $r3++);
        }
        $this->autoSizeColumns($sheet3, 'A', 'K', $r3 - 1);

        // SHEET 4: Master Data Clients (UMKM)
        $sheet4 = $spreadsheet->createSheet();
        $sheet4->setTitle('Data Clients');
        $headerClients = ['NO', 'NAMA UKM', 'NAMA PEMILIK', 'NAMA PRODUK', 'DOMISILI', 'ALAMAT LENGKAP', 'NO HP/WA', 'EMAIL', 'WEBSITE', 'DESKRIPSI USAHA'];
        $sheet4->fromArray($headerClients, null, 'A1');
        $this->styleHeader($sheet4, 'A1:J1');

        $clientsData = Client::query()->whereYear('created_at', $year)->get();
        if ($clientsData->isEmpty()) {
            $clientsData = Client::all();
        }

        $r4 = 2;
        $idx = 1;
        foreach ($clientsData as $c) {
            $sheet4->fromArray([
                $idx++,
                $c->nama_ukm ?? '-',
                $c->nama_pemilik ?? '-',
                $c->nama_produk ?? '-',
                $c->domisili ?? '-',
                $c->alamat_lengkap ?? '-',
                $c->no_hp ?? '-',
                $c->email ?? '-',
                $c->website ?? '-',
                $c->deskripsi_usaha ?? '-',
            ], null, 'A' . $r4++);
        }
        $this->autoSizeColumns($sheet4, 'A', 'J', $r4 - 1);

        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);
        ob_start();
        $writer->save('php://output');
        $content = ob_get_clean();

        return response($content)
            ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Cache-Control', 'max-age=0')
            ->header('Expires', '0');
    }

    private function writeRow($sheet, $rowNum, $project, $mentor, $talenta, $client)
    {
        $sheet->fromArray([
            $project->opd ?? '', $project->bidang ?? '', $project->tanggal ?? '',
            $mentor->nama ?? '', $mentor->jenis_kelamin ?? '', $mentor->domisili ?? '',
            $mentor->alamat_lengkap ?? '', $mentor->no_wa ?? '', $mentor->url_cv ?? '',
            $mentor->url_ktp ?? '', $mentor->url_butap ?? '', $mentor->portofolio_url ?? '',
            $talenta->nama ?? '', $talenta->jenis_kelamin ?? '', $talenta->alamat_lengkap ?? '',
            $talenta->domisili ?? '', $talenta->no_wa ?? '', $talenta->url_cv ?? '',
            $talenta->url_ktp ?? '', '', $talenta->portofolio_url ?? '', $talenta->bidang_pekerjaan ?? '',
            $client->nama_ukm ?? '', $client->alamat_lengkap ?? '', $client->domisili ?? '',
            $client->nama_produk ?? '', $client->nama_pemilik ?? '', $client->no_hp ?? '', '',
        ], null, 'A' . $rowNum);
    }

    protected function getMentorData(string $year): array
    {
        $result = Mentor::query()->whereYear('created_at', $year)->get();

        $rows = [];
        foreach ($result as $mentor) {
            $kategori = 'MENTOR - ' . ($mentor->bidang ?? 'Pendidikan');

            $rows[] = [
                $kategori,
                $mentor->nama ?? '-',
                $mentor->jenis_kelamin ?? '-',
                $mentor->domisili ?? '-',
                $mentor->alamat_lengkap ?? '-',
                $mentor->no_wa ?? '-',
                $mentor->email ?? '-',
                $mentor->keahlian ?? '-',
                $mentor->pengalaman ?? '-',
                $mentor->bidang ?? '-',
                '',
                '',
                $mentor->status ?? '-',
                $year,
            ];
        }

        return $rows;
    }

    protected function getTalentaData(string $year): array
    {
        $result = Talent::query()->whereYear('created_at', $year)->get();

        $rows = [];
        foreach ($result as $talenta) {
            $kategori = 'TALENTA - ' . ($talenta->bidang_pekerjaan ?? 'Umum');

            $rows[] = [
                $kategori,
                $talenta->nama ?? '-',
                $talenta->jenis_kelamin ?? '-',
                $talenta->domisili ?? '-',
                $talenta->alamat_lengkap ?? '-',
                $talenta->no_wa ?? '-',
                $talenta->email ?? '-',
                $talenta->keahlian ?? '-',
                $talenta->pengalaman ?? '-',
                $talenta->status_pekerjaan ?? '-',
                $talenta->bidang_pekerjaan ?? '-',
                '',
                '',
                $talenta->status ?? '-',
                $year,
            ];
        }

        return $rows;
    }

    protected function getClientData(string $year): array
    {
        $result = Client::query()->whereYear('created_at', $year)->get();

        $rows = [];
        foreach ($result as $client) {
            $kategori = 'UKM/CLIENT - ' . (Client::kategoriKey($client) ?? 'UMKM');

            $rows[] = [
                $kategori,
                $client->nama_ukm ?? '-',
                $client->alamat_lengkap ?? '-',
                $client->domisili ?? '-',
                $client->nama_pemilik ?? '-',
                $client->no_hp ?? '-',
                $client->email ?? '-',
                $client->website ?? '-',
                $client->nama_produk ?? '-',
                $client->deskripsi_usaha ?? '-',
                '',
                $year,
                $client->status ?? '-',
            ];
        }

        return $rows;
    }
protected function generateExcel(array $mentorData, array $talentaData, array $clientData, string $year)
    {
        $filename = 'Data_Mentor_Talenta_UKM_' . $year . '.xlsx';

        $spreadsheet = new Spreadsheet();

        // ===== Sheet 1: Data Mentor =====
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Data Mentor');

        $headerMentor = ['Kategori', 'Nama', 'JK', 'Domisili', 'Alamat', 'No WA', 'Email', 'Keahlian', 'Pengalaman', 'Bidang', 'Foto', 'Portofolio', 'Status', 'Tahun'];
        $sheet1->fromArray($headerMentor, null, 'A1');
        $this->styleHeader($sheet1, 'A1:N1');

        $rowNum = 2;
        if (!empty($mentorData)) {
            foreach ($mentorData as $row) {
                $sheet1->fromArray($row, null, 'A' . $rowNum);
                $rowNum++;
            }
        } else {
            $sheet1->setCellValue('A2', 'Tidak ada data mentor untuk tahun ' . $year);
            $rowNum = 3;
        }
        $this->autoSizeColumns($sheet1, 'A', 'N', $rowNum);

        // ===== Sheet 2: Data Talenta =====
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Data Talenta');

        $headerTalenta = ['Kategori', 'Nama', 'JK', 'Domisili', 'Alamat', 'No WA', 'Email', 'Keahlian', 'Pengalaman', 'Status Pekerjaan', 'Bidang Pekerjaan', 'Foto', 'Portofolio', 'Status', 'Tahun'];
        $sheet2->fromArray($headerTalenta, null, 'A1');
        $this->styleHeader($sheet2, 'A1:O1');

        $rowNum = 2;
        if (!empty($talentaData)) {
            foreach ($talentaData as $row) {
                $sheet2->fromArray($row, null, 'A' . $rowNum);
                $rowNum++;
            }
        } else {
            $sheet2->setCellValue('A2', 'Tidak ada data talenta untuk tahun ' . $year);
            $rowNum = 3;
        }
        $this->autoSizeColumns($sheet2, 'A', 'O', $rowNum);

        // ===== Sheet 3: Data UKM =====
        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('Data UKM');

        $headerClient = ['Kategori', 'Nama UKM', 'Alamat', 'Domisili', 'Nama Pemilik', 'No HP', 'Email', 'Website', 'Nama Produk', 'Deskripsi Usaha', 'Foto Logo', 'Tahun', 'Status'];
        $sheet3->fromArray($headerClient, null, 'A1');
        $this->styleHeader($sheet3, 'A1:M1');

        $rowNum = 2;
        if (!empty($clientData)) {
            foreach ($clientData as $row) {
                $sheet3->fromArray($row, null, 'A' . $rowNum);
                $rowNum++;
            }
        } else {
            $sheet3->setCellValue('A2', 'Tidak ada data UKM untuk tahun ' . $year);
            $rowNum = 3;
        }
        $this->autoSizeColumns($sheet3, 'A', 'M', $rowNum);

        // Set active sheet to first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Output to browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Expires: 0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit;
    }

        protected function styleHeader($sheet, string $range)
    {
        $sheet->getStyle($range)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 10,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E293B'], // Dark Slate / Header Admin
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '475569'],
                ],
            ],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(26);
    }

    protected function autoSizeColumns($sheet, string $startCol, string $endCol, int $lastRow)
    {
        if ($lastRow < 1) {
            $lastRow = 1;
        }

        for ($col = $startCol; $col !== $endCol; $col++) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet->getColumnDimension($endCol)->setAutoSize(true);

        if ($lastRow > 1) {
            $sheet->getStyle("{$startCol}2:{$endCol}{$lastRow}")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'E2E8F0'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);
        }
    }
}