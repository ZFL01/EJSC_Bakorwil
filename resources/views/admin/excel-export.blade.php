@extends('layouts.admin')

@section('title', 'Ekspor Excel - Data Mentor, Talenta & UKM')
@section('header', 'Ekspor Excel - Data Mentor, Talent & UKM')

@section('content')
<div class="space-y-6">
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
        <h3 class="font-semibold text-blue-800">Panduan Penggunaan</h3>
        <ul class="list-disc list-inside text-sm text-blue-700 mt-2 space-y-1">
            <li>Pilih tahun dari dropdown (otomatis terisi tahun saat ini)</li>
            <li>Klik <strong>Muat Data</strong> untuk melihat preview data</li>
            <li>Klik <strong>Export ke Excel</strong> untuk mengunduh file</li>
            <li>File dapat langsung dibuka di Excel atau Google Sheets</li>
        </ul>
    </div>

    <form id="exportForm" action="{{ route('admin.excel-export.export') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="tahun" id="exportTahunInput">
    </form>

    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Pilih Tahun</label>
                <select id="tahun" class="border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#56b8c2]">
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-3">
                <button id="btnMuatData" class="bg-gray-800 hover:bg-gray-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition">Muat Data</button>
                <button id="btnExport" class="bg-[#56b8c2] hover:bg-[#3d9aa3] text-white px-5 py-2.5 rounded-lg text-sm font-medium transition disabled:opacity-50" disabled>Export ke Excel</button>
            </div>
        </div>
    </div>

    <div id="summaryCards" class="grid grid-cols-3 gap-4 hidden">
        <div class="bg-white p-4 rounded-xl border border-gray-200 text-center">
            <p class="text-xs text-gray-500 uppercase">Data Mentor</p>
            <p id="mentorCount" class="text-2xl font-bold text-sky-600">0</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-200 text-center">
            <p class="text-xs text-gray-500 uppercase">Data Talenta</p>
            <p id="talentaCount" class="text-2xl font-bold text-emerald-600">0</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-200 text-center">
            <p class="text-xs text-gray-500 uppercase">Data UKM</p>
            <p id="clientCount" class="text-2xl font-bold text-amber-600">0</p>
        </div>
    </div>

    <div id="loading" class="hidden flex items-center justify-center bg-white p-8 rounded-xl border border-gray-200">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#56b8c2]"></div>
        <span class="ml-3 text-gray-600">Memuat data...</span>
    </div>

    <div id="preview" class="hidden bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
            <h3 class="font-semibold text-gray-800">Preview Data</h3>
            <span class="text-sm text-gray-500">Tahun: <strong id="previewYear">-</strong></span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="p-3 w-28">Kategori</th>
                        <th class="p-3">Nama / UKM</th>
                        <th class="p-3 w-16">JK</th>
                        <th class="p-3 w-28">Domisili</th>
                        <th class="p-3 w-40">Alamat</th>
                        <th class="p-3 w-24">No WA/HP</th>
                        <th class="p-3 w-20">Status</th>
                    </tr>
                </thead>
                <tbody id="previewBody" class="divide-y divide-gray-100">
                    <tr><td colspan="7" class="p-8 text-center text-gray-400">Belum ada data</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <p id="exportInfo" class="hidden text-emerald-600 bg-emerald-50 p-3 rounded-lg text-sm">
        Data berhasil dimuat! Klik tombol <strong>Export ke Excel</strong> untuk mengunduh.
    </p>
</div>
@endsection
@section('scripts')
<script>
function cellText(value) {
    return (value === undefined || value === null) ? '' : String(value);
}

function cellTd(text, className) {
    var td = document.createElement('td');
    if (className) td.className = className;
    td.textContent = cellText(text);
    return td;
}

function spanBadge(text, className) {
    var span = document.createElement('span');
    if (className) span.className = className;
    span.textContent = cellText(text);
    return span;
}

