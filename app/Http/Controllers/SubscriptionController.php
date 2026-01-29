<?php

namespace App\Http\Controllers;

use App\Repositories\DalleManage\SubscriptionDMRepository;

class SubscriptionController
{
    public function __construct(protected SubscriptionDMRepository $repository) {}

    public function index()
    {
        $subscriptions = $this->repository->getAllEnterprisesBySubscriptions();

        return response()->json(['subscriptions' => $subscriptions]);
    }
}
