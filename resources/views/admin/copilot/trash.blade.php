@extends('template.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Trash - Manajemen Co-Pilot</h4>
                    <a href="{{ route('admin.copilot.index') }}" class="btn btn-primary">
                        <i class="fa fa-arrow-left"></i> Kembali ke Daftar Co-Pilot
                    </a>
                </div>
                <div class="card-body">
                    <table id="copilotsTrashTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Nomor Lisensi</th>
                                <th>Tanggal Lahir</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
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
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

<script>
$(document).ready(function() {
    $('#copilotsTrashTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.copilot.trashData") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'license_number', name: 'license_number' },
            { data: 'date_of_birth', name: 'date_of_birth' },
            { data: 'phone', name: 'phone' },
            { data: 'address', name: 'address' },
            { data: 'created_at', name: 'created_at' },
            { data: 'buttons', name: 'buttons', orderable: false, searchable: false }
        ]
    });
});
</script>
@endsection
