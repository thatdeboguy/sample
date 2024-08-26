<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Administrator extends Model
{
    use HasFactory;

    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }
    protected $fillable =[
        'user_id', 'email', 'roles', 'last_login'
    ];
    protected function casts(): array {
        
        return [
            'last_login' => 'datetime',
        ];
    }
}
