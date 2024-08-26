<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'work_id', 'company_id', 'reviewed','city', 'applied'
    ];
    protected function casts(): array {
        
        return [
            'applied' => 'datetime',
        ];
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function work(): BelongsTo 
    {
        return $this->belongsTo(Work::class);
    }
    
    public function company(): BelongsTo 
    {
        return $this->belongsTo(Company::class);
    }
    
}
