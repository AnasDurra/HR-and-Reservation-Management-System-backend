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
        $users = User::query()
            ->WhereHas('logs', function ($query) {
                return $query
                    ->where('affected_user_id', '!=', null);
            })->get();

        $affectedUsers = array();
        foreach ($users as $user) {
            if ($user->user_type_id == 1 /*type for the employee*/) {

                // get the user id
                $user_id = $user->user_id;

                if (isset($user->employee)) {
                    $jobApplication = $user->employee->jobApplication;
                    if (isset($jobApplication)) {
                        $empData = $jobApplication->empData;
                        if (isset($empData)) {
                            $first_name = $empData->first_name;
                            $last_name = $empData->last_name;

                            $affectedUsers[] = [
                                "user_id" => $user_id,
                                "first_name" => $first_name,
                                "last_name" => $last_name
                            ];
                        }
                    }
                }
            }
        }

        $finalUsers = array();
        $user_id = request('user_id');
        $name = request('name');

        if ($user_id) {
            foreach ($affectedUsers as $user) {
                if ($user['user_id'] === $user_id) {
                    // Value found
                    $finalUsers[] = [
                        "user_id" => $user['user_id'],
                        "first_name" => $user['first_name'],
                        "last_name" => $user['last_name']
                    ];
                    break;
                }
            }
        }
        if ($name) {
            foreach ($affectedUsers as $user) {
                if (stristr($user['first_name'], $name) !== false || stristr($user['last_name'], $name) !== false) {
                    // Value found
                    $finalUsers[] = [
                        "user_id" => $user['user_id'],
                        "first_name" => $user['first_name'],
                        "last_name" => $user['last_name']
                    ];
                }
            }
        }

        if (!$user_id && !$name) {
            $finalUsers = $affectedUsers;
        }


        $collection = new Collection($finalUsers);

        // Current page number (from request or any other source)
        $page = request()->input('page', 1);

        // Number of items to display per page
        $perPage = 10;

        // Calculate the offset
        $offset = ($page - 1) * $perPage;

        // Get the items for the current page using array_slice()
        $paginatedItems = array_slice($finalUsers, $offset, $perPage);

        // Create a new collection with the paginated items
        $paginatedCollection = collect($paginatedItems);

        // Total number of items in the array
        $totalItems = count($finalUsers);

        // Create a paginator manually
        $paginator = new LengthAwarePaginator(
            $paginatedCollection,
            $totalItems,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

//        // Access the paginated data
//        foreach ($paginator as $item) {
//            // Process each item
//        }
//
//        return response()->json([
//            'data' => $processedData,
//            'pagination' => [
//                'current_page' => $paginator->currentPage(),
//                'per_page' => $paginator->perPage(),
//                'total' => $paginator->total(),
//            ],
//        ]);


        return $paginator;
    }

    // get id and full name from User
    public function getAllUser(): LengthAwarePaginator
    {

        $users = User::query()->get();

        $usersArray = array();
        foreach ($users as $user) {
            if ($user->user_type_id == 1 /*type for the employee*/) {

                // get the user id
                $user_id = $user->user_id;

                if (isset($user->employee)) {
                    $jobApplication = $user->employee->jobApplication;
                    if (isset($jobApplication)) {
                        $empData = $jobApplication->empData;
                        if (isset($empData)) {
                            $first_name = $empData->first_name;
                            $last_name = $empData->last_name;

                            $usersArray[] = [
                                "user_id" => $user_id,
                                "first_name" => $first_name,
                                "last_name" => $last_name
                            ];
                        }
                    }
                }
            }
        }

        $finalUsers = array();
        $user_id = request('user_id');
        $name = request('name');

        if ($user_id) {
            foreach ($usersArray as $user) {
                if ($user['user_id'] === $user_id) {
                    // Value found
                    $finalUsers[] = [
                        "user_id" => $user['user_id'],
                        "first_name" => $user['first_name'],
                        "last_name" => $user['last_name']
                    ];
                    break;
                }
            }
        }
        if ($name) {
            foreach ($usersArray as $user) {
                if (stristr($user['first_name'], $name) !== false || stristr($user['last_name'], $name) !== false) {
                    // Value found
                    $finalUsers[] = [
                        "user_id" => $user['user_id'],
                        "first_name" => $user['first_name'],
                        "last_name" => $user['last_name']
                    ];
                }
            }
        }

        if (!$user_id && !$name) {
            $finalUsers = $usersArray;
        }

        // Current page number (from request or any other source)
        $page = request()->input('page', 1);

        // Number of items to display per page
        $perPage = 10;

        // Calculate the offset
        $offset = ($page - 1) * $perPage;

        // Get the items for the current page using array_slice()
        $paginatedItems = array_slice($finalUsers, $offset, $perPage);

        // Create a new collection with the paginated items
        $paginatedCollection = collect($paginatedItems);

        // Total number of items in the array
        $totalItems = count($finalUsers);

        // Create a paginator manually
        $paginator = new LengthAwarePaginator(
            $paginatedCollection,
            $totalItems,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return $paginator;

//        $user = User::query()->select('user_id', 'first_name', 'last_name');
//
//
//        $user_id = request('user_id');
//        $first_name = request('first_name');
//        $last_name = request('last_name');
//
//        if ($user_id) {
//            $user->where('user_id', '=', $user_id);
//        }
//        if ($first_name) {
//            $user->where('first_name', 'like', '%' . $first_name . '%');
//        }
//        if ($last_name) {
//            $user->where('last_name', 'like', '%' . $last_name . '%');
//        }
//
//        return $user->paginate(10);
    }
}
