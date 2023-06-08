<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Models\Action;
use App\Domain\Models\AffectedUser;
use App\Domain\Models\User;
use App\Domain\Repositories\LogRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentLogRepository implements LogRepositoryInterface
{

    public function getAllAction(): Collection
    {
        return Action::all();
    }

    //get id and full name for affected user
    public function getAllAffectedUser(): LengthAwarePaginator
    {
        /**
         * get the user_id from User table , with first_name and last_name from Employee table
         * where user_type_id == 1 && user_id is exists in AffectedUser table
         * */
        $users = User::query()
            ->WhereHas('logs', function ($query) {
                return $query
                    ->where('affected_user_id', '!=', null);
            });

//        dd($users->first()-);

        $affectedUsers = [];
        foreach ($users as $user) {
            if ($user->user_type_id == 1 /*type for the employee*/) {
                $user_id = $user->user_id;
                $first_name = $user->employee->jobApplication->empData->first_name;
                $last_name = $user->employee->jobApplication->empData->last_name;

                $affectedUsers[] = [
                    "user_id" => $user_id,
                    "first_name" => $first_name,
                    "last_name" => $last_name
                ];
            }
        }

        dd($affectedUsers);
//
//        $user_id = request('user_id');
//        $name = request('name');
//
//        if ($affected_user->user_type_id == 1 /*type for the employee*/) {
//            $affected_user->user->employee->full_name;
//        }
//
//        if ($user_id) {
//            $affected_user->where('user_id', '=', $user_id);
//        }
//        if ($name) {
//            $affected_user->whereHas('user', function ($query) use ($name) {
//                $query->where('first_name', 'like', '%' . $name . '%')->orWhere('last_name', 'like', '%' . $name . '%');
//            });
//        }
//        return $affected_user->paginate(10);
    }

    // get id and full name from User
    public function getAllUser(): LengthAwarePaginator
    {
        $user = User::query()->select('user_id', 'first_name', 'last_name');


        $user_id = request('user_id');
        $first_name = request('first_name');
        $last_name = request('last_name');

        if ($user_id) {
            $user->where('user_id', '=', $user_id);
        }
        if ($first_name) {
            $user->where('first_name', 'like', '%' . $first_name . '%');
        }
        if ($last_name) {
            $user->where('last_name', 'like', '%' . $last_name . '%');
        }

        return $user->paginate(10);
    }
}
