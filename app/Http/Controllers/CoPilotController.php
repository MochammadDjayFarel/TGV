<?php

namespace App\Http\Controllers;

use App\Models\CoPilot;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\CoPilotExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CoPilotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.copilot.index');
    }

    /**
     * Get co-pilots data for DataTables.
     */
    public function getCoPilotsData()
    {
        $coPilots = CoPilot::select(['id', 'name', 'license_number', 'phone', 'created_at']);

        return DataTables::of($coPilots)
            ->editColumn('created_at', function ($coPilot) {
                return $coPilot->created_at->format('d M Y H:i');
            })
            ->addColumn('action', function ($coPilot) {
                return '<button class="btn btn-sm btn-warning edit-btn" data-id="' . $coPilot->id . '">Edit</button> ' .
                    '<button class="btn btn-sm btn-danger delete-btn" data-id="' . $coPilot->id . '">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.copilot.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|max:20|unique:co_pilots',
            'date_of_birth' => 'required|date',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ], [
            'name.required' => 'Nama co-pilot harus diisi',
            'license_number.required' => 'Nomor lisensi harus diisi',
            'license_number.unique' => 'Nomor lisensi sudah terdaftar',
            'date_of_birth.required' => 'Tanggal lahir harus diisi',
            'phone.required' => 'Nomor telepon harus diisi',
            'address.required' => 'Alamat harus diisi',
        ]);

        CoPilot::create($request->all());

        return redirect()->route('admin.copilot.index')->with('success', 'Co-pilot berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CoPilot $coPilot)
    {
        return response()->json($coPilot);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CoPilot $coPilot)
    {
        return view('admin.copilot.edit', compact('coPilot'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CoPilot $coPilot)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|max:20|unique:co_pilots,license_number,' . $coPilot->id,
            'date_of_birth' => 'required|date',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
        ], [
            'name.required' => 'Nama co-pilot harus diisi',
            'license_number.required' => 'Nomor lisensi harus diisi',
            'license_number.unique' => 'Nomor lisensi sudah terdaftar',
            'date_of_birth.required' => 'Tanggal lahir harus diisi',
            'phone.required' => 'Nomor telepon harus diisi',
        ]);

        $coPilot->update($request->all());

        return response()->json(['success' => 'Co-pilot berhasil diperbarui!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CoPilot $coPilot,$id)
    {
    $deletData = CoPilot::where('id', $id)->delete();
        if($deletData){
            return redirect()->route('admin.copilot.index')->with('success', 'Berhasil menhapus data Co-pilot');
        }else{
            return redirect()->back()->with('failed', 'Gagal silahkan coba lagi');
        }
    }

                public function exportExcel()
        {
            $filleName ='data-CoPilot.xlsx';
            return Excel::download(new CoPilot, $filleName);
        }

}
