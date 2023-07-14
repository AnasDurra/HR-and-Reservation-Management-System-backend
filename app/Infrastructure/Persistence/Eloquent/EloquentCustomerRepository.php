<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\CustomerRepositoryInterface;
use App\Domain\Models\Customer;
use App\Exceptions\EntryNotFoundException;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EloquentCustomerRepository implements CustomerRepositoryInterface
{
    public function getCustomerList(): array
    {
        // TODO: Implement the logic to retrieve a list of Customers
    }

    public function getCustomerById(int $id): Customer|Builder|null
    {
        // TODO: Implement the logic to retrieve a Customer by ID
    }

    public function createCustomer(array $data): Customer|Builder|null
    {
        // TODO: Implement the logic to create a Customer
    }

    /**
     * @throws EntryNotFoundException
     */
    public function updateCustomer(int $id, array $data): Customer|Builder|null
    {

        try {
            $customer = Customer::query()
                ->where('id', '=', $id)
                ->firstOrFail();

        } catch (Exception) {
            throw new EntryNotFoundException("customer with id $id not found");
        }

        $customer->update([
            'first_name' => $data['first_name'] ?? $customer->first_name,
            'last_name' => $data['last_name'] ?? $customer->last_name,
            'education_level_id' => $data['education_level_id'] ?? $customer->education_level_id,
            'email' => $data['email'] ?? $customer->email,
            'username' => $data['username'] ?? $customer->username,
            'password' => isset($data['password']) ? Hash::make($data['password']) : $customer->password,
            'job' => $data['job'] ?? $customer->job,
            'birth_date' => $data['birth_date'] ?? $customer->birth_date,
            'phone' => $data['phone'] ?? $customer->phone,
            'phone_number' => $data['phone_number'] ?? $customer->phone_number,
            'martial_status' => $data['martial_status'] ?? $customer->martial_status,
            'num_of_children' => $data['num_of_children'] ?? $customer->num_of_children,
            'national_number' => $data['national_number'] ?? $customer->national_number,
            'profile_picture' => $data['profile_picture'] ?? $customer->profile_picture,
        ]);
        return $customer;
    }

    public function deleteCustomer($id): Customer|Builder|null
    {
        // TODO: Implement the logic to delete a Customer
    }

    public function userSingUp(array $data): array
    {
        $new_customer = Customer::query()->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'education_level_id' => $data['education_level_id'],
            'email' => $data['email'] ?? null,
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'job' => $data['job'],
            'birth_date' => $data['birth_date'],
            'phone' => $data['phone'] ?? null,
            'phone_number' => $data['phone_number'],
            'martial_status' => $data['martial_status'],
            'num_of_children' => $data['num_of_children'],
            'national_number' => $data['national_number'],
//            'profile_picture' => optional($data)['profile_picture'] ?? $data['profile_picture'],
            'profile_picture' => $data['profile_picture'] ?? null,
        ]);
        return [
            'token' => $new_customer->createToken('customer_auth_token')->plainTextToken,
            'customer_data' => $new_customer,
        ];
    }

    /**
     * @throws EntryNotFoundException
     */
    public function userLogin(array $data): array
    {
        $customer = Customer::query()
            ->where('email', $data['email'] ?? '')
            ->orWhere('username', $data['username'] ?? '')
            ->first();

        if (!$customer) {
            throw new EntryNotFoundException('المستخدم غير موجود', 404);
        }

        if (!Hash::check($data['password'], $customer->password)) {
            throw new EntryNotFoundException("كلمة المرور غير صحيحة", 401);
        }

        return [
            'token' => $customer->createToken('customer_auth_token')->plainTextToken,
            'customer_name' => $customer->full_name,
        ];
    }

    /**
     * @throws EntryNotFoundException
     */
    public function userLogout(): void
    {
        // Retrieve the currently authenticated customer
        $customer = Auth::guard('customer')->user();

        // Check if the customer is authenticated
        if (!$customer) {
            throw new EntryNotFoundException('المتسخدم غير موجود', 404);
        }

        // Revoke the token associated with the customer
        $customer->currentAccessToken()->delete();
    }
}
