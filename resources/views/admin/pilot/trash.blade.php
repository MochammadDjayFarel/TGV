@extends('template.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Trash Pilot</h4>
                    <a href="{{ route('admin.pilot.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <table id="pilotsTrashTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Pilot</th>
                                <th>Nomor Lisensi</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Dihapus Pada</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pilots as $pilot)
                            <tr>
                                <td>{{ $pilot->id }}</td>
                                <td>{{ $pilot->name }}</td>
                                <td>{{ $pilot->license_number }}</td>
                                <td>{{ $pilot->email }}</td>
                                <td>{{ $pilot->phone }}</td>
                                <td>{{ $pilot->deleted_at ? $pilot->deleted_at->format('d M Y H:i') : '-' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-success restore-btn" data-id="{{ $pilot->id }}">Restore</button>
                                    <button class="btn btn-sm btn-danger delete-permanent-btn" data-id="{{ $pilot->id }}">Delete Permanent</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Handle restore button click
    $(document).on('click', '.restore-btn', function() {
        var pilotId = $(this).data('id');
        if (confirm('Apakah Anda yakin ingin mengembalikan pilot ini?')) {
            $.ajax({
                url: '{{ route("admin.pilot.restore", ":id") }}'.replace(':id', pilotId),
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    location.reload();
                    toastr.success(response.success);
                },
                error: function() {
                    toastr.error('Gagal mengembalikan pilot.');
                }
            });
        }
    });

    // Handle delete permanent button click
    $(document).on('click', '.delete-permanent-btn', function() {
        var pilotId = $(this).data('id');
        if (confirm('Apakah Anda yakin ingin menghapus pilot ini secara permanen?')) {
            $.ajax({
                url: '{{ route("admin.pilot.delete_permanent", ":id") }}'.replace(':id', pilotId),
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    location.reload();
                    toastr.success(response.success);
                },
                error: function() {
                    toastr.error('Gagal menghapus pilot secara permanen.');
                }
            });
        }
    });
});
</script>
@endsection
