-- ============================================
-- Bakorwil Jember - Update Schema
-- PostgreSQL Version
-- Date: 2026-08-22
-- Deskripsi: Update schema untuk menambahkan fitur admin management
-- ============================================

-- ============================================
-- 1. Update tabel users - Tambah kolom yang diperlukan
-- ============================================

-- Cek dan tambah kolom jika belum ada
DO $$
BEGIN
    -- Tambah kolom name jika belum ada (untuk compatibility dengan Laravel)
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='users' AND column_name='name') THEN
        ALTER TABLE users ADD COLUMN name VARCHAR(255);
        UPDATE users SET name = username WHERE name IS NULL;
    END IF;

    -- Tambah kolom remember_token jika belum ada (untuk Laravel auth)
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='users' AND column_name='remember_token') THEN
        ALTER TABLE users ADD COLUMN remember_token VARCHAR(100) NULL;
    END IF;

    -- Tambah kolom email_verified_at jika belum ada
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='users' AND column_name='email_verified_at') THEN
        ALTER TABLE users ADD COLUMN email_verified_at TIMESTAMP NULL;
    END IF;

    -- Tambah kolom profile_photo jika belum ada
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='users' AND column_name='profile_photo') THEN
        ALTER TABLE users ADD COLUMN profile_photo VARCHAR(255) NULL;
    END IF;
END $$;

-- Update constraint role untuk menambahkan role 'public' jika belum ada
ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check;
ALTER TABLE users ADD CONSTRAINT users_role_check 
CHECK (role IN ('admin', 'mentor', 'talenta', 'client', 'public'));

COMMENT ON COLUMN users.role IS 'Role user: admin, mentor, talenta, client, public';

-- ============================================
-- 2. Update tabel client - Standarisasi kolom
-- ============================================

DO $$
BEGIN
    -- Tambah kolom created_by jika belum ada (untuk tracking siapa yang membuat)
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='client' AND column_name='created_by') THEN
        ALTER TABLE client ADD COLUMN created_by BIGINT NULL;
        ALTER TABLE client ADD CONSTRAINT fk_client_created_by 
        FOREIGN KEY (created_by) REFERENCES users(id_user) ON DELETE SET NULL;
    END IF;

    -- Tambah kolom updated_by jika belum ada
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='client' AND column_name='updated_by') THEN
        ALTER TABLE client ADD COLUMN updated_by BIGINT NULL;
        ALTER TABLE client ADD CONSTRAINT fk_client_updated_by 
        FOREIGN KEY (updated_by) REFERENCES users(id_user) ON DELETE SET NULL;
    END IF;
END $$;

-- ============================================
-- 3. Update tabel mentor - Standarisasi kolom
-- ============================================

DO $$
BEGIN
    -- Tambah kolom created_by jika belum ada
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='mentor' AND column_name='created_by') THEN
        ALTER TABLE mentor ADD COLUMN created_by BIGINT NULL;
        ALTER TABLE mentor ADD CONSTRAINT fk_mentor_created_by 
        FOREIGN KEY (created_by) REFERENCES users(id_user) ON DELETE SET NULL;
    END IF;

    -- Tambah kolom updated_by jika belum ada
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='mentor' AND column_name='updated_by') THEN
        ALTER TABLE mentor ADD COLUMN updated_by BIGINT NULL;
        ALTER TABLE mentor ADD CONSTRAINT fk_mentor_updated_by 
        FOREIGN KEY (updated_by) REFERENCES users(id_user) ON DELETE SET NULL;
    END IF;

    -- Tambah kolom expertise_tags untuk array skills (jika belum ada)
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='mentor' AND column_name='expertise_tags') THEN
        ALTER TABLE mentor ADD COLUMN expertise_tags TEXT[] NULL;
    END IF;

    -- Tambah kolom is_available untuk status ketersediaan
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='mentor' AND column_name='is_available') THEN
        ALTER TABLE mentor ADD COLUMN is_available BOOLEAN DEFAULT true;
    END IF;

    -- Tambah kolom jumlah_mentee
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='mentor' AND column_name='jumlah_mentee') THEN
        ALTER TABLE mentor ADD COLUMN jumlah_mentee INT DEFAULT 0;
    END IF;
