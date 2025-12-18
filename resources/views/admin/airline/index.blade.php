@extends('template.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Manajemen Maskapai</h4>
                    <a href="{{ route('admin.airline.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tambah Maskapai
                    </a>
                    <a href="{{ route('admin.airline.export.excel') }}" class="btn btn-success">
                        <i class="fa fa-plus"></i> Export Excel
                    </a>
                </div>
                <div class="card-body">
                    <table id="airlinesTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Maskapai</th>
                                <th>Kode</th>
                                <th>Negara</th>
                                <th>Dibuat Pada</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
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
    $('#airlinesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.airline.data") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'code', name: 'code' },
            { data: 'country', name: 'country' },
            { data: 'created_at', name: 'created_at' },
            { data: 'buttons', name: 'buttons', orderable: false, searchable: false }
        ]
    });

    // Handle delete button click
    $(document).on('click', '.delete-btn', function() {
        var airlineId = $(this).data('id');
        if (confirm('Apakah Anda yakin ingin menghapus maskapai ini?')) {
            $.ajax({
                url: '{{ route("admin.airline.destroy", ":id") }}'.replace(':id', airlineId),
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#airlinesTable').DataTable().ajax.reload();
                        toastr.success(response.success);
                    }
                },
                error: function() {
                    toastr.error('Gagal menghapus maskapai.');
                }
            });
        }
    });
});
</script>
@endsection
