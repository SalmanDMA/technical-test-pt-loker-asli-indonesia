<?php

namespace App\Services;

use App\Repositories\ApproverRepositoryInterface;

class ApproverService
{
    protected $approverRepository;

    public function __construct(ApproverRepositoryInterface $approverRepository)
    {
        $this->approverRepository = $approverRepository;
    }

    public function createApprover(array $data)
    {
        return $this->approverRepository->create($data);
    }
}
