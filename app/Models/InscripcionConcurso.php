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
        'pago_inscripcion_id',
        'usuario_id',
        'concurso_id',
        'estado',
        'archivo_cdr',
        'estado_cdr',
        'comentarios_cdr',
        'archivo_pfr',
        'estado_pfr',
        'comentarios_pfr'
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

    public function pagoInscripcion()
    {
        return $this->belongsTo(PagoInscripcion::class, 'pago_inscripcion_id');
    }
}