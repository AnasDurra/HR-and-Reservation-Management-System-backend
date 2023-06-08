<?php


namespace App\Application\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed user
 */
class StoreEmployeeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:users,email', Rule::unique('users')->ignore($this->user)],
            'username' => ['required', 'string', 'min:3', 'max:50', 'unique:users,username', Rule::unique('users')->ignore($this->user)],
            'password' => ['required', 'string', 'min:8', 'max:50'],

            // employee entity fields second.
            'job_app_id' => [
                'required',
                'integer',

                // check that job_app status is accepted.
                Rule::exists('job_applications', 'job_app_id')
                    ->where('app_status_id', 2),

                // check that job_app is not assigned to another employee.
                Rule::unique('employees', 'job_app_id')->ignore($this->user)
            ],
            'schedule_id' => ['required', 'integer', 'exists:schedules,schedule_id'],
            'leaves_balance' => ['required', 'integer', 'min:0'],

            // staffing entity fields third.
            'job_title_id' => ['required', 'integer', 'exists:job_titles,job_title_id'],
            'start_date' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.unique' => 'البريد الإلكتروني مستخدم من قبل.',
            'email.email' => 'البريد الإلكتروني غير صالح.',

            'username.required' => 'اسم المستخدم مطلوب.',
            'username.unique' => 'اسم المستخدم مستخدم من قبل.',
            'username.min' => 'اسم المستخدم يجب أن يكون على الأقل 3 أحرف.',

            'password.required' => 'كلمة المرور مطلوبة.',
            'password.min' => 'كلمة المرور يجب أن تكون على الأقل 8 أحرف.',

            'job_app_id.required' => 'معرف طلب التوظيف مطلوب.',
            'job_app_id.integer' => 'معرف طلب التوظيف يجب أن يكون رقماً صحيحاً.',
            'job_app_id.exists' => 'معرف طلب التوظيف غير موجود.',
            'job_app_id.unique' => 'معرف طلب التوظيف مستخدم من قبل.',

            'schedule_id.required' => 'معرف جدول الدوام مطلوب.',
            'schedule_id.integer' => 'معرف جدول الدوام يجب أن يكون رقماً صحيحاً.',
            'schedule_id.exists' => 'معرف جدول الدوام غير موجود.',

            'leaves_balance.required' => 'رصيد الإجازات مطلوب.',
            'leaves_balance.integer' => 'رصيد الإجازات يجب أن يكون رقماً صحيحاً.',
            'leaves_balance.min' => 'رصيد الإجازات يجب أن يكون على الأقل 0.',

            'job_title_id.required' => 'معرف المسمّى الوظيفي مطلوب.',
            'job_title_id.integer' => 'معرف المسمّى الوظيفي يجب أن يكون رقماً صحيحاً.',
            'job_title_id.exists' => 'معرف المسمّى الوظيفي غير موجود.',

            'start_date.required' => 'تاريخ بدء العمل مطلوب.',
            'start_date.date' => 'تاريخ بدء العمل غير صالح.',
        ];
    }


}
