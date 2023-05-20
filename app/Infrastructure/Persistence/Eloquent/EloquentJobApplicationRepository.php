<?php


namespace App\Infrastructure\Persistence\Eloquent;


use App\Domain\Models\Address;
use App\Domain\Models\ComputerSkill;
use App\Domain\Models\EmpData;
use App\Domain\Models\JobApplication;
use App\Domain\Models\Language;
use App\Domain\Models\Passport;
use App\Domain\Models\PersonalCard;
use App\Domain\Models\Skill;
use App\Domain\Repositories\JobApplicationRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EloquentJobApplicationRepository implements JobApplicationRepositoryInterface
{

    public function getJobApplicationsList(): Collection
    {
        return JobApplication::all();
    }

    public function getJobApplicationById(int $id): ?JobApplication
    {
        return JobApplication::query()->findOrFail($id)->first();
    }

    /**
     * @throws Exception
     */
    public function createJobApplication(array $data): Builder|Model
    {

        try {

            // start transaction
            DB::beginTransaction();

            // store employee personal photo in local storage
            $data['personal_data']['personal_photo'] =
             $this->storePersonalPhoto($data['personal_data']['personal_photo']);


            // create personal card data for this employee data
            $personalCard = new PersonalCard([
                "card_number" => $data['personal_card']['card_number'],
                "place_of_issue" => $data['personal_card']['card_place_of_issue'],
                "date_of_issue" => $data['personal_card']['card_date_of_issue'],
            ]);

            // save personal card data
            $personalCard->save();

            // create passport data for this employee data (if exists)
            if (isset($data['passport'])) {
                $passport = new Passport([
                    "passport_number" => $data['passport']['passport_number'],
                    "place_of_issue" => $data['passport']['passport_place_of_issue'],
                    "date_of_issue" => $data['passport']['passport_date_of_issue'],
                ]);

                // save passport data
                $passport->save();
            }


            // address data
            $address = new Address([
                "state" => $data['address']['state'],
                "city" => $data['address']['city'],
                "street" => $data['address']['street'],
                "postal_code" => optional($data['address'])['postal_code'],
                "email" => optional($data['address'])['email'],
                "mobile_no" => optional($data['address'])['mobile_no'],
                "home_phone_no" => optional($data['address'])['home_phone_no'],
                "work_phone_no" => optional($data['address'])['work_phone_no'],
            ]);

            // save address data
            $address->save();

            // create job application data
            $employeeData = EmpData::query()->create([

                // personal data fields
                "first_name" => $data['personal_data']['first_name'],
                "last_name" => $data['personal_data']['last_name'],
                "father_name" => $data['personal_data']['father_name'],
                "grand_father_name" => $data['personal_data']['grand_father_name'],
                "personal_photo" => $data['personal_data']['personal_photo'],
                "birth_date" => $data['personal_data']['birth_date'],
                "birth_place" => $data['personal_data']['birth_place'],
                "marital_status" => $data['personal_data']['marital_status'],

                // job data
                "start_working_date" => $data['job_data']['start_working_date'],
                "is_employed" => $data['job_data']['is_employed'],

                // passport data
                "passport_id" => isset($passport)
                    ? $passport->getAttribute('passport_id')
                    : null,

                // personal card data
                "card_id" => $personalCard->getAttribute('personal_card_id'),

                // address data
                "address_id" => $address->getAttribute('address_id'),
            ]);

            // check if passport is passed, assign the object ot the empData


            // create job application for this employee data
            $employeeData->jobApplication()->create([
                "job_vacancy_id" => $data['job_application']['job_vacancy_id'],
                "app_status_id" => 1, // needs to be processed
                "section_man_notes" => optional($data)['job_application']['section_man_notes'],
                "vice_man_rec" => optional($data)['job_application']['vice_man_rec'],
            ]);


            // driving licence data (if exists)
            if (isset($data['driving_licence'])) {
                $employeeData->drivingLicence()->create([
                    "category" => optional($data)['driving_licence']['category'],
                    "date_of_issue" => $data['driving_licence']['date_of_issue'],
                    "place_of_issue" => $data['driving_licence']['place_of_issue'],
                    "number" => $data['driving_licence']['number'],
                    "expiry_date" => $data['driving_licence']['expiry_date'],
                    "blood_group" => $data['driving_licence']['blood_group'],
                ]);
            }

            // dependents data (if exists)
            if (isset($data['dependants'])) {
                foreach ($data['dependants'] as $dependant) {
                    $employeeData->dependents()->create([
                        "name" => $dependant['name'],
                        "age" => $dependant['age'],
                        "relation" => $dependant['relationship'],
                        "address" => $dependant['address'],
                    ]);
                }
            }

            // previous employment records data (if exists)
            if (isset($data['previous_employment_record'])) {
                foreach ($data['previous_employment_record'] as $record) {
                    $employeeData->previousEmploymentRecords()->create([
                        "employer_name" => $record['employer_name'],
                        "address" => $record['address'],
                        "telephone" => $record['telephone'],
                        "job_title" => $record['job_title'],
                        "job_description" => $record['job_description'],
                        "start_date" => $record['start_date'],
                        "end_date" => $record['end_date'],
                        "salary" => $record['salary'],
                        "allowance" => $record['allowance'],
                        "quit_reason" => optional($data)['quit_reason'],
                    ]);
                }
            }

            // convictions (if exists)
            if (isset($data['convictions'])) {
                foreach ($data['convictions'] as $conviction) {
                    $employeeData->convictions()->create([
                        "description" => $conviction['description'],
                    ]);
                }
            }

            // education records (if exists)
            if (isset($data['education'])) {
                foreach ($data['education'] as $record) {
                    // attach education level to this employee data
                    $employeeData->educationLevels()->attach($record['education_level_id'], [
                        "univ_name" => $record['univ_name'],
                        "city" => $record['city'],
                        "start_date" => $record['start_date'],
                        "end_date" => $record['end_date'],
                        "specialize" => optional($record)['specialize'],
                        "grade" => optional($record)['grade'],
                    ]);

                }
            }

            // training courses (if exists)
            if (isset($data['training_courses'])) {
                foreach ($data['training_courses'] as $course) {
                    $employeeData->trainingCourses()->create([
                        "name" => $course['course_name'],
                        "institute_name" => $course['institute_name'],
                        "city" => $course['city'],
                        "start_date" => $course['start_date'],
                        "end_date" => $course['end_date'],
                        "specialize" => $course['specialize'],
                    ]);
                }
            }

            // skills (if exists)
            if (isset($data['skills'])) {
                foreach ($data['skills'] as $skill) {
                    // create skill if not exists
                    $skillModel = Skill::query()->firstOrCreate([
                        "name" => $skill['skill_name'],
                    ]);

                    // attach skill to this employee data
                    $employeeData->skills()->attach($skillModel->getAttribute("skill_id"));
                }
            }

            // languages (if exists)
            if (isset($data['languages'])) {
                foreach ($data['languages'] as $language) {
                    // create language if not exists
                    $languageModel = Language::query()->firstOrCreate([
                        "name" => $language['language_name'],
                    ]);

                    // attach language to this employee data
                    $employeeData->languages()->attach($languageModel->getAttribute("language_id"), [
                        "reading_level" => $language['reading'],
                        "writing_level" => $language['writing'],
                        "speaking_level" => $language['speaking'],
                    ]);
                }
            }

            // computer skills (if exists)
            if (isset($data['computer_skills'])) {
                foreach ($data['computer_skills'] as $skill) {
                    // create computer skill if not exists
                    $computerSkillModel = ComputerSkill::query()->firstOrCreate([
                        "name" => $skill['skill_name'],
                    ]);

                    // attach computer skill to this employee data
                    $employeeData->computerSkills()->attach($computerSkillModel->getAttribute("computer_skill_id"), [
                        "level" => $skill['level'],
                    ]);
                }
            }

            // relatives (from center employees) (if exists)
            if (isset($data['relatives'])) {
                foreach ($data['relatives'] as $relative) {
                    // TODO: Check that if it's working or not
                    // attach relative to this employee data
                    $employeeData->relatives()->attach($relative["emp_id"]);
                }
            }

            // references (if exists)
            if (isset($data['references'])) {
                foreach ($data['references'] as $reference) {
                    $employeeData->references()->create([
                        "name" => $reference['name'],
                        "job" => $reference['job'],
                        "company" => $reference['company'],
                        "address" => $reference['address'],
                        "telephone" => $reference['telephone'],
                    ]);
                }
            }

            // certificates (if exists)
            // store certificates in local storage
            if (isset($data['certificates'])) {
                foreach ($data['certificates'] as $certificate) {
                    $employeeData->certificates()->create([
                        "name" => $certificate['certificate_name'],
                        "file_url" => $this->storeCertificate($certificate['file']),
                    ]);
                }
            }

            // save employee data
            $employeeData->save();

            // create job application
            $jobApplication = JobApplication::query()->create([
                "emp_data_id" => $employeeData->getAttribute("emp_data_id"),
                "app_status_id" => 1, // set app status id by default to 1 (pending)
                "job_vacancy_id" => $data['job_application']["job_vacancy_id"],
                "section_man_notes" => optional($data['job_application'])["section_man_notes"],
                "vice_man_rec" => optional($data['job_application'])["vice_man_rec"],
            ]);

            DB::commit();

            return $jobApplication;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }


    public function updateJobApplication(int $id, array $data): bool
    {

    }

    public function deleteJobApplication($id): bool
    {
        // TODO: Implement deleteJobApplication() method.
    }


    // store personal photo in local storage
    private function storePersonalPhoto($file): string
    {
        // store file in local storage
        $file->store('public/personal_photos');

        // get file name
        $fileName = $file->hashName();

        // return image url
        return asset('storage/personal_photos/' . $fileName);
    }

    // store certificate in local storage
    private function storeCertificate($file): string
    {
        // store file in local storage
        $file->store('public/certificates');

        // get file name
        $fileName = $file->hashName();

        // return image url
        return asset('storage/certificates/' . $fileName);
    }
}
