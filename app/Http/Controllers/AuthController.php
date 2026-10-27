<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /** Muestra el formulario de registro (HU-01). */
    public function mostrarRegistro(): View
    {
        return view('auth.register');
    }

    /** Procesa el registro de un nuevo cliente (HU-01). */
    public function registrar(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'cedula' => 'required|string|max:20|unique:users,cedula',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'barrio' => 'required|string|max:100',
            'ciudad' => 'required|string|max:100',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.unique' => 'Ya existe una cuenta con esa cédula.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Ya existe una cuenta con ese correo.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'direccion.required' => 'La dirección es obligatoria.',
            'barrio.required' => 'El barrio es obligatorio.',
            'ciudad.required' => 'La ciudad es obligatoria.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'apellido' => $request->apellido,
            'cedula' => $request->cedula,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'barrio' => $request->barrio,
            'ciudad' => $request->ciudad,
            'id_rol' => 2, // Cliente por defecto
            'activo' => true,
        ]);

        Auth::login($user);

        return redirect()->route('catalogo.index')
            ->with('success', '¡Bienvenido a JC URBAN! Tu cuenta ha sido creada exitosamente.');
    }

    /** Muestra el formulario de inicio de sesión (HU-02). */
    public function mostrarLogin(): View
    {
        return view('auth.login');
    }

    /** Procesa el inicio de sesión (HU-02). */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credenciales = $request->only('email', 'password');
        $recordar = $request->boolean('remember');

        if (Auth::attempt($credenciales, $recordar)) {
            $request->session()->regenerate();

            $usuario = Auth::user();

            // Redirige según el rol
            if ($usuario->id_rol === 1) {
                return redirect()->route('admin.dashboard');
            }

            // Redirige a URL guardada antes del login o al catálogo
            $urlIntended = session()->pull('url_intended', route('catalogo.index'));

            return redirect($urlIntended)
                ->with('success', '¡Bienvenido de vuelta, '.$usuario->name.'!');
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Correo o contraseña incorrectos. Por favor verifica tus datos.');
    }

    /** Cierra la sesión del usuario autenticado (HU-04). */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Has cerrado sesión correctamente.');
    }
}
