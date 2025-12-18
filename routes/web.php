<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\PilotController;
use App\Http\Controllers\FlightScheduleController;
use App\Http\Controllers\CoPilotController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\TicketController;

// user tampilan
Route::get('/', [App\Http\Controllers\UserController::class, 'publicIndex'])->name('index');

// isGuest
// tampilan
Route::get('/Login', function () { return view('login'); })->name('login')->middleware('isGuest');
Route::get('/Singup', function () { return view('singup'); })->name('singup')->middleware('isGuest');

// controller
Route::post('/Singup', [UserController::class, 'singup'])->name('singup.auth')->middleware('isGuest');
Route::post('/login', [UserController::class, 'login'])->name('login.auth')->middleware('isGuest');

// Logout
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Ticket
Route::get('/Ticket', [TicketController::class, 'ticketIndex'])->name('ticket');


// Payment
Route::middleware('isUser')->group(function(){
Route::get('/tickets/{ticket}/payment', [TicketController::class, 'paymentPage'])->name('ticket-payments.page');
Route::post('/tickets/{ticket}/payment', [TicketController::class, 'paymentStore'])->name('ticket-payments.store');
Route::get('/scan/{barcode}', [TicketController::class, 'paymentConfirmByBarcode'])->name('ticket-payments.scan');
Route::get(
    '/ticket-payments/{ticketPayment}/pdf',
    [TicketController::class, 'paymentPrintPdf']
)->name('ticket-payments.pdf');
});

