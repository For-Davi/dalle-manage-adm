<?php

namespace App\Http\Controllers\DalleAdm;

use App\Repositories\DalleManage\EnterpriseDMRepository;
use Inertia\Inertia;

class EnterpriseController
{
    public function __construct(protected EnterpriseDMRepository $repository) {}

    public function index()
    {
        $enterprises = $this->repository->getAll();

        return Inertia::render('Enterprises', [
            'enterprises' => $enterprises,
        ]);
    }
}
