# SIGAP Rudenim Surabaya

**Sistem Informasi & Gerakan Administratif Pengungsi** — aplikasi web pendataan pengungsi luar negeri untuk wilayah kerja Rumah Detensi Imigrasi Surabaya.

Dibangun dengan **Laravel 11**, **Firebase Realtime Database** sebagai sumber data utama (dengan fallback ke database lokal), dan **Vercel** untuk deployment.

---

## Ringkasan

| Aspek                | Detail                                                                                  |
|----------------------|-----------------------------------------------------------------------------------------|
| **Framework**        | Laravel 11 (PHP 8.2+)                                                                   |
| **Database utama**   | Firebase Realtime Database — `ralf-803d6-default-rtdb.asia-southeast1.firebasedatabase.app` |
| **Database lokal**   | SQLite (default) atau MySQL / PostgreSQL                                                 |
| **Penyimpanan file** | Lokal (disk Laravel) atau Firebase Storage via REST                                      |
| **Auth**             | Hybrid: Laravel Auth (email + password) atau sesi demo cepat per peran                  |
| **Repositori**       | GitHub                                                                                  |
| **Deployment**       | Vercel (PHP runtime serverless)                                                          |

---

## Modul Fungsional

| Modul | Deskripsi |
|---|---|
| **Dashboard** | Statistik harian, aktivitas terbaru, status sinkronisasi Firebase, wizard input |
| **CRUD Data Pengungsi** | Create, Read, Update, Delete identitas, kebangsaan, status, lokasi, dokumen utama |
| **Modul Unggah Dokumen** | Identitas utama, administrasi, riwayat penempatan, lampiran tambahan. Lokal atau Firebase Storage |
| **Modul Penempatan** | Pencatatan hunian aktif, mutasi, riwayat per pengungsi |
| **Pencarian & Filter** | Filter per kebangsaan, status, lokasi, kelengkapan dokumen, urutan, paginasi |
| **Pembaruan & Log Aktivitas** | Audit trail otomatis tiap CRUD: pelaku, waktu, alasan, perubahan nilai |
| **Penyusunan Laporan** | Rekap data aktif, laporan dokumen, audit trail, prioritas verifikasi |

## Kebutuhan Non-Fungsional

| Aspek | Implementasi |
|---|---|
| **Role-Based Access Control** | 3 peran: `admin` (full access), `petugas` (CRUD ops), `supervisor` (review & reports). Middleware `EnsureSigapAbility` enforce per route |
| **Keamanan Otentikasi** | Hash password Bcrypt, CSRF token, session regenerate, password ≥ 6 char, hybrid login support |
| **Antarmuka Mudah & Menarik** | Tema **Biru Tosca & Emas**, responsif (mobile-first), wizard 4 langkah untuk input, font Plus Jakarta Sans, ikon SVG inline |
| **Ketersediaan & Keandalan** | Fallback chain: Firebase RTDB → DB lokal → sample data. Service di-singleton, try/catch di network call, paginasi server-side |

---

## Cara Menjalankan Lokal

### 1. Persiapan

```bash
# Clone repo
git clone <repository-url>
cd aplikasi_pendataan_pengungsi

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Buat database SQLite (atau gunakan MySQL)
touch database/database.sqlite

# Jalankan migrasi & seeder
php artisan migrate --seed
```

### 2. Jalankan server

```bash
php artisan serve
```

Akses di `http://localhost:8000`.

### 3. Login default (hasil seeder)

| Peran       | Email                              | Password               |
|-------------|------------------------------------|------------------------|
| Admin       | `admin@sigap-rudenim.local`        | `Sigap@Admin2026`      |
| Petugas     | `petugas@sigap-rudenim.local`      | `Sigap@Petugas2026`    |
| Supervisor  | `supervisor@sigap-rudenim.local`   | `Sigap@Supervisor2026` |

> **⚠️ Ganti password default sebelum deploy ke produksi.**

Atau gunakan **login demo** (pilih peran tanpa password) di halaman `/login`.

---

## Mode Operasi (Saklar Environment)

Atur di `.env`:

| Variabel | Nilai | Efek |
|---|---|---|
| `SIGAP_LOGIN_MODE` | `hybrid` (rekomendasi), `auth`, `demo` | Mode login default di halaman login |
| `SIGAP_DEMO_LOGIN_ENABLED` | `true` / `false` | Aktifkan tombol login demo |
| `SIGAP_LARAVEL_AUTH_ENABLED` | `true` / `false` | Aktifkan form login Laravel |
| `SIGAP_FIREBASE_READ_ENABLED` | `true` (default) / `false` | Baca data dari Firebase RTDB |
| `SIGAP_SAMPLE_DATA_ENABLED` | `true` / `false` | Fallback ke sample data bila Firebase & DB kosong |
| `SIGAP_ACTIVE_ROLE` | kosong / `admin` / `petugas` / `supervisor` | Bypass login (DEV only — kosongkan di prod) |
| `FIREBASE_STORAGE_DISK` | `local` / `firebase-rest` | Lokasi penyimpanan dokumen unggahan |

### Profil rekomendasi

**Preview / Handoff:**
```env
SIGAP_LOGIN_MODE=hybrid
SIGAP_DEMO_LOGIN_ENABLED=true
SIGAP_LARAVEL_AUTH_ENABLED=true
SIGAP_SAMPLE_DATA_ENABLED=true
SIGAP_FIREBASE_READ_ENABLED=true
```

