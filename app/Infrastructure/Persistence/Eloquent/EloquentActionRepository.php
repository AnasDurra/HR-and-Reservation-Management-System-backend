<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\ActionRepositoryInterface;
use App\Domain\Models\Action;

class EloquentActionRepository implements ActionRepositoryInterface
{
    public function getActionList(): array
    {
        // TODO: Implement the logic to retrieve a list of Actions
    }

    public function getActionById(int $id): ?Action
    {
        // TODO: Implement the logic to retrieve a Action by ID
    }

    public function createAction(array $data): Action
    {
        // TODO: Implement the logic to create a Action
    }

    public function updateAction(int $id, array $data): Action
    {
        // TODO: Implement the logic to update a Action
    }

    public function deleteAction($id): Action
    {
        // TODO: Implement the logic to delete a Action
    }
}