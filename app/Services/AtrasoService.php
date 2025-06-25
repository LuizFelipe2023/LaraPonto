<?php

namespace App\Services;

use App\Models\Atraso;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Collection;

class AtrasoService
{
    public function getAllAtrasos(): Collection
    {
        $user = auth()->user();

        $query = Atraso::with(['funcionario.setor'])
            ->join('funcionarios', 'atrasos.funcionario_id', '=', 'funcionarios.id')
            ->join('setores',     'funcionarios.setor_id', '=', 'setores.id')
            ->orderBy('setores.nome')
            ->select('atrasos.*');

        if ($user->tipo_usuario === 2) {
            $setoresIds = $user->setoresGerenciados->pluck('id')->toArray();
            $query->whereIn('funcionarios.setor_id', $setoresIds);
        }

        if ($user->tipo_usuario === 3) {
            $query->where('atrasos.funcionario_id', $user->funcionario->id);
        }

        return $query->get();
    }

    public function getAtrasoById(int $id): Atraso
    {
        return Atraso::findOrFail($id);
    }

    public function storeAtraso(array $data): Atraso
    {
        return Atraso::create($data);
    }

    public function updateAtraso(int $id, array $data): Atraso
    {
        $atraso = $this->getAtrasoById($id);
        $atraso->update($data);
        return $atraso;
    }

    public function destroyAtraso(int $id): bool
    {
        $atraso = $this->getAtrasoById($id);
        return $atraso->delete();
    }

    public function pdfAtrasosGeral()
    {
           $atrasos = $this->getAllAtrasos();
           $pdf = Pdf::loadView('pdfs.atrasos-geral',compact('atrasos'));
           return $pdf->download('atrasos-geral.pdf');
    }
}
