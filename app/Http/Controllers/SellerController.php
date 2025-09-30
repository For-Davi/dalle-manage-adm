<?php

namespace App\Http\Controllers;

use App\Http\Requests\Seller\CreateSellerRequest;
use App\Http\Requests\Seller\DeleteSellerRequest;
use App\Http\Requests\Seller\UpdateSellerRequest;
use App\Repositories\DalleAdm\SellerRepository;
use App\Services\DalleAdm\SellerService;
use App\Utils\ErrorLogger;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class SellerController
{
    public function __construct(
        protected SellerRepository $repository,
        protected SellerService $service
    ) {}

    public function index()
    {
        $sellers = $this->repository->getAll(['subscription']);

        return Inertia::render('Sellers', [
            'sellers' => $sellers,
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
            ],
        ]);
    }

    public function create(CreateSellerRequest $request)
    {
        try {
            DB::beginTransaction();

            $sellers = $this->service->create($request);

            if ($sellers) {
                DB::commit();

                return redirect()->route('sellers');
            }
        } catch (ValidationException $e) {
            DB::rollBack();

            return back()->withErrors($e->errors())->withInput();
        } catch (ValidationException  $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao criar vendedor', $e, $request);

            return back()->withErrors(['error' => 'Ocorreu um erro no servidor. Por favor, tente novamente.']);
        }
    }

    public function update(UpdateSellerRequest $request)
    {
        try {
            DB::beginTransaction();

            $sellers = $this->service->update($request);

            if ($sellers) {
                DB::commit();

                return redirect()->route('sellers')->with('success', 'Vendedor atualizado com sucesso');
            }
        } catch (ValidationException $e) {
            DB::rollBack();

            return back()->withErrors($e->errors())->withInput();
        } catch (ValidationException  $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao atualizar vendedor', $e, $request);

            return back()->withErrors(['error' => 'Ocorreu um erro no servidor. Por favor, tente novamente.']);
        }
    }

    public function delete(DeleteSellerRequest $request)
    {
        try {
            DB::beginTransaction();

            $sellers = $this->repository->delete($request->route('id'));

            if ($sellers) {

                DB::commit();

                return redirect()->route('sellers')->with('success', 'Vendedor deletado com sucesso');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao deletar a empresa', $e, $request);

            return back()->withErrors(['name' => 'Erro ao deletar vendedor.'])->onlyInput('name');
        }

        return redirect()->route('enterprises')->with('error', 'Erro ao deletar vendedor');
    }
}
