<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InscripcionConcurso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inscripciones_concursos';

    protected $fillable = [
        'pre_registro_id',
        'pago_paypal_inscripcion_id',
        'usuario_id',
        'concurso_id',
        'estado',
        'archivo_cdr',
        'estado_cdr',
        'comentarios_cdr',
        'archivo_pfr',
        'estado_pfr',
        'comentarios_pfr',
        'codigo_pago_terceros'
    ];

    protected $casts = [
        'estado' => 'string',
        'estado_cdr' => 'string',
        'estado_pfr' => 'string'
    ];

    protected $attributes = [
        'estado' => 'pendiente',
        'estado_cdr' => 'pendiente',
        'estado_pfr' => 'pendiente'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function concurso()
    {
        return $this->belongsTo(Concurso::class);
    }

    public function preRegistro()
    {
        return $this->belongsTo(PreRegistroConcurso::class, 'pre_registro_id');
    }

    /**
     * Obtiene el pago de PayPal de inscripción asociado.
     */
    public function pagoInscripcion()
    {
        return $this->belongsTo(PagoPaypalConcurso::class, 'pago_paypal_inscripcion_id');
    }

    /**
     * Obtiene el pago por tercero asociado a la inscripción.
     */
    public function pagoTercero()
    {
        return $this->belongsTo(PagoTerceroTransferenciaConcurso::class, 'codigo_pago_terceros', 'codigo_validacion_unico');
    }
}