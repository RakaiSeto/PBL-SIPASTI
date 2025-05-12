<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_laporan extends Model
{
    use HasFactory;

    protected $table = 'm_laporan';
    protected $primaryKey = 'laporan_id';
    protected $fillable = ['user_id', 'fasilitas_ruang_id', 'teknisi_id', 'deskripsi_laporan', 'lapor_datetime', 'review_pelapor', 'is_verified', 'is_done'];

    public function user()
    {
        return $this->belongsTo(m_user::class, 'user_id', 'user_id');
    }

    public function fasilitas_ruang()
    {
        return $this->belongsTo(m_fasilitas_ruang::class, 'fasilitas_ruang_id', 'fasilitas_ruang_id');
    }

    public function teknisi()
    {
        return $this->belongsTo(m_user::class, 'teknisi_id', 'user_id');
    }
}
