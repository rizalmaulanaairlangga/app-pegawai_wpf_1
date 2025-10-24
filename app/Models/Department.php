<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'departments';

    // Kolom yang dapat diisi
    protected $fillable = [
        'nama_departemen',
    ];

    // Relasi: 1 departemen punya banyak karyawan
    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id');
    }
}
