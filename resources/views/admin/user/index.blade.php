@extends('template.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Manajemen Staff</h4>
                    <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tambah Staff
                    </a>
                    <a href="{{ route('admin.user.export.excel') }}" class="btn btn-success">
                        <i class="fa fa-plus"></i> Export Excel
                    </a>
                    <a href="{{ route('admin.user.trash') }}" class="btn btn-danger">
                        <i class="fa fa-plus"></i> Recycler Bin
                    </a>
                </div>
                <div class="card-body">
                    <table id="usersTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
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
$(function(){
    $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.user.data') }}",
        order: [[1, 'asc']],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'role_label', name: 'role', orderable: false, searchable: false },
            { data: 'created_at', name: 'created_at' },
            { data: 'buttons', name: 'buttons', orderable: false, searchable: false },
        ]
    });
});
</script>
@endsection
