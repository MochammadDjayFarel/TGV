<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\airlienExport;
use App\Exports\airlineExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AirlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.airline.index');
    }

    /**
     * Get airlines data for DataTables.
     */
    public function getAirlinesData()
    {
        $query = Airline::select(['id', 'name', 'code', 'country', 'created_at']);

        return DataTables::of($query)
            ->editColumn('created_at', function ($airline) {
                if ($airline->created_at instanceof \DateTime) {
                    return $airline->created_at->format('d M Y H:i');
                }

                if (empty($airline->created_at)) {
                    return '';
                }

                try {
                    return Carbon::parse($airline->created_at)->format('d M Y H:i');
                } catch (\Exception $e) {
                    return $airline->created_at;
                }
            })
            ->addIndexColumn()
            ->addColumn('buttons', function ($data) {
                $editUrl = route('admin.airline.edit', $data->id);
                $deleteUrl = route('admin.airline.destroy', $data->id);

                $btnEdit = '<a href="'. $editUrl .'" class="btn btn-warning btn-sm me-2">Edit</a>';

                $btnDelete = '<form action="'. $deleteUrl .'" method="POST" class="btn btn-outline-danger" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus airline ini?\')">' .
                                csrf_field() .
                                method_field('DELETE') .
                                '<button type="submit" class="btn">Delete</button>' .
                            '</form>';

                return '<div class="d-flex align-items-center">'. $btnEdit . $btnDelete .'</div>';
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
        return view('admin.airline.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'code' => 'required|unique:airlines,code|max:3',
            'country' => 'required|min:2',
        ], [
            'name.required' => 'Nama maskapai tidak boleh kosong',
            'name.min' => 'Nama maskapai harus diisi minimal 3 karakter',
            'code.required' => 'Kode maskapai harus diisi',
            'code.unique' => 'Kode maskapai sudah terdaftar',
            'code.max' => 'Kode maskapai maksimal 3 karakter',
            'country.required' => 'Negara tidak boleh kosong',
            'country.min' => 'Negara harus diisi minimal 2 karakter',
        ]);

        Airline::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'country' => $request->country,
        ]);

        return redirect()->route('admin.airline.index')->with('success', 'Maskapai berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Airline $airline)
    {
        return response()->json($airline);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Airline $airline)
    {
        return view('admin.airline.edit', compact('airline'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Airline $airline)
    {
        $request->validate([
            'name' => 'required|min:3',
            'code' => 'required|max:3|unique:airlines,code,' . $airline->id,
            'country' => 'required|min:2',
        ], [
            'name.required' => 'Nama maskapai tidak boleh kosong',
            'name.min' => 'Nama maskapai harus diisi minimal 3 karakter',
            'code.required' => 'Kode maskapai harus diisi',
            'code.unique' => 'Kode maskapai sudah terdaftar',
            'code.max' => 'Kode maskapai maksimal 3 karakter',
            'country.required' => 'Negara tidak boleh kosong',
            'country.min' => 'Negara harus diisi minimal 2 karakter',
        ]);

        $airline->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'country' => $request->country,
        ]);

        return redirect()->route('admin.airline.index')->with('success', 'Maskapai berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Airline $airline, $id)
    {
    $deletData = Airline::where('id', $id)->delete();
        if($deletData){
            return redirect()->route('admin.airline.index')->with('success', 'Berhasil menhapus data Maskapai');
        }else{
            return redirect()->back()->with('failed', 'Gagal silahkan coba lagi');
        }
    }

                public function exportExcel()
        {
            $filleName ='data-AirLine.xlsx';
            return Excel::download(new airlineExport, $filleName);
        }
}
