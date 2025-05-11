<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_log_pekerjaan extends Model
{
    use HasFactory;

    protected $table = 'm_log_pekerjaan';
    protected $primaryKey = 'log_pekerjaan_id';
    protected $fillable = ['laporan_id', 'deskripsi_pekerjaan', 'log_datetime'];

    public function laporan()
    {
        return $this->belongsTo(m_laporan::class, 'laporan_id', 'laporan_id');
    }

    public function user()
    {
        return $this->belongsTo(m_user::class, 'user_id', 'user_id');
    }
}