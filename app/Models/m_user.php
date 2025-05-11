<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_user extends Model
{
    use HasFactory;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    protected $fillable = ['username', 'fullname', 'password', 'profile_picture', 'email', 'no_telp'];

    public function role()
    {
        return $this->belongsTo(m_role::class, 'role_id', 'role_id');
    }
}
