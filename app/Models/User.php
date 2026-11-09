<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_STCECILIAS_EDITOR = 'stcecilias_editor';

    protected $attributes = ['cms_role' => null];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isCmsAdministrator() || $this->isStceciliasEditor();
    }

    public function isStceciliasEditor(): bool
    {
        return $this->cms_role === self::ROLE_STCECILIAS_EDITOR;
    }

    public function isCmsAdministrator(): bool
    {
        if ($this->cms_role !== null) {
            return false;
        }

        if (app()->isLocal()) {
            return true;
        }

        $allowed = config('filament.admin_emails', []);
        if ($allowed === []) {
            return false;
        }

        $needle = strtolower(trim($this->email));
        $allowedLower = array_map(static fn (string $e): string => strtolower(trim($e)), $allowed);

        return in_array($needle, $allowedLower, true);
    }
}
