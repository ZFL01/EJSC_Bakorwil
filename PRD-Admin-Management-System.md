# Product Requirements Document (PRD)
## Sistem Manajemen Admin - Multi User Role

**Tanggal:** 22 Agustus 2026  
**Versi:** 1.0  
**Project:** Bakorwil Jember Platform

---

## 1. Overview

Mengembangkan sistem manajemen berbasis role untuk platform Bakorwil Jember dengan 3 tipe user (Admin, Talent/Mentor/Client, Publik) dan fitur kelola data untuk Admin.

---

## 2. Tujuan

- Memisahkan akses dan hak setiap role user
- Memberikan Admin kontrol penuh untuk mengelola Client, Mentor, Talent, dan Kegiatan
- Memperbaiki tampilan kelola yang saat ini masih sama untuk semua entitas
- Implementasi kontrol akses berdasarkan tabel permission yang ada

---

## 3. User Roles & Permissions

### 3.1 Role Definitions

| Role | Deskripsi |
|------|-----------|
| **Publik** | User yang belum login, dapat melihat profil publik |
| **Talent/Mentor/Client** | User terdaftar dengan akses terbatas ke data pribadi + admin |
| **Admin** | User dengan akses penuh untuk CRUD semua data |

### 3.2 Data Access Matrix

| Data | Publik | Talent/Mentor/Client | Admin |
|------|--------|----------------------|-------|
| Nama | ✅ | ✅ | ✅ |
| Foto profil | ✅ | ✅ | ✅ |
| Kota/domisi | ✅ | ✅ | ✅ |
| Bidang/keahlian | ✅ | ✅ | ✅ |
| Portofolio | ✅ | ✅ | ✅ |
| No. WhatsApp | ❌ | Pemilik + Admin | ✅ |
| Alamat lengkap | ❌ | Pemilik + Admin | ✅ |
| KTP | ❌ | ❌ | ✅ |
| Buku tabungan | ❌ | ❌ | ✅ |
| CV lengkap | ❌/terbatas | Pemilik + Admin | ✅ |

---

## 4. Fitur Requirement

### 4.1 Sistem Autentikasi & Role

#### 4.1.1 Database Schema Updates

**Table: users**
```sql
- id
- name
- email
- password
- role (enum: 'admin', 'talent', 'mentor', 'client', 'public')
- profile_type (untuk tracking tipe user)
- created_at
- updated_at
```

**Table: profiles** (polymorphic untuk talent/mentor/client)
```sql
- id
- user_id (foreign key)
- profileable_type (App\Models\Talent, App\Models\Mentor, App\Models\Client)
- profileable_id
- foto_profil
- kota_domisili
- bidang_keahlian
- portofolio (JSON atau text)
- no_whatsapp (encrypted)
- alamat_lengkap (encrypted)
- foto_ktp (encrypted path)
- foto_buku_tabungan (encrypted path)
- cv_file (encrypted path)
- is_public (boolean, default true untuk data publik)
- created_at
- updated_at
```

**Table: activities** (untuk kelola kegiatan)
```sql
- id
- title
- description
- date
- location
- organizer_id (user_id dari admin)
- participants (JSON array of user_ids)
- status (enum: 'planned', 'ongoing', 'completed', 'cancelled')
- image
- created_at
- updated_at
```

#### 4.1.2 Seeder untuk 3 User Default

Buat 3 user dengan role berbeda:

1. **Admin User**
   - Email: admin@bakorwil.go.id
   - Password: Admin123!
   - Role: admin
   - Full access ke semua fitur

2. **Mentor User**
   - Email: mentor@example.com
   - Password: Mentor123!
   - Role: mentor
   - Akses ke profil pribadi + lihat data publik

3. **Talent User**
   - Email: talent@example.com
   - Password: Talent123!
   - Role: talent
   - Akses ke profil pribadi + lihat data publik

### 4.2 Admin Dashboard - Kelola Client

**Route:** `/admin/clients`

**Fitur:**
- List semua Client dengan tabel yang informatif
- Search & Filter (nama, kota, bidang)
- CRUD operations:
  - Create: Form tambah client baru
  - Read: Detail view dengan semua data termasuk data sensitif
  - Update: Edit semua field termasuk upload dokumen
  - Delete: Soft delete dengan konfirmasi

**Tampilan Khusus:**
- Avatar/foto profil dalam grid atau list
- Badge untuk status aktif/tidak aktif
- Quick actions (edit, delete, view detail)
- Pagination
- Export ke Excel/PDF

