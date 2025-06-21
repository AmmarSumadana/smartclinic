<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:Pasien,Pegawai Rumah Sakit'], // Validasi pilihan dari form
        ]);

        // Tentukan peran sebenarnya berdasarkan pilihan dari form
        $assignedRole = '';
        if ($request->role === 'Pasien') {
            $assignedRole = 'pasien'; // Peran internal 'pasien'
        } elseif ($request->role === 'Pegawai Rumah Sakit') {
            $assignedRole = 'staff'; // Defaultkan 'Pegawai Rumah Sakit' ke peran internal 'staff'
            // Jika Anda ingin membedakan antara staff dan doctor dari registrasi,
            // ini adalah tempat di mana logika tambahan akan ditambahkan.
            // Misalnya, bisa ada field tersembunyi atau logika berdasarkan email, dsb.
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $assignedRole, // Gunakan peran yang sudah ditentukan
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect berdasarkan peran pengguna (sama seperti AuthenticatedSessionController)
        if ($user->isPatient()) {
            return redirect()->intended(route('dashboard', absolute: false));
        } elseif ($user->isStaff() || $user->isDoctor()) {
            return redirect()->intended(route('dashboard.pegawai', absolute: false));
        }

        // Fallback default
        return redirect()->intended(route('dashboard', absolute: false));
    }
}
