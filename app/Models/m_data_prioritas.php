<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_data_prioritas extends Model
{
    use HasFactory;

    protected $table = 'm_data_prioritas';
    protected $primaryKey = 'prioritas_id';
    protected $fillable = ['prioritas_nama', 'prioritas_bobot'];
}