**Fields yang ditampilkan:**
- Nama
- Email
- Kota/domisili
- Bidang usaha
- No. WhatsApp (masked di list, full di detail)
- Status
- Actions

### 4.3 Admin Dashboard - Kelola Mentor

**Route:** `/admin/mentors`

**Fitur:**
- List semua Mentor dengan tabel
- Search & Filter (nama, kota, keahlian)
- CRUD operations lengkap
- Rating/review system (optional, future enhancement)

**Tampilan Khusus:**
- Expertise tags/badges
- Jumlah mentee yang dibimbing
- Status ketersediaan
- Portfolio preview

**Fields yang ditampilkan:**
- Nama & Foto
- Email
- Kota/domisili
- Bidang keahlian
- Jumlah mentee
- Status ketersediaan
- Actions

### 4.4 Admin Dashboard - Kelola Talent

**Route:** `/admin/talents`

**Fitur:**
- List semua Talent
- Search & Filter (nama, kota, skill)
- CRUD operations lengkap
- Matching dengan mentor (optional)

**Tampilan Khusus:**
- Skill tags
- Portfolio highlights
- Status pencarian kerja
- Mentor yang dibimbing oleh

**Fields yang ditampilkan:**
- Nama & Foto
- Email
- Kota/domisili
- Skills/keahlian
- Status
- Mentor terkait (jika ada)
- Actions

### 4.5 Admin Dashboard - Kelola Kegiatan

**Route:** `/admin/activities`

**Fitur:**
- List semua kegiatan (upcoming, ongoing, past)
- Search & Filter (tanggal, status, lokasi)
- CRUD operations:
  - Create: Form dengan detail kegiatan, upload foto, pilih peserta
  - Read: Detail dengan daftar peserta
  - Update: Edit semua field
  - Delete: Soft delete dengan konfirmasi
  - Manage participants: Tambah/hapus peserta

**Tampilan Khusus:**
- Calendar view (optional)
- Timeline untuk status kegiatan
- Photo gallery untuk dokumentasi
- Participant management
- Status badges (planned/ongoing/completed/cancelled)

**Fields yang ditampilkan:**
- Judul kegiatan
- Tanggal & Waktu
- Lokasi
- Jumlah peserta
- Status
- Thumbnail foto
- Actions

### 4.6 Perbedaan Tampilan dari yang Ada

**Yang Sekarang:**
- Tampilan kelola client, mentor, talent masih sama
- Tidak ada role-based access
- Tidak ada fitur kelola kegiatan

**Yang Baru:**
1. **Distinct UI untuk setiap entitas**
   - Client: Fokus pada info bisnis/perusahaan
   - Mentor: Fokus pada keahlian dan availability
   - Talent: Fokus pada skills dan portfolio
   - Kegiatan: Fokus pada event management

2. **Role-based Dashboard**
   - Admin: Sidebar dengan menu kelola lengkap
   - User biasa: Hanya melihat dashboard pribadi

3. **Data Security**
   - Sensitive data (KTP, buku tabungan, CV) hanya untuk admin
   - Encryption untuk data pribadi
   - Audit log untuk akses data sensitif

---

## 5. Technical Stack

### 5.1 Backend
- **Framework:** Laravel 11
- **Authentication:** Laravel Breeze/Sanctum
- **Authorization:** Gates & Policies
- **File Storage:** Laravel Storage (private disk untuk sensitive files)
- **Database:** MySQL/PostgreSQL

### 5.2 Frontend
- **Blade Templates** dengan komponen reusable
- **CSS Framework:** Tailwind CSS (sudah ada di project)
- **JavaScript:** Alpine.js atau Vue.js untuk interactivity
- **Icons:** Heroicons atau Font Awesome

### 5.3 Security
- **Encryption:** Laravel's built-in encryption untuk data sensitif
- **CSRF Protection:** Laravel default
- **XSS Protection:** Blade automatic escaping
- **File Upload Validation:** Strict validation untuk KTP, CV, dll
- **Rate Limiting:** Untuk prevent abuse

---

