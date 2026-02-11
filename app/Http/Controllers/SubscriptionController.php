<?php

namespace App\Http\Controllers;

use App\Repositories\DalleManage\SubscriptionDMRepository;
use Illuminate\Http\Request;

class SubscriptionController extends BaseController
{
    public function __construct(
        protected SubscriptionDMRepository $repository
    ) {}

    public function index(Request $request)
    {
        return $this->safeExecute(function () {

            $subscriptions = $this->repository
                ->getAllEnterprisesBySubscriptions();

            return response()->json([
                'subscriptions' => $subscriptions,
            ]);

        }, 'Erro ao buscar subscriptions', $request);
    }
}
