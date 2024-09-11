<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('final_asfa_coba', function (Blueprint $table) {
            $table->id();
            $table->string('Kendaraan', 100);
            $table->string('Wilayah', 100);
            $table->string('Status', 100);
            $table->string('Provinsi', 100);
            $table->string('Tahun', 100);
            $table->decimal('Nilai', 20, 2);
        });
    }

    public function down()
    {
        Schema::dropIfExists('final_asfa_coba');
    }
    
};