// admin area
Route::middleware('isAdmin')->prefix('/Admin')->name('admin.')->group(function(){
    Route::get('/Dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // data users
    Route::prefix('/User')->name('user.')->group(function(){
        Route::get('/addstaff', [UserController::class, 'index'])->name('index');
        Route::get('/data', [UserController::class, 'getUsersData'])->name('data');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroy');
        Route::get('/export-excel', [UserController::class, 'exportExcel'])->name('export.excel');
        Route::get('/trash', [UserController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [UserController::class, 'restore'])->name('restore');
        Route::delete('/delet-permanet/{id}', [UserController::class, 'deletePermanent'])->name('delete_permanent');
    });

    // data Airport
    Route::prefix('/Airport')->name('airport.')->group(function(){
        Route::get('/addairport', [AirportController::class, 'index'])->name('index');
        Route::get('/data', [AirportController::class, 'getAirportsData'])->name('data');
        Route::post('/store', [AirportController::class, 'store'])->name('store');
        Route::get('/create', [AirportController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [AirportController::class, 'edit'])->name('edit');
        Route::get('/show/{id}', [AirportController::class, 'show'])->name('show');
        Route::put('/update/{id}', [AirportController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [AirportController::class, 'destroy'])->name('destroy');
        Route::get('/export-excel', [AirportController::class, 'exportExcel'])->name('export.excel');
        Route::get('/trash', [AirportController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [AirportController::class, 'restore'])->name('restore');
        Route::delete('/delet-permanet/{id}', [AirportController::class, 'deletePermanent'])->name('delete_permanent');
    });

    // data Pilot
    Route::prefix('/Pilot')->name('pilot.')->group(function(){
        Route::get('/addpilot', [PilotController::class, 'index'])->name('index');
        Route::get('/data', [PilotController::class, 'getPilotsData'])->name('data');
        Route::post('/store', [PilotController::class, 'store'])->name('store');
        Route::get('/create', [PilotController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [PilotController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [PilotController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [PilotController::class, 'destroy'])->name('delete');
        Route::get('/show/{id}', [PilotController::class, 'show'])->name('show');
        Route::get('/export-excel', [PilotController::class, 'exportExcel'])->name('export.excel');
        Route::get('/trash', [PilotController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [PilotController::class, 'restore'])->name('restore');
        Route::delete('/delet-permanet/{id}', [PilotController::class, 'deletePermanent'])->name('delete_permanent');
    });

    // data Airline
    Route::prefix('/Airline')->name('airline.')->group(function(){
        Route::get('/addairline', [AirlineController::class, 'index'])->name('index');
        Route::get('/data', [AirlineController::class, 'getAirlinesData'])->name('data');
        Route::post('/store', [AirlineController::class, 'store'])->name('store');
        Route::get('/create', [AirlineController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [AirlineController::class, 'edit'])->name('edit');
        Route::get('/show/{id}', [AirlineController::class, 'show'])->name('show');
        Route::put('/update/{id}', [AirlineController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [AirlineController::class, 'destroy'])->name('destroy');
        Route::get('/export-excel', [AirlineController::class, 'exportExcel'])->name('export.excel');
        Route::get('/trash', [AirlineController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [AirlineController::class, 'restore'])->name('restore');
        Route::delete('/delet-permanet/{id}', [AirlineController::class, 'deletePermanent'])->name('delete_permanent');
    });

    // data Co-Pilot
    Route::prefix('/CoPilot')->name('copilot.')->group(function(){
        Route::get('/addcopilot', [CoPilotController::class, 'index'])->name('index');
        Route::get('/data', [CoPilotController::class, 'getCoPilotsData'])->name('data');
        Route::post('/store', [CoPilotController::class, 'store'])->name('store');
        Route::get('/create', [CoPilotController::class, 'create'])->name('create');
        Route::get('/edit/{coPilot}', [CoPilotController::class, 'edit'])->name('edit');
        Route::get('/show/{coPilot}', [CoPilotController::class, 'show'])->name('show');
        Route::put('/update/{coPilot}', [CoPilotController::class, 'update'])->name('update');
        Route::delete('/delete/{coPilot}', [CoPilotController::class, 'destroy'])->name('destroy');
        Route::get('/export-excel', [CoPilotController::class, 'exportExcel'])->name('export.excel');
        Route::get('/trash', [CoPilotController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [CoPilotController::class, 'restore'])->name('restore');
        Route::delete('/delet-permanet/{id}', [CoPilotController::class, 'deletePermanent'])->name('delete_permanent');
    });
});

Route::middleware('isStaff')->prefix('/staff')->name('staff.')->group(function(){
    // Staff dashboard (GET) — used by template links (route('staff.index'))
    Route::get('/', [UserController::class, 'staffIndex'])->name('index');

    // data Jadwal Penerbangan
    Route::prefix('/jadwal')->name('jadwal.')->group(function(){
        Route::get('/addjadwal', [FlightScheduleController::class, 'index'])->name('index');
        Route::get('/data', [FlightScheduleController::class, 'getFlightSchedulesData'])->name('data');
        Route::post('/store', [FlightScheduleController::class, 'store'])->name('store');
        Route::get('/create', [FlightScheduleController::class, 'create'])->name('create');
        Route::get('/edit/{flightSchedule}', [FlightScheduleController::class, 'edit'])->name('edit');
        Route::get('/show/{flightSchedule}', [FlightScheduleController::class, 'show'])->name('show');
        Route::put('/update/{flightSchedule}', [FlightScheduleController::class, 'update'])->name('update');
        Route::delete('/delete/{flightSchedule}', [FlightScheduleController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('/Promo')->name('promo.')->group(function(){
        Route::get('/addpromo', [PromoController::class, 'index'])->name('index');
        Route::get('/data', [PromoController::class, 'getPromosData'])->name('data');
        Route::post('/store', [PromoController::class, 'store'])->name('store');
        Route::get('/create', [PromoController::class, 'create'])->name('create');
        Route::get('/edit/{promo}', [PromoController::class, 'edit'])->name('edit');
        Route::get('/show/{promo}', [PromoController::class, 'show'])->name('show');
        Route::put('/update/{promo}', [PromoController::class, 'update'])->name('update');
        Route::delete('/delete/{promo}', [PromoController::class, 'destroy'])->name('destroy');
        Route::get('/trash', [PromoController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [PromoController::class, 'restore'])->name('restore');
        Route::delete('/delet-permanet/{id}', [PromoController::class, 'deletePermanent'])->name('delete_permanent');
    });

    // Ticket CRUD
    Route::resource('ticket', App\Http\Controllers\TicketController::class);

    Route::get('ticket/View/{id}', [TicketController::class, 'show'])->name('lihat');

});
