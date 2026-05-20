<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class RoleAccessService
{
    public function authModes(): array
    {
        $modes = [];

        if (filter_var(config('sigap.auth.demo_enabled', true), FILTER_VALIDATE_BOOL)) {
            $modes['demo'] = [
                'label' => 'Login Demo',
                'description' => 'Masuk cepat dengan role simulasi tanpa tabel user.',
            ];
        }

        if (filter_var(config('sigap.auth.laravel_auth_enabled', true), FILTER_VALIDATE_BOOL)) {
            $modes['auth'] = [
                'label' => 'Akun Laravel',
                'description' => 'Masuk dengan email dan password dari tabel users.',
            ];
        }

        return $modes;
    }

    public function defaultAuthMode(): string
    {
        $configured = (string) config('sigap.auth.login_mode', 'hybrid');
        $modes = $this->authModes();

        if ($configured === 'auth' && array_key_exists('auth', $modes)) {
            return 'auth';
        }

        if ($configured === 'demo' && array_key_exists('demo', $modes)) {
            return 'demo';
        }

        return array_key_first($modes) ?? 'demo';
    }

    public function roles(): array
    {
        return [
            'admin' => [
                'label' => 'Admin',
                'abilities' => ['full-access', 'manage-refugees', 'manage-documents', 'manage-reports', 'view-reports', 'manage-settings'],
            ],
            'petugas' => [
                'label' => 'Petugas Pendataan',
                'abilities' => ['manage-refugees', 'manage-documents', 'manage-placements'],
            ],
            'supervisor' => [
                'label' => 'Supervisor',
                'abilities' => ['review-changes', 'verify-documents', 'view-reports'],
            ],
        ];
    }

    public function flow(): array
    {
        return [
            ['step' => 'Input awal', 'actor' => 'Petugas Pendataan', 'description' => 'Mengisi identitas, administrasi dasar, penempatan, dan unggah dokumen awal.'],
            ['step' => 'Validasi operasional', 'actor' => 'Supervisor', 'description' => 'Memeriksa perubahan penting, verifikasi dokumen, dan mutasi penempatan.'],
            ['step' => 'Finalisasi & pengaturan', 'actor' => 'Admin', 'description' => 'Mengelola konfigurasi, audit, ekspor laporan, dan penghapusan data sensitif.'],
        ];
    }

    public function currentRoleKey(): string
    {
        $authRole = Auth::check() ? (string) (Auth::user()->role ?? '') : '';
        $sessionRole = (string) session('sigap_user.role', '');
        $envRole = (string) config('sigap.auth.active_role_fallback', '');
        $role = $authRole !== ''
            ? $authRole
            : ($sessionRole !== '' ? $sessionRole : $envRole);

        return array_key_exists($role, $this->roles()) ? $role : 'supervisor';
    }

    public function currentRole(): array
    {
        if (! $this->isSignedIn()) {
            return [
                'key' => 'guest',
                'label' => 'Belum Login',
                'abilities' => [],
                'source' => 'guest',
            ];
        }

        $key = $this->currentRoleKey();
        $source = Auth::check() && filled(Auth::user()->role ?? null)
            ? 'auth'
            : (filled(session('sigap_user.role')) ? 'session' : 'env');

        return [
            'key' => $key,
            'label' => $this->roles()[$key]['label'],
            'abilities' => $this->roles()[$key]['abilities'],
            'source' => $source,
        ];
    }

    public function isSignedIn(): bool
    {
        return Auth::check()
            || filled(session('sigap_user.role'))
            || array_key_exists((string) config('sigap.auth.active_role_fallback', ''), $this->roles());
    }

    public function currentUser(): array
    {
        if (Auth::check()) {
            return [
                'name' => (string) (Auth::user()->name ?? 'Pengguna'),
                'email' => (string) (Auth::user()->email ?? ''),
                'role' => $this->currentRole(),
            ];
        }

        if (filled(session('sigap_user.name'))) {
            return [
                'name' => (string) session('sigap_user.name'),
                'email' => (string) session('sigap_user.email', ''),
                'role' => $this->currentRole(),
            ];
        }

        return [
            'name' => 'Tamu',
            'email' => '',
            'role' => $this->currentRole(),
        ];
    }

    public function can(string $ability, ?string $role = null): bool
    {
        if ($role === null && ! $this->isSignedIn()) {
            return false;
        }

        $roleKey = $role ?: $this->currentRoleKey();
        $abilities = $this->roles()[$roleKey]['abilities'] ?? [];

        return in_array('full-access', $abilities, true) || in_array($ability, $abilities, true);
    }
}
