<?php

namespace App\Domain\Models;

use App\Models\Certificate;
use App\Models\Reference;
use App\Models\Relative;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EmpData extends Model
{
    use HasFactory;

    protected $primaryKey = 'emp_data_id';
    protected $fillable = [
        'personal_photo',
        'father_name',
        'grand_father_name',
        'birth_date',
        'birth_place',
        'marital_status',
        'start_working_date',
        'is_employed',
        'card_id',
        'passport_id',
        'address_id',
        'driving_licence_id',
    ];

    public function jobApplication(): HasOne
    {
        return $this->hasOne(JobApplication::class, 'emp_data_id', 'emp_data_id');
    }

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class, 'emp_data_id', 'emp_data_id');
    }

    public function drivingLicence(): HasOne
    {
        return $this->belongsTo(DrivingLicence::class, 'driving_licence_id', 'driving_licence_id');
    }

    public function passport(): BelongsTo
    {
        return $this->belongsTo(Passport::class, 'passport_id', 'passport_id');
    }

    public function personalCard(): BelongsTo
    {
        return $this->belongsTo(PersonalCard::class, 'personal_card_id', 'personal_card_id');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id', 'address_id');
    }

    public function convictions(): HasMany
    {
        return $this->hasMany(Conviction::class, 'emp_data_id', 'emp_data_id');
    }

    public function trainingCourses(): HasMany
    {
        return $this->hasMany(TrainingCourse::class, 'emp_data_id', 'emp_data_id');
    }

    public function previousEmploymentRecords(): HasMany
    {
        return $this->hasMany(PreviousEmploymentRecord::class, 'emp_data_id', 'emp_data_id');
    }

    public function dependents(): HasMany
    {
        return $this->hasMany(Dependent::class, 'emp_data_id', 'emp_data_id');
    }

    public function computerSkills(): BelongsToMany
    {
        return $this->belongsToMany(ComputerSkill::class, 'emp_computer_skills', 'emp_data_id', 'computer_skill_id',
            'emp_data_id', 'computer_skill_id')
            ->withPivot('level');
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(EmpData::class, 'emp_skills', 'emp_data_id', 'skill_id',
            'emp_data_id', 'skill_id')
            ->withPivot('level');
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'emp_languages', 'emp_data_id', 'language_id',
            'emp_data_id', 'language_id')
            ->withPivot('speaking_level', 'writing_level', 'reading_level');
    }

    public function educationLevels(): BelongsToMany
    {
        return $this->belongsToMany(EducationLevel::class, 'education_records', 'emp_data_id', 'education_level_id',
            'emp_data_id', 'education_level_id')
            ->withPivot('univ_name', 'city', 'start_date', 'end_date', 'specialize', 'grade');
    }

    public function relatives(){
        return $this->belongsTo(Relative::class, 'emp_data_id', 'emp_data_id');
    }

    public function references()
    {
        return $this->hasMany(Reference::class, 'emp_data_id', 'emp_data_id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'emp_data_id', 'emp_data_id');
    }
}
