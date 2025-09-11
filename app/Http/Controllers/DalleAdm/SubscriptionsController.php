<?php

namespace App\Http\Controllers\DalleAdm;

use App\Repositories\DalleManage\SubscriptionsDMRepository;
use Inertia\Inertia;

class SubscriptionsController
{
    public function __construct(protected SubscriptionsDMRepository $repository) {}

    public function index()
    {
        $subscriptions = $this->repository->getAllEnterprisesBySubscriptions();

        return Inertia::render('Subscriptions', [
            'subscriptions' => $subscriptions,
        ]);
    }
}
