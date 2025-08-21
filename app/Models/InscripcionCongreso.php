<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InscripcionCongreso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inscripciones_congreso';

    protected $fillable = [
        'usuario_id',
        'congreso_id',
        'articulo_id',
        'convocatoria_congreso_id',
        'pago_paypal_id',
        'tipo_participante',
        'institucion',
        'comprobante_estudiante',
        'pago_inscripcion_id',
        'codigo_pago_terceros'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'tipo_participante' => 'string'
    ];

    // Tipos de participante posibles
    const TIPO_ESTUDIANTE = 'estudiante';
    const TIPO_DOCENTE = 'docente';
    const TIPO_INVESTIGADOR = 'investigador';
    const TIPO_PROFESIONAL = 'profesional';

    // Relación con el usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación con el congreso
    public function congreso()
    {
        return $this->belongsTo(Congreso::class, 'congreso_id');
    }

    // Relación con el artículo
    public function articulo()
    {
        return $this->belongsTo(ArticuloCongreso::class, 'articulo_id');
    }

    // Relación con la convocatoria
    public function convocatoria()
    {
        return $this->belongsTo(ConvocatoriaCongreso::class, 'convocatoria_congreso_id');
    }

    // Relación con el pago de inscripción
    public function pagoInscripcion()
    {
        return $this->belongsTo(PagoInscripcionCongreso::class, 'pago_inscripcion_id');
    }

    // Relación con los pagos del congreso
    public function pagosCongreso()
    {
        return $this->hasMany(PagoInscripcionCongreso::class, 'usuario_id', 'usuario_id')
            ->where('congreso_id', $this->congreso_id);
    }

    // Método para verificar si la inscripción está pagada
    public function estaPagada()
    {
        return $this->pagosCongreso()
            ->where('estado_pago', 'pagado')
            ->exists();
    }

    public function ultimoPago()
    {
        return $this->pagosCongreso()
            ->latest('fecha_pago')
            ->first();
    }

    // Relación con el pago PayPal de la inscripción
    public function pagoPaypal()
    {
        return $this->belongsTo(PagoPaypalCongreso::class, 'pago_paypal_id');
    }

    // Relación con el pago de terceros usando el código
    public function pagoTercero()
    {
        return $this->belongsTo(PagoTerceroTransferenciaCongreso::class, 'codigo_pago_terceros', 'codigo_validacion_unico');
    }

    /**
     * Verificar si la inscripción tiene un pago válido (nuevo método)
     */
    public function tienePagoValido()
    {
        // Verificar pago PayPal
        if ($this->pago_paypal_id && $this->pagoPaypal && $this->pagoPaypal->estado_pago === 'pagado') {
            return true;
        }

        // Verificar pago de terceros
        if ($this->codigo_pago_terceros && $this->pagoTercero && $this->pagoTercero->estado_pago === 'validado') {
            return true;
        }

        // Verificar pago de inscripción legacy
        if ($this->pago_inscripcion_id && $this->pagoInscripcion && $this->pagoInscripcion->estado_pago === 'pagado') {
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
        if ($this->pago_inscripcion_id) {
            return 'inscripcion_legacy';
        }
        return 'sin_pago';
    }

    /**
     * Obtener información detallada del pago
     */
    public function getInfoPagoAttribute()
    {
        if ($this->pago_paypal_id && $this->pagoPaypal) {
            return [
                'tipo' => 'PayPal',
                'monto' => $this->pagoPaypal->monto,
                'referencia' => $this->pagoPaypal->referencia_paypal,
                'fecha' => $this->pagoPaypal->fecha_pago,
                'estado' => $this->pagoPaypal->estado_pago
            ];
        }

        if ($this->codigo_pago_terceros && $this->pagoTercero) {
            return [
                'tipo' => 'Pago de Terceros',
                'monto' => $this->pagoTercero->monto_total,
                'referencia' => $this->pagoTercero->referencia_transferencia,
                'fecha' => $this->pagoTercero->fecha_pago,
                'estado' => $this->pagoTercero->estado_pago,
                'codigo' => $this->codigo_pago_terceros
            ];
        }

        if ($this->pago_inscripcion_id && $this->pagoInscripcion) {
            return [
                'tipo' => 'Inscripción Legacy',
                'monto' => $this->pagoInscripcion->monto,
                'referencia' => $this->pagoInscripcion->referencia_pago,
                'fecha' => $this->pagoInscripcion->fecha_pago,
                'estado' => $this->pagoInscripcion->estado_pago
            ];
        }

        return null;
    }
}