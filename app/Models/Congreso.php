<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Congreso extends Model
{
    use SoftDeletes;

    protected $table = 'congresos';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    protected $attributes = [
        'estado' => 'pendiente'
    ];

    protected $dates = ['deleted_at', 'fecha_inicio', 'fecha_fin'];

    // Relación con eventos del congreso
    public function eventos(): HasMany
    {
        return $this->hasMany(EventoCongreso::class, 'congreso_id');
    }

    // Relación con convocatorias
    public function convocatorias(): HasMany
    {
        return $this->hasMany(ConvocatoriaCongreso::class, 'congreso_id');
    }

    // Relación con artículos
    public function articulos(): HasMany
    {
        return $this->hasMany(ArticuloCongreso::class, 'congreso_id');
    }

    // Relación con pagos de inscripción
    public function pagosInscripcion(): HasMany
    {
        return $this->hasMany(PagoInscripcionCongreso::class, 'congreso_id');
    }

    // Relación con pagos PayPal del congreso
    public function pagosPaypal(): HasMany
    {
        return $this->hasMany(PagoPaypalCongreso::class, 'congreso_id');
    }

    // Relación con pagos de terceros del congreso
    public function pagosTerceros(): HasMany
    {
        return $this->hasMany(PagoTerceroTransferenciaCongreso::class, 'congreso_id');
    }

    // Relación con inscripciones del congreso
    public function inscripciones(): HasMany
    {
        return $this->hasMany(InscripcionCongreso::class, 'congreso_id');
    }

    /**
     * Obtener todos los pagos PayPal de artículos para este congreso
     */
    public function pagosPaypalArticulos()
    {
        return $this->pagosPaypal()->where('tipo_pago', PagoPaypalCongreso::TIPO_ARTICULO);
    }

    /**
     * Obtener todos los pagos PayPal de inscripciones para este congreso
     */
    public function pagosPaypalInscripciones()
    {
        return $this->pagosPaypal()->where('tipo_pago', PagoPaypalCongreso::TIPO_INSCRIPCION);
    }
}