-- ============================================
-- Bakorwil Jember - Seed Admin Users
-- PostgreSQL Version
-- Date: 2026-08-22
-- Deskripsi: Membuat 4 user default dengan role berbeda
-- ============================================

-- ============================================
-- Password hash menggunakan bcrypt dari Laravel
-- Default password untuk semua user: "password"
-- Hash: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
-- ⚠️ WAJIB diganti di production!
-- ============================================

-- ============================================
-- 1. Insert Admin User
-- ============================================

INSERT INTO users (
    username, 
    name,
    email, 
    password_hash, 
    role, 
    status,
    email_verified_at,
    created_at, 
    updated_at
) 
VALUES (
    'admin',
    'Administrator Bakorwil Jember',
    'admin@bakorwil.go.id',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'admin',
    'aktif',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
) 
ON CONFLICT (email) DO UPDATE SET
    name = EXCLUDED.name,
    role = EXCLUDED.role,
    status = EXCLUDED.status;

-- ============================================
-- 2. Insert Mentor User + Profile
-- ============================================

-- Insert user
INSERT INTO users (
    username,
    name, 
    email, 
    password_hash, 
    role, 
    status,
    email_verified_at,
    created_at, 
    updated_at
) 
VALUES (
    'mentor_demo',
    'Budi Santoso',
    'mentor@example.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'mentor',
    'aktif',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
) 
ON CONFLICT (email) DO UPDATE SET
    name = EXCLUDED.name,
    role = EXCLUDED.role,
    status = EXCLUDED.status;

-- Insert mentor profile
INSERT INTO mentor (
    id_user,
    nama,
    jenis_kelamin,
    domisili,
    alamat_lengkap,
    no_wa,
    email,
    bio,
    keahlian,
    pengalaman,
    expertise_tags,
    is_available,
    jumlah_mentee,
    status,
    is_public,
    created_at,
    updated_at
)
SELECT 
    u.id_user,
    'Budi Santoso',
    'L',
    'Jember',
    'Jl. Contoh No. 123, Jember',
    '081234567890',
    'mentor@example.com',
    'Mentor berpengalaman dengan 10+ tahun di bidang digital marketing dan business development. Telah membimbing 50+ talent dan membantu mereka mencapai karir yang sukses.',
    'Digital Marketing, Business Development, SEO, Content Strategy, Social Media Marketing',
    'Founder & CEO PT Digital Marketing Indonesia (2015-sekarang), Digital Marketing Manager di Startup XYZ (2012-2015)',
    ARRAY['Digital Marketing', 'SEO', 'Content Strategy', 'Business Development', 'Leadership'],
    true,
    15,
    'aktif',
    true,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
FROM users u
WHERE u.email = 'mentor@example.com'
ON CONFLICT DO NOTHING;

-- ============================================
-- 3. Insert Talent User + Profile
-- ============================================

-- Insert user
INSERT INTO users (
    username,
    name, 
    email, 
    password_hash, 
    role, 
    status,
    email_verified_at,
    created_at, 
    updated_at
) 
VALUES (
    'talent_demo',
    'Siti Nurhaliza',
    'talent@example.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'talenta',
    'aktif',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
) 
ON CONFLICT (email) DO UPDATE SET
    name = EXCLUDED.name,
    role = EXCLUDED.role,
    status = EXCLUDED.status;

-- Insert talenta profile
INSERT INTO talenta (
    id_user,
    nama,
    jenis_kelamin,
    domisili,
    alamat_lengkap,
    no_wa,
    email,
    bio,
    bidang_pekerjaan,
    keahlian,
    pengalaman,
    skill_tags,
    status_pekerjaan,
    status,
    is_public,
    created_at,
    updated_at
)
SELECT 
    u.id_user,
    'Siti Nurhaliza',
    'P',
    'Lumajang',
    'Jl. Contoh No. 456, Lumajang',
    '081234567891',
    'talent@example.com',
    'Fresh graduate yang passionate di bidang design dan frontend development. Mencari mentor untuk mengembangkan karir di industri tech.',
    'UI/UX Design & Frontend Development',
    'UI/UX Design, Figma, Adobe XD, HTML, CSS, JavaScript, React, Responsive Design',
    'Magang di Startup ABC (6 bulan), Freelance Designer (1 tahun)',
    ARRAY['UI/UX Design', 'Figma', 'HTML/CSS', 'JavaScript', 'React', 'Adobe XD'],
    'mencari_kerja',
    'aktif',
    true,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
FROM users u
WHERE u.email = 'talent@example.com'
ON CONFLICT DO NOTHING;

-- ============================================
-- 4. Insert Client User + Profile
-- ============================================

-- Insert user
INSERT INTO users (
    username,
    name, 
    email, 
    password_hash, 
    role, 
    status,
    email_verified_at,
    created_at, 
    updated_at
) 
VALUES (
    'client_demo',
    'PT Jember Digital Teknologi',
    'client@example.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'client',
    'aktif',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
) 
ON CONFLICT (email) DO UPDATE SET
    name = EXCLUDED.name,
    role = EXCLUDED.role,
    status = EXCLUDED.status;

