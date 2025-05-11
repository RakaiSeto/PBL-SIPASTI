<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_fasilitas extends Model
{
    use HasFactory;

    protected $table = 'm_fasilitas';
    protected $primaryKey = 'fasilitas_id';
    protected $fillable = ['fasilitas_nama'];

    public function ruangan()
    {
        return $this->belongsTo(m_ruangan::class, 'ruangan_id', 'ruangan_id');
    }
}
