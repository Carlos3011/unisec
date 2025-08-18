<?php

namespace App\Http\Controllers;

use App\Models\PagoPaypalConcurso;
use App\Models\PagoInscripcionCongreso;
use App\Models\User;
use App\Models\InscripcionCongreso;
use App\Models\PreRegistroConcurso;
use App\Models\InscripcionConcurso;
use App\Models\Congreso;
use App\Models\Concurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Estadísticas de usuarios
        $totalUsuarios = User::count();
        $usuariosPorMes = User::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as mes'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();

        // Estadísticas de pagos
        $pagosPreRegistro = PagoPaypalConcurso::select(
            DB::raw('DATE(fecha_pago) as fecha'),
            DB::raw('SUM(monto) as total')
        )
        ->where('estado_pago', 'pagado')
        ->where('tipo_pago', PagoPaypalConcurso::TIPO_PRE_REGISTRO)
        ->groupBy('fecha')
        ->orderBy('fecha')
        ->get();

        $pagosInscripcion = PagoInscripcionCongreso::select(
            DB::raw('DATE(fecha_pago) as fecha'),
            DB::raw('SUM(monto) as total')
        )
        ->where('estado_pago', 'pagado')
        ->groupBy('fecha')
        ->orderBy('fecha')
        ->get();

        // Estadísticas de congresos y concursos
        $totalCongresos = Congreso::count();
        $totalConcursos = Concurso::count();

        // Estadísticas de participación por tipo en congresos
        $participantesCongreso = InscripcionCongreso::select('tipo_participante', DB::raw('COUNT(*) as total'))
            ->groupBy('tipo_participante')
            ->get();

        // Preparar datos para las gráficas
        $datosGraficas = [
            'usuarios' => [
                'total' => $totalUsuarios,
                'porMes' => [
                    'meses' => $usuariosPorMes->pluck('mes')->toArray(),
                    'totales' => $usuariosPorMes->pluck('total')->toArray()
                ]
            ],
            'pagos' => [
                'preRegistro' => [
                    'fechas' => $pagosPreRegistro->pluck('fecha')->toArray(),
                    'montos' => $pagosPreRegistro->pluck('total')->toArray(),
                    'total' => $pagosPreRegistro->sum('total')
                ],
                'inscripcion' => [
                    'fechas' => $pagosInscripcion->pluck('fecha')->toArray(),
                    'montos' => $pagosInscripcion->pluck('total')->toArray(),
                    'total' => $pagosInscripcion->sum('total')
                ]
            ],
            'eventos' => [
                'totalCongresos' => $totalCongresos,
                'totalConcursos' => $totalConcursos
            ],
            'participantes' => [
                'tipos' => $participantesCongreso->pluck('tipo_participante')->toArray(),
                'totales' => $participantesCongreso->pluck('total')->toArray()
            ]
        ];

        return view('admin.dashboard', compact('datosGraficas'));
    }

    public function usuarios()
    {
        return view('admin.usuarios');
    }


    public function cursos()
    {
        return view('admin.cursos');
    }

    public function talleres()
    {
        return view('admin.talleres');
    }

    public function ponencias()
    {
        return view('admin.ponencias');
    }

    public function concursos()
    {
        return view('admin.concursos');
    }

    public function ponentes()
    {
        return view('admin.ponentes');
    }

    public function congresosEventos()
    {
        return view('admin.congresos-eventos');
    }

    public function becas()
    {
        return view('admin.becas');
    }

    public function pagosFacturacion()
    {
        return view('admin.pagos-facturacion');
    }

    public function reportesEstadisticas()
    {
        return view('admin.reportes-estadisticas');
    }
}


