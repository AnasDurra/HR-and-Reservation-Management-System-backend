<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestStatus extends Model
{
    use HasFactory;
    protected $primaryKey = 'req_stat_id';
    protected $fillable = ['name', 'description'];
    protected $timestamps = true;

    public function shiftRequests()
    {
        return $this->hasMany(ShiftRequest::class, 'req_stat_id', 'req_stat_id');
    }
}
