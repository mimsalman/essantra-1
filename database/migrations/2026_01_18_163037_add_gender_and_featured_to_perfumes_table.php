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
        Schema::table('perfumes', function (Blueprint $table) {
            $table->enum('gender', ['men','women','unisex'])->default('unisex')->after('brand');
            $table->boolean('is_featured')->default(false)->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perfumes', function (Blueprint $table) {
            //
        });
    }
};
