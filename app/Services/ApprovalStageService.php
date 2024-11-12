<?php

namespace App\Services;

use App\Repositories\ApprovalStageRepositoryInterface;

class ApprovalStageService
{
    protected $approvalStageRepository;

    public function __construct(ApprovalStageRepositoryInterface $approvalStageRepository)
    {
        $this->approvalStageRepository = $approvalStageRepository;
    }

    public function createApprovalStage(array $data)
    {
        return $this->approvalStageRepository->create($data);
    }

    public function updateApprovalStage($id, array $data)
    {
        return $this->approvalStageRepository->update($id, $data);
    }
}
