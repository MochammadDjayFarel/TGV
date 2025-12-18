<?php

namespace App\Http\Controllers;

use App\Models\FlightSchedule;
use App\Models\Airport;
use App\Models\Airline;
use App\Models\Pilot;
use App\Models\CoPilot;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class FlightScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $airports = Airport::select(['id', 'name', 'code'])->get();
        $airlines = Airline::select(['id', 'name'])->get();
        $pilots = Pilot::select(['id', 'name'])->get();
        return view('staff.jadwal.index', compact('airports', 'airlines', 'pilots'));
    }

    /**
     * Get flight schedules data for DataTables.
     */
    public function getFlightSchedulesData()
    {
        $flightSchedules = FlightSchedule::with(['departureAirport', 'arrivalAirport', 'airline', 'pilot', 'coPilot'])
            ->select(['id', 'flight_number', 'departure_time', 'arrival_time', 'airline_id', 'pilot_id', 'co_pilot_id', 'created_at']);

        return DataTables::of($flightSchedules)
            ->editColumn('created_at', function ($schedule) {
                return $schedule->created_at->format('d M Y H:i');
            })
            ->addColumn('airline', function ($schedule) {
                return $schedule->airline->name;
            })
            ->addColumn('pilot', function ($schedule) {
                return $schedule->pilot->name;
            })
            ->addColumn('co_pilot', function ($schedule) {
                return $schedule->coPilot ? $schedule->coPilot->name : '-';
            })
            ->addColumn('status', function ($schedule) {
                $now = now();
                if ($schedule->arrival_time < $now) {
                    return '<span class="badge bg-secondary">Selesai</span>';
                } elseif ($schedule->departure_time > $now) {
                    return '<span class="badge bg-warning">Akan Berangkat</span>';
                } else {
                    return '<span class="badge bg-success">Aktif</span>';
                }
            })
            ->addColumn('action', function ($schedule) {
                return '<button class="btn btn-sm btn-info show-btn" data-id="' . $schedule->id . '">View</button> ' .
                    '<button class="btn btn-sm btn-warning edit-btn" data-id="' . $schedule->id . '">Edit</button> ' .
                    '<button class="btn btn-sm btn-danger delete-btn" data-id="' . $schedule->id . '">Delete</button>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $airports = Airport::select(['id', 'name', 'code'])->get();
        $airlines = Airline::select(['id', 'name'])->get();
        $pilots = Pilot::select(['id', 'name'])->get();
        $coPilots = CoPilot::select(['id', 'name'])->get();
        return view('staff.jadwal.create', compact('airports', 'airlines', 'pilots', 'coPilots'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'departure_airport_id' => 'required|exists:airports,id',
            'arrival_airport_id' => 'required|exists:airports,id|different:departure_airport_id',
            'departure_time' => 'required|date|after:now',
            'arrival_time' => 'required|date|after:departure_time',
            'airline_id' => 'required|exists:airlines,id',
            'pilot_id' => 'required|exists:pilots,id',
            'co_pilot_id' => 'nullable|exists:co_pilots,id',
        ], [
            'departure_airport_id.required' => 'Bandara keberangkatan harus dipilih',
            'arrival_airport_id.required' => 'Bandara kedatangan harus dipilih',
            'arrival_airport_id.different' => 'Bandara kedatangan harus berbeda dari keberangkatan',
            'departure_time.required' => 'Waktu keberangkatan harus diisi',
            'departure_time.after' => 'Waktu keberangkatan harus di masa depan',
            'arrival_time.required' => 'Waktu kedatangan harus diisi',
            'arrival_time.after' => 'Waktu kedatangan harus setelah keberangkatan',
            'airline_id.required' => 'Maskapai harus dipilih',
            'pilot_id.required' => 'Pilot harus dipilih',
            'co_pilot_id.exists' => 'Co-pilot yang dipilih tidak valid',
        ]);

        $airline = Airline::find($request->airline_id);
        $flightNumber = $this->generateFlightNumber($airline->code);

        $data = $request->all();
        $data['flight_number'] = $flightNumber;
        $data['co_pilot_id'] = $data['co_pilot_id'] ?: null;
        FlightSchedule::create($data);

        return redirect()->route('staff.jadwal.index')->with('success', 'Jadwal penerbangan berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(FlightSchedule $flightSchedule)
    {
        $schedule = $flightSchedule->load(['departureAirport', 'arrivalAirport', 'airline', 'pilot', 'coPilot']);
        $now = now();
        if ($schedule->arrival_time < $now) {
            $status = 'Selesai';
        } elseif ($schedule->departure_time > $now) {
            $status = 'Akan Berangkat';
        } else {
            $status = 'Aktif';
        }
        $schedule->status = $status;
        return response()->json($schedule);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FlightSchedule $flightSchedule)
    {
        $airports = Airport::select(['id', 'name', 'code'])->get();
        $airlines = Airline::select(['id', 'name'])->get();
        $pilots = Pilot::select(['id', 'name'])->get();
        $coPilots = CoPilot::select(['id', 'name'])->get();
        return view('staff.jadwal.edit', compact('flightSchedule', 'airports', 'airlines', 'pilots', 'coPilots'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FlightSchedule $flightSchedule)
    {
        $request->validate([
            'flight_number' => 'required|unique:flight_schedules,flight_number,' . $flightSchedule->id,
            'departure_airport_id' => 'required|exists:airports,id',
            'arrival_airport_id' => 'required|exists:airports,id|different:departure_airport_id',
            'departure_time' => 'required|date|after:now',
            'arrival_time' => 'required|date|after:departure_time',
            'airline_id' => 'required|exists:airlines,id',
            'pilot_id' => 'required|exists:pilots,id',
            'co_pilot_id' => 'nullable|exists:co_pilots,id',
        ], [
            'flight_number.required' => 'Nomor penerbangan harus diisi',
            'flight_number.unique' => 'Nomor penerbangan sudah terdaftar',
            'departure_airport_id.required' => 'Bandara keberangkatan harus dipilih',
            'arrival_airport_id.required' => 'Bandara kedatangan harus dipilih',
            'arrival_airport_id.different' => 'Bandara kedatangan harus berbeda dari keberangkatan',
            'departure_time.required' => 'Waktu keberangkatan harus diisi',
            'departure_time.after' => 'Waktu keberangkatan harus di masa depan',
            'arrival_time.required' => 'Waktu kedatangan harus diisi',
            'arrival_time.after' => 'Waktu kedatangan harus setelah keberangkatan',
            'airline_id.required' => 'Maskapai harus dipilih',
            'pilot_id.required' => 'Pilot harus dipilih',
        ]);

        $flightSchedule->update($request->all());

        return response()->json(['success' => 'Jadwal penerbangan berhasil diperbarui!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FlightSchedule $flightSchedule)
    {
        $flightSchedule->delete();
        return response()->json(['success' => 'Jadwal penerbangan berhasil dihapus!']);
    }

    /**
     * Generate a unique flight number.
     */
    private function generateFlightNumber($airlineCode)
    {
        do {
            $number = strtoupper($airlineCode) . rand(1000, 9999);
        } while (FlightSchedule::where('flight_number', $number)->exists());

        return $number;
    }
}
