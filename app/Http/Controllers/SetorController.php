<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertSetorRequest;
use App\Http\Requests\UpdateSetorRequest;
use App\Services\SetorService;
use App\Services\UserService;
use App\Services\AuditService;  // <-- importar AuditService
use Exception;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Auth;

class SetorController extends Controller
{
    protected $setorService, $userService, $auditService;  

    public function __construct(SetorService $setorService, UserService $userService, AuditService $auditService)  
    {
        $this->setorService = $setorService;
        $this->userService = $userService;
        $this->auditService = $auditService;  
    }

    public function index()
    {
        try {
            $setores = $this->setorService->index();
            return view('setores.painel', compact('setores'));
        } catch (Exception $e) {
            Log::error('Houve um erro ao recuperar a lista de setores', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Houve um erro inesperado ao retornar a lista de setores');
        }
    }

    public function createSetor()
    {
        try {
            $users = $this->userService->returnAllManagers();
            return view('setores.create', compact('users'));
        } catch (Exception $e) {
            Log::error('Houve um erro inesperado ao acessar a pagina de criação de setor.', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Houve um erro inesperado ao acessar o formulário de criação de setor.');
        }
    }

    public function storeSetor(InsertSetorRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $setor = $this->setorService->insertSetor($validatedData);

            $this->auditService->insertAudit([
                'user_id' => Auth::user()->id,
                'acao' => 'Inserção de setor',
                'detalhes' => 'Setor ID: ' . ($setor->id ?? 'N/A') . ', Nome: ' . ($validatedData['nome'] ?? ''),
            ]);

            return redirect()->route('setores.index')->with('success', 'Foi criado um novo setor com sucesso');
        } catch (Exception $e) {
            Log::error('Houve um erro inesperado no processo de inserção de um novo setor: ', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Houve um erro inesperado na inserção de um novo setor, verifique o formulário');
        }
    }

    public function editSetor($id)
    {
        try {
            $setor = $this->setorService->getSetorById($id);
            $users = $this->userService->returnAllManagers();

            if (!$setor) {
                return redirect()->route('setores.index')->with('error', 'Setor não encontrado.');
            }

            return view('setores.edit', compact('setor', 'users'));
        } catch (Exception $e) {
            Log::error('Erro ao acessar o formulário de edição do setor', ['error' => $e->getMessage()]);
            return redirect()->route('setores.index')->with('error', 'Houve um erro inesperado ao acessar o formulário de edição.');
        }
    }

    public function updateSetor(UpdateSetorRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $updated = $this->setorService->updateSetor($id, $validatedData);

            if (!$updated) {
                return redirect()->back()->with('error', 'Não foi possível atualizar o setor.');
            }

            $this->auditService->insertAudit([
                'user_id' => Auth::user()->id,
                'acao' => 'Atualização de setor',
                'detalhes' => 'Setor ID: ' . $id,
            ]);

            return redirect()->route('setores.index')->with('success', 'Setor atualizado com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao atualizar setor', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Houve um erro inesperado ao atualizar o setor.');
        }
    }

    public function deleteSetor($id)
    {
        try {
            $deleted = $this->setorService->destroySetor($id);

            if (!$deleted) {
                return redirect()->route('setores.index')->with('error', 'Não foi possível excluir o setor.');
            }

            $this->auditService->insertAudit([
                'user_id' => Auth::user()->id,
                'acao' => 'Exclusão de setor',
                'detalhes' => 'Setor ID: ' . $id,
            ]);

            return redirect()->route('setores.index')->with('success', 'Setor excluído com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao excluir setor', ['error' => $e->getMessage()]);
            return redirect()->route('setores.index')->with('error', 'Houve um erro inesperado ao excluir o setor.');
        }
    }
}
