<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffectedUser extends Model
{
    use HasFactory;
    protected $primaryKey = 'affected_user_id';
    protected $fillable = [
        'user_id',
        'log_id',
    ];
    //not done
}
