<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_activity_log extends Model
{
    use HasFactory;

    protected $table = 't_activity_log';
    protected $primaryKey = 'activity_log_id';
    protected $fillable = ['username', 'module', 'action', 'description'];
}
