<?php

namespace App\Http\Controllers;

use App\Services\AuditService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuditController extends Controller
{
    protected AuditService $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function index()
    {
        try {
            $audits = $this->auditService->getAllAudits();
            return view('audits.index', compact('audits'));
        } catch (Exception $e) {
            Log::error('Erro ao carregar auditorias: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Não foi possível carregar as auditorias.');
        }
    }

    public function pdf(Request $request)
    {
        try {
            $filtros = [
                'data_inicio' => $request->input('data_inicio'),
                'data_fim'    => $request->input('data_fim'),
                'mes'         => $request->input('mes'),
            ];

            return $this->auditService->pdfAudits($filtros);
        } catch (Exception $e) {
            Log::error('Erro ao gerar PDF de auditorias: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Não foi possível gerar o PDF.');
        }
    }
}
