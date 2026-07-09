<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WaliSiswa;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class WaliSiswaController extends Controller
{
    public function index()
    {
        $walis = WaliSiswa::with(['user', 'siswa.user'])->paginate(10);
        return view('admin.wali-siswa.index', compact('walis'));
    }

    public function create()
    {
        $siswas = Siswa::with('user')->get();
        return view('admin.wali-siswa.create', compact('siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'siswa_id' => 'required|exists:siswa,id',
            'hubungan' => 'required|string|max:100',
            'no_hp' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'wali_siswa',
            ]);

            WaliSiswa::create([
                'user_id' => $user->id,
                'siswa_id' => $request->siswa_id,
                'hubungan' => $request->hubungan,
                'no_hp' => $request->no_hp,
            ]);
        });

        return redirect()->route('admin.wali-siswa.index')->with('success', 'Data Wali Siswa berhasil ditambahkan.');
    }

    public function edit(WaliSiswa $waliSiswa)
    {
        $siswas = Siswa::with('user')->get();
        return view('admin.wali-siswa.edit', compact('waliSiswa', 'siswas'));
    }

    public function update(Request $request, WaliSiswa $waliSiswa)
    {
        $user = $waliSiswa->user;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'siswa_id' => 'required|exists:siswa,id',
            'hubungan' => 'required|string|max:100',
            'no_hp' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $waliSiswa, $user) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            $waliSiswa->update([
                'siswa_id' => $request->siswa_id,
                'hubungan' => $request->hubungan,
                'no_hp' => $request->no_hp,
            ]);
        });

        return redirect()->route('admin.wali-siswa.index')->with('success', 'Data Wali Siswa berhasil diubah.');
    }

    public function destroy(WaliSiswa $waliSiswa)
    {
        DB::transaction(function () use ($waliSiswa) {
            $user = $waliSiswa->user;
            $waliSiswa->delete();
            $user->delete();
        });

        return redirect()->route('admin.wali-siswa.index')->with('success', 'Data Wali Siswa berhasil dihapus.');
    }

    public function monitoring(WaliSiswa $waliSiswa)
    {
        $siswa = $waliSiswa->siswa;
        if (!$siswa) {
            return back()->with('error', 'Siswa tidak ditemukan untuk wali ini.');
        }
        return redirect()->route('wali.siswa', $siswa->id);
    }
}
