<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagoPaypalConcurso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pagos_paypal_concursos';

    protected $fillable = [
        'usuario_id',
        'concurso_id',
        'pre_registro_id',
        'tipo_pago',
        'monto',
        'metodo_pago',
        'referencia_paypal',
        'paypal_order_id',
        'estado_pago',
        'fecha_pago',
        'detalles_transaccion',
        'comprobante_pago'
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_pago' => 'datetime',
        'detalles_transaccion' => 'json'
    ];

    protected $attributes = [
        'metodo_pago' => 'paypal',
        'estado_pago' => 'pendiente'
    ];

    // Constantes para tipos de pago
    const TIPO_PRE_REGISTRO = 'pre_registro';
    const TIPO_INSCRIPCION = 'inscripcion';

    // Constantes para estados de pago
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_PAGADO = 'pagado';
    const ESTADO_RECHAZADO = 'rechazado';

    /**
     * Relación con el usuario que realizó el pago
     */
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el concurso
     */
    public function concurso()
    {
        return $this->belongsTo(Concurso::class);
    }

    /**
     * Relación con el pre-registro (opcional, solo para pagos de inscripción)
     */
    public function preRegistro()
    {
        return $this->belongsTo(PreRegistroConcurso::class, 'pre_registro_id');
    }

    /**
     * Scope para filtrar pagos de pre-registro
     */
    public function scopePreRegistro($query)
    {
        return $query->where('tipo_pago', self::TIPO_PRE_REGISTRO);
    }

    /**
     * Scope para filtrar pagos de inscripción
     */
    public function scopeInscripcion($query)
    {
        return $query->where('tipo_pago', self::TIPO_INSCRIPCION);
    }

    /**
     * Scope para filtrar pagos pagados
     */
    public function scopePagados($query)
    {
        return $query->where('estado_pago', self::ESTADO_PAGADO);
    }

    /**
     * Scope para filtrar pagos pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado_pago', self::ESTADO_PENDIENTE);
    }

    /**
     * Verifica si el pago es de pre-registro
     */
    public function esPreRegistro()
    {
        return $this->tipo_pago === self::TIPO_PRE_REGISTRO;
    }

    /**
     * Verifica si el pago es de inscripción
     */
    public function esInscripcion()
    {
        return $this->tipo_pago === self::TIPO_INSCRIPCION;
    }

    /**
     * Verifica si el pago está completado
     */
    public function estaPagado()
    {
        return $this->estado_pago === self::ESTADO_PAGADO;
    }
}