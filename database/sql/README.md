# SQL Scripts untuk PostgreSQL Bakorwil Jember

File-file SQL ini dirancang untuk update database Bakorwil Jember yang sudah ada dengan fitur management admin baru.

## 📋 File & Urutan Eksekusi

### 1. **01_update_schema.sql** (Update Schema)
Update schema database yang sudah ada dengan menambahkan:
- Kolom baru di tabel users, client, mentor, talenta
- Tabel baru: kegiatan_participants, admin_logs
- Indexes untuk performa
- Triggers untuk auto-update timestamps
- Views untuk admin dashboard

**⚠️ PENTING**: Script ini menggunakan `DO $$ BEGIN ... END $$` untuk conditional updates, jadi aman dijalankan berulang kali tanpa error.

### 2. **02_seed_admin_users.sql** (Seed Data)
Membuat data demo:
- 4 user dengan role berbeda (Admin, Mentor, Talent, Client)
- Profile lengkap untuk setiap user
- 2 sample kegiatan

## 🚀 Cara Menggunakan di pgAdmin4

### Method 1: Query Tool (Recommended)

1. **Buka pgAdmin4**
2. **Connect ke database `bakorwil_jember`**
3. **Klik kanan database → Query Tool**
4. **Jalankan script berurutan:**

   **Step 1: Update Schema**
   ```sql
   -- Copy-paste isi file: 01_update_schema.sql
   -- Tekan F5 atau klik Execute
   ```

   **Step 2: Seed Data**
   ```sql
   -- Copy-paste isi file: 02_seed_admin_users.sql
   -- Tekan F5 atau klik Execute
   ```

### Method 2: psql Command Line

```bash
# Jalankan dari terminal/command prompt
psql -U postgres -d bakorwil_jember -f database/sql/01_update_schema.sql
psql -U postgres -d bakorwil_jember -f database/sql/02_seed_admin_users.sql
```

## 🔍 Verifikasi Hasil

Setelah menjalankan kedua script, verifikasi dengan query berikut:

### Cek Tabel Baru

```sql
-- Cek tabel kegiatan_participants
SELECT * FROM kegiatan_participants LIMIT 5;

-- Cek tabel admin_logs
SELECT * FROM admin_logs LIMIT 5;
```

### Cek Users Baru

```sql
-- Lihat semua users
SELECT id_user, username, name, email, role, status 
FROM users 
ORDER BY id_user;

-- Lihat profile mentor
SELECT m.*, u.email, u.role 
FROM mentor m 
JOIN users u ON m.id_user = u.id_user
WHERE u.email = 'mentor@example.com';

-- Lihat profile talent
SELECT t.*, u.email, u.role 
FROM talenta t 
JOIN users u ON t.id_user = u.id_user
WHERE u.email = 'talent@example.com';

-- Lihat profile client
SELECT c.*, u.email, u.role 
FROM client c 
JOIN users u ON c.id_user = u.id_user
WHERE u.email = 'client@example.com';
```

### Cek Kegiatan

```sql
-- Lihat kegiatan yang dibuat
SELECT id_kegiatan, judul_kegiatan, tanggal_kegiatan, status, lokasi
FROM kegiatan_ejsc
ORDER BY created_at DESC
LIMIT 5;
```

### Cek Views Baru

```sql
-- Dashboard statistics
SELECT * FROM v_admin_dashboard_stats;

-- Recent activities
SELECT * FROM v_recent_activities;
```

## 🔐 Login Credentials (Demo)

| Role | Email | Password | Akses |
|------|-------|----------|-------|
| **Admin** | admin@bakorwil.go.id | password | Full access |
| **Mentor** | mentor@example.com | password | Mentor dashboard |
| **Talent** | talent@example.com | password | Talent dashboard |
| **Client** | client@example.com | password | Client dashboard |

**⚠️ WAJIB GANTI PASSWORD DI PRODUCTION!**

## 📊 Perubahan Database

### Tabel yang Di-update:

#### **users**
- ✅ Tambah kolom `name` (untuk Laravel compatibility)
- ✅ Tambah kolom `remember_token`
- ✅ Tambah kolom `email_verified_at`
- ✅ Tambah kolom `profile_photo`
- ✅ Update constraint `role` (tambah 'public')

#### **client**
- ✅ Tambah kolom `created_by` (foreign key ke users)
- ✅ Tambah kolom `updated_by` (foreign key ke users)

#### **mentor**
- ✅ Tambah kolom `created_by`
- ✅ Tambah kolom `updated_by`
- ✅ Tambah kolom `expertise_tags` (array of skills)
- ✅ Tambah kolom `is_available` (status ketersediaan)
- ✅ Tambah kolom `jumlah_mentee`

