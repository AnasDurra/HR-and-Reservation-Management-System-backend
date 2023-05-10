<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Staffing extends Model
{
    use HasFactory;

    protected $primaryKey = 'staff_id';
    protected $fillable = ['emp_id', 'job_title_id', 'dep_id', 'start_date', 'end_date'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'emp_id');
    }

    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class, 'job_title_id', 'job_title_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dep_id', 'dep_id');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'staff_permissions', 'staff_id', 'perm_id',
            'staff_id', 'perm_id')
            ->withPivot('status');
    }
}
