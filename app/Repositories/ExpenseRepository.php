<?php

namespace App\Repositories;

use App\Models\Expense;
use App\Models\Approval;

class ExpenseRepository implements ExpenseRepositoryInterface
{
    public function create(array $data)
    {
        return Expense::create($data);
    }

    public function getById($id)
    {
        return Expense::with(['status', 'approvals.approver'])->find($id);
    }

    public function createApproval($expenseId, $approverId, $statusId)
    {
        return Approval::create([
            'expense_id' => $expenseId,
            'approver_id' => $approverId,
            'status_id' => $statusId
        ]);
    }

    public function updateStatus($id, $statusId)
    {
        $expense = $this->getById($id);
        $expense->update(['status_id' => $statusId]);
        return $expense;
    }
}
