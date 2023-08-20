<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Models\CD\CaseNote;
use App\Domain\Repositories\CaseNoteRepositoryInterface;
use App\Exceptions\EntryNotFoundException;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class EloquentCaseNoteRepository implements CaseNoteRepositoryInterface
{

    public function getCaseNoteById(int $id): CaseNote|Builder|null
    {
        try {
            return CaseNote::query()->findOrFail($id);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function createCaseNote(array $data): CaseNote|Builder|null
    {
        return CaseNote::query()->create([
            'app_id' => $data['app_id'],
            'title' => $data['title'],
            'description' => $data['description'],
        ]);
    }

    /**
     * @throws EntryNotFoundException
     */
    public function updateCaseNote(int $id, array $data): CaseNote|Builder|null
    {
        try {
            $caseNote = CaseNote::query()->findOrFail($id);
        } catch (Exception) {
            throw new EntryNotFoundException("Shift Request with ID $id not found.");
        }

        $caseNote->title = $data['title'] ?? $caseNote->title;
        $caseNote->description = $data['description'] ?? $caseNote->description;

        $caseNote->save();

        return $caseNote;
    }


}
