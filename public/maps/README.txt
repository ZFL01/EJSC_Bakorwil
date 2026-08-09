==================================================
 PANDUAN PETA GIS (QGIS) - EJSC BAKORWIL
 Sistem Informasi Geografis 7 Daerah Tapal Kuda
==================================================

PETA INI BELUM DIISI / BELUM ADA DATA.
Di bawah ini adalah TAHAPAN yang harus dilakukan
untuk menampilkan peta di landing page.

--------------------------------------------------
 RINGKASAN APA YANG HARUS DILAKUKAN
--------------------------------------------------
1. Buat/dapatkan peta wilayah di QGIS (7 daerah).
2. Ekspor layer wilayah menjadi file GeoJSON.
3. Simpan file dengan nama: bakorwil.geojson
4. Letakkan file di folder ini:
       public/maps/bakorwil.geojson
5. Jalankan aplikasi Laravel.
6. Buka halaman utama (landing page).
7. Klik tombol "Muat Data Peta" pada placeholder.
8. Peta akan tampil full-width di bagian paling atas.

--------------------------------------------------
 A. PERSIAPAN DATA DI QGIS
--------------------------------------------------
1. Buka aplikasi QGIS (versi 3.x disarankan).
2. Siapkan layer polygon (shapefile/GeoPackage) yang
   berisi batas wilayah 7 daerah berikut:
      - Kota Probolinggo
      - Kabupaten Probolinggo
      - Kabupaten Lumajang
      - Kabupaten Jember
      - Kabupaten Bondowoso
      - Kabupaten Situbondo
      - Kabupaten Banyuwangi

   Catatan: Jika layer belum ada, Anda bisa mengunduh
   data batas administrasi dari sumber publik (misal:
   Ina-Geoportal, BPS, atau data open-source lainnya).

--------------------------------------------------
 B. PASTIKAN ATRIBUT (FIELD) LAYER
--------------------------------------------------
Agar tampilan interaktif berfungsi, layer HARUS
memiliki field/atribut berikut:

   Field Wajib:
   - NAME (string) : nama wilayah, contoh "Jember"
   - TYPE (string) : tipe, contoh "Kota" / "Kabupaten"

   Field Opsional (disarankan):
   - DESCRIPTION (string) : deskripsi/penjelasan
     wilayah yang akan tampil saat wilayah diklik.

   Cara mengecek/menambah field:
   - Buka Attribute Table (klik kanan layer ->
     Open Attribute Table).
   - Pastikan kolom NAME dan TYPE sudah diisi.
   - Jika belum ada, tambahkan kolom baru lalu isi
     datanya (gunakan Field Calculator jika perlu).

--------------------------------------------------
 C. EKSPOR LAYER KE GEOJSON
--------------------------------------------------
1. Klik kanan layer wilayah di panel Layers.
2. Pilih menu: Export -> Save Features As...
3. Pada dialog yang muncul, atur:
   - Format       : GeoJSON
   - File name    : pilih lokasi simpan
   - CRS          : pilih "WGS 84 - EPSG:4326"
                    (penting agar koordinat peta benar)
   - Pastikan opsi "Save only selected features"
     TIDAK dicentang (agar semua wilayah tersimpan).
4. Klik OK. File GeoJSON akan terbuat.
5. Beri nama file tersebut: bakorwil.geojson

--------------------------------------------------
 D. LETAKKAN FILE DI PROYEK
--------------------------------------------------
1. Salin file bakorwil.geojson ke folder ini:
       public/maps/bakorwil.geojson

   (Folder ini = public/maps di dalam proyek Laravel)

2. Pastikan nama file PERSIS "bakorwil.geojson"
   (huruf kecil semua). Jika nama berbeda, peta
   tidak akan termuat.

--------------------------------------------------
 E. MENJALANKAN & MELIHAT HASIL
--------------------------------------------------
1. Jalankan server Laravel (di terminal proyek):
       php artisan serve
   Biasanya akses di: http://127.0.0.1:8000

2. Buka halaman utama (landing page). Di bagian
   paling atas terdapat area peta dengan tombol
   "Muat Data Peta".

3. Klik tombol "Muat Data Peta". Jika file GeoJSON
   sudah benar, wilayah akan tampil dengan warna
   hijau telur asin (teal). Hover untuk menyorot,
   klik untuk melihat detail.

--------------------------------------------------
 F. JIKA PETA TIDAK MUNCUL / ERROR
--------------------------------------------------
- Pastikan file benar-benar ada di:
  public/maps/bakorwil.geojson
- Pastikan nama file persis "bakorwil.geojson".
- Pastikan format file valid GeoJSON (buka dengan
  editor teks, harus diawali { "type": "FeatureCollection" ... ).
- Pastikan CRS di QGIS saat ekspor adalah EPSG:4326.
- Pastikan seluruh 7 wilayah termasuk dalam layer.
- Setelah meletakkan file baru, muat ulang halaman
  browser (Ctrl+F5) lalu klik "Muat Data Peta".
- Jika masih gagal, cek konsol browser (F12 ->
  Console) untuk melihat pesan error.

--------------------------------------------------
 INFO TAMBAHAN
--------------------------------------------------
- Warna poligon: hijau telur asin (teal #0d9488).
- Saat hover: berubah kuning (#f59e0b).
- Tema halaman: hijau telur asin, kuning, putih, hitam.
- Peta memakai Leaflet.js (CDN). Perlu koneksi internet
  saat pertama dimuat agar tile peta & library tampil.
