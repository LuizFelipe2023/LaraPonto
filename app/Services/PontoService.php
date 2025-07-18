<?php

namespace App\Services;

use App\Models\Funcionario;
use App\Models\Ponto;
use Illuminate\Database\Eloquent\Collection;
use Barryvdh\DomPDF\Facade\Pdf;

class PontoService
{
    public function getPontos(): Collection
    {
        $user = auth()->user();

        $query = Ponto::with(['funcionario.setor'])
            ->join('funcionarios', 'pontos.funcionario_id', '=', 'funcionarios.id')
            ->join('setores', 'funcionarios.setor_id', '=', 'setores.id')
            ->orderBy('setores.nome')
            ->select('pontos.*');

        if ($user->tipo_usuario == 2) {
            $setoresIds = $user->setoresGerenciados->pluck('id')->toArray();

            $query->whereIn('funcionarios.setor_id', $setoresIds);
        }

        if ($user->tipo_usuario == 3) {
            abort(403, 'Acesso não autorizado.');
        }

        return $query->get();
    }

    public function getPontoById(int $id): Ponto
    {
        return Ponto::findOrFail($id);
    }

    public function insertPonto(array $data): Ponto
    {
        return Ponto::create($data);
    }

    public function updatePonto(int $id, array $data): Ponto
    {
        $ponto = $this->getPontoById($id);
        $ponto->fill($data);
        $ponto->save();

        return $ponto;
    }

    public function destroyPonto(int $id): bool
    {
        $ponto = $this->getPontoById($id);
        return $ponto->delete();
    }

    public function registrarEntrada(int $funcionarioId): Ponto
    {
        $now = now();

        $pontoAberto = Ponto::where('funcionario_id', $funcionarioId)
            ->whereNull('hora_saida')
            ->first();

        if ($pontoAberto) {
            throw new \Exception("Já existe um ponto aberto para esse funcionário.");
        }

        return Ponto::create([
            'funcionario_id' => $funcionarioId,
            'data' => $now->toDateString(),
            'hora_entrada' => $now->toTimeString(),
            'hora_saida' => null,
        ]);
    }
    public function registrarSaida(int $pontoId): Ponto
    {
        $ponto = $this->getPontoById($pontoId);

        if ($ponto->hora_saida !== null) {
            throw new \Exception("Este ponto já possui hora de saída registrada.");
        }

        $now = now();
        $ponto->hora_saida = $now->toTimeString();

        $entrada = \Carbon\Carbon::createFromFormat('H:i:s', $ponto->hora_entrada);
        $saida = \Carbon\Carbon::createFromFormat('H:i:s', $ponto->hora_saida);

        $duracaoTrabalho = $entrada->diffInSeconds($saida);
        $duracaoHoras = $duracaoTrabalho / 3600;

        $jornada = 8; 

        if ($duracaoHoras > $jornada) {
            $horaExtra = $duracaoHoras - $jornada;
        } else {
            $horaExtra = 0;
        }

        $ponto->hora_extra = round($horaExtra, 2);
        $ponto->save();

        return $ponto;
    }

    public function getPontosAbertosPorFuncionario(int $funcionarioId): ?Ponto
    {
        return Ponto::where('funcionario_id', $funcionarioId)
            ->whereNull('hora_saida')
            ->orderBy('data', 'desc')
            ->first();
    }

    public function pdfPontosFuncionario($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        $pontos = Ponto::where('funcionario_id', $funcionario->id)->get();
        $pdf = Pdf::loadView('pdfs.pontos-funcionario', compact('funcionario', 'pontos'));
        return $pdf->download('pontos_' . $funcionario->usuario->name . '.pdf');
    }

    public function pdfsPontosGeral()
    {
        $pontos = Ponto::select('pontos.*')
            ->join('funcionarios', 'pontos.funcionario_id', '=', 'funcionarios.id')
            ->join('setores', 'funcionarios.setor_id', '=', 'setores.id')
            ->with(['funcionario.setor', 'funcionario.usuario'])
            ->orderBy('setores.nome')
            ->get();
        $pdf = Pdf::loadView('pdfs.pontos-geral', compact('pontos'));
        return $pdf->download('pontos-gerais.pdf');
    }

}