## 6. File Structure (New/Modified)

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── ClientController.php (new)
│   │   │   ├── MentorController.php (new)
│   │   │   ├── TalentController.php (new)
│   │   │   └── ActivityController.php (new)
│   │   └── ProfileController.php (modified)
│   ├── Middleware/
│   │   ├── CheckRole.php (new)
│   │   └── CheckPermission.php (new)
│   └── Requests/
│       ├── StoreClientRequest.php (new)
│       ├── StoreMentorRequest.php (new)
│       ├── StoreTalentRequest.php (new)
│       └── StoreActivityRequest.php (new)
├── Models/
│   ├── Client.php (new)
│   ├── Mentor.php (new)
│   ├── Talent.php (new)
│   ├── Activity.php (new)
│   ├── Profile.php (new)
│   └── User.php (modified)
├── Policies/
│   ├── ClientPolicy.php (new)
│   ├── MentorPolicy.php (new)
│   ├── TalentPolicy.php (new)
│   └── ActivityPolicy.php (new)

database/
├── migrations/
│   ├── xxxx_create_profiles_table.php (new)
│   ├── xxxx_create_clients_table.php (new)
│   ├── xxxx_create_mentors_table.php (new)
│   ├── xxxx_create_talents_table.php (new)
│   ├── xxxx_create_activities_table.php (new)
│   └── xxxx_add_role_to_users_table.php (new)
└── seeders/
    ├── UserSeeder.php (new)
    └── RolePermissionSeeder.php (new)

resources/
├── views/
│   ├── admin/
│   │   ├── clients/
│   │   │   ├── index.blade.php (new)
│   │   │   ├── create.blade.php (new)
│   │   │   ├── edit.blade.php (new)
│   │   │   └── show.blade.php (new)
│   │   ├── mentors/
│   │   │   ├── index.blade.php (new)
│   │   │   ├── create.blade.php (new)
│   │   │   ├── edit.blade.php (new)
│   │   │   └── show.blade.php (new)
│   │   ├── talents/
│   │   │   ├── index.blade.php (new)
│   │   │   ├── create.blade.php (new)
│   │   │   ├── edit.blade.php (new)
│   │   │   └── show.blade.php (new)
│   │   ├── activities/
│   │   │   ├── index.blade.php (new)
│   │   │   ├── create.blade.php (new)
│   │   │   ├── edit.blade.php (new)
│   │   │   └── show.blade.php (new)
│   │   └── dashboard.blade.php (modified)
│   ├── components/
│   │   ├── admin-sidebar.blade.php (new)
│   │   ├── data-table.blade.php (new)
│   │   └── status-badge.blade.php (new)
│   └── layouts/
│       └── admin.blade.php (new)

