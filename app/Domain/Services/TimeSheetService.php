<?php

namespace App\Domain\Services;

use App\Domain\Models\CD\Shift;
use App\Domain\Repositories\TimeSheetRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class TimeSheetService
{
    private TimeSheetRepositoryInterface $TimeSheetRepository;

    public function __construct(TimeSheetRepositoryInterface $TimeSheetRepository)
    {
        $this->TimeSheetRepository = $TimeSheetRepository;
    }

    public function getTimeSheetList(): LengthAwarePaginator
    {
        return $this->TimeSheetRepository->getTimeSheetList();
    }

    public function createTimeSheet(array $data): Shift|Builder|null
    {
        return $this->TimeSheetRepository->createTimeSheet($data);
    }

    public function deleteTimeSheet($id): Shift|Builder|null
    {
        return $this->TimeSheetRepository->deleteTimeSheet($id);
    }
}
