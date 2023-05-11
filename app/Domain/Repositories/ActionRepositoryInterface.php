<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Action;

interface ActionRepositoryInterface
{
    public function getActionList(): array;

    public function getActionById(int $id): ?Action;

    public function createAction(array $data): Action;

    public function updateAction(int $id, array $data): Action;

    public function deleteAction($id): Action;
}