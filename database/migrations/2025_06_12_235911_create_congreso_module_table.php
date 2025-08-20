<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('congresos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->enum('estado', ['activo', 'inactivo', 'pendiente'])->default('pendiente');  // Estado del concurso, con valor por defecto 'pendiente'.
            $table->timestamps();
            $table->softDeletes();
        });


        // Tabla para almacenar las convocatorias del congreso
        Schema::create('convocatorias_congreso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('congreso_id')
                ->constrained('congresos')
                ->onDelete('cascade');
            $table->text('descripcion');
            $table->string('sede');
            $table->string('dirigido_a')
                ->default('Docentes/Investigadores y Estudiantes');
            $table->text('requisitos');
            $table->json('tematicas');
            $table->text('criterios_evaluacion');
            $table->text('formato_articulo');
            $table->text('formato_extenso')->nullable();
            $table->json('cuotas_inscripcion')->nullable();
            $table->string('contacto_email')->nullable();
            $table->string('archivo_convocatoria')->nullable();
            $table->string('archivo_articulo')->nullable();
            $table->string('imagen_portada')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->enum('estado', ['activo', 'inactivo', 'pendiente'])->default('pendiente');
            $table->timestamps();
            $table->softDeletes();
        });

        // 1. Creación de la tabla unificada 'pagos_paypal_congresos' para registrar pagos de PayPal tanto de artículos como inscripción
        Schema::create('pagos_paypal_congresos', function (Blueprint $table) {
            $table->id();  // Clave primaria.
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');  // Relación con el usuario que realiza el pago
            $table->foreignId('congreso_id')->constrained('congresos')->onDelete('cascade');  // Relación con el congreso
            
            // Campo para identificar el tipo de pago
            $table->enum('tipo_pago', ['articulo', 'inscripcion']);  // Tipo de pago
            
            // Campos específicos de PayPal
            $table->decimal('monto', 10, 2);  // Monto del pago.
            $table->string('metodo_pago')->default('paypal');  // Método de pago, siempre PayPal
            $table->string('referencia_paypal')->nullable();  // Referencia de transacción en PayPal
            $table->string('paypal_order_id')->nullable();  // ID único de la orden en PayPal
            $table->enum('estado_pago', ['pendiente', 'pagado', 'rechazado'])->default('pendiente');  // Estado del pago.
            $table->timestamp('fecha_pago')->nullable();  // Fecha en que se realizó el pago
            $table->text('detalles_transaccion')->nullable();  // Detalles adicionales de la transacción en formato JSON
            $table->string('comprobante_pago')->nullable();  // Archivo o evidencia del pago
            $table->timestamps();  // Registra las fechas de creación y actualización.
            $table->softDeletes();  // Permite el borrado suave de los pagos.
        });
        
        Schema::create('pagos_terceros_transferencia_congreso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');  // Relación con la tabla 'users'
            $table->foreignId('congreso_id')->constrained('congresos')->onDelete('cascade');  // Relación con la tabla 'congresos'
            $table->enum('tipo_tercero', ['universidad', 'empresa', 'persona_fisica'])->default('persona_fisica');
            $table->string('nombre_tercero');
            $table->string('rfc_tercero')->nullable();
            $table->string('contacto_tercero');
            $table->string('correo_tercero');
            $table->string('comprobante_pago')->nullable();
            $table->decimal('monto_total', 10, 2);
            $table->enum('estado_pago', ['pendiente', 'validado', 'rechazado'])->default('pendiente');
            $table->string('referencia_transferencia')->nullable();
            $table->integer('numero_pagos')->unsigned()->default(1);
            $table->boolean('cubre_articulo')->default(false);
            $table->boolean('cubre_inscripcion')->default(false);
            $table->string('codigo_validacion_unico', 100);
            $table->timestamp('fecha_pago')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabla para pagos de inscripción al congreso (mantener compatibilidad)
        Schema::create('pagos_inscripcion_congreso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('congreso_id')->constrained('congresos')->onDelete('cascade');
            $table->decimal('monto', 10, 2);
            $table->string('metodo_pago')->default('paypal');
            $table->string('referencia_paypal')->nullable();
            $table->string('paypal_order_id')->nullable();

            $table->enum('estado_pago', ['pendiente', 'pagado', 'rechazado'])->default('pendiente');
            $table->timestamp('fecha_pago')->nullable();
            $table->text('detalles_transaccion')->nullable();
            $table->string('comprobante_pago')->nullable();
            $table->timestamps();
        });

        // Tabla para eventos del congreso
        Schema::create('eventos_congreso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('congreso_id')->constrained('congresos')->onDelete('cascade');
            $table->string('tipo');
            $table->string('titulo');
            $table->date('fecha');
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabla para asistencias a eventos
        Schema::create('asistencias_eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('evento_id')->constrained('eventos_congreso')->onDelete('cascade');
            $table->enum('estado_asistencia', ['confirmado', 'pendiente', 'cancelado'])->default('pendiente');
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabla para fechas importantes del congreso
        Schema::create('fechas_importantes_congreso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('convocatoria_congreso_id')->constrained('convocatorias_congreso')->onDelete('cascade');
            $table->string('titulo');
            $table->date('fecha');
            $table->text('descripcion')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabla para almacenar los artículos del congreso
        Schema::create('articulos_congreso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('congreso_id')->constrained('congresos')->onDelete('cascade');
            $table->foreignId('convocatoria_congreso_id')->constrained('convocatorias_congreso')->onDelete('cascade');
            $table->foreignId('pago_paypal_id')->nullable()->constrained('pagos_paypal_congresos')->onDelete('cascade');  // Relación con el pago PayPal
            $table->string('titulo');
            $table->json('autores_data'); // Almacena información de los autores;
            $table->string('archivo_articulo')->nullable(); // Archivo del artículo
            $table->string('archivo_extenso')->nullable(); // Documento en extenso
            $table->enum('estado_articulo', ['pendiente', 'en_revision', 'aceptado', 'rechazado'])->default('pendiente');
            $table->enum('estado_extenso', ['pendiente', 'en_revision', 'aceptado', 'rechazado'])->default('pendiente');
            $table->text('comentarios_articulo')->nullable();
            $table->text('comentarios_extenso')->nullable();
            $table->string('codigo_pago_terceros')->nullable()->comment('FK lógico a pagos_terceros_transferencia_congreso');
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabla para inscripciones al congreso
        Schema::create('inscripciones_congreso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('congreso_id')->constrained('congresos')->onDelete('cascade');
            $table->foreignId('articulo_id')->nullable()->constrained('articulos_congreso')->onDelete('cascade');
            $table->foreignId('convocatoria_congreso_id')->constrained('convocatorias_congreso')->onDelete('cascade');
            $table->foreignId('pago_paypal_id')->nullable()->constrained('pagos_paypal_congresos')->onDelete('cascade');  // Relación con el pago PayPal
            $table->enum('tipo_participante', ['estudiante', 'docente', 'investigador', 'profesional'])->default('estudiante');
            $table->string('institucion');
            $table->string('comprobante_estudiante')->nullable(); // Para estudiantes que requieran validar su estatus
            $table->enum('estado_inscripcion', ['pendiente', 'validado', 'rechazado'])->default('pendiente');
            $table->string('codigo_pago_terceros')->nullable()->comment('FK lógico a pagos_terceros_transferencia_congreso');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscripciones_congreso');
        Schema::dropIfExists('articulos_congreso');
        Schema::dropIfExists('fechas_importantes_congreso');
        Schema::dropIfExists('asistencias_eventos');
        Schema::dropIfExists('eventos_congreso');
        Schema::dropIfExists('pagos_inscripcion_congreso');
        Schema::dropIfExists('pagos_terceros_transferencia_congreso');
        Schema::dropIfExists('pagos_paypal_congresos');
        Schema::dropIfExists('convocatorias_congreso');
        Schema::dropIfExists('congresos');
    }
};