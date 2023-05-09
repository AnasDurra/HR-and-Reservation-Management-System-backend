<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    public function jobApplication()
    {
        return $this->hasOne(JobApplication::class, 'emp_data_id', 'emp_data_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'emp_data_id', 'emp_data_id');
    }

    public function drivingLicence()
    {
        return $this->hasOne(DrivingLicence::class, 'emp_data_id', 'emp_data_id');
    }

    public function passport()
    {
        return $this->belongsTo(Passport::class, 'passport_id', 'passport_id');
    }

    public function personalCard()
    {
        return $this->belongsTo(PersonalCard::class, 'personal_card_id', 'personal_card_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'address_id');
    }

    public function convictions()
    {
        return $this->hasMany(Conviction::class, 'emp_data_id', 'emp_data_id');
    }
    public function trainingCourses()
    {
        return $this->hasMany(TrainingCourse::class, 'emp_data_id', 'emp_data_id');
    }

    public function previousEmploymentRecords()
    {
        return $this->hasMany(PreviousEmploymentRecord::class, 'emp_data_id', 'emp_data_id');
    }

    public function dependents()
    {
        return $this->hasMany(Dependent::class, 'emp_data_id', 'emp_data_id');
    }

    public function computerSkills()
    {
        return $this->belongsToMany(ComputerSkill::class, 'emp_computer_skills', 'emp_data_id', 'computer_skill_id',
            'emp_data_id','computer_skill_id')
            ->withPivot('level');
    }

    public function skills()
    {
        return $this->belongsToMany(EmpData::class, 'emp_skills', 'emp_data_id', 'skill_id',
            'emp_data_id','skill_id')
            ->withPivot('level');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'emp_languages', 'emp_data_id', 'language_id',
            'emp_data_id','language_id')
            ->withPivot('speaking_level', 'writing_level', 'reading_level');
    }

    public function educationLevels()
    {
        return $this->belongsToMany(EducationLevel::class, 'education_records', 'emp_data_id', 'education_level_id',
            'emp_data_id','education_level_id')
            ->withPivot('univ_name', 'city', 'start_date', 'end_date', 'specialize', 'grade');
    }
}
