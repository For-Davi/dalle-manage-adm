<?php

namespace App\Http\Controllers;

use App\Repositories\DalleManage\SubscriptionsDMRepository;
use Inertia\Inertia;

class SubscriptionsController
{
    public function __construct(protected SubscriptionsDMRepository $repository) {}

    public function show()
    {
        $subscriptions = $this->repository->getAllEnterprisesBySubscriptions();

        return Inertia::render('Subscription', [
            'subscriptions' => $subscriptions,
        ]);
    }
}
