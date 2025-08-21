<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Concurso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'concursos';

    protected $fillable = [
        'titulo',
        'categoria_id',
        'estado'
    ];

    protected $attributes = [
        'estado' => 'pendiente'
    ];

    protected $casts = [
        'estado' => 'string'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }



    public function inscripciones()
    {
        return $this->hasMany(InscripcionConcurso::class);
    }

    public function convocatorias()
    {
        return $this->hasMany(ConvocatoriaConcurso::class);
    }

    public function preRegistros()
    {
        return $this->hasMany(PreRegistroConcurso::class);
    }

    public function pagos()
    {
        return $this->hasManyThrough(PagoConcurso::class, InscripcionConcurso::class);
    }

    /**
     * Obtiene todos los pagos de PayPal relacionados con este concurso
     */
    public function pagosPaypal()
    {
        return $this->hasMany(PagoPaypalConcurso::class);
    }

    /**
     * Obtiene los pagos de pre-registro de PayPal
     */
    public function pagosPreRegistroPaypal()
    {
        return $this->hasMany(PagoPaypalConcurso::class)->preRegistro();
    }

    /**
     * Obtiene los pagos de inscripción de PayPal
     */
    public function pagosInscripcionPaypal()
    {
        return $this->hasMany(PagoPaypalConcurso::class)->inscripcion();
    }
}