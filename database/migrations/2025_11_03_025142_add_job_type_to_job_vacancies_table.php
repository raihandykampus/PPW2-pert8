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
        Schema::table('job_vacancies', function (Blueprint $table) {
            // Tambah kolom 'job_type' setelah 'salary'
            $table->string('job_type')->nullable()->after('salary');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::table('job_vacancies', function (Blueprint $table) {
            // Cara membatalkan/menghapus kolom
            $table->dropColumn('job_type');
        });
    }
};