END $$;

-- ============================================
-- 4. Update tabel talenta - Standarisasi kolom
-- ============================================

DO $$
BEGIN
    -- Tambah kolom created_by jika belum ada
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='talenta' AND column_name='created_by') THEN
        ALTER TABLE talenta ADD COLUMN created_by BIGINT NULL;
        ALTER TABLE talenta ADD CONSTRAINT fk_talenta_created_by 
        FOREIGN KEY (created_by) REFERENCES users(id_user) ON DELETE SET NULL;
    END IF;

    -- Tambah kolom updated_by jika belum ada
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='talenta' AND column_name='updated_by') THEN
        ALTER TABLE talenta ADD COLUMN updated_by BIGINT NULL;
        ALTER TABLE talenta ADD CONSTRAINT fk_talenta_updated_by 
        FOREIGN KEY (updated_by) REFERENCES users(id_user) ON DELETE SET NULL;
    END IF;

    -- Tambah kolom skill_tags untuk array skills (jika belum ada)
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='talenta' AND column_name='skill_tags') THEN
        ALTER TABLE talenta ADD COLUMN skill_tags TEXT[] NULL;
    END IF;

    -- Tambah kolom mentor_id untuk relasi dengan mentor
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='talenta' AND column_name='mentor_id') THEN
        ALTER TABLE talenta ADD COLUMN mentor_id BIGINT NULL;
        ALTER TABLE talenta ADD CONSTRAINT fk_talenta_mentor 
        FOREIGN KEY (mentor_id) REFERENCES mentor(id_mentor) ON DELETE SET NULL;
    END IF;

    -- Tambah kolom status_pekerjaan
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='talenta' AND column_name='status_pekerjaan') THEN
        ALTER TABLE talenta ADD COLUMN status_pekerjaan VARCHAR(100) NULL;
    END IF;

    -- Rename url_buku_tabungan menjadi url_butap jika belum
    IF EXISTS (SELECT 1 FROM information_schema.columns 
               WHERE table_name='talenta' AND column_name='url_buku_tabungan') 
       AND NOT EXISTS (SELECT 1 FROM information_schema.columns 
                      WHERE table_name='talenta' AND column_name='url_butap') THEN
        ALTER TABLE talenta RENAME COLUMN url_buku_tabungan TO url_butap;
    END IF;
END $$;

-- ============================================
-- 5. Update/Create tabel kegiatan_ejsc
-- ============================================

-- Tabel sudah ada, tambah kolom jika diperlukan
DO $$
BEGIN
    -- Tambah kolom organizer_id jika belum ada
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='kegiatan_ejsc' AND column_name='organizer_id') THEN
        ALTER TABLE kegiatan_ejsc ADD COLUMN organizer_id BIGINT NULL;
        ALTER TABLE kegiatan_ejsc ADD CONSTRAINT fk_kegiatan_organizer 
        FOREIGN KEY (organizer_id) REFERENCES users(id_user) ON DELETE SET NULL;
    END IF;

    -- Tambah kolom lokasi jika belum ada
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='kegiatan_ejsc' AND column_name='lokasi') THEN
        ALTER TABLE kegiatan_ejsc ADD COLUMN lokasi VARCHAR(255) NULL;
    END IF;

    -- Tambah kolom max_participants
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='kegiatan_ejsc' AND column_name='max_participants') THEN
        ALTER TABLE kegiatan_ejsc ADD COLUMN max_participants INT NULL;
    END IF;

    -- Tambah kolom is_public
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='kegiatan_ejsc' AND column_name='is_public') THEN
        ALTER TABLE kegiatan_ejsc ADD COLUMN is_public BOOLEAN DEFAULT true;
    END IF;

    -- Tambah kolom gallery untuk multiple photos
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns 
                   WHERE table_name='kegiatan_ejsc' AND column_name='gallery') THEN
        ALTER TABLE kegiatan_ejsc ADD COLUMN gallery JSON NULL;
    END IF;
