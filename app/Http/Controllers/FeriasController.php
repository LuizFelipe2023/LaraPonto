<?php

namespace App\Http\Controllers;

use App\Services\AuditService;
use App\Services\FeriasService;
use App\Services\FuncionarioService;
use Exception;
use Illuminate\Http\Request;
use Log;

class FeriasController extends Controller
{
    protected $feriasService, $auditService, $funcionarioService;

    public function __construct(FeriasService $feriasService, AuditService $auditService, FuncionarioService $funcionarioService)
    {
        $this->feriasService = $feriasService;
        $this->auditService = $auditService;
        $this->funcionarioService = $funcionarioService;
    }

    public function index()
    {
        try {
            $ferias = $this->feriasService->getAllFerias();
            return view('ferias.index', compact('ferias'));
        } catch (Exception $e) {
            Log::error('Houve um erro ao recuperar a lista de férias', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Houve um erro ao acessar a lista de férias');
        }
    }

    public function createFerias()
    {
        try {
            $funcionarios = $this->funcionarioService->getAllFuncionarios();
            return view('ferias.create', compact('funcionarios'));
        } catch (Exception $e) {
            Log::error('Houve um erro ao recuperar a lista de funcionários para inserção de um registro de férias', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao carregar funcionários');
        }
    }

    public function store(Request $request)
    {
        try {
            $this->feriasService->insertFerias($request->all());
            return redirect()->route('ferias.index')->with('success', 'Férias cadastradas com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao cadastrar férias', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao cadastrar férias');
        }
    }

    public function edit($id)
    {
        try {
            $ferias = $this->feriasService->getFeriasById($id);
            $funcionarios = $this->funcionarioService->getAllFuncionarios();
            return view('ferias.edit', compact('ferias', 'funcionarios'));
        } catch (Exception $e) {
            Log::error('Erro ao buscar registro de férias para edição', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao carregar registro de férias');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->feriasService->updateFerias($id, $request->all());
            return redirect()->route('ferias.index')->with('success', 'Férias atualizadas com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao atualizar registro de férias', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao atualizar férias');
        }
    }

    public function destroy($id)
    {
        try {
            $this->feriasService->destroyFerias($id);
            return redirect()->back()->with('success', 'Férias removidas com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao excluir registro de férias', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao excluir férias');
        }
    }
}
