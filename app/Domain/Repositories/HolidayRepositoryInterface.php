<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Holiday;
use Illuminate\Database\Eloquent\Builder;

interface HolidayRepositoryInterface
{
    public function getHolidayList(): array;

    public function getHolidayById(int $id): Holiday|Builder|null;

    public function createHoliday(array $data): Holiday|Builder|null;

    public function updateHoliday(int $id, array $data): Holiday|Builder|null;

    public function deleteHoliday($id): Holiday|Builder|null;
}