function addRow(previewBody, data, color) {
    var tr = document.createElement('tr');
    tr.className = 'hover:bg-gray-50';
    var sc = data.status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600';

    var badgeTd = cellTd('', 'p-3');
    badgeTd.appendChild(spanBadge(data.kategori, 'px-2 py-0.5 bg-' + color + '-100 text-' + color + '-700 text-xs rounded-full'));

    tr.appendChild(badgeTd);
    tr.appendChild(cellTd(data.nama, 'p-3 font-medium'));
    tr.appendChild(cellTd(data.jk, 'p-3'));
    tr.appendChild(cellTd(data.domisili, 'p-3 text-gray-600'));
    tr.appendChild(cellTd(data.alamat, 'p-3 text-gray-600 max-w-xs truncate'));
    tr.appendChild(cellTd(data.noWa, 'p-3 text-gray-600'));

    var statusTd = cellTd('', 'p-3');
    statusTd.appendChild(spanBadge(data.status, 'px-2 py-0.5 rounded-full text-xs font-medium ' + sc));
    tr.appendChild(statusTd);

    previewBody.appendChild(tr);
}

document.addEventListener('DOMContentLoaded', function() {
    var btnMuatData = document.getElementById('btnMuatData');
    var btnExport = document.getElementById('btnExport');
    var tahunSelect = document.getElementById('tahun');
    var summaryCards = document.getElementById('summaryCards');
    var loading = document.getElementById('loading');
    var preview = document.getElementById('preview');
    var exportInfo = document.getElementById('exportInfo');
    var previewBody = document.getElementById('previewBody');
    var previewYear = document.getElementById('previewYear');

    btnMuatData.addEventListener('click', function() {
        var year = tahunSelect.value;
        loading.classList.remove('hidden');
        summaryCards.classList.add('hidden');
        preview.classList.add('hidden');
        exportInfo.classList.add('hidden');
        btnExport.disabled = true;

        var formData = new FormData();
        formData.append('tahun', year);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route('admin.excel-export.preview') }}', { method: 'POST', body: formData })
            .then(function(r) { if (!r.ok) throw new Error('Gagal'); return r.json(); })
            .then(function(data) {
                document.getElementById('mentorCount').textContent = data.mentors;
                document.getElementById('talentaCount').textContent = data.talents;
                document.getElementById('clientCount').textContent = data.clients;
                summaryCards.classList.remove('hidden');

                previewYear.textContent = year;
                previewBody.innerHTML = '';

                if (data.rows.length === 0) {
                    var noRowsTd = document.createElement('td');
                    noRowsTd.setAttribute('colspan', '7');
                    noRowsTd.className = 'p-8 text-center text-gray-400';

                    var noRowsText = document.createElement('span');
                    noRowsText.textContent = 'Tidak ada data untuk tahun ';
                    noRowsTd.appendChild(noRowsText);

                    var noRowsYear = document.createElement('strong');
                    noRowsYear.textContent = String(year);
                    noRowsTd.appendChild(noRowsYear);

                    var noRowsTr = document.createElement('tr');
                    noRowsTr.appendChild(noRowsTd);
                    previewBody.appendChild(noRowsTr);
                } else {
                    data.rows.forEach(function(row) {
                        addRow(previewBody, {
                            kategori: row.kategori || (row.project_opd ? (row.project_opd + ' / ' + (row.project_bidang || '')) : 'DATA'),
                            nama: row.nama || row.talenta_nama || row.mentor_nama || row.client_nama_ukm || '-',
                            jk: row.jk || row.talenta_jk || '-',
                            domisili: row.domisili || row.talenta_domisili || '-',
                            alamat: row.alamat || row.talenta_alamat || '-',
                            noWa: row.noWa || row.talenta_no_wa || '-',
                            status: row.status || 'aktif'
                        }, 'sky');
                    });
                }

                preview.classList.remove('hidden');
                exportInfo.classList.remove('hidden');
                btnExport.disabled = false;
            })
            .catch(function(e) {
                alert('Gagal memuat data: ' + e.message);
            })
            .finally(function() {
                loading.classList.add('hidden');
            });
    });

    btnExport.addEventListener('click', function() {
        var year = tahunSelect.value;
        document.getElementById('exportTahunInput').value = year;
        document.getElementById('exportForm').submit();
    });
});
</script>
@endsection
