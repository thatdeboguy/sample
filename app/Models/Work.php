<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
          'title', 'company_id', 'published', 'last_modified', 'city'
    ];
   public function company(): BelongsTo
   {
        return $this->belongsTo(Company::class);
   }
   public function applications(): HasMany 
   {
        return $this->hasMany(Application::class);
   }
}
