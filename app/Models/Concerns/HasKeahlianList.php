<?php

namespace App\Models\Concerns;

/**
 * Logika daftar bidang keahlian yang dipakai bersama Talent & Mentor.
 *
 * Satu baris boleh punya lebih dari satu bidang. Nilainya disimpan sebagai
 * teks yang dipisah koma pada kolom `keahlian`, mis. "Desain, Video",
 * sehingga pencarian (ILIKE) dan filter lama tetap berjalan.
 */
trait HasKeahlianList
{
    /**
     * Pisahkan isi kolom keahlian menjadi daftar bidang yang rapi.
     * Menerima model atau string mentah. Nilai ganda (tanpa peduli
     * besar-kecil huruf) dibuang, urutan pertama dipertahankan.
     */
    public static function keahlianList($model): array
    {
        $raw = is_object($model)
            ? (string) ($model->keahlian ?? '')
            : (string) $model;

        $list = [];

        foreach (preg_split('/[,;]+/u', $raw) ?: [] as $item) {
            $item = trim(preg_replace('/\s+/u', ' ', $item) ?? '');

            if ($item === '') {
                continue;
            }

            if (in_array(mb_strtolower($item), array_map('mb_strtolower', $list), true)) {
                continue;
            }

            $list[] = $item;
        }

        return $list;
    }

    /**
     * Rapikan daftar bidang keahlian menjadi satu string siap simpan.
     * Mengembalikan null bila tidak ada bidang yang tersisa.
     */
    public static function normalizeKeahlian($value): ?string
    {
        $list = static::keahlianList($value);

        return $list === [] ? null : implode(', ', $list);
    }
}
