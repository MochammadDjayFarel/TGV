<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\airportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AirportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.airport.index');
    }

    /**
     * Get airports data for DataTables.
     */
    public function getAirportsData()
    {
        $query = Airport::select(['id', 'name', 'code', 'city', 'country', 'created_at']);

        return DataTables::of($query)
            ->editColumn('created_at', function ($airport) {
                return $airport->created_at->format('d M Y H:i');
            })
            ->addIndexColumn()
            ->addColumn('buttons', function ($data) {
                $editUrl = route('admin.airport.edit', $data['id']);
                $deleteUrl = route('admin.airport.destroy', $data['id']);

                $btnEdit = '<a href="' . $editUrl . '" class="btn btn-warning btn-sm me-2">Edit</a>';

                $btnDelete = '<form action="' . $deleteUrl . '" method="POST" style="display: inline;" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus airport ini?\')">' .
                                csrf_field() .
                                method_field('DELETE') .
                                '<button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>' .
                            '</form>';

                return '<div class="d-flex align-items-center">' . $btnEdit . $btnDelete . '</div>';
            })
            ->orderColumn('DT_RowIndex', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->rawColumns(['buttons'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.airport.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'code' => 'required|unique:airports,code|max:3',
            'city' => 'required|min:2',
            'country' => 'required|min:2',
        ], [
            'name.required' => 'Nama bandara tidak boleh kosong',
            'name.min' => 'Nama bandara harus diisi minimal 3 karakter',
            'code.required' => 'Kode bandara harus diisi',
            'code.unique' => 'Kode bandara sudah terdaftar',
            'code.max' => 'Kode bandara maksimal 3 karakter',
            'city.required' => 'Kota tidak boleh kosong',
            'city.min' => 'Kota harus diisi minimal 2 karakter',
            'country.required' => 'Negara tidak boleh kosong',
            'country.min' => 'Negara harus diisi minimal 2 karakter',
        ]);

        Airport::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'city' => $request->city,
            'country' => $request->country,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => 'Bandara berhasil dibuat!']);
        } else {
            return redirect()->route('admin.airport.index')->with('success', 'Bandara berhasil dibuat!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Airport $airport)
    {
        return response()->json($airport);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Airport $airport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Airport $airport)
    {
        $request->validate([
            'name' => 'required|min:3',
            'code' => 'required|max:3|unique:airports,code,' . $airport->id,
            'city' => 'required|min:2',
            'country' => 'required|min:2',
        ], [
            'name.required' => 'Nama bandara tidak boleh kosong',
            'name.min' => 'Nama bandara harus diisi minimal 3 karakter',
            'code.required' => 'Kode bandara harus diisi',
            'code.unique' => 'Kode bandara sudah terdaftar',
            'code.max' => 'Kode bandara maksimal 3 karakter',
            'city.required' => 'Kota tidak boleh kosong',
            'city.min' => 'Kota harus diisi minimal 2 karakter',
            'country.required' => 'Negara tidak boleh kosong',
            'country.min' => 'Negara harus diisi minimal 2 karakter',
        ]);

        $airport->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'city' => $request->city,
            'country' => $request->country,
        ]);

        return response()->json(['success' => 'Bandara berhasil diperbarui!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $deletData = Airport::where('id', $id)->delete();
        if($deletData){
            return redirect()->route('admin.airport.index')->with('success', 'Berhasil menhapus data Bandara');
        }else{
            return redirect()->back()->with('failed', 'Gagal silahkan coba lagi');
        }
    }

        public function exportExcel()
        {
            $fileName = 'data-AirPort.xlsx';
            return Excel::download(new airportExport, $fileName);
        }
}
