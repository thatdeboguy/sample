<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'phone', 'email', 'converted','total_applications', 'reviewed_applications', 'active_jobs', 'last_login'
    ];

    protected function casts(): array
    {
        return [
            'last_login' => 'datetime',
        ];
    }
    public function works():HasMany 
    {
        return $this->hasMany(Work::class);
    }
    public function applications(): HasMany 
    {
        return $this->hasMany(Application::class);
    }
}
