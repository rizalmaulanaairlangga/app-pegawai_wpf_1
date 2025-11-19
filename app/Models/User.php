<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// Tambahkan use statement ini
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Ganti extends Model menjadi Authenticatable
class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 
        'email', 
        'username', 
        'password', 
        'role'
    ];

    protected $hidden = [
        'password',
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }
    
    // Jika perlu custom field untuk login
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }
}