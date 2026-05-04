<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'identificacion_usuario' => 'required|integer|unique:users,identificacion_usuario',
            'correo'                 => 'required|email|unique:users,correo',
            'clave'                  => 'required|string|min:8',
            'id_rol'                 => 'required|integer|exists:roles,id_rol',
            'nombre_usuario'         => 'required|string|max:100',
            'apellido1_usuario'      => 'required|string|max:100',
            'apellido2_usuario'      => 'nullable|string|max:100',
        ]);

        $user = User::create([
            'identificacion_usuario' => $request->identificacion_usuario,
            'correo'                 => $request->correo,
            'clave'                  => Hash::make($request->clave),
            'id_rol'                 => $request->id_rol,
            'estado'                 => true,
            'nombre_usuario'         => $request->nombre_usuario,
            'apellido1_usuario'      => $request->apellido1_usuario,
            'apellido2_usuario'      => $request->apellido2_usuario,
        ]);

        return response()->json([
            'message' => 'Usuario creado correctamente.',
            'usuario' => $user,
        ], 201);
    }
}