routes/
└── web.php (modified - add admin routes)
```

---

## 7. Implementation Phases

### Phase 1: Database & Authentication (Priority: High)
- [ ] Buat migrations untuk semua tabel baru
- [ ] Update User model dengan role
- [ ] Buat Models: Client, Mentor, Talent, Activity, Profile
- [ ] Buat seeder untuk 3 user default
- [ ] Setup middleware untuk role checking

### Phase 2: Admin - Kelola Client (Priority: High)
- [ ] ClientController dengan CRUD
- [ ] Views untuk kelola client (index, create, edit, show)
- [ ] Form validation
- [ ] File upload handling (KTP, CV, dll)

### Phase 3: Admin - Kelola Mentor (Priority: High)
- [ ] MentorController dengan CRUD
- [ ] Views untuk kelola mentor
- [ ] Expertise/skill management

### Phase 4: Admin - Kelola Talent (Priority: High)
- [ ] TalentController dengan CRUD
- [ ] Views untuk kelola talent
- [ ] Portfolio management

### Phase 5: Admin - Kelola Kegiatan (Priority: High)
- [ ] ActivityController dengan CRUD
- [ ] Views untuk kelola kegiatan
- [ ] Participant management
- [ ] Photo gallery untuk dokumentasi

### Phase 6: UI/UX Enhancement (Priority: Medium)
- [ ] Admin dashboard yang distinct
- [ ] Responsive design untuk mobile
- [ ] Search & filter functionality
- [ ] Pagination
- [ ] Export data (Excel/PDF)

### Phase 7: Security & Testing (Priority: High)
- [ ] Policies untuk authorization
- [ ] Encryption untuk data sensitif
- [ ] File upload security
- [ ] Unit tests
- [ ] Integration tests

---

## 8. User Stories

### Story 1: Admin Login
**As an** admin  
**I want to** login dengan kredensial admin  
**So that** saya bisa mengakses dashboard admin

**Acceptance Criteria:**
- Admin bisa login dengan email & password
- Setelah login redirect ke admin dashboard
- Non-admin tidak bisa akses route admin

### Story 2: Kelola Client
**As an** admin  
**I want to** melihat, tambah, edit, dan hapus data client  
**So that** saya bisa mengelola semua client di platform

**Acceptance Criteria:**
- Bisa lihat list semua client dengan pagination
- Bisa search client by nama/email/kota
- Bisa tambah client baru dengan form lengkap
- Bisa edit data client termasuk upload dokumen
- Bisa hapus client dengan konfirmasi
- Bisa lihat detail client termasuk data sensitif

### Story 3: Kelola Mentor
**As an** admin  
**I want to** melihat, tambah, edit, dan hapus data mentor  
**So that** saya bisa mengelola semua mentor di platform

**Acceptance Criteria:**
- Sama seperti Story 2 tapi untuk mentor
- Tambahan: bisa manage expertise/keahlian
- Bisa lihat jumlah mentee yang dibimbing

### Story 4: Kelola Talent
**As an** admin  
**I want to** melihat, tambah, edit, dan hapus data talent  
**So that** saya bisa mengelola semua talent di platform

**Acceptance Criteria:**
- Sama seperti Story 2 tapi untuk talent
- Tambahan: bisa manage skills
- Bisa lihat portfolio

### Story 5: Kelola Kegiatan
**As an** admin  
**I want to** membuat, mengedit, dan mengelola kegiatan  
**So that** saya bisa mengorganisir event/kegiatan platform

**Acceptance Criteria:**
- Bisa buat kegiatan baru dengan detail lengkap
- Bisa upload foto kegiatan
- Bisa tambah/hapus peserta kegiatan
- Bisa update status kegiatan
- Bisa lihat list kegiatan dengan filter by status/tanggal

### Story 6: User Biasa Access Control
**As a** talent/mentor/client  
**I want to** hanya bisa akses data pribadi saya  
**So that** data saya aman dan privacy terjaga

**Acceptance Criteria:**
- User biasa tidak bisa akses route admin
- User hanya bisa edit profil sendiri
- User tidak bisa lihat data sensitif user lain

---

## 9. UI Mockup Description

### Admin Dashboard Layout
```
+----------------------------------------------------------+
| [Logo] Bakorwil Admin                    [User] [Logout] |
+----------------------------------------------------------+
| Sidebar              | Main Content                        |
|                      |                                     |
| Dashboard            | +-------------------------------+  |
| Kelola Client        | | Stats Cards                   |  |
| Kelola Mentor        | | - Total Client: 45            |  |
| Kelola Talent        | | - Total Mentor: 12            |  |
| Kelola Kegiatan      | | - Total Talent: 78            |  |
| Pengaturan           | | - Kegiatan Upcoming: 5        |  |
|                      | +-------------------------------+  |
|                      |                                     |
|                      | Recent Activities Table            |
|                      | Quick Actions                       |
+----------------------------------------------------------+
```

### Admin - Kelola Client List
```
+----------------------------------------------------------+
| Kelola Client                         [+ Tambah Client]  |
+----------------------------------------------------------+
| [Search: ___________] [Filter: Kota v] [Filter: Status v]|
+----------------------------------------------------------+
| Foto | Nama      | Email        | Kota    | Status | Act  |
|------|-----------|--------------|---------|--------|------|
| [📷] | PT ABC    | abc@x.com    | Jember  | Aktif  | ⚙️   |
| [📷] | CV XYZ    | xyz@x.com    | Lumajang| Aktif  | ⚙️   |
|------|-----------|--------------|---------|--------|------|
| < 1 2 3 4 5 >                                            |
+----------------------------------------------------------+
```

### Admin - Form Tambah/Edit Client
```
+----------------------------------------------------------+
| Tambah Client Baru                              [Simpan] |
+----------------------------------------------------------+
| Data Dasar                                               |
| Nama Perusahaan: [___________________________________]   |
| Email:           [___________________________________]   |
| Bidang Usaha:    [___________________________________]   |
|                                                          |
| Informasi Kontak                                         |
| No. WhatsApp:    [___________________________________]   |
| Kota/Domisili:   [___________________________________]   |
| Alamat Lengkap:  [___________________________________]   |
|                  [___________________________________]   |
|                                                          |
| Upload Dokumen                                           |
| Foto Profil:     [Choose File] (Max 2MB, JPG/PNG)      |
| Portfolio:       [Choose Files] (Max 5 files)           |
|                                                          |
| [Batal]                                        [Simpan]  |
+----------------------------------------------------------+
```

---

## 10. API Endpoints (if needed for future SPA)

### Authentication
- POST `/api/login` - Login
- POST `/api/logout` - Logout
- GET `/api/user` - Get current user

### Admin - Clients
- GET `/api/admin/clients` - List clients
- POST `/api/admin/clients` - Create client
- GET `/api/admin/clients/{id}` - Get client detail
- PUT `/api/admin/clients/{id}` - Update client
- DELETE `/api/admin/clients/{id}` - Delete client

### Admin - Mentors
- GET `/api/admin/mentors` - List mentors
- POST `/api/admin/mentors` - Create mentor
- GET `/api/admin/mentors/{id}` - Get mentor detail
- PUT `/api/admin/mentors/{id}` - Update mentor
- DELETE `/api/admin/mentors/{id}` - Delete mentor

### Admin - Talents
- GET `/api/admin/talents` - List talents
- POST `/api/admin/talents` - Create talent
- GET `/api/admin/talents/{id}` - Get talent detail
- PUT `/api/admin/talents/{id}` - Update talent
- DELETE `/api/admin/talents/{id}` - Delete talent

### Admin - Activities
- GET `/api/admin/activities` - List activities
- POST `/api/admin/activities` - Create activity
- GET `/api/admin/activities/{id}` - Get activity detail
- PUT `/api/admin/activities/{id}` - Update activity
- DELETE `/api/admin/activities/{id}` - Delete activity
- POST `/api/admin/activities/{id}/participants` - Add participant
- DELETE `/api/admin/activities/{id}/participants/{userId}` - Remove participant

---

## 11. Success Metrics

- [ ] 3 user dengan role berbeda berhasil dibuat dan bisa login
- [ ] Admin bisa CRUD semua data client dengan tampilan yang distinct
- [ ] Admin bisa CRUD semua data mentor dengan tampilan yang distinct
- [ ] Admin bisa CRUD semua data talent dengan tampilan yang distinct
- [ ] Admin bisa CRUD kegiatan dan manage participants
- [ ] User biasa tidak bisa akses route admin (403 Forbidden)
- [ ] Data sensitif ter-enkripsi dan hanya bisa diakses admin
- [ ] Semua form memiliki validasi yang proper
- [ ] File upload berjalan dengan baik dan aman
- [ ] Responsive di mobile dan desktop

---

## 12. Risks & Mitigations

| Risk | Impact | Mitigation |
|------|--------|------------|
| Data sensitif leaked | High | Encryption, proper authorization, audit log |
| File upload attack | High | Strict validation, antivirus scan, size limit |
| Unauthorized access | High | Middleware, policies, proper authentication |
| Performance dengan banyak data | Medium | Pagination, lazy loading, caching |
| User experience buruk | Medium | User testing, responsive design |

---

## 13. Future Enhancements

- [ ] Audit log untuk tracking semua perubahan data
- [ ] Email notification untuk kegiatan baru
- [ ] Advanced search dengan Elasticsearch
- [ ] Dashboard analytics dengan charts
- [ ] Export data ke Excel/PDF
- [ ] Bulk operations (delete, update multiple records)
- [ ] Activity calendar view
- [ ] Mentor-Talent matching algorithm
- [ ] Review/rating system
- [ ] Mobile app (React Native/Flutter)

---

## 14. Dependencies

- Laravel 11.x
- PHP 8.2+
- MySQL 8.0+ / PostgreSQL 13+
- Composer
- Node.js & NPM (untuk Vite)
- Tailwind CSS
- Alpine.js (optional)

---

## 15. Timeline Estimate

| Phase | Duration | Notes |
|-------|----------|-------|
| Phase 1: Database & Auth | 3-4 days | Critical foundation |
| Phase 2: Kelola Client | 2-3 days | First admin module |
| Phase 3: Kelola Mentor | 2-3 days | Similar to client |
| Phase 4: Kelola Talent | 2-3 days | Similar to client |
| Phase 5: Kelola Kegiatan | 3-4 days | More complex with participants |
| Phase 6: UI/UX Enhancement | 2-3 days | Polish & responsive |
| Phase 7: Security & Testing | 3-4 days | Critical for production |
| **Total** | **17-24 days** | ~3-4 weeks |

---

## 16. Approval & Sign-off

- [ ] Product Owner Review
- [ ] Technical Lead Review
- [ ] Security Team Review
- [ ] Stakeholder Approval

**Ready for Implementation:** [ ]

---

## Notes

- Dokumen ini adalah living document dan akan di-update seiring perkembangan project
- Setiap perubahan requirement harus didokumentasikan
- Prioritas bisa berubah berdasarkan business needs
- Testing harus dilakukan di setiap phase