**Produksi:**
```env
SIGAP_LOGIN_MODE=auth
SIGAP_DEMO_LOGIN_ENABLED=false
SIGAP_LARAVEL_AUTH_ENABLED=true
SIGAP_SAMPLE_DATA_ENABLED=false
SIGAP_FIREBASE_READ_ENABLED=true
FIREBASE_STORAGE_DISK=firebase-rest
FIREBASE_STORAGE_BEARER_TOKEN=<bearer-token-firebase-storage>
```

---

## Peta Data Firebase RTDB

URL: `https://ralf-803d6-default-rtdb.asia-southeast1.firebasedatabase.app/`

```
/refugees/{key}         — identitas, kebangsaan, status, lokasi, dokumen utama
/documents/{key}        — metadata dokumen pendukung, status verifikasi
/placements/{key}       — hunian aktif, tanggal masuk/keluar, status penempatan
/audit_trails/{auto}    — log perubahan: field, nilai lama/baru, pelaku, waktu
/reports/{auto}         — log unduh laporan, filter yang dipakai, pelaku
/users/{key}            — referensi akun (opsional, sumber otoritatif tetap DB Laravel)
```

Operasi CRUD di Laravel otomatis sync ke Firebase via `FirebaseRealtimeDatabaseService`.

---

## Deployment ke Vercel

Repo sudah berisi `vercel.json` dan `api/index.php` untuk runtime PHP serverless.

### Langkah

1. Push repo ke GitHub.
2. Di [vercel.com](https://vercel.com), **Import Project** dari GitHub.
3. Tambahkan environment variables di **Vercel → Settings → Environment Variables**:
   - `APP_KEY` (generate dengan `php artisan key:generate --show`)
   - `APP_NAME`, `APP_URL` (otomatis dari Vercel)
   - `FIREBASE_DATABASE_URL`, `FIREBASE_AUTH_DOMAIN`, `FIREBASE_STORAGE_BUCKET`
   - `FIREBASE_DATABASE_SECRET` (jika diperlukan auth Firebase)
   - `SIGAP_LOGIN_MODE=auth`
   - `SIGAP_SAMPLE_DATA_ENABLED=false`
   - Untuk database: hosting MySQL eksternal (PlanetScale, Aiven, Railway) lalu set `DB_*`.
4. Deploy. Vercel akan menjalankan `composer install` otomatis dan handle request via `api/index.php`.

> Catatan: Vercel pakai filesystem read-only kecuali `/tmp`. `api/index.php` sudah mengarahkan view cache, session file, dan log ke `/tmp`. Pertimbangkan `SESSION_DRIVER=cookie` atau Redis untuk session di lingkungan multi-instance.

---

## Struktur Folder

```
aplikasi_pendataan_pengungsi/
├── app/
│   ├── Http/
│   │   ├── Controllers/         # Refugee, Document, Placement, Auth, Dashboard, History, Report, Setting
│   │   ├── Middleware/          # EnsureSigapAuthenticated, EnsureSigapAbility
│   │   └── Requests/            # Validation request: filter, upsert refugee/placement/document
│   ├── Models/                  # Refugee, RefugeeDocument, Placement, AuditTrail, ReportLog, User
│   ├── Policies/                # Refugee, Placement, RefugeeDocument
│   ├── Providers/               # AppServiceProvider, AuthServiceProvider
│   └── Services/                # FirebaseService, FirebaseRealtimeDatabaseService, FirebaseStorageService, RoleAccessService, SigapDataService
├── bootstrap/                   # app.php (middleware alias, routing), providers.php
├── config/                      # app, auth, cache, database, filesystems, logging, mail, queue, services, session, sigap (custom), view
├── database/
│   ├── factories/               # Refugee, RefugeeDocument, Placement, AuditTrail, ReportLog
│   ├── migrations/              # Base tables + Sigap tables (refugees, placements, documents, audit_trails, report_logs)
│   └── seeders/                 # UserSeeder, SigapSeeder, DatabaseSeeder
├── public/
│   ├── index.php                # Front controller Laravel
│   └── .htaccess                # Apache rewrite
├── api/
│   └── index.php                # Entrypoint Vercel serverless
├── resources/
│   ├── views/
│   │   ├── auth/                # login
│   │   ├── components/          # icon (SVG)
│   │   ├── dashboard/, refugees/, documents/, placements/, history/, reports/, settings/
│   │   ├── layouts/             # app.blade.php (utama), sigap.blade.php
│   │   ├── partials/            # sidebar, topbar
│   │   └── sigap/partials/      # styles (CSS tema Biru Tosca & Emas)
├── routes/
│   ├── web.php                  # Semua route SIGAP
│   └── console.php
├── storage/                     # Laravel storage scaffold
├── .env.example                 # Template environment
├── .gitignore, .gitattributes
├── artisan                      # Laravel CLI
├── composer.json                # Dependencies
├── vercel.json                  # Vercel config
└── README.md                    # File ini
```

---

## Catatan Keamanan

- **CSRF token** otomatis di semua form via `@csrf` Blade directive.
- **Password hashing** dengan Bcrypt (default Laravel).
- **Session encryption** dapat diaktifkan dengan `SESSION_ENCRYPT=true`.
- **HTTPS enforce** di produksi via `AppServiceProvider::boot()`.
- **Firebase secret** TIDAK boleh di-commit. Selalu via environment variable.
- **Role check ganda**: middleware di route + ensureAbility() di controller method.
- **Mass assignment protection** via `$fillable` di tiap model.
- **Input validation** via FormRequest class untuk semua mutasi.

---

## Lisensi

MIT — bebas dipakai dan dimodifikasi untuk keperluan internal Rumah Detensi Imigrasi.

---

**Dikembangkan untuk Rumah Detensi Imigrasi Surabaya, 2026.**
