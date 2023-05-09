<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTitlePermission extends Model
{
    use HasFactory;
    protected $primaryKey = 'job_title_perm_id';
    protected $fillable = ['job_title_id', 'perm_id'];
}
