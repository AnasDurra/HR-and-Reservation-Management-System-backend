<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'schedule_id';
    protected $fillable = ['name', 'time_in', 'time_out'];
    protected $hidden = ['pivot'];

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class,'schedule_employees','schedule_id','emp_id',
            'schedule_id','emp_id');
    }
}
