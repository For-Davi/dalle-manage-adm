<?php

namespace App\Http\Controllers;

use App\Http\Requests\Seller\Registration\DeleteRegistrationRequest;
use App\Http\Requests\Seller\Registration\ShowRegistrationRequest;
use App\Http\Resources\Registration\RegistrationResource;
use App\Repositories\DalleAdm\RegistrationRepository;

class RegistrationController extends BaseController
{
    public function __construct(
        protected RegistrationRepository $repository,
    ) {}

    public function index()
    {
        return $this->safeExecute(function () {

            $registrations = $this->repository->getAll();

            return response()->json([
                'registrations' => RegistrationResource::collection($registrations),
            ]);

        }, 'Erro ao listar inscrições');
    }

    public function show(ShowRegistrationRequest $request)
    {
        return $this->safeExecute(function () use ($request) {

            $registration = $this->repository
                ->findById($request->route('registration'));

            return response()->json([
                'registration' => $registration,
            ]);

        }, 'Erro ao buscar inscrição', $request);
    }

    public function delete(DeleteRegistrationRequest $request)
    {
        return $this->safeTransaction(function () use ($request) {

            $this->repository
                ->delete($request->route('registration'));

            $registrations = $this->repository->getAll();

            return response()->json([
                'registrations' => $registrations,
                'message' => 'Inscrição excluída',
            ]);

        }, 'Erro ao excluir inscrição', $request);
    }
}
