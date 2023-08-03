<?php

namespace App\Domain\Repositories;

use App\Domain\Models\CD\Shift;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

interface TimeSheetRepositoryInterface
{
    public function getTimeSheetList(): LengthAwarePaginator;

    public function createTimeSheet(array $data): Shift|Builder|null;

    public function deleteTimeSheet($id): Shift|Builder|null;
}
