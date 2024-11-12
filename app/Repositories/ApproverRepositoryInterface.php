<?php

namespace App\Repositories;

interface ApproverRepositoryInterface
{
    public function create(array $data);
    public function getById($id);
    public function getAll();
}
