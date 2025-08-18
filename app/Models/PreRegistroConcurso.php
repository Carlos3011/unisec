<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PagoPaypalConcurso;

class PreRegistroConcurso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pre_registro_concursos';

    protected $fillable = [
        'usuario_id',
        'concurso_id',
        'pago_paypal_id',
        'pagos_terceros_transferencia_concurso_id',
        'nombre_equipo',
        'integrantes',
        'asesor',
        'institucion',
        'archivo_pdr',
        'estado_pdr',
        'comentarios_pdr',
        'integrantes_data',
        'codigo_pago_terceros',
        'estado_pago'
    ];

    protected $casts = [
        'integrantes' => 'integer',
        'estado_pdr' => 'string',
        'integrantes_data' => 'array'
    ];
    
    const ESTADO_PDR_PENDIENTE = 'pendiente';
    const ESTADO_PDR_EN_REVISION = 'en revisión';
    const ESTADO_PDR_APROBADO = 'aprobado';
    const ESTADO_PDR_RECHAZADO = 'rechazado';

    /**
     * Obtiene el usuario asociado al pre-registro.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene el pago de PayPal asociado al pre-registro.
     */
    public function pagoPaypal()
    {
        return $this->belongsTo(PagoPaypalConcurso::class, 'pago_paypal_id');
    }

    public function inscripcion()
    {
        return $this->hasOne(InscripcionConcurso::class);
    }

    /**
     * Obtiene el pago de inscripción asociado (PayPal).
     */
    public function pagoInscripcion()
    {
        return $this->hasOne(PagoPaypalConcurso::class, 'pre_registro_id')
                    ->where('tipo_pago', PagoPaypalConcurso::TIPO_INSCRIPCION);
    }

    /**
     * Obtiene el concurso asociado al pre-registro.
     */
    public function concurso()
    {
        return $this->belongsTo(Concurso::class, 'concurso_id');
    }

    /**
     * Obtiene los integrantes del equipo asociados al pre-registro.
     */
    public function integrantes()
    {
        return $this->hasMany(IntegranteEquipoConcurso::class, 'pre_registro_concurso_id');
    }

    /**
     * Obtiene el pago por tercero asociado al pre-registro.
     */
    public function pagoTercero()
    {
        return $this->belongsTo(PagoTerceroTransferenciaConcurso::class, 'codigo_pago_terceros', 'codigo_validacion_unico');
    }

    /**
     * Obtiene el pago por tercero asociado directamente al pre-registro.
     */
    public function pagoTerceroTransferencia()
    {
        return $this->belongsTo(PagoTerceroTransferenciaConcurso::class, 'pagos_terceros_transferencia_concurso_id');
    }
}