#### **talenta**
- ✅ Tambah kolom `created_by`
- ✅ Tambah kolom `updated_by`
- ✅ Tambah kolom `skill_tags` (array of skills)
- ✅ Tambah kolom `mentor_id` (foreign key ke mentor)
- ✅ Tambah kolom `status_pekerjaan`
- ✅ Rename `url_buku_tabungan` → `url_butap`

#### **kegiatan_ejsc**
- ✅ Tambah kolom `organizer_id` (foreign key ke users)
- ✅ Tambah kolom `lokasi`
- ✅ Tambah kolom `max_participants`
- ✅ Tambah kolom `is_public`
- ✅ Tambah kolom `gallery` (JSON untuk multiple photos)

### Tabel Baru:

#### **kegiatan_participants**
```sql
- id_participant (PK)
- id_kegiatan (FK)
- id_user (FK)
- status (registered, confirmed, attended, cancelled)
- registered_at
- attended_at
- notes
```

#### **admin_logs**
```sql
- id_log (PK)
- id_user (FK)
- action
- table_name
- record_id
- old_values (JSON)
- new_values (JSON)
- ip_address
- user_agent
- created_at
```

### Views Baru:

- ✅ `v_admin_dashboard_stats` - Statistik untuk dashboard
- ✅ `v_recent_activities` - Recent activities monitoring

### Indexes Baru:

- ✅ Full-text search indexes (GIN) untuk nama client, mentor, talent
- ✅ Indexes untuk filtering (domisili, status, tanggal)
- ✅ Foreign key indexes

### Triggers Baru:

- ✅ Auto-update `updated_at` untuk semua tabel utama

## ⚠️ Important Notes

1. **Backup Database**: Selalu backup database sebelum menjalankan update!
   ```bash
   pg_dump -U postgres bakorwil_jember > backup_$(date +%Y%m%d_%H%M%S).sql
   ```

2. **Idempotent Scripts**: Script dirancang untuk bisa dijalankan berulang kali tanpa error (idempotent). Aman untuk re-run.

3. **Password Hash**: Default password menggunakan bcrypt hash dari Laravel. Hash: `$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi` = "password"

4. **Foreign Keys**: Semua relasi menggunakan:
   - `ON DELETE CASCADE` untuk child records
   - `ON DELETE SET NULL` untuk optional references

5. **Data Existing**: Script tidak akan menghapus atau mengubah data yang sudah ada. Hanya menambahkan struktur baru.

## 🐛 Troubleshooting

### Error: "relation already exists"
Script sudah handle ini dengan `CREATE TABLE IF NOT EXISTS`. Bisa diabaikan.

### Error: "column already exists"
Script sudah handle ini dengan conditional `IF NOT EXISTS`. Bisa diabaikan.

### Error: "permission denied"
```sql
-- Grant privileges ke user
GRANT ALL PRIVILEGES ON DATABASE bakorwil_jember TO your_user;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO your_user;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO your_user;
```

### Error: "password authentication failed"
Check credentials di pg_hba.conf atau connection string.

## 📝 Next Steps

Setelah menjalankan SQL scripts:

1. ✅ Verify database structure
2. ✅ Test login dengan 4 akun demo
3. ✅ Check foreign key relationships
4. ✅ Verify triggers working (update a record and check updated_at)
5. ✅ Check views returning correct data

Kemudian lanjut ke development Laravel:
- Setup Models (Client, Mentor, Talent, Kegiatan, etc.)
- Setup Controllers (Admin CRUD)
- Setup Views (Admin dashboard)
- Setup Routes & Middleware

## 🔄 Rollback (jika diperlukan)

Jika perlu rollback, restore dari backup:

```bash
# Restore from backup
psql -U postgres -d bakorwil_jember < backup_20260822_HHMMSS.sql
```

Atau drop objects secara manual:

```sql
-- Drop new tables
DROP TABLE IF EXISTS kegiatan_participants CASCADE;
DROP TABLE IF EXISTS admin_logs CASCADE;

-- Drop new views
DROP VIEW IF EXISTS v_admin_dashboard_stats;
DROP VIEW IF EXISTS v_recent_activities;

-- Drop new columns (hati-hati!)
ALTER TABLE users DROP COLUMN IF EXISTS name;
ALTER TABLE users DROP COLUMN IF EXISTS remember_token;
-- dst...
```

---

**Last Updated**: 2026-08-22  
**Database**: PostgreSQL 18.4  
**Compatible with**: Laravel 11.x  
**Author**: Kiro AI Assistant