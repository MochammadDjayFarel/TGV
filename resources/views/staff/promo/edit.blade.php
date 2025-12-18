@extends('template.staff')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Edit Promo</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('staff.promo.update', $promo) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Promo</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $promo->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ $promo->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="discount_percentage" class="form-label">Persentase Diskon (%)</label>
                            <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" min="0" max="100" step="0.01" value="{{ $promo->discount_percentage }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $promo->start_date->format('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Tanggal Berakhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $promo->end_date->format('Y-m-d') }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('staff.promo.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
