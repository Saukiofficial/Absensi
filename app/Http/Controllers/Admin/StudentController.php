<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = User::student()->latest()->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Tambah Siswa';
        // Memulai query dengan User::query() untuk menghindari ambiguitas
        $guardians = User::query()->guardian()->orderBy('name')->get();
        return view('admin.students.form', compact('pageTitle', 'guardians'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nis' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'class' => ['required', 'string', 'max:255'],
            'card_uid' => ['nullable', 'string', 'max:255', 'unique:'.User::class],
            'fingerprint_id' => ['nullable', 'string', 'max:255', 'unique:'.User::class],
            'guardian_id' => ['required', 'exists:users,id'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
            'nis' => $request->nis,
            'class' => $request->class,
            'card_uid' => $request->card_uid,
            'fingerprint_id' => $request->fingerprint_id,
            'guardian_id' => $request->guardian_id,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $student)
    {
        $pageTitle = 'Edit Siswa: ' . $student->name;
        // Memperbaiki query untuk form edit juga
        $guardians = User::query()->guardian()->orderBy('name')->get();
        return view('admin.students.form', compact('pageTitle', 'student', 'guardians'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $student)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email,'.$student->id],
            'nis' => ['required', 'string', 'max:255', 'unique:'.User::class.',nis,'.$student->id],
            'class' => ['required', 'string', 'max:255'],
            'card_uid' => ['nullable', 'string', 'max:255', 'unique:'.User::class.',card_uid,'.$student->id],
            'fingerprint_id' => ['nullable', 'string', 'max:255', 'unique:'.User::class.',fingerprint_id,'.$student->id],
            'guardian_id' => ['required', 'exists:users,id'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'nis' => $request->nis,
            'class' => $request->class,
            'card_uid' => $request->card_uid,
            'fingerprint_id' => $request->fingerprint_id,
            'guardian_id' => $request->guardian_id,
        ]);

        if ($request->filled('password')) {
            $student->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}

