<?php

namespace App\Domain\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_type_id',
        'first_name',
        'last_name',
        'email',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id','user_id');
    }

    public function usertype()
    {
        return $this->belongsTo(UserType::class, 'user_type_id','user_type_id');
    }

    public function actions(){
        return $this->belongsToMany(Action::class,'logs','user_id','action_id',
            'user_id','action_id')
            ->withPivot('description','date');
    }


}
