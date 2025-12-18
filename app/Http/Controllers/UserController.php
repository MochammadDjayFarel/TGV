<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Airline;
use App\Models\Airport;
use App\Models\CoPilot;
use App\Models\Pilot;
use App\Models\Ticket;
use App\Models\FlightSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Get users data for DataTables.
     */
public function getUsersData()
    {
        // Ambil query builder Eloquent (jangan pakai ->getQuery())
        $query = User::whereIn('role', ['staff', 'admin'])
                    ->select(['id', 'name', 'email', 'role', 'created_at']);

        return DataTables::of($query)
            ->editColumn('created_at', function ($user) {
                // Jika sudah Carbon object, langsung format; jika string, parse dulu
                if ($user->created_at instanceof \DateTime) {
                    return $user->created_at->format('d M Y H:i');
                }

                // safe fallback jika null atau string
                if (empty($user->created_at)) {
                    return '';
                }

                try {
                    return Carbon::parse($user->created_at)->format('d M Y H:i');
                } catch (\Exception $e) {
                    return $user->created_at; // kalau tetap error, tampilkan apa adanya
                }
            })
            ->addIndexColumn()
            ->addColumn('role_label', function ($data) {
                if ($data->role === 'admin') {
                    return '<span class="badge bg-info">Admin</span>';
                } elseif ($data->role === 'staff') {
                    return '<span class="badge bg-success">Staff</span>';
                }
                return '<span class="badge bg-secondary">'. e($data->role) .'</span>';
            })
            ->addColumn('buttons', function ($data) {
                $editUrl = route('admin.user.edit', $data->id);
                $deleteUrl = route('admin.user.destroy', $data->id);

                $btnEdit = '<a href="'. $editUrl .'" class="btn btn-warning btn-sm me-2">Edit</a>';

                $btnDelete = '<form action="'. $deleteUrl .'" method="POST" class="btn btn-outline-danger" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus user ini?\')">' .
                                csrf_field() .
                                method_field('DELETE') .
                                '<button type="submit" class="btn">Delete</button>' .
                            '</form>';

                return '<div class="d-flex align-items-center">'. $btnEdit . $btnDelete .'</div>';
            })
            ->orderColumn('DT_RowIndex', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->rawColumns(['role_label', 'buttons'])
            ->make(true);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        // Membuat user baru dengan role 'staff' secara otomatis tanpa input role dari form
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff',
        ]);

        // Redirect kembali ke index dengan pesan sukses
        return redirect()->route('admin.user.index')->with('success', 'Staff berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email:dns|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'name.min' => 'Nama harus diisi minimal 3 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Harus diisi dengan email yang valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Minimal harus diisi 8 karakter',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'Staff berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['success' => 'Staff berhasil dihapus!']);
    }

    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        try {
            $airlineCount = Airline::count();
            $airportCount = Airport::count();
            $pilotCount = Pilot::count();
            $copilotCount = CoPilot::count();
            $userCount = User::where('role', 'staff')->count();
        } catch (\Exception $e) {
            // Handle any database or model errors
            $airlineCount = 0;
            $airportCount = 0;
            $pilotCount = 0;
            $copilotCount = 0;
            $userCount = 0;
        }

        return view('admin.index', compact('airlineCount', 'airportCount', 'pilotCount', 'copilotCount', 'userCount'));
    }

    public function singup(Request $request)
    {
        $request->validate([
            'name'=> 'required|min:3',
            'email' => 'required|email:dns',
            'password' => 'required|min:8',
        ], [
            'name.required' => 'Nama belakang tidak boleh kosong',
            'name.min' => 'Nama harus di isi minimal 3 karakter',
            'email.required' => 'Email harus di isi',
            'email.email' => 'Harus di isi degan valid',
            'password.required' => 'Pasword harus di isi',
            'password.min' => 'Minimal harus di isi 8',
        ]);

        $createUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        if($createUser) {
            return redirect()->route('login')->with('oke', 'berhasil membuat akun! silahkan login');
        }else{ return redirect()->back()->with('error','silahkan sisi ulang'); }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email Harus Diisi',
            'password.required' => 'Password Harus Diisi'
        ]);

        $data = $request->only(['email', 'password']);

        if(Auth::attempt($data)){
            if(Auth::user()->role == 'admin'){
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil dilakukan');
            }elseif(Auth::user()->role == 'staff'){
                return redirect()->route('staff.index')->with('login', 'Berhasil Login');
            } else {
                return redirect()->route('index')->with('success', 'Login berhasil dilakukan');
            }
        } else {
            return redirect()->back()->with('error', 'Gagal login! coba lagi');
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('index')->with('logout', 'Berhasil logout silahkan login kembali untuk aksess lengkap');
    }

    /**
     * Show the staff dashboard.
     */
    public function staffIndex()
    {
        return view('staff.index');
    }

    /**
     * Show the public index page with flight schedules.
     */
    public function publicIndex()
    {
        $flightSchedules = FlightSchedule::with(['departureAirport', 'arrivalAirport', 'airline'])->get();
        $airports = Airport::all();
        return view('index', [
            'flightSchedules' => $flightSchedules,
            'airports' => $airports,
        ]);
    }

    public function exportExcel()
    {
        $filleName ='data-User.xlsx';
        return Excel::download(new UserExport, $filleName);
    }

    public function trash()
    {
        $data = User::onlyTrashed()->get();
        return view('admin.user.trash', compact('data'));
    }

    /**
     * Restore user yang di-trashed
     * Menerima AJAX (lebih cepat) atau non-AJAX (redirect).
     */
    public function restore(Request $request, $id)
    {
        try {
            $user = User::onlyTrashed()->find($id);

            if (! $user) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'Data tidak ditemukan atau sudah dikembalikan.'], 404);
                }
                return redirect()->route('admin.user.trash')->with('error', 'Data tidak ditemukan atau sudah dikembalikan.');
            }

            $user->restore();

            if ($request->ajax()) {
                return response()->json(['success' => 'User berhasil dikembalikan.']);
            }

            return redirect()->route('admin.user.index')->with('success', 'User berhasil dikembalikan.');
        } catch (\Exception $e) {
            Log::error('Restore user error: '.$e->getMessage().' | id: '.$id);
            if ($request->ajax()) {
                return response()->json(['error' => 'Terjadi kesalahan saat mengembalikan data.'], 500);
            }
            return redirect()->route('admin.user.trash')->with('error', 'Terjadi kesalahan saat mengembalikan data.');
        }
    }

    /**
     * Hapus permanen (force delete)
     * Menerima AJAX (lebih cepat) atau non-AJAX (redirect).
     */
    public function deletePermanent(Request $request, $id)
    {
        try {
            $user = User::onlyTrashed()->find($id);

            if (! $user) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'Data tidak ditemukan.'], 404);
                }
                return redirect()->route('admin.user.trash')->with('error', 'Data tidak ditemukan.');
            }

            $user->forceDelete();

            if ($request->ajax()) {
                return response()->json(['success' => 'User berhasil dihapus permanen.']);
            }

            return redirect()->route('admin.user.trash')->with('success', 'User berhasil dihapus permanen.');
        } catch (\Exception $e) {
            Log::error('DeletePermanent user error: '.$e->getMessage().' | id: '.$id);
            if ($request->ajax()) {
                return response()->json(['error' => 'Terjadi kesalahan saat menghapus permanen.'], 500);
            }
            return redirect()->route('admin.user.trash')->with('error', 'Terjadi kesalahan saat menghapus permanen.');
        }
    }
}
