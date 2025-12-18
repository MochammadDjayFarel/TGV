@extends('template.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Edit Maskapai</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.airline.update', $airline->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Maskapai</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $airline->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label">Kode Maskapai</label>
                            <input type="text" class="form-control" id="code" name="code" value="{{ $airline->code }}" maxlength="3" required>
                            <small class="form-text text-muted">Maksimal 3 karakter</small>
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label">Negara</label>
                            <input type="text" class="form-control" id="country" name="country" value="{{ $airline->country }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.airline.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
