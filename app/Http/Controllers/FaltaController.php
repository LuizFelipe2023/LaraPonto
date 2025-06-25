<?php

namespace App\Http\Controllers;

use App\Services\FaltaService;
use App\Services\FuncionarioService;
use App\Services\AuditService;
use App\Http\Requests\InsertFaltaRequest;
use App\Http\Requests\UpdateFaltaRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class FaltaController extends Controller
{
    protected FaltaService $faltaService;
    protected FuncionarioService $funcionarioService;
    protected AuditService $auditService;

    public function __construct(FaltaService $faltaService, FuncionarioService $funcionarioService, AuditService $auditService)
    {
        $this->faltaService = $faltaService;
        $this->funcionarioService = $funcionarioService;
        $this->auditService = $auditService;
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
            $falta = $this->faltaService->storeFalta($request->validated());

            $this->auditService->insertAudit([
                'user_id' => Auth::user()->id,
                'acao' => 'Inserção de falta',
                'detalhes' => 'Falta ID: ' . ($falta->id ?? 'N/A'),
            ]);

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

            $this->auditService->insertAudit([
                'user_id' => Auth::user()->id,
                'acao' => 'Atualização de falta',
                'detalhes' => 'Falta ID: ' . $id,
            ]);

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

            $this->auditService->insertAudit([
                'user_id' => Auth::user()->id,
                'acao' => 'Exclusão de falta',
                'detalhes' => 'Falta ID: ' . $id,
            ]);

            return redirect()->route('faltas.index')->with('success', 'Falta excluída com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao excluir falta', ['id' => $id, 'error' => $e->getMessage()]);
            return back()->with('error', 'Não foi possível excluir a falta.');
        }
    }

    public function pdfFaltas()
    {
        try {
            return $this->faltaService->pdfFaltasGeral();
        } catch(Exception $e) {
            Log::error('Houve um erro inesperado ao realizar o download de pdf das faltas', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao realizar o download do pdf de faltas');
        }
    }
}
