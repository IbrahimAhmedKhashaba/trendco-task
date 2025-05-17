<?php

namespace App\Interfaces\Repositories\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;


interface AdminRepositoryInterface
{
    public function index(): Collection;
    public function show($id): ?User;
    public function store($data): ?User;
}
