<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use function Symfony\Component\Clock\now;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Users/Index', [
            'users' => User::with('roles', 'permissions')->paginate(10)
        ]);
    }  

    public function create()
    {
        return Inertia::render('Admin/Users/FormAdmin', [
            'isEditing' => false,
            'roles' => Role::all(),
            'permissions' => Permission::all(),
            // No enviar 'user' porque estamos creando
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Asignar roles y permisos especiales
        $user->syncRoles($request->roles ?? []);
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        return Inertia::render('Admin/Users/FormAdmin', [ // Cambiar 'Edit' por 'Form'
            'user' => $user->load('roles', 'permissions'),
            'roles' => Role::all(),
            'permissions' => Permission::all(),
            'isEditing' => true
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('name', 'email'));

        // Actualizar roles y permisos
        $user->syncRoles($request->roles ?? []);
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.users.index');
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:6'
        ]);

        $user->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        return redirect()->route('dashboard');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index');
    }

    
    
    public function resetPassword(User $user)
    {
        $capitalizedName = ucfirst(strtolower($user->name));

        $tempPassword = $capitalizedName . now()->format('Ymd') .'@';

        $user->update([
            'password' => Hash::make($tempPassword),
            'must_change_password' => true,
        ]);

        return response()->json([
            'message' => 'Contraseña restablecida correctamente',
            'temporary_password' => $tempPassword,
        ]);
    }

    public function changePasswordForm()
    {
        return inertia('Auth/ForceChangePassword');
    }

    public function updateOwnPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = Auth()->user();

        $user->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Contraseña actualizada correctamente');
    }
}