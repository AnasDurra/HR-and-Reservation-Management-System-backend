<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Models\Action;
use App\Domain\Models\AffectedUser;
use App\Domain\Models\User;
use App\Domain\Repositories\LogRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentLogRepository implements LogRepositoryInterface
{

    public function getAllAction(): Collection
    {
        return Action::all();
    }

    // get id and full name for affected users
    public function getAllAffectedUser(): LengthAwarePaginator
    {
        $affected_user = AffectedUser::query()->select('user_id')->distinct();

        $name = request('name');

        if ($name != null) {
            $affected_user->whereHas('user.employee.jobApplication.empData', function (Builder $query) use ($name) {
                $query->where('first_name', 'LIKE', '%' . $name . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $name . '%');
            });
        }

        return $affected_user->paginate(10);
    }


    //get id and full name for users
    public function getAllUser(): LengthAwarePaginator
    {
        $user = User::query();

        $name = request('name');

        if ($name != null) {
            $user->whereHas('employee.jobApplication.empData', function (Builder $query) use ($name) {
                $query->where('first_name', 'LIKE', '%' . $name . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $name . '%');
            });
        }

        return $user->paginate(10);
    }
}
