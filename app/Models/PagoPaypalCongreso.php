<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagoPaypalCongreso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pagos_paypal_congresos';

    protected $fillable = [
        'usuario_id',
        'congreso_id',
        'tipo_pago',
        'monto',
        'metodo_pago',
        'referencia_paypal',
        'paypal_order_id',
        'estado_pago',
        'fecha_pago',
        'detalles_transaccion',
        'comprobante_pago',
    ];

    protected $casts = [
        'fecha_pago' => 'datetime',
        'detalles_transaccion' => 'array',
        'monto' => 'decimal:2',
    ];

    // Constantes para tipos de pago
    const TIPO_ARTICULO = 'articulo';
    const TIPO_INSCRIPCION = 'inscripcion';

    // Constantes para estados de pago
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_PAGADO = 'pagado';
    const ESTADO_RECHAZADO = 'rechazado';

    /**
     * Relación con el modelo User
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relación con el modelo Congreso
     */
    public function congreso()
    {
        return $this->belongsTo(Congreso::class, 'congreso_id');
    }

    /**
     * Relación con artículos de congreso
     */
    public function articulosCongreso()
    {
        return $this->hasMany(ArticuloCongreso::class, 'pago_paypal_id');
    }

    /**
     * Relación con inscripciones de congreso
     */
    public function inscripcionesCongreso()
    {
        return $this->hasMany(InscripcionCongreso::class, 'pago_paypal_id');
    }

    /**
     * Scope para filtrar por tipo de pago
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_pago', $tipo);
    }

    /**
     * Scope para filtrar por estado de pago
     */
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado_pago', $estado);
    }

    /**
     * Scope para pagos de artículos
     */
    public function scopeArticulos($query)
    {
        return $query->where('tipo_pago', self::TIPO_ARTICULO);
    }

    /**
     * Scope para pagos de inscripciones
     */
    public function scopeInscripciones($query)
    {
        return $query->where('tipo_pago', self::TIPO_INSCRIPCION);
    }

    /**
     * Scope para pagos pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado_pago', self::ESTADO_PENDIENTE);
    }

    /**
     * Scope para pagos completados
     */
    public function scopePagados($query)
    {
        return $query->where('estado_pago', self::ESTADO_PAGADO);
    }

    /**
     * Scope para pagos rechazados
     */
    public function scopeRechazados($query)
    {
        return $query->where('estado_pago', self::ESTADO_RECHAZADO);
    }

    /**
     * Verificar si el pago está completado
     */
    public function estaPagado()
    {
        return $this->estado_pago === self::ESTADO_PAGADO;
    }

    /**
     * Verificar si el pago está pendiente
     */
    public function estaPendiente()
    {
        return $this->estado_pago === self::ESTADO_PENDIENTE;
    }

    /**
     * Verificar si el pago fue rechazado
     */
    public function estaRechazado()
    {
        return $this->estado_pago === self::ESTADO_RECHAZADO;
    }

    /**
     * Marcar el pago como completado
     */
    public function marcarComoPagado()
    {
        $this->update([
            'estado_pago' => self::ESTADO_PAGADO,
            'fecha_pago' => now(),
        ]);
    }

    /**
     * Marcar el pago como rechazado
     */
    public function marcarComoRechazado()
    {
        $this->update([
            'estado_pago' => self::ESTADO_RECHAZADO,
        ]);
    }

    /**
     * Obtener el nombre del tipo de pago
     */
    public function getNombreTipoPagoAttribute()
    {
        return match($this->tipo_pago) {
            self::TIPO_ARTICULO => 'Artículo',
            self::TIPO_INSCRIPCION => 'Inscripción',
            default => 'Desconocido'
        };
    }

    /**
     * Obtener el nombre del estado de pago
     */
    public function getNombreEstadoPagoAttribute()
    {
        return match($this->estado_pago) {
            self::ESTADO_PENDIENTE => 'Pendiente',
            self::ESTADO_PAGADO => 'Pagado',
            self::ESTADO_RECHAZADO => 'Rechazado',
            default => 'Desconocido'
        };
    }
}