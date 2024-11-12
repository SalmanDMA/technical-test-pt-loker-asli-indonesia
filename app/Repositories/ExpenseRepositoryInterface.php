<?php

namespace App\Repositories;

namespace App\Repositories;

interface ExpenseRepositoryInterface
{
    public function create(array $data);
    public function getById($id);
    public function createApproval($expenseId, $approverId, $statusId);
    public function updateStatus($id, $statusId);
}
