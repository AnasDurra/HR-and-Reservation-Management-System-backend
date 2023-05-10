<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Action extends Model
{
    use HasFactory;

    protected $primaryKey = 'action_id';
    protected $fillable = ['name', 'description'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'logs', 'action_id', 'user_id',
            'action_id', 'user_id')
            ->withPivot('description', 'date');
    }


}
