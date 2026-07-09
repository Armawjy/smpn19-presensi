<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with(['user', 'kelas']);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nis', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($qu) use ($search) {
                      $qu->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $siswas = $query->paginate(10);
        $kelas = Kelas::where('status', 'aktif')->get();

        return view('admin.siswa.index', compact('siswas', 'kelas'));
    }

    public function create()
    {
        $kelas = Kelas::where('status', 'aktif')->get();
        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'nis' => 'required|string|unique:siswa',
            'kelas_id' => 'required|exists:kelas,id',
            'no_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
            'agama' => 'nullable|string',
            'jenis_kelamin' => 'required|in:L,P',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::transaction(function () use ($request) {
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('foto_profile', 'public');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'siswa',
                'foto' => $fotoPath,
            ]);

            $qrCodeText = 'SMPN19-' . $request->nis;

            Siswa::create([
                'user_id' => $user->id,
                'nis' => $request->nis,
                'kelas_id' => $request->kelas_id,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'agama' => $request->agama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'qr_code' => $qrCodeText,
            ]);
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data Siswa berhasil ditambahkan.');
    }

    public function show(Siswa $siswa)
    {
        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::where('status', 'aktif')->get();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $user = $siswa->user;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'nis' => 'required|string|unique:siswa,nis,' . $siswa->id,
            'kelas_id' => 'required|exists:kelas,id',
            'no_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
            'agama' => 'nullable|string',
            'jenis_kelamin' => 'required|in:L,P',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::transaction(function () use ($request, $siswa, $user) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            if ($request->hasFile('foto')) {
                if ($user->foto) {
                    Storage::disk('public')->delete($user->foto);
                }
                $userData['foto'] = $request->file('foto')->store('foto_profile', 'public');
            }

            $user->update($userData);

            $qrCodeText = 'SMPN19-' . $request->nis;

            $siswa->update([
                'nis' => $request->nis,
                'kelas_id' => $request->kelas_id,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'agama' => $request->agama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'qr_code' => $qrCodeText,
            ]);
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data Siswa berhasil diubah.');
    }

    public function destroy(Siswa $siswa)
    {
        DB::transaction(function () use ($siswa) {
            $user = $siswa->user;
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $siswa->delete();
            $user->delete();
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data Siswa berhasil dihapus.');
    }

    public function generateQR(Siswa $siswa)
    {
        $qrCodeText = 'SMPN19-' . $siswa->nis;
        $siswa->update(['qr_code' => $qrCodeText]);
        return back()->with('success', 'QR Code berhasil digenerate.');
    }
}