-- Insert client profile
INSERT INTO client (
    id_user,
    nama_ukm,
    domisili,
    alamat_lengkap,
    no_hp,
    email,
    website,
    deskripsi_usaha,
    nama_pemilik,
    status,
    is_public,
    created_at,
    updated_at
)
SELECT 
    u.id_user,
    'PT Jember Digital Teknologi',
    'Jember',
    'Jl. Bisnis No. 789, Jember',
    '081234567892',
    'client@example.com',
    'https://jemberdigital.co.id',
    'Perusahaan teknologi yang fokus pada pengembangan software dan IT consulting untuk UMKM di wilayah Jember dan sekitarnya.',
    'Ahmad Wijaya',
    'aktif',
    true,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
FROM users u
WHERE u.email = 'client@example.com'
ON CONFLICT DO NOTHING;

-- ============================================
-- 5. Insert Sample Kegiatan
-- ============================================

INSERT INTO kegiatan_ejsc (
    judul_kegiatan,
    deskripsi,
    tanggal_kegiatan,
    lokasi,
    organizer_id,
    status,
    max_participants,
    is_public,
    created_at,
    updated_at
)
SELECT 
    'Workshop: Digital Marketing untuk UMKM',
    'Workshop intensif tentang strategi digital marketing yang efektif untuk UMKM di era digital. Materi meliputi: Social Media Marketing, Content Marketing, SEO Dasar, dan Google My Business. Workshop akan dibimbing langsung oleh praktisi berpengalaman.',
    CURRENT_DATE + INTERVAL '7 days',
    'Gedung Bakorwil Jember, Jl. Raya Jember No. 123',
    u.id_user,
    'akan_datang',
    30,
    true,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
FROM users u
WHERE u.email = 'admin@bakorwil.go.id'
ON CONFLICT DO NOTHING;

INSERT INTO kegiatan_ejsc (
    judul_kegiatan,
    deskripsi,
    tanggal_kegiatan,
    lokasi,
    organizer_id,
    status,
    max_participants,
    is_public,
    created_at,
    updated_at
)
SELECT 
    'Bootcamp: UI/UX Design Fundamentals',
    'Bootcamp 3 hari untuk mempelajari fundamental UI/UX Design. Peserta akan belajar design thinking, wireframing, prototyping, dan user testing. Cocok untuk pemula yang ingin berkarir di bidang design.',
    CURRENT_DATE + INTERVAL '14 days',
    'Online via Zoom',
    u.id_user,
    'akan_datang',
    50,
    true,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
FROM users u
WHERE u.email = 'admin@bakorwil.go.id'
ON CONFLICT DO NOTHING;

-- ============================================
-- 6. Verification & Statistics
-- ============================================

DO $$
DECLARE
    user_count INT;
    admin_count INT;
    mentor_count INT;
    talent_count INT;
    client_count INT;
    kegiatan_count INT;
BEGIN
    SELECT COUNT(*) INTO user_count FROM users;
    SELECT COUNT(*) INTO admin_count FROM users WHERE role = 'admin';
    SELECT COUNT(*) INTO mentor_count FROM mentor;
    SELECT COUNT(*) INTO talent_count FROM talenta;
    SELECT COUNT(*) INTO client_count FROM client;
    SELECT COUNT(*) INTO kegiatan_count FROM kegiatan_ejsc;
    
    RAISE NOTICE '✅ Seeding completed successfully!';
    RAISE NOTICE '═══════════════════════════════════════════';
    RAISE NOTICE 'Database Statistics:';
    RAISE NOTICE '-------------------------------------------';
    RAISE NOTICE 'Total Users       : %', user_count;
    RAISE NOTICE '  - Admin         : %', admin_count;
    RAISE NOTICE '  - Mentor        : %', mentor_count;
    RAISE NOTICE '  - Talent        : %', talent_count;
    RAISE NOTICE '  - Client        : %', client_count;
    RAISE NOTICE 'Total Kegiatan    : %', kegiatan_count;
    RAISE NOTICE '═══════════════════════════════════════════';
    RAISE NOTICE '';
    RAISE NOTICE '🔐 Default Login Credentials:';
    RAISE NOTICE '-------------------------------------------';
    RAISE NOTICE '1. ADMIN';
    RAISE NOTICE '   Email    : admin@bakorwil.go.id';
    RAISE NOTICE '   Password : password';
    RAISE NOTICE '   Role     : Administrator (full access)';
    RAISE NOTICE '';
    RAISE NOTICE '2. MENTOR';
    RAISE NOTICE '   Email    : mentor@example.com';
    RAISE NOTICE '   Password : password';
    RAISE NOTICE '   Role     : Mentor (Budi Santoso)';
    RAISE NOTICE '';
    RAISE NOTICE '3. TALENT';
    RAISE NOTICE '   Email    : talent@example.com';
    RAISE NOTICE '   Password : password';
    RAISE NOTICE '   Role     : Talent (Siti Nurhaliza)';
    RAISE NOTICE '';
    RAISE NOTICE '4. CLIENT';
    RAISE NOTICE '   Email    : client@example.com';
    RAISE NOTICE '   Password : password';
    RAISE NOTICE '   Role     : Client (PT Jember Digital)';
    RAISE NOTICE '═══════════════════════════════════════════';
    RAISE NOTICE '';
    RAISE NOTICE '⚠️  IMPORTANT SECURITY NOTES:';
    RAISE NOTICE '-------------------------------------------';
    RAISE NOTICE '1. Change all passwords immediately in production!';
    RAISE NOTICE '2. These are demo accounts for development only';
    RAISE NOTICE '3. Never use default passwords in production';
    RAISE NOTICE '4. Enable 2FA for admin accounts';
    RAISE NOTICE '═══════════════════════════════════════════';
END $$;