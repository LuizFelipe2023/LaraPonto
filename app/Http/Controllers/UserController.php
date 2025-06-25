<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\TipoUsuarioService;
use App\Services\UserService;
use App\Services\AuditService; 
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; 
use Illuminate\View\View;

class UserController extends Controller
{
    protected UserService $userService;
    protected TipoUsuarioService $tipoUsuarioService;
    protected AuditService $auditService; 

    public function __construct(UserService $userService, TipoUsuarioService $tipoUsuarioService, AuditService $auditService)
    {
        $this->userService = $userService;
        $this->tipoUsuarioService = $tipoUsuarioService;
        $this->auditService = $auditService; 
    }

    public function painelUsuarios(): View|RedirectResponse
    {
        try {
            $users = $this->userService->index();
            $tipoUsuarios = $this->tipoUsuarioService->getAllTipoUsuarios();
            return view('users.painel', compact('users','tipoUsuarios'));
        } catch (Exception $e) {
            Log::error('Erro ao recuperar a lista de usuários.', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro inesperado ao carregar a lista de usuários.');
        }
    }

    public function createUser(): View|RedirectResponse
    {
        try {
            $tipoUsuarios = $this->tipoUsuarioService->getAllTipoUsuarios();
            return view('users.create', compact('tipoUsuarios'));
        } catch (Exception $e) {
            Log::error('Erro ao carregar tipos de usuário para criação.', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao carregar informações para criação de usuário.');
        }
    }

    public function storeUser(InsertUserRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        try {
            Log::info('Inserção de novo usuário.', ['data' => $validatedData]);
            $user = $this->userService->insertUser($validatedData);

            $this->auditService->insertAudit([
                'user_id' => Auth::user()->id,
                'acao' => 'Inserção de usuário',
                'detalhes' => 'Usuário ID: ' . ($user->id ?? 'N/A') . ', Email: ' . ($validatedData['email'] ?? ''),
            ]);

            return redirect()->route('users.painel')->with('success', 'Usuário cadastrado com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao cadastrar usuário.', ['error' => $e->getMessage(), 'data' => $validatedData]);
            return redirect()->back()->with('error', 'Erro inesperado ao cadastrar o usuário.')->withInput();
        }
    }

    public function editUser(int $id): View|RedirectResponse
    {
        try {
            $tipoUsuarios = $this->tipoUsuarioService->getAllTipoUsuarios();
            $user = $this->userService->findUserById($id);

            return view('users.edit', compact('user', 'tipoUsuarios'));
        } catch (Exception $e) {
            Log::error('Erro ao carregar usuário para edição.', ['error' => $e->getMessage(), 'id' => $id]);
            return redirect()->route('users.painel')->with('error', 'Usuário não encontrado ou erro ao carregar dados.');
        }
    }

    public function updateUser(int $id, UpdateUserRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        try {
            $this->userService->updateUser($id, $validatedData);

            $this->auditService->insertAudit([
                'user_id' => Auth::user()->id,
                'acao' => 'Atualização de usuário',
                'detalhes' => 'Usuário ID: ' . $id,
            ]);

            return redirect()->route('users.painel')->with('success', 'Usuário atualizado com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao atualizar usuário.', ['error' => $e->getMessage(), 'id' => $id, 'data' => $validatedData]);
            return redirect()->back()->with('error', 'Erro ao atualizar o usuário.')->withInput();
        }
    }

    public function deleteUser(int $id): RedirectResponse
    {
        try {
            $this->userService->destroyUser($id);

            $this->auditService->insertAudit([
                'user_id' => Auth::user()->id,
                'acao' => 'Exclusão de usuário',
                'detalhes' => 'Usuário ID: ' . $id,
            ]);

            return redirect()->back()->with('success', 'Usuário deletado com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao deletar usuário.', ['error' => $e->getMessage(), 'id' => $id]);
            return redirect()->back()->with('error', 'Erro inesperado ao deletar o usuário.');
        }
    }
}
