<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Creación de la tabla 'concursos' para almacenar información sobre los concursos.
        Schema::create('concursos', function (Blueprint $table) {
            $table->id();  // Creación de la columna 'id' como clave primaria.
            $table->string('titulo');  // Título del concurso.
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');  // Relación con la tabla 'categorias', eliminando concursos si se elimina la categoría.
            $table->enum('estado', ['activo', 'inactivo', 'pendiente'])->default('pendiente');  // Estado del concurso, con valor por defecto 'pendiente'.
            $table->timestamps();  // Registra las fechas de creación y actualización.
            $table->softDeletes();  // Permite el borrado suave (no físico) de registros.
        });

        // Creación de la tabla 'convocatorias_concursos' para almacenar convocatorias relacionadas a concursos.
        Schema::create('convocatorias_concursos', function (Blueprint $table) {
            $table->id();  // Clave primaria.
            $table->foreignId('concurso_id')->constrained('concursos')->onDelete('cascade');  // Relación con la tabla 'concursos', eliminando convocatorias si se elimina el concurso.
            $table->string('sede');  // Ubicación de la convocatoria.
            $table->string('dirigido_a')->default('Estudiantes de nivel licenciatura');  // Público al que está dirigida la convocatoria.
            $table->integer('max_integrantes')->default(5);  // Número máximo de integrantes por equipo.
            $table->boolean('asesor_requerido')->default(true);  // Indica si se requiere asesor para el equipo.
            $table->text('requisitos');  // Requisitos para participar en la convocatoria.
            $table->text('etapas_mision');  // Descripción de las etapas o misión del concurso.
            $table->text('pruebas_requeridas');  // Pruebas necesarias para participar.
            $table->string('documentacion_requerida')->default('PDR, CDR, PFR');  // Documentos requeridos (PDR, CDR, PFR).
            $table->text('criterios_evaluacion');  // Criterios que se utilizarán para evaluar a los participantes.
            $table->text('premiacion')->nullable();  // Información sobre los premios del concurso (opcional).
            $table->text('penalizaciones')->nullable();  // Penalizaciones por incumplimiento de reglas (opcional).
            $table->string('contacto_email')->nullable();  // Correo electrónico de contacto.
            $table->string('archivo_convocatoria')->nullable();  // PDF con la convocatoria general.
            $table->string('imagen_portada')->nullable();  // Imagen que representa la convocatoria.
            $table->string('archivo_pdr')->nullable();  // Archivo con el PDR.
            $table->string('archivo_cdr')->nullable();  // Archivo con el CDR.
            $table->string('archivo_pfr')->nullable();  // Archivo con el PFR.
            $table->string('archivo_articulo')->nullable();  // Archivo con los artículos requeridos.
            
            // Costos de participación
            $table->decimal('costo_pre_registro', 10, 2)->nullable();  // Costo del pre-registro, si aplica
            $table->decimal('costo_inscripcion', 10, 2)->nullable();  // Costo de la inscripción completa
            
            $table->timestamps();  // Registra las fechas de creación y actualización.
            $table->softDeletes();  // Permite el borrado suave de las convocatorias.
        });

        // Creación de la tabla 'fechas_importantes_concursos' para registrar fechas clave de las convocatorias.
        Schema::create('fechas_importantes_concursos', function (Blueprint $table) {
            $table->id();  // Clave primaria.
            $table->foreignId('convocatorias_concursos_id')->constrained('convocatorias_concursos')->onDelete('cascade');  // Relación con la tabla 'convocatorias_concursos', eliminando fechas si se elimina la convocatoria.
            $table->string('titulo');  // Título o nombre de la fecha importante.
            $table->date('fecha');  // Fecha importante.
            $table->timestamps();  // Registra las fechas de creación y actualización.
            $table->softDeletes();  // Permite el borrado suave de las fechas importantes.
        });

        // Creación de la tabla 'imagenes_concursos' para almacenar imágenes relacionadas con las convocatorias.
        Schema::create('imagenes_concursos', function (Blueprint $table) {
            $table->id();  // Clave primaria.
            $table->foreignId('convocatorias_concursos_id')->constrained('convocatorias_concursos')->onDelete('cascade');  // Relación con la tabla 'convocatorias_concursos', eliminando imágenes si se elimina la convocatoria.
            $table->string('imagen');  // URL o nombre de la imagen.
            $table->string('descripcion')->nullable();  // Descripción opcional de la imagen.
            $table->timestamps();  // Registra las fechas de creación y actualización.
            $table->softDeletes();  // Permite el borrado suave de las imágenes.
        });
        
        // 1. Creación de la tabla 'pagos_pre_registro' para registrar los pagos realizados antes del pre-registro
        Schema::create('pagos_pre_registro', function (Blueprint $table) {
            $table->id();  // Clave primaria.
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');  // Relación con el usuario que realiza el pago
            $table->foreignId('concurso_id')->constrained('concursos')->onDelete('cascade');  // Relación con el concurso
            $table->decimal('monto', 10, 2);  // Monto del pago.
            $table->string('metodo_pago')->default('paypal');  // Método de pago, por defecto PayPal
            $table->string('referencia_paypal')->nullable();  // Referencia de transacción en PayPal
            $table->string('paypal_order_id')->nullable();  // ID único de la orden en PayPal
            $table->enum('estado_pago', ['pendiente', 'pagado', 'rechazado'])->default('pendiente');  // Estado del pago.
            $table->timestamp('fecha_pago')->nullable();  // Fecha en que se realizó el pago
            $table->text('detalles_transaccion')->nullable();  // Detalles adicionales de la transacción en formato JSON
            $table->string('comprobante_pago')->nullable();  // Archivo o evidencia del pago
            $table->timestamps();  // Registra las fechas de creación y actualización.
        });

        // 2. Creación de la tabla 'pre_registro_concursos' para almacenar los pre-registros después del pago inicial
        Schema::create('pre_registro_concursos', function (Blueprint $table) {
            $table->id();  // Clave primaria.
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');  // Relación con la tabla 'users'
            $table->foreignId('concurso_id')->constrained('concursos')->onDelete('cascade');  // Relación con la tabla 'concursos'
            $table->foreignId('pago_pre_registro_id')->constrained('pagos_pre_registro')->onDelete('cascade');  // Relación con el pago previo
            $table->string('nombre_equipo');  // Nombre del equipo.
            $table->integer('integrantes')->unsigned()->default(1);  // Número de integrantes en el equipo.
            $table->string('asesor')->nullable();  // Asesor del equipo (opcional).
            $table->string('institucion')->nullable();  // Institución a la que pertenece el equipo (opcional).
            
            // Campos para PDR
            $table->string('archivo_pdr')->nullable();  // Archivo PDR
            $table->enum('estado_pdr', ['pendiente', 'en revisión', 'aprobado', 'rechazado'])->default('pendiente');  // Estado de evaluación del PDR
            $table->text('comentarios_pdr')->nullable();  // Comentarios sobre el PDR
            
            // Campo JSON para almacenar los datos de los integrantes
            $table->json('integrantes_data')->nullable();  // Almacena los datos de los integrantes en formato JSON
            
            $table->timestamps();  // Registra las fechas de creación y actualización.
            $table->softDeletes();  // Permite el borrado suave de los pre-registros.
        });
        
        // 3. Creación de la tabla 'pagos_inscripcion' para registrar los pagos de inscripción después del pre-registro
        Schema::create('pagos_inscripcion', function (Blueprint $table) {
            $table->id();  // Clave primaria.
            $table->foreignId('pre_registro_id')->constrained('pre_registro_concursos')->onDelete('cascade');  // Relación con el pre-registro
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');  // Relación con el usuario
            $table->foreignId('concurso_id')->constrained('concursos')->onDelete('cascade');  // Relación con el concurso
            $table->decimal('monto', 10, 2);  // Monto del pago.
            $table->string('metodo_pago')->default('paypal');  // Método de pago, por defecto PayPal
            $table->string('referencia_paypal')->nullable();  // Referencia de transacción en PayPal
            $table->string('paypal_order_id')->nullable();  // ID único de la orden en PayPal
            $table->enum('estado_pago', ['pendiente', 'pagado', 'rechazado'])->default('pendiente');  // Estado del pago.
            $table->timestamp('fecha_pago')->nullable();  // Fecha en que se realizó el pago
            $table->text('detalles_transaccion')->nullable();  // Detalles adicionales de la transacción en formato JSON
            $table->string('comprobante_pago')->nullable();  // Archivo o evidencia del pago
            $table->timestamps();  // Registra las fechas de creación y actualización.
        });

        // 4. Creación de la tabla 'inscripciones_concursos' para registrar las inscripciones después del pago de inscripción
        Schema::create('inscripciones_concursos', function (Blueprint $table) {
            $table->id();  // Clave primaria.
            $table->foreignId('pre_registro_id')->constrained('pre_registro_concursos')->onDelete('cascade');  // Relación con el pre-registro
            $table->foreignId('pago_inscripcion_id')->constrained('pagos_inscripcion')->onDelete('cascade');  // Relación con el pago de inscripción
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');  // Relación con la tabla 'users'
            $table->foreignId('concurso_id')->constrained('concursos')->onDelete('cascade');  // Relación con la tabla 'concursos'
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada'])->default('pendiente');  // Estado de la inscripción.
            
            // Campos para documentos adicionales
            $table->string('archivo_cdr')->nullable();  // Archivo CDR 
            $table->enum('estado_cdr', ['pendiente', 'en revisión', 'aprobado', 'rechazado'])->default('pendiente');
            $table->text('comentarios_cdr')->nullable();
            
            $table->string('archivo_pfr')->nullable();  // Archivo PFR
            $table->enum('estado_pfr', ['pendiente', 'en revisión', 'aprobado', 'rechazado'])->default('pendiente');
            $table->text('comentarios_pfr')->nullable();
            
            $table->timestamps();  // Registra las fechas de creación y actualización.
            $table->softDeletes();  // Permite el borrado suave de las inscripciones.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminación de las tablas creadas en orden inverso para respetar las restricciones de clave foránea
        Schema::dropIfExists('inscripciones_concursos');
        Schema::dropIfExists('pagos_inscripcion');
        Schema::dropIfExists('pre_registro_concursos');
        Schema::dropIfExists('pagos_pre_registro');
        Schema::dropIfExists('imagenes_concursos');
        Schema::dropIfExists('fechas_importantes_concursos');
        Schema::dropIfExists('convocatorias_concursos');
        Schema::dropIfExists('concursos');
    }
};