<?php

namespace App\Http\Controllers;

use App\Services\FaltaService;
use App\Http\Requests\InsertFaltaRequest;
use App\Http\Requests\UpdateFaltaRequest;
use App\Services\FuncionarioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Exception;

class FaltaController extends Controller
{
    protected FaltaService $faltaService;
    protected FuncionarioService $funcionarioService;

    public function __construct(FaltaService $faltaService, FuncionarioService $funcionarioService)
    {
        $this->faltaService = $faltaService;
        $this->funcionarioService = $funcionarioService;
    }

    public function index(): View|RedirectResponse
    {
        try {
            $faltas = $this->faltaService->getAllFaltas();
            return view('faltas.index', compact('faltas'));
        } catch (Exception $e) {
            Log::error('Erro ao listar faltas', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Não foi possível carregar as faltas.');
        }
    }

    public function create(): View
    {
        $funcionarios = $this->funcionarioService->getAllFuncionarios();
        return view('faltas.create',compact('funcionarios'));
    }

    public function store(InsertFaltaRequest $request): RedirectResponse
    {
        try {
            $this->faltaService->storeFalta($request->validated());
            return redirect()->route('faltas.index')->with('success', 'Falta registrada com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao criar falta', ['error' => $e->getMessage()]);
            return back()->with('error', 'Não foi possível registrar a falta.')->withInput();
        }
    }

    public function edit(int $id): View|RedirectResponse
    {
        try {
            $falta = $this->faltaService->getFaltaById($id);
            return view('faltas.edit', compact('falta'));
        } catch (Exception $e) {
            Log::error('Falta não encontrada', ['id' => $id, 'error' => $e->getMessage()]);
            return back()->with('error', 'Falta não encontrada.');
        }
    }

    public function update(UpdateFaltaRequest $request, int $id): RedirectResponse
    {
        try {
            $this->faltaService->updateFalta($id, $request->validated());
            return redirect()->route('faltas.index')->with('success', 'Falta atualizada com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao atualizar falta', ['id' => $id, 'error' => $e->getMessage()]);
            return back()->with('error', 'Não foi possível atualizar a falta.')->withInput();
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->faltaService->destroyFalta($id);
            return redirect()->route('faltas.index')->with('success', 'Falta excluída com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao excluir falta', ['id' => $id, 'error' => $e->getMessage()]);
            return back()->with('error', 'Não foi possível excluir a falta.');
        }
    }

    public function pdfFaltas()
    {
           try{
              return $this->faltaService->pdfFaltasGeral();
           }catch(Exception $e){
              Log::error('Houve um erro inesperado ao realizar o download de pdf das faltas',['error' => $e->getMessage()]);
              return redirect()->back()->with('Erro ao realizar o download do pdf de faltas');
           }
    }
}
