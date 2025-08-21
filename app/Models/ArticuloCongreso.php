<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticuloCongreso extends Model
{
    use SoftDeletes;

    protected $table = 'articulos_congreso';

    protected $fillable = [
        'usuario_id',
        'congreso_id',
        'convocatoria_congreso_id',
        'pago_paypal_id',
        'titulo',
        'autores_data',
        'archivo_articulo',
        'archivo_extenso',
        'estado_articulo',
        'estado_extenso',
        'comentarios_articulo',
        'comentarios_extenso',
        'codigo_pago_terceros'
    ];

    protected $casts = [
        'autores_data' => 'array'
    ];

    // Estados posibles para artículos y extensos
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_EN_REVISION = 'en_revision';
    const ESTADO_ACEPTADO = 'aceptado';
    const ESTADO_RECHAZADO = 'rechazado';

    // Relación con el usuario
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación con el congreso
    public function congreso(): BelongsTo
    {
        return $this->belongsTo(Congreso::class, 'congreso_id');
    }

    // Relación con la convocatoria
    public function convocatoria(): BelongsTo
    {
        return $this->belongsTo(ConvocatoriaCongreso::class, 'convocatoria_congreso_id');
    }

    // Relación con pagos de inscripción
    public function pagosInscripcion(): HasMany
    {
        return $this->hasMany(PagoInscripcionCongreso::class, 'articulo_id');
    }

    // Relación con el pago PayPal del artículo
    public function pagoPaypal(): BelongsTo
    {
        return $this->belongsTo(PagoPaypalCongreso::class, 'pago_paypal_id');
    }

    // Relación con el pago de terceros usando el código
    public function pagoTerceros()
    {
        return $this->belongsTo(PagoTerceroTransferenciaCongreso::class, 'codigo_pago_terceros', 'codigo_validacion_unico');
    }

    /**
     * Verificar si el artículo tiene un pago válido
     */
    public function tienePagoValido()
    {
        // Verificar pago PayPal
        if ($this->pago_paypal_id && $this->pagoPaypal && $this->pagoPaypal->estaPagado()) {
            return true;
        }

        // Verificar pago de terceros
        if ($this->codigo_pago_terceros && $this->pagoTerceros && $this->pagoTerceros->estaValidado()) {
            return true;
        }

        return false;
    }

    /**
     * Obtener el tipo de pago utilizado
     */
    public function getTipoPagoAttribute()
    {
        if ($this->pago_paypal_id) {
            return 'paypal';
        }
        if ($this->codigo_pago_terceros) {
            return 'terceros';
        }
        return 'sin_pago';
    }

    /**
     * Obtener información del pago
     */
    public function getInfoPagoAttribute()
    {
        if ($this->pago_paypal_id && $this->pagoPaypal) {
            return [
                'tipo' => 'PayPal',
                'monto' => $this->pagoPaypal->monto,
                'estado' => $this->pagoPaypal->nombre_estado_pago,
                'fecha' => $this->pagoPaypal->fecha_pago
            ];
        }

        if ($this->codigo_pago_terceros && $this->pagoTerceros) {
            return [
                'tipo' => 'Terceros',
                'monto' => $this->pagoTerceros->monto_total,
                'estado' => $this->pagoTerceros->nombre_estado_pago,
                'codigo' => $this->pagoTerceros->codigo_validacion_unico
            ];
        }

        return null;
    }
}