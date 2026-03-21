<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up(): void
{
    Schema::create('tickets', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description');
        $table->string('status')->default('nowe'); // np. nowe, w trakcie, zamknięte
        $table->string('priority')->default('niski'); // np. niski, średni, wysoki
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('assigned_it_id')->nullable()->constrained('users')->onDelete('set null');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
