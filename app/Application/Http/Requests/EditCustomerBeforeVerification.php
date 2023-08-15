<?php

namespace App\Application\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCustomerBeforeVerification extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => [
                'sometimes',
                'string',
                'min:2',
                'max:50',
            ],
            'last_name' => [
                'sometimes',
                'string',
                'min:2',
                'max:50',
            ],
            'job' => [
                'sometimes',
                'string',
                'max:100',
            ],
            'birth_date' => [
                'sometimes',
                'date',
                'before:today',
            ],
            'phone' => [
                'sometimes',
                'string',
                'min:7',
                'max:15',
            ],
            'phone_number' => [
                'sometimes',
                'string',
                'min:10',
                'max:15',
            ],
            'martial_status' => [
                'sometimes',
                'integer',
                'min:1',
                'max:5',
            ],
            'num_of_children' => [
                'sometimes',
                'integer',
                'min:0',
                'max:20',
            ],
            'national_number' => [
                'sometimes',
                'integer',
                'digits:11'
            ],
            'profile_picture' => [
                'sometimes',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ],
            'education_level_id' => [
                'sometimes',
                'integer',
                'exists:education_levels,education_level_id',
            ],
            'email' => [
                'sometimes',
                'email',
                'unique:customers,email',
            ],
            'username' => [
                'sometimes',
                'string',
                'min:5',
                'max:50',
                'unique:customers,username',
            ],
            'password' => [
                'sometimes',
                'confirmed',
                'min:8',
            ],
            'verified' => [
                'sometimes',
                'boolean',
            ],
            'blocked' => [
                'sometimes',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.string' => 'يجب أن يكون الاسم الأول نصًا.',
            'first_name.min' => 'يجب أن يحتوي الاسم الأول على الأقل على حرفين.',
            'first_name.max' => 'يجب ألا يتجاوز الاسم الأول خمسين حرفًا.',
            'last_name.string' => 'يجب أن يكون الاسم الأخير نصًا.',
            'last_name.min' => 'يجب أن يحتوي الاسم الأخير على الأقل على حرفين.',
            'last_name.max' => 'يجب ألا يتجاوز الاسم الأخير خمسين حرفًا.',
            'job.string' => 'يجب أن تكون الوظيفة نصًا.',
            'job.min' => 'يجب أن يحتوي حقل الوظيفة على الأقل على خمس أحرف.',
            'job.max' => 'يجب ألا يتجاوز حقل الوظيفة مئة حرفًا.',
            'birth_date.required' => 'حقل تاريخ الميلاد مطلوب.',
            'birth_date.date' => 'يجب أن يكون تاريخ الميلاد صحيحًا.',
            'birth_date.before' => 'يجب أن يكون تاريخ الميلاد قبل اليوم.',
            'phone.string' => 'يجب أن يكون الهاتف نصًا.',
            'phone.min' => 'يجب أن يحتوي الهاتف على الأقل على سبع حرفاً.',
            'phone.max' => 'يجب ألا يتجاوز الهاتف خمسة عشر رقماً.',
            'phone_number.string' => 'يجب أن يكون رقم الهاتف نصًا.',
            'phone_number.min' => 'يجب أن يحتوي رقم الهاتف على الأقل على عشر أرقام.',
            'phone_number.max' => 'يجب ألا يتجاوز رقم الهاتف خمسة عشر حرفًا.',
            'num_of_children.integer' => 'يجب أن يكون عدد الأطفال رقمًا صحيحًا.',
            'num_of_children.min' => 'يجب أن يكون عدد الأطفال على الأقل :min.',
            'num_of_children.max' => 'يجب ألا يتجاوز عدد الأطفال :max.',
            'national_number.string' => 'يجب أن يكون الرقم الوطني نصًا.',
            'national_number.min' => 'يجب أن يحتوي الرقم الوطني على أحد عشر رقماً.',
            'national_number.max' => 'يجب أن يحتوي الرقم الوطني على أحد عشر رقماً.',
            'profile_picture.image' => 'يجب أن تكون الصورة الشخصية ملف صورة.',
            'profile_picture.mimes' => 'يجب أن تكون الصورة الشخصية من نوع: jpeg,png,jpg,gif,svg .',
            'profile_picture.max' => 'يجب ألا يتجاوز حجم الصورة الشخصية 2048 كيلوبايت.',
            'education_level_id.exists' => 'المستوى التعليمي المحدد غير صالح.',
            'email.email' => 'البريد الإلكتروني غير صحيح.',
            'username.string' => 'يجب أن يكون اسم المستخدم نصًا.',
            'username.min' => 'يجب أن يحتوي اسم المستخدم على الأقل على خمس أحرف.',
            'username.max' => 'يجب ألا يتجاوز اسم المستخدم خمسين حرفًا.',
            'username.unique' => 'اسم المستخدم موجود مسبقاُ.',
            'password.min' => 'يجب أن تكون كلمة المرور على الأقل ثمان أحرف.',
            'password.confirmed' => 'كلمة المرور غير متطابقة.',
            'verified.boolean' => 'حقل التوثيق غير صحيح.',
            'blocked.boolean' => 'حقل الحظر غير صحيح.',
        ];
    }
}
