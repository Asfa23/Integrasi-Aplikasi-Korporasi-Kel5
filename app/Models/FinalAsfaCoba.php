<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalAsfaCoba extends Model
{
    use HasFactory;

    protected $table = 'final_asfa_coba'; // Nama tabel
    protected $primaryKey = null; // Tanpa primary key, atau set sesuai kebutuhan
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'Kendaraan',
        'Wilayah',
        'Status',
        'Provinsi',
        'Tahun',
        'Nilai',
    ];
}
