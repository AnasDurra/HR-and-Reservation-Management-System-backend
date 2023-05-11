<?php

namespace App\Domain\Services;

use App\Domain\Repositories\ActionRepositoryInterface;
use App\Domain\Models\Action;

class ActionService
{
    /** @var ActionRepositoryInterface */
    private $ActionRepository;

    public function __construct(ActionRepositoryInterface $ActionRepository)
    {
        $this->ActionRepository = $ActionRepository;
    }

    public function getActionList(): array
    {
        return $this->ActionRepository->getActionList();
    }

    public function getActionById(int $id): ?Action
    {
        return $this->ActionRepository->getActionById($id);
    }

    public function createAction(array $data): Action
    {
        return $this->ActionRepository->createAction($data);
    }

    public function updateAction(int $id, array $data): Action
    {
        return $this->ActionRepository->updateAction($id, $data);
    }

    public function deleteAction($id): Action
    {
        return $this->ActionRepository->deleteAction($id);
    }
}