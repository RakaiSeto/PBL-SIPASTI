<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_fasilitas_ruang extends Model
{
    use HasFactory;

    protected $table = 'm_fasilitas_ruang';
    protected $primaryKey = 'fasilitas_ruang_id';
    protected $fillable = ['fasilitas_id', 'ruangan_id'];

    public function fasilitas()
    {
        return $this->belongsTo(m_fasilitas::class, 'fasilitas_id', 'fasilitas_id');
    }

    public function ruangan()
    {
        return $this->belongsTo(m_ruangan::class, 'ruangan_id', 'ruangan_id');
    }
}
