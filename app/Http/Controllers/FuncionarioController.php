<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertFuncionarioRequest;
use App\Http\Requests\UpdateFuncionarioRequest;
use App\Services\FuncionarioService;
use App\Services\SetorService;
use App\Services\StatusFuncionarioService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Log;

class FuncionarioController extends Controller
{
    protected $setorService, $funcionarioService, $userService, $statusFuncionarioService;

    public function __construct(SetorService $setorService, FuncionarioService $funcionarioService, UserService $userService, StatusFuncionarioService $statusFuncionarioService)
    {
        $this->setorService = $setorService;
        $this->funcionarioService = $funcionarioService;
        $this->userService = $userService;
        $this->statusFuncionarioService = $statusFuncionarioService;
    }

    public function indexFuncionarios()
    {
        try {
            $funcionarios = $this->funcionarioService->getAllFuncionarios();
            $statuses = $this->statusFuncionarioService->getAllStatuses();
            $setores = $this->setorService->index();
            return view('funcionarios.index', ['funcionarios' => $funcionarios, 'statuses' => $statuses, 'setores' => $setores]);
        } catch (Exception $e) {
            Log::error('Houve um erro inesperado ao recuperar a lista de funcionários', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Houve um erro inesperado ao retornar a lista de funcionários. Tente novamente');
        }
    }

    public function createFuncionario()
    {
        try {
            $usuarios = $this->userService->getAllUsers();
            $statuses = $this->statusFuncionarioService->getAllStatuses();
            $setores = $this->setorService->index();
            return view('funcionarios.create', compact('usuarios', 'setores','statuses'));
        } catch (Exception $e) {
            Log::error('Erro ao acessar o formulário de criação de funcionário', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro inesperado ao acessar o formulário de criação de funcionário.');
        }
    }

    public function storeFuncionario(InsertFuncionarioRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $this->funcionarioService->insertFuncionario($validatedData);
            return redirect()->route('funcionarios.index')->with('success', 'Funcionário criado com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao criar funcionário', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro inesperado ao criar funcionário. Verifique os dados e tente novamente.')->withInput();
        }
    }

    public function editFuncionario($id)
    {
        try {
            $funcionario = $this->funcionarioService->getFuncionarioById($id);
            $statuses = $this->statusFuncionarioService->getAllStatuses();
            $setores = $this->setorService->index();
            return view('funcionarios.edit', compact('funcionario', 'setores','statuses'));
        } catch (Exception $e) {
            Log::error('Erro ao acessar o formulário de edição de funcionário', ['error' => $e->getMessage()]);
            return redirect()->route('funcionarios.index')->with('error', 'Erro inesperado ao acessar o formulário de edição.');
        }
    }

    public function updateFuncionario(UpdateFuncionarioRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $updated = $this->funcionarioService->updateFuncionario($id, $validatedData);
            if (!$updated) {
                return redirect()->back()->with('error', 'Não foi possível atualizar o funcionário.');
            }
            return redirect()->route('funcionarios.index')->with('success', 'Funcionário atualizado com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao atualizar funcionário', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro inesperado ao atualizar funcionário.')->withInput();
        }
    }

    public function deleteFuncionario($id)
    {
        try {
            $deleted = $this->funcionarioService->deleteFuncionario($id);

            if (!$deleted) {
                return redirect()->route('funcionarios.index')->with('error', 'Não foi possível excluir o funcionário.');
            }

            return redirect()->route('funcionarios.index')->with('success', 'Funcionário excluído com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao excluir funcionário', ['error' => $e->getMessage()]);
            return redirect()->route('funcionarios.index')->with('error', 'Erro inesperado ao excluir funcionário.');
        }
    }
}
