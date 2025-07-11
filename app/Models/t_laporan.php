<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_laporan extends Model
{
    use HasFactory;

    protected $table = 't_laporan';
    protected $primaryKey = 'laporan_id';
    protected $fillable = ['user_id', 'fasilitas_ruang_id', 'teknisi_id', 'deskripsi_laporan', 'lapor_foto', 'lapor_datetime', 'verifikasi_datetime', 'selesai_datetime', 'review_pelapor', 'review_komentar', 'spk_kerusakan', 'spk_dampak', 'spk_frekuensi', 'spk_waktu_perbaikan', 'is_verified', 'is_done', 'is_kerjakan'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(m_user::class, 'user_id', 'user_id');
    }

    public function fasilitas_ruang()
    {
        return $this->belongsTo(t_fasilitas_ruang::class, 'fasilitas_ruang_id', 'fasilitas_ruang_id');
    }

    public function teknisi()
    {
        return $this->belongsTo(m_user::class, 'teknisi_id', 'user_id');
    }

    public function ruangan()
    {
        return $this->hasOneThrough(
            \App\Models\m_ruangan::class,
            \App\Models\t_fasilitas_ruang::class,
            'fasilitas_ruang_id', // Foreign key di t_fasilitas_ruang
            'ruangan_id',         // Foreign key di m_ruangan
            'fasilitas_ruang_id', // Local key di t_laporan
            'ruangan_id'          // Local key di t_fasilitas_ruang
        );
    }

    public function fasilitas()
    {
        return $this->hasOneThrough(
            \App\Models\m_fasilitas::class,
            \App\Models\t_fasilitas_ruang::class,
            'fasilitas_ruang_id',
            'fasilitas_id',
            'fasilitas_ruang_id',
            'fasilitas_id'
        );
    }
}
