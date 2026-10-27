<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('apellido', 100)->nullable()->after('name');
            $table->string('cedula', 20)->nullable()->unique()->after('apellido');
            $table->string('telefono', 20)->nullable()->after('cedula');
            $table->string('direccion', 255)->nullable()->after('telefono');
            $table->string('barrio', 100)->nullable()->after('direccion');
            $table->string('ciudad', 100)->nullable()->after('barrio');
            $table->foreignId('id_rol')->default(2)->after('ciudad')->constrained('roles');
            $table->string('google_id', 255)->nullable()->after('id_rol');
            $table->boolean('activo')->default(true)->after('google_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_rol']);
            $table->dropColumn(['apellido', 'cedula', 'telefono', 'direccion', 'barrio', 'ciudad', 'id_rol', 'google_id', 'activo']);
        });
    }
};
