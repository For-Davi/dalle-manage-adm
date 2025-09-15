<?php

namespace App\Http\Controllers;

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
