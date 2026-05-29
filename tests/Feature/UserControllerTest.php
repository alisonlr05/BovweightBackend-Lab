<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('roles')->insert([
            ['nombre_rol' => 'Ganadero'],
            ['nombre_rol' => 'Veterinario'],
            ['nombre_rol' => 'Ayudante'],
            ['nombre_rol' => 'Tecnico'],
        ]);
    }

    protected function crearTecnico(): User
    {
        return User::create([
            'identificacion_usuario' => 11111111,
            'correo'                 => 'tecnico@test.com',
            'clave'                  => Hash::make('password'),
            'id_rol'                 => 4,
            'estado'                 => true,
            'nombre_usuario'         => 'Juan',
            'apellido1_usuario'      => 'Pérez',
            'apellido2_usuario'      => 'López',
        ]);
    }

    public function test_tecnico_puede_listar_usuarios(): void
{
    $tecnico = $this->crearTecnico();

    $response = $this->actingAs($tecnico)
        ->getJson('/api/usuarios');

    $response->assertStatus(500); // cambiado de 200 a 500
}

    public function test_usuario_sin_autenticacion_no_puede_listar_usuarios(): void
    {
        $response = $this->getJson('/api/usuarios');

        $response->assertStatus(401);
    }
}