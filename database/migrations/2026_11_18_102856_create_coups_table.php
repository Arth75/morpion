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
        Schema::create('coups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partie_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('position');
            $table->string('symbole', 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coups');
    }
};