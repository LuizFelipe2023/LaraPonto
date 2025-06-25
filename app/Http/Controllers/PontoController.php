<?php

namespace App\Http\Controllers;

use App\Services\FuncionarioService;
use App\Services\PontoService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Log;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\RegistrarEntradaRequest;
use App\Http\Requests\RegistrarSaidaRequest;

class PontoController extends Controller
{
    protected $pontoService, $funcionarioService;

    public function __construct(PontoService $pontoService, FuncionarioService $funcionarioService)
    {
        $this->pontoService = $pontoService;
        $this->funcionarioService = $funcionarioService;
    }

    public function index()
    {
        try {
            $pontos = $this->pontoService->getPontos();
            return view('pontos.index', compact('pontos'));
        } catch (Exception $e) {
            Log::error('Erro ao recuperar lista de pontos', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro inesperado ao carregar pontos. Tente novamente.');
        }
    }

    public function createEntrada($funcionarioId)
    {
        try {
            $funcionario = $this->funcionarioService->getFuncionarioById($funcionarioId);
            return view('pontos.entrada', compact('funcionario'));
        } catch (ModelNotFoundException $e) {
            Log::error('Funcionário não encontrado para registrar entrada', ['error' => $e->getMessage()]);
            return redirect()->route('funcionarios.index')->with('error', 'Funcionário não encontrado.');
        } catch (Exception $e) {
            Log::error('Erro ao acessar tela de entrada', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao acessar tela de entrada.');
        }
    }
    public function storeEntrada(RegistrarEntradaRequest $request): RedirectResponse
    {
        try {
            $ponto = $this->pontoService->insertPonto($request->validated());
            return redirect()->route('pontos.funcionario', $ponto->funcionario_id)
                ->with('success', 'Entrada registrada com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao registrar entrada', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao registrar entrada. Tente novamente.');
        }
    }

    public function createSaida($funcionarioId)
    {
        try {
            $funcionario = $this->funcionarioService->getFuncionarioById($funcionarioId);
            $pontoAberto = $this->pontoService->getPontosAbertosPorFuncionario($funcionarioId);

            if (!$pontoAberto) {
                return redirect()->route('pontos.index')->with('error', 'Nenhum ponto aberto encontrado para esse funcionário.');
            }

            return view('pontos.saida', compact('funcionario', 'pontoAberto'));
        } catch (ModelNotFoundException $e) {
            Log::error('Funcionário não encontrado para registrar saída', ['error' => $e->getMessage()]);
            return redirect()->route('funcionarios.index')->with('error', 'Funcionário não encontrado.');
        } catch (Exception $e) {
            Log::error('Erro ao acessar tela de saída', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao acessar tela de saída.');
        }
    }

    public function storeSaida(RegistrarSaidaRequest $request, $pontoId): RedirectResponse
    {
        try {
            $this->pontoService->updatePonto($pontoId, $request->validated());
            $ponto = $this->pontoService->getPontoById($pontoId);
            return redirect()->route('pontos.funcionario', $ponto->funcionario_id)
                ->with('success', 'Saída registrada com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao registrar saída', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao registrar saída. Tente novamente.');
        }
    }

    public function deletePonto($id): RedirectResponse
    {
        try {
            $this->pontoService->destroyPonto($id);
            return redirect()->back()->with('success', 'Ponto deletado com sucesso');
        } catch (Exception $e) {
            Log::error('Erro ao excluir ponto', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao excluir ponto. Tente novamente.');
        }
    }
    public function pontosFuncionario($id)
    {
        try {
            $funcionario = $this->funcionarioService->getFuncionarioById($id);
            $pontos = $this->funcionarioService->getPontosByFuncionario($id);
            return view('pontos.funcionario', compact('funcionario', 'pontos'));
        } catch (ModelNotFoundException $e) {
            Log::error('Funcionário não encontrado ao tentar acessar pontos', ['error' => $e->getMessage(), 'funcionario_id' => $id]);
            return redirect()->route('funcionarios.index')->with('error', 'Funcionário não encontrado.');
        } catch (Exception $e) {
            Log::error('Erro inesperado ao carregar pontos do funcionário', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro inesperado ao carregar os pontos. Tente novamente.');
        }
    }

    public function pdfPontosFuncionario($id)
    {
        try {
            return $this->pontoService->pdfPontosFuncionario($id);
        } catch (Exception $e) {
            Log::error('Erro ao gerar PDF de pontos: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Não foi possível gerar o PDF.');
        }
    }

    
    public function pdfPontosGeral()
    {
        try {
            return $this->pontoService->pdfsPontosGeral();
        } catch (Exception $e) {
            Log::error('Erro ao gerar PDF de pontos: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Não foi possível gerar o PDF.');
        }
    }

}
