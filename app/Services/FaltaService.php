<?php

namespace App\Services;

use App\Models\Falta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Collection;

class FaltaService
{
    public function getAllFaltas(): Collection
    {
        $user = auth()->user();

        $query = Falta::with(['funcionario.setor'])
            ->join('funcionarios', 'faltas.funcionario_id', '=', 'funcionarios.id')
            ->join('setores',     'funcionarios.setor_id', '=', 'setores.id')
            ->orderBy('setores.nome')
            ->select('faltas.*');

        if ($user->tipo_usuario === 2) {
            $setoresIds = $user->setoresGerenciados->pluck('id')->toArray();
            $query->whereIn('funcionarios.setor_id', $setoresIds);
        }

        if ($user->tipo_usuario === 3) {
            // Só suas próprias faltas
            $query->where('faltas.funcionario_id', $user->funcionario->id);
        }

        return $query->get();
    }

    public function getFaltaById(int $id): Falta
    {
        return Falta::findOrFail($id);
    }

    public function storeFalta(array $data): Falta
    {
        return Falta::create($data);
    }

    public function updateFalta(int $id, array $data): Falta
    {
        $falta = $this->getFaltaById($id);
        $falta->update($data);
        return $falta;
    }

    public function destroyFalta(int $id): bool
    {
        $falta = $this->getFaltaById($id);
        return $falta->delete();
    }

    public function pdfFaltasGeral()
    {
           $faltas = $this->getAllFaltas();
           $pdf = Pdf::loadView('pdfs.faltas-geral',compact('faltas'));
           return $pdf->download('faltas-geral.pdf');
    }
}
