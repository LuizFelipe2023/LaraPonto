<?php

namespace App\Services;

use App\Models\Audit;
use Barryvdh\DomPDF\Facade\Pdf;

class AuditService
{
    public function getAllAudits()
    {
        return Audit::select('acao', \DB::raw('count(*) as total'))
            ->groupBy('acao')
            ->get();

    }

    public function insertAudit(array $data): Audit
    {
        return Audit::create([
            'user_id' => $data['user_id'],
            'acao' => $data['acao'],
            'detalhes' => $data['detalhes']
        ]);
    }

    public function pdfAudits(array $data = [])
    {
        $query = Audit::with('user');

        if (isset($data['mes'])) {
            $query->whereYear('created_at', substr($data['mes'], 0, 4))
                ->whereMonth('created_at', substr($data['mes'], 5, 2));
        } elseif (isset($data['data_inicio'], $data['data_fim'])) {
            $query->whereBetween('created_at', [$data['data_inicio'], $data['data_fim']]);
        }

        $audits = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('pdfs.audits', compact('audits', 'data'));

        return $pdf->download('auditorias.pdf');
    }

}