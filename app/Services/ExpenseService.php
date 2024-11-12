<?php

namespace App\Services;

use App\Models\ApprovalStage;
use App\Repositories\ExpenseRepositoryInterface;
use App\Repositories\ApprovalStageRepositoryInterface;
use App\Repositories\ApproverRepositoryInterface;
use App\Models\Status;
use App\Models\Expense;

class ExpenseService
{
    protected $expenseRepository;
    protected $approvalStageRepository;
    protected $approverRepository;

    public function __construct(
        ExpenseRepositoryInterface $expenseRepository,
        ApprovalStageRepositoryInterface $approvalStageRepository,
        ApproverRepositoryInterface $approverRepository
    ) {
        $this->expenseRepository = $expenseRepository;
        $this->approvalStageRepository = $approvalStageRepository;
        $this->approverRepository = $approverRepository;
    }

    /**
     * Membuat pengeluaran baru dan menyiapkan proses approval.
     */
    public function createExpense(array $data)
    {
        $status = Status::where('name', 'menunggu persetujuan')->first();

        if (!$status) {
            $status = Status::create([
                'name' => 'menunggu persetujuan'
            ]);
        }

        $expense = $this->expenseRepository->create([
            'amount' => $data['amount'],
            'status_id' => $status->id
        ]);

        return $expense;
    }

    public function approveExpense($expenseId, $approverId)
    {
        $expense = $this->expenseRepository->getById($expenseId);

        if (!$expense) {
            throw new \Exception('Expense not found');
        }
        $currentStage = $expense->approvals()->count();
        $nextStage = ApprovalStage::orderBy('id')->skip($currentStage)->firstOrFail();

        if ($nextStage->approver_id != $approverId) {
            throw new \Exception('Invalid approver for this stage');
        }

        $approvedStatusId = Status::where('name', 'disetujui')->first()->id;
        $approval = $expense->approvals()->create([
            'approver_id' => $approverId,
            'status_id' => $approvedStatusId
        ]);

        // Periksa jika semua tahap persetujuan telah disetujui
        if ($expense->approvals()->count() == ApprovalStage::count()) {
            $this->expenseRepository->updateStatus($expense->id, $approvedStatusId);
        }

        return $approval;
    }




    public function getExpense($id)
    {
        return $this->expenseRepository->getById($id);
    }
}