END $$;

-- ============================================
-- 6. Create tabel kegiatan_participants (jika belum ada)
-- ============================================

CREATE TABLE IF NOT EXISTS kegiatan_participants (
    id_participant BIGSERIAL PRIMARY KEY,
    id_kegiatan BIGINT NOT NULL,
    id_user BIGINT NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'registered',
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    attended_at TIMESTAMP NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_kegiatan) REFERENCES kegiatan_ejsc(id_kegiatan) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
    UNIQUE(id_kegiatan, id_user)
);

CREATE INDEX IF NOT EXISTS idx_kegiatan_participants_kegiatan 
ON kegiatan_participants(id_kegiatan);

CREATE INDEX IF NOT EXISTS idx_kegiatan_participants_user 
ON kegiatan_participants(id_user);

-- Constraint untuk status participant
DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM pg_constraint 
        WHERE conname = 'chk_kegiatan_participants_status'
    ) THEN
        ALTER TABLE kegiatan_participants ADD CONSTRAINT chk_kegiatan_participants_status 
        CHECK (status IN ('registered', 'confirmed', 'attended', 'cancelled'));
    END IF;
END $$;

COMMENT ON TABLE kegiatan_participants IS 'Peserta kegiatan/event';
COMMENT ON COLUMN kegiatan_participants.status IS 'Status: registered, confirmed, attended, cancelled';

-- ============================================
-- 7. Create tabel admin_logs (untuk audit trail)
-- ============================================

CREATE TABLE IF NOT EXISTS admin_logs (
    id_log BIGSERIAL PRIMARY KEY,
    id_user BIGINT NOT NULL,
    action VARCHAR(100) NOT NULL,
    table_name VARCHAR(100) NULL,
    record_id BIGINT NULL,
    old_values JSON NULL,
    new_values JSON NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS idx_admin_logs_user ON admin_logs(id_user);
CREATE INDEX IF NOT EXISTS idx_admin_logs_action ON admin_logs(action);
CREATE INDEX IF NOT EXISTS idx_admin_logs_table ON admin_logs(table_name);
CREATE INDEX IF NOT EXISTS idx_admin_logs_created ON admin_logs(created_at);

COMMENT ON TABLE admin_logs IS 'Log aktivitas admin untuk audit trail';

-- ============================================
-- 8. Tambah indexes untuk performa
-- ============================================

-- Index untuk searching dan filtering
CREATE INDEX IF NOT EXISTS idx_client_nama_ukm ON client USING gin(to_tsvector('indonesian', nama_ukm));
CREATE INDEX IF NOT EXISTS idx_mentor_nama ON mentor USING gin(to_tsvector('indonesian', nama));
CREATE INDEX IF NOT EXISTS idx_talenta_nama ON talenta USING gin(to_tsvector('indonesian', nama));

CREATE INDEX IF NOT EXISTS idx_client_domisili ON client(domisili);
CREATE INDEX IF NOT EXISTS idx_mentor_domisili ON mentor(domisili);
CREATE INDEX IF NOT EXISTS idx_talenta_domisili ON talenta(domisili);

CREATE INDEX IF NOT EXISTS idx_kegiatan_status ON kegiatan_ejsc(status);
CREATE INDEX IF NOT EXISTS idx_kegiatan_tanggal ON kegiatan_ejsc(tanggal_kegiatan);

-- ============================================
-- 9. Create trigger untuk updated_at otomatis
-- ============================================

-- Function untuk update timestamp
CREATE OR REPLACE FUNCTION update_modified_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Trigger untuk setiap tabel
DO $$
BEGIN
    -- Client
    IF NOT EXISTS (SELECT 1 FROM pg_trigger WHERE tgname = 'update_client_modtime') THEN
        CREATE TRIGGER update_client_modtime
        BEFORE UPDATE ON client
        FOR EACH ROW
        EXECUTE FUNCTION update_modified_column();
    END IF;

    -- Mentor
    IF NOT EXISTS (SELECT 1 FROM pg_trigger WHERE tgname = 'update_mentor_modtime') THEN
        CREATE TRIGGER update_mentor_modtime
        BEFORE UPDATE ON mentor
        FOR EACH ROW
        EXECUTE FUNCTION update_modified_column();
    END IF;

    -- Talenta
    IF NOT EXISTS (SELECT 1 FROM pg_trigger WHERE tgname = 'update_talenta_modtime') THEN
        CREATE TRIGGER update_talenta_modtime
        BEFORE UPDATE ON talenta
        FOR EACH ROW
        EXECUTE FUNCTION update_modified_column();
    END IF;

    -- Kegiatan
    IF NOT EXISTS (SELECT 1 FROM pg_trigger WHERE tgname = 'update_kegiatan_modtime') THEN
        CREATE TRIGGER update_kegiatan_modtime
        BEFORE UPDATE ON kegiatan_ejsc
        FOR EACH ROW
        EXECUTE FUNCTION update_modified_column();
    END IF;

    -- Users
    IF NOT EXISTS (SELECT 1 FROM pg_trigger WHERE tgname = 'update_users_modtime') THEN
        CREATE TRIGGER update_users_modtime
        BEFORE UPDATE ON users
        FOR EACH ROW
        EXECUTE FUNCTION update_modified_column();
    END IF;
END $$;

-- ============================================
-- 10. Create Views untuk Admin Dashboard
-- ============================================

-- View untuk statistik dashboard
CREATE OR REPLACE VIEW v_admin_dashboard_stats AS
SELECT 
    (SELECT COUNT(*) FROM client WHERE status = 'aktif') AS total_client_aktif,
    (SELECT COUNT(*) FROM mentor WHERE status = 'aktif') AS total_mentor_aktif,
    (SELECT COUNT(*) FROM talenta WHERE status = 'aktif') AS total_talenta_aktif,
    (SELECT COUNT(*) FROM kegiatan_ejsc WHERE status != 'dibatalkan') AS total_kegiatan,
    (SELECT COUNT(*) FROM kegiatan_ejsc WHERE status = 'akan_datang' 
     AND tanggal_kegiatan > CURRENT_DATE) AS kegiatan_upcoming,
    (SELECT COUNT(*) FROM profile_changes WHERE status = 'pending') AS pending_changes,
    (SELECT COUNT(*) FROM users WHERE status = 'pending') AS pending_users;

COMMENT ON VIEW v_admin_dashboard_stats IS 'Statistik untuk admin dashboard';

-- View untuk recent activities
CREATE OR REPLACE VIEW v_recent_activities AS
SELECT 
    al.id_log,
    al.action,
    al.table_name,
    al.created_at,
    u.username,
    u.name,
    u.role
FROM admin_logs al
JOIN users u ON al.id_user = u.id_user
ORDER BY al.created_at DESC
LIMIT 50;

COMMENT ON VIEW v_recent_activities IS 'Recent activities untuk monitoring admin';

-- ============================================
-- Success Message
-- ============================================

DO $$
BEGIN
    RAISE NOTICE '✅ Schema update completed successfully!';
    RAISE NOTICE '-----------------------------------';
    RAISE NOTICE 'Updates applied:';
    RAISE NOTICE '1. Users table updated with new columns';
    RAISE NOTICE '2. Client, Mentor, Talenta tables enhanced';
    RAISE NOTICE '3. Kegiatan table updated for event management';
    RAISE NOTICE '4. Kegiatan participants table created';
    RAISE NOTICE '5. Admin logs table created for audit trail';
    RAISE NOTICE '6. Indexes added for better performance';
    RAISE NOTICE '7. Triggers created for auto-update timestamps';
    RAISE NOTICE '8. Views created for admin dashboard';
    RAISE NOTICE '-----------------------------------';
    RAISE NOTICE 'Next step: Run 02_seed_admin_users.sql';
END $$;