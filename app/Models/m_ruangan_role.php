<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_ruangan_role extends Model
{
    use HasFactory;

    protected $table = 'm_ruangan_role';
    protected $primaryKey = 'ruangan_role_id';
    protected $fillable = ['ruangan_role_nama'];
}

