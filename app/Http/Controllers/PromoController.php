<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('staff.promo.index');
    }

    /**
     * Get promos data for DataTables.
     */
    public function getPromosData()
    {
        $promos = Promo::select(['id', 'title', 'description', 'discount_percentage', 'start_date', 'end_date', 'created_at']);

        return DataTables::of($promos)
            ->editColumn('discount_percentage', function ($promo) {
                return $promo->discount_percentage . '%';
            })
            ->editColumn('start_date', function ($promo) {
                return $promo->start_date->format('d M Y');
            })
            ->editColumn('end_date', function ($promo) {
                return $promo->end_date->format('d M Y');
            })
            ->editColumn('created_at', function ($promo) {
                return $promo->created_at->format('d M Y H:i');
            })
            ->addColumn('status', function ($promo) {
                $today = now()->toDateString();
                if ($promo->end_date < $today) {
                    return '<span class="badge bg-danger">Expired</span>';
                } elseif ($promo->start_date > $today) {
                    return '<span class="badge bg-warning">Upcoming</span>';
                } else {
                    return '<span class="badge bg-success">Active</span>';
                }
            })
            ->addColumn('action', function ($promo) {
                return '<button class="btn btn-sm btn-info show-btn" data-id="' . $promo->id . '">View</button> ' .
                    '<button class="btn btn-sm btn-warning edit-btn" data-id="' . $promo->id . '">Edit</button> ' .
                    '<button class="btn btn-sm btn-danger delete-btn" data-id="' . $promo->id . '">Delete</button>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.promo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'nullable|max:1000',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ], [
            'title.required' => 'Judul promo tidak boleh kosong',
            'title.min' => 'Judul promo harus diisi minimal 3 karakter',
            'title.max' => 'Judul promo maksimal 255 karakter',
            'description.max' => 'Deskripsi maksimal 1000 karakter',
            'discount_percentage.required' => 'Persentase diskon harus diisi',
            'discount_percentage.numeric' => 'Persentase diskon harus berupa angka',
            'discount_percentage.min' => 'Persentase diskon minimal 0%',
            'discount_percentage.max' => 'Persentase diskon maksimal 100%',
            'start_date.required' => 'Tanggal mulai harus diisi',
            'start_date.date' => 'Tanggal mulai harus berupa tanggal yang valid',
            'start_date.after_or_equal' => 'Tanggal mulai harus hari ini atau setelahnya',
            'end_date.required' => 'Tanggal akhir harus diisi',
            'end_date.date' => 'Tanggal akhir harus berupa tanggal yang valid',
            'end_date.after' => 'Tanggal akhir harus setelah tanggal mulai',
        ]);

        Promo::create([
            'title' => $request->title,
            'description' => $request->description,
            'discount_percentage' => $request->discount_percentage,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => 'Promo berhasil dibuat!']);
        } else {
            return redirect()->route('staff.promo.index')->with('success', 'Promo berhasil dibuat!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Promo $promo)
    {
        return response()->json($promo);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promo $promo)
    {
        return view('staff.promo.edit', compact('promo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'nullable|max:1000',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ], [
            'title.required' => 'Judul promo tidak boleh kosong',
            'title.min' => 'Judul promo harus diisi minimal 3 karakter',
            'title.max' => 'Judul promo maksimal 255 karakter',
            'description.max' => 'Deskripsi maksimal 1000 karakter',
            'discount_percentage.required' => 'Persentase diskon harus diisi',
            'discount_percentage.numeric' => 'Persentase diskon harus berupa angka',
            'discount_percentage.min' => 'Persentase diskon minimal 0%',
            'discount_percentage.max' => 'Persentase diskon maksimal 100%',
            'start_date.required' => 'Tanggal mulai harus diisi',
            'start_date.date' => 'Tanggal mulai harus berupa tanggal yang valid',
            'end_date.required' => 'Tanggal akhir harus diisi',
            'end_date.date' => 'Tanggal akhir harus berupa tanggal yang valid',
            'end_date.after' => 'Tanggal akhir harus setelah tanggal mulai',
        ]);

        $promo->update([
            'title' => $request->title,
            'description' => $request->description,
            'discount_percentage' => $request->discount_percentage,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => 'Promo berhasil diperbarui!']);
        } else {
            return redirect()->route('staff.promo.index')->with('success', 'Promo berhasil diperbarui!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promo $promo)
    {
        $promo->delete();
        return response()->json(['success' => 'Promo berhasil dihapus!']);
    }

}
