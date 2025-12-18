<?php

namespace App\Http\Controllers;

use App\Models\Pilot;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\pilotExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PilotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pilot.index');
    }

    /**
     * Get pilots data for DataTables.
     */
    public function getPilotsData()
    {
        $pilots = Pilot::select(['id', 'name', 'license_number', 'email', 'phone', 'created_at']);

        return DataTables::of($pilots)
            ->editColumn('created_at', function ($pilot) {
                return $pilot->created_at->format('d M Y H:i');
            })
            ->addColumn('action', function ($pilot) {
                return '<button class="btn btn-sm btn-warning edit-btn" data-id="' . $pilot->id . '">Edit</button> ' .
                    '<button class="btn btn-sm btn-danger delete-btn" data-id="' . $pilot->id . '">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pilot.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'license_number' => 'required|unique:pilots,license_number',
            'email' => 'required|email|unique:pilots,email',
            'phone' => 'required|min:10',
        ], [
            'name.required' => 'Nama pilot tidak boleh kosong',
            'name.min' => 'Nama pilot harus diisi minimal 3 karakter',
            'license_number.required' => 'Nomor lisensi harus diisi',
            'license_number.unique' => 'Nomor lisensi sudah terdaftar',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Harus diisi dengan email yang valid',
            'email.unique' => 'Email sudah terdaftar',
            'phone.required' => 'Nomor telepon harus diisi',
            'phone.min' => 'Nomor telepon harus diisi minimal 10 karakter',
        ]);

        Pilot::create([
            'name' => $request->name,
            'license_number' => $request->license_number,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => 'Pilot berhasil dibuat!']);
        } else {
            return redirect()->route('admin.pilot.index')->with('success', 'Pilot berhasil dibuat!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pilot $pilot)
    {
        return response()->json($pilot);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pilot $pilot)
    {
        return view('admin.pilot.edit', compact('pilot'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pilot $pilot)
    {
        $request->validate([
            'name' => 'required|min:3',
            'license_number' => 'required|unique:pilots,license_number,' . $pilot->id,
            'email' => 'required|email|unique:pilots,email,' . $pilot->id,
            'phone' => 'required|min:10',
        ], [
            'name.required' => 'Nama pilot tidak boleh kosong',
            'name.min' => 'Nama pilot harus diisi minimal 3 karakter',
            'license_number.required' => 'Nomor lisensi harus diisi',
            'license_number.unique' => 'Nomor lisensi sudah terdaftar',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Harus diisi dengan email yang valid',
            'email.unique' => 'Email sudah terdaftar',
            'phone.required' => 'Nomor telepon harus diisi',
            'phone.min' => 'Nomor telepon harus diisi minimal 10 karakter',
        ]);

        $pilot->update([
            'name' => $request->name,
            'license_number' => $request->license_number,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return response()->json(['success' => 'Pilot berhasil diperbarui!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pilot $pilot,$id)
    {
    $deletData = Pilot::where('id', $id)->delete();
        if($deletData){
            return redirect()->route('admin.pilot.index')->with('success', 'Berhasil menhapus data Pilot');
        }else{
            return redirect()->back()->with('failed', 'Gagal silahkan coba lagi');
        }
    }

            public function exportExcel()
        {
            $filleName ='data-Pilot.xlsx';
            return Excel::download(new pilotExport, $filleName);
        }

    public function trash()
    {
        $pilots = Pilot::onlyTrashed()->get();

        return view('admin.pilot.trash', compact('pilots'));
    }

    // Restore pilot yang di-trashed
    public function restore($id)
    {
        try {
            $pilot = Pilot::onlyTrashed()->find($id);

            if (! $pilot) {
                return redirect()->route('admin.pilot.trash')->with('error', 'Data tidak ditemukan atau sudah dikembalikan.');
            }

            $pilot->restore();

            return redirect()->route('admin.pilot.index')->with('success', 'Pilot berhasil dikembalikan.');
        } catch (\Exception $e) {
            Log::error('Restore pilot error: '.$e->getMessage().' | id: '.$id);
            return redirect()->route('admin.pilot.trash')->with('error', 'Terjadi kesalahan saat mengembalikan data.');
        }
    }

    // Hapus permanen (force delete)
    public function deletePermanent($id)
    {
        try {
            $pilot = Pilot::onlyTrashed()->find($id);

            if (! $pilot) {
                return redirect()->route('admin.pilot.trash')->with('error', 'Data tidak ditemukan.');
            }

            $pilot->forceDelete();

            return redirect()->route('admin.pilot.trash')->with('success', 'Pilot berhasil dihapus permanen.');
        } catch (\Exception $e) {
            Log::error('DeletePermanent pilot error: '.$e->getMessage().' | id: '.$id);
            return redirect()->route('admin.pilot.trash')->with('error', 'Terjadi kesalahan saat menghapus permanen.');
        }
    }
}