<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_role extends Model
{
    use HasFactory;

    protected $table = 'm_role';
    protected $primaryKey = 'role_id';
    protected $fillable = ['role_nama'];
}
