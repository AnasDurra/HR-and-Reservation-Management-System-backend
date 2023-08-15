<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\ConsultantRepositoryInterface;
use App\Domain\Models\CD\Consultant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Str;

class EloquentConsultantRepository implements ConsultantRepositoryInterface
{
    public function getConsultantList(): Collection
    {
        $consultants =  Consultant::query()->with('user');

        // search by name (full name)
        if (request()->has('name')) {

            // get the name
            $name = request()->get('name');

            // trim & convert to lowercase
            $name = strtolower(trim($name));

            // search after ignoring the case
            $consultants->whereRaw('LOWER(first_name) LIKE ?', ["%$name%"])
                        ->orWhereRaw('LOWER(last_name) LIKE ?', ["%$name%"])
                        ->orWhereRaw('CONCAT(LOWER(first_name), " ", LOWER(last_name)) LIKE ?', ["%$name%"]);
        }
        return $consultants->get();
    }

    public function getConsultantById(int $id): Consultant|Builder|null
    {
        $consultant =  Consultant::query()->find($id);
        if(!$consultant)
            return null;

        return $consultant;
    }

    public function createConsultant(array $data): Consultant|Builder|null
    {

        $eloquentUserRepository = new EloquentUserRepository();
        $user = $eloquentUserRepository->createUser([
            'user_type_id' => '2',
            'email' => $data['email'],
            'username' => $this->generateUniqueUsername($data['first_name']),
            'password' => $this->generatePassword()
        ]);

        return Consultant::query()->create([
           'user_id' => $user['user_id'],
           'clinic_id' => $data['clinic_id'],
           'first_name' => $data['first_name'],
           'last_name' => $data['last_name'],
           'birth_date' => $data['birth_date'],
           'phone_number' => $data['phone_number'],
           'address' => $data['address'],
        ])->load('user');
    }

    public function updateConsultant(int $id, array $data): Consultant|Builder|null
    {
        $consultant = Consultant::query()->with('user')->find($id);
        if(!$consultant) return null;

        $consultant['clinic_id'] = $data['clinic_id'] ?? $consultant['clinic_id'];
        $consultant['first_name'] = $data['first_name'] ?? $consultant['first_name'];
        $consultant['last_name'] = $data['last_name'] ?? $consultant['last_name'];
        $consultant['phone_number'] = $data['phone_number'] ?? $consultant['phone_number'];
        $consultant['user']['email'] = $data['email'] ?? $consultant['user']['email'];
        $consultant['address'] = $data['address'] ?? $consultant['address'];
        $consultant['birth_date'] = $data['birth_date'] ?? $consultant['birth_date'];
        $consultant->save();
        $consultant->user->save();

        return $consultant;

    }

    /**
     * @throws \Throwable
     */
    public function deleteConsultant($id): Consultant|Builder|null
    {
        $consultant =  Consultant::query()->find($id);
        if(!$consultant)
            return null;

        $user = $consultant->user;

        if ($user) {
            DB::beginTransaction();
            try {
                $consultant->delete();

                $user->delete();

                DB::commit();

            } catch (\Exception $e) {

                DB::rollback();
                $consultant["message"] = "Error occurred while deleting consultant";
                return null;
            }
        }

        // TODO Cancel all consultant appointments

        return $consultant;
    }


    function generateUniqueUsername($firstName): string
    {

        $random_number = rand(100, 999);

        $username = strtolower($firstName) . $random_number;

        $eloquentUserRepository = new EloquentUserRepository();
        $users = $eloquentUserRepository->getUserList()->pluck('username');
        if ($users->contains('username', $username)) {
            return $this->generateUniqueUsername($firstName);
        }

        return $username;
    }

    function generatePassword(): string
    {
        return Str::random(8);
    }
}
