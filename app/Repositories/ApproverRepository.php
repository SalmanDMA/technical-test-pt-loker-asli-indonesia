<?php

namespace App\Repositories;

use App\Models\Approver;

class ApproverRepository implements ApproverRepositoryInterface
{
    public function create(array $data)
    {
        return Approver::create($data);
    }

    public function getById($id)
    {
        return Approver::find($id);
    }

    public function getAll()
    {
        return Approver::all();
    }
}
