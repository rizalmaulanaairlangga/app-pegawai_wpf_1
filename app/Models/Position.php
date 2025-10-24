<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $table = 'positions';

    protected $fillable = [
        'nama_jabatan',
        'gaji_pokok',
    ];

    protected $casts = [
        'gaji_pokok' => 'integer',
    ];

    // Relasi: 1 posisi bisa dimiliki banyak karyawan
    public function employees()
    {
        return $this->hasMany(Employee::class, 'position_id');
    }
}
