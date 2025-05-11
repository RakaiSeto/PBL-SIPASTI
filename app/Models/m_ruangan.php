<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_ruangan extends Model
{
    use HasFactory;

    protected $table = 'm_ruangan';
    protected $primaryKey = 'ruangan_id';
    protected $fillable = ['ruangan_nama', 'lantai'];

    public function ruangan_role()
    {
        return $this->belongsTo(m_ruangan_role::class, 'ruangan_role_id', 'ruangan_role_id');
    }
}
