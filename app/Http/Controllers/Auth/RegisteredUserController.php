<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRegistrationRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page for students.
     */
    public function create(): Response
    {
        return Inertia::render('auth/register', [
            'title' => 'Pendaftaran Mahasiswa',
            'description' => 'Daftar akun untuk mengakses sistem peminjaman alat laboratorium. Khusus untuk mahasiswa UI dengan email @ui.ac.id.'
        ]);
    }

    /**
     * Handle student registration request.
     */
    public function store(StudentRegistrationRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'study_program' => $request->study_program,
            'batch_year' => $request->batch_year,
            'is_verified' => false, // Mahasiswa perlu verifikasi
            'is_active' => true,
            'must_change_password' => false,
        ]);

        event(new Registered($user));

        // Don't auto-login - user needs verification first
        return redirect()->route('login')->with('status', 
            'Akun Anda berhasil dibuat! Silakan tunggu verifikasi dari Admin/Laboran sebelum dapat menggunakan sistem. Anda akan mendapat notifikasi melalui email.'
        );
    }
}