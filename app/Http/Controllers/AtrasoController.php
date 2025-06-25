<?php

namespace App\Http\Controllers;

use App\Services\AtrasoService;
use App\Http\Requests\InsertAtrasoRequest;
use App\Http\Requests\UpdateAtrasoRequest;
use App\Services\AuditService;
use App\Services\FuncionarioService;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Exception;

class AtrasoController extends Controller
{
    protected AtrasoService $atrasoService;
    protected FuncionarioService $funcionarioService;
    protected AuditService $auditService;

    public function __construct(AtrasoService $atrasoService, FuncionarioService $funcionarioService, AuditService $auditService)
    {
        $this->atrasoService = $atrasoService;
        $this->funcionarioService = $funcionarioService;
        $this->auditService = $auditService;
    }

    public function index(): View|RedirectResponse
    {
        try {
            $atrasos = $this->atrasoService->getAllAtrasos();
            return view('atrasos.index', compact('atrasos'));
        } catch (Exception $e) {
            Log::error('Erro ao listar atrasos', ['error' => $e->getMessage()]);
            return back()->with('error', 'Não foi possível carregar os atrasos.');
        }
    }

    public function create(): View|RedirectResponse
    {
        try {
            $funcionarios = $this->funcionarioService->getAllFuncionarios();
            return view('atrasos.create', compact('funcionarios'));
        } catch (Exception $e) {
            Log::error('Houve um erro ao abrir a tela de inserção de atraso', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Houve um erro ao abrir a tela de inserção de atraso.');
        }
    }

    public function store(InsertAtrasoRequest $request): RedirectResponse
    {
        try {
            $atraso = $this->atrasoService->storeAtraso($request->validated());
            $this->auditService->insertAudit([
                'user_id' => Auth::user()->id,
                'acao' => 'Inserção de atraso',
                'detalhes' => 'Atraso ID: ' . $atraso->id,
            ]);

            return redirect()->route('atrasos.index')->with('success', 'Atraso registrado com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao criar atraso', ['error' => $e->getMessage()]);
            return back()->with('error', 'Não foi possível registrar o atraso.')->withInput();
        }
    }

    public function edit(int $id): View|RedirectResponse
    {
        try {
            $atraso = $this->atrasoService->getAtrasoById($id);
            return view('atrasos.edit', compact('atraso'));
        } catch (Exception $e) {
            Log::error('Atraso não encontrado', ['id' => $id, 'error' => $e->getMessage()]);
            return back()->with('error', 'Atraso não encontrado.');
        }
    }

    public function update(UpdateAtrasoRequest $request, int $id): RedirectResponse
    {
        try {
            $this->atrasoService->updateAtraso($id, $request->validated());
            $this->auditService->insertAudit([
                'user_id' => Auth::user()->id,
                'acao' => 'Atualização de atraso',
                'detalhes' => 'Atraso ID: ' . $id,
            ]);

            return redirect()->route('atrasos.index')->with('success', 'Atraso atualizado com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao atualizar atraso', ['id' => $id, 'error' => $e->getMessage()]);
            return back()->with('error', 'Não foi possível atualizar o atraso.')->withInput();
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->atrasoService->destroyAtraso($id);
            $this->auditService->insertAudit([
                'user_id' => Auth::user()->id,
                'acao' => 'Exclusão de atraso',
                'detalhes' => 'Atraso ID: ' . $id,
            ]);

            return redirect()->route('atrasos.index')->with('success', 'Atraso excluído com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao excluir atraso', ['id' => $id, 'error' => $e->getMessage()]);
            return back()->with('error', 'Não foi possível excluir o atraso.');
        }
    }

    public function pdfAtrasos()
    {
        try {
            return $this->atrasoService->pdfAtrasosGeral();
        } catch (Exception $e) {
            Log::error('Houve um erro inesperado ao realizar o download de pdf dos atrasos', ['error' => $e->getMessage()]);
            return redirect()->back()->with('Erro ao realizar o download do pdf de atrasos');
        }
    }
}
