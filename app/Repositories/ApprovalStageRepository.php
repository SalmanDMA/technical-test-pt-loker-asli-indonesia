<?php

namespace App\Repositories;

use App\Models\Approval;
use App\Models\ApprovalStage;
use App\Models\Expense;

class ApprovalStageRepository implements ApprovalStageRepositoryInterface
{
    public function create(array $data)
    {
        return ApprovalStage::create($data);
    }

    public function update($id, array $data)
    {
        $approvalStage = $this->getById($id);
        $approvalStage->update($data);
        return $approvalStage;
    }

    public function getById($id)
    {
        return ApprovalStage::find($id);
    }

    public function getApprovalStagesForExpense($expenseId)
    {
        $approvals = Approval::where('expense_id', $expenseId)
            ->orderBy('id')
            ->get();

        if ($approvals->isEmpty()) {
            return collect();
        }

        $approvalStages = ApprovalStage::whereIn('id', $approvals->pluck('approval_stage_id'))
            ->orderBy('id')
            ->get();

        return $approvalStages;
    }
}
