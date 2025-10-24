<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'status_absensi',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal' => 'string',
        'waktu_masuk' => 'string',
        'waktu_keluar' => 'string',
    ];

    // Relasi: setiap absensi milik satu karyawan
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'karyawan_id');
    }
}
