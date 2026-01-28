<?php

namespace App\Http\Controllers;

use App\Http\Requests\Seller\CreateSellerRequest;
use App\Http\Requests\Seller\DeleteSellerRequest;
use App\Http\Requests\Seller\UpdateSellerRequest;
use App\Repositories\DalleAdm\SellerRepository;
use App\Services\DalleAdm\SellerService;
use App\Utils\ErrorLogger;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SellerController
{
    public function __construct(
        protected SellerRepository $repository,
        protected SellerService $service
    ) {}

    public function index()
    {
        $sellers = $this->repository->getAll();

        return response()->json(['sellers' => $sellers]);
    }

    public function create(CreateSellerRequest $request)
    {
        try {
            DB::beginTransaction();

            $sellers = $this->service->create($request);

            if ($sellers) {
                DB::commit();

                $sellers = $this->repository->getAll();

                return response()->json(['sellers' => $sellers, 'message' => 'Vendedor criado'], 201);
            }
        } catch (Exception  $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao criar vendedor', $e, $request);

            return response()->json(['message' => 'Erro ao criar vendedor'], 500);
        }
    }

    public function update(UpdateSellerRequest $request)
    {
        try {
            DB::beginTransaction();

            $sellers = $this->service->update($request);

            if ($sellers) {
                DB::commit();

                $sellers = $this->repository->getAll();

                return response()->json(['sellers' => $sellers, 'message' => 'Vendedor atualizado']);
            }
        } catch (ValidationException  $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao atualizar vendedor', $e, $request);

            return response()->json(['message' => 'Erro ao atualizar vendedor'], 500);
        }
    }

    public function delete(DeleteSellerRequest $request)
    {
        try {
            DB::beginTransaction();

            $sellers = $this->repository->delete($request->route('id'));

            if ($sellers) {

                DB::commit();

                $sellers = $this->repository->getAll();

                return response()->json(['sellers' => $sellers, 'message' => 'Vendedor excluído']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao excluir vendedor', $e, $request);

            return response()->json(['message' => 'Erro ao excluir vendedor'], 500);
        }
    }
}
