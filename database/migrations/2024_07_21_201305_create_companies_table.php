<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('phone');
            $table->string('email')->unique();
            $table->boolean('converted')->default(false);
            $table->timestamp('converted_at')->default(DB::raw('CURRENT_TIMESTAMP')); 
            $table->integer('total_applications')->default(0);
            $table->integer('reviewed_applications')->default(0);
            $table->integer('active_jobs')->default(0);  
            $table->timestamp('last_login')->default(DB::raw('CURRENT_TIMESTAMP'));                      
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
