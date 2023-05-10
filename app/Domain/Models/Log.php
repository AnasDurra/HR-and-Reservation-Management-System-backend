<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $primaryKey = 'log_id';
    protected $fillable = ['user_id', 'action_id', 'description', 'date'];

}
