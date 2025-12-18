@extends('template.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Tambah Bandara Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.airport.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Bandara</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label">Kode Bandara</label>
                            <input type="text" class="form-control" id="code" name="code" maxlength="3" required>
                            <small class="form-text text-muted">Maksimal 3 karakter</small>
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">Kota</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label">Negara</label>
                            <input type="text" class="form-control" id="country" name="country" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.airport.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
