<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PagoTerceroTransferenciaCongreso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pagos_terceros_transferencia_congreso';

    protected $fillable = [
        'usuario_id',
        'congreso_id',
        'tipo_tercero',
        'nombre_tercero',
        'rfc_tercero',
        'contacto_tercero',
        'correo_tercero',
        'comprobante_pago',
        'monto_total',
        'estado_pago',
        'referencia_transferencia',
        'numero_pagos',
        'cubre_articulo',
        'cubre_inscripcion',
        'codigo_validacion_unico',
        'fecha_pago',
    ];

    protected $casts = [
        'fecha_pago' => 'datetime',
        'monto_total' => 'decimal:2',
        'numero_pagos' => 'integer',
        'cubre_articulo' => 'boolean',
        'cubre_inscripcion' => 'boolean',
    ];

    // Constantes para tipos de tercero
    const TIPO_UNIVERSIDAD = 'universidad';
    const TIPO_EMPRESA = 'empresa';
    const TIPO_PERSONA_FISICA = 'persona_fisica';

    // Constantes para estados de pago
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_VALIDADO = 'validado';
    const ESTADO_RECHAZADO = 'rechazado';

    /**
     * Boot del modelo para generar código único
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->codigo_validacion_unico)) {
                $model->codigo_validacion_unico = self::generarCodigoUnico();
            }
        });
    }

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
     * Relación con artículos de congreso que usan este código de pago
     */
    public function articulosCongreso()
    {
        return $this->hasMany(ArticuloCongreso::class, 'codigo_pago_terceros', 'codigo_validacion_unico');
    }

    /**
     * Relación con inscripciones de congreso que usan este código de pago
     */
    public function inscripcionesCongreso()
    {
        return $this->hasMany(InscripcionCongreso::class, 'codigo_pago_terceros', 'codigo_validacion_unico');
    }

    /**
     * Scope para filtrar por tipo de tercero
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_tercero', $tipo);
    }

    /**
     * Scope para filtrar por estado de pago
     */
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado_pago', $estado);
    }

    /**
     * Scope para pagos pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado_pago', self::ESTADO_PENDIENTE);
    }

    /**
     * Scope para pagos validados
     */
    public function scopeValidados($query)
    {
        return $query->where('estado_pago', self::ESTADO_VALIDADO);
    }

    /**
     * Scope para pagos rechazados
     */
    public function scopeRechazados($query)
    {
        return $query->where('estado_pago', self::ESTADO_RECHAZADO);
    }

    /**
     * Scope para pagos que cubren artículos
     */
    public function scopeQueCobreArticulo($query)
    {
        return $query->where('cubre_articulo', true);
    }

    /**
     * Scope para pagos que cubren inscripciones
     */
    public function scopeQueCobreInscripcion($query)
    {
        return $query->where('cubre_inscripcion', true);
    }

    /**
     * Verificar si el pago está validado
     */
    public function estaValidado()
    {
        return $this->estado_pago === self::ESTADO_VALIDADO;
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
     * Marcar el pago como validado
     */
    public function marcarComoValidado()
    {
        $this->update([
            'estado_pago' => self::ESTADO_VALIDADO,
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
     * Verificar si el código puede ser usado para un artículo
     */
    public function puedeUsarseParaArticulo()
    {
        return $this->estaValidado() && $this->cubre_articulo && $this->numero_pagos > 0;
    }

    /**
     * Verificar si el código puede ser usado para una inscripción
     */
    public function puedeUsarseParaInscripcion()
    {
        return $this->estaValidado() && $this->cubre_inscripcion && $this->numero_pagos > 0;
    }

    /**
     * Usar el código de pago (decrementar número de pagos)
     */
    public function usarCodigo()
    {
        if ($this->numero_pagos > 0) {
            $this->decrement('numero_pagos');
            return true;
        }
        return false;
    }

    /**
     * Obtener el nombre del tipo de tercero
     */
    public function getNombreTipoTerceroAttribute()
    {
        return match($this->tipo_tercero) {
            self::TIPO_UNIVERSIDAD => 'Universidad',
            self::TIPO_EMPRESA => 'Empresa',
            self::TIPO_PERSONA_FISICA => 'Persona Física',
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
            self::ESTADO_VALIDADO => 'Validado',
            self::ESTADO_RECHAZADO => 'Rechazado',
            default => 'Desconocido'
        };
    }

    /**
     * Generar un código único para el pago
     */
    public static function generarCodigoUnico()
    {
        do {
            $codigo = 'CONG-' . strtoupper(Str::random(8));
        } while (self::where('codigo_validacion_unico', $codigo)->exists());

        return $codigo;
    }

    /**
     * Buscar por código de validación
     */
    public static function buscarPorCodigo($codigo)
    {
        return self::where('codigo_validacion_unico', $codigo)->first();
    }

    /**
     * Verificar si el código está disponible para uso
     */
    public function codigoDisponible()
    {
        return $this->estaValidado() && $this->numero_pagos > 0;
    }

    /**
     * Obtener información de cobertura
     */
    public function getInfoCoberturaAttribute()
    {
        $cobertura = [];
        if ($this->cubre_articulo) {
            $cobertura[] = 'Artículo';
        }
        if ($this->cubre_inscripcion) {
            $cobertura[] = 'Inscripción';
        }
        return implode(', ', $cobertura) ?: 'Ninguna';
    }
}