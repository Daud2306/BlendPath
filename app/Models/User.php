<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
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

    protected $table = 'users';

    public function progress()
    {
        return $this->hasMany(Progress::class);
    }

    public function tanya()
    {
        return $this->hasMany(Tanya::class);
    }

    public function jawab()
    {
        return $this->hasMany(Jawab::class);
    }

    public function responQuizzes()
    {
        return $this->hasMany(ResponQuiz::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function getOverallProgress()
    {
        $totalSubmoduls = Submodul::count();
        if ($totalSubmoduls === 0) return 0;

        $completedSubmoduls = $this->progress()->where('is_completed', true)->count();
        return round(($completedSubmoduls / $totalSubmoduls) * 100, 1);
    }

    public function getCompletedSubmodulsCount()
    {
        return $this->progress()->where('is_completed', true)->count();
    }

    public function getEnrolledModulsCount()
    {
        return $this->progress()
            ->join('submoduls', 'progress.submodul_id', '=', 'submoduls.id')
            ->distinct('submoduls.modul_id')
            ->count('submoduls.modul_id');
    }

    public function isActive()
    {
        return $this->updated_at && $this->updated_at->gte(now()->subDays(30));
    }

    public function showcases()
    {
        return $this->hasMany(Showcase::class);
    }
}
