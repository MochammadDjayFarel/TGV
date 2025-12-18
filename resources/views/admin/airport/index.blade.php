@extends('template.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Manajemen Bandara</h4>
                    <a href="{{ route('admin.airport.create') }}" class="btn btn-primary" >
                        <i class="fa fa-plus"></i> Tambah Bandara
                    </a>
                    <a href="{{ route('admin.airport.export.excel') }}" class="btn btn-success">
                        <i class="fa fa-download"></i> Export Excel
                    </a>
                    <a href="{{ route('admin.airport.trash') }}" class="btn btn-danger">
                        <i class="fa fa-trash"></i> Recycler Bin
                    </a>
                </div>
                <div class="card-body">
                    <table id="airportsTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Bandara</th>
                                <th>Kode</th>
                                <th>Kota</th>
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
$(function(){
    $('#airportsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.airport.data') }}",
            dataSrc: 'data'
        },
        order: [[1, 'asc']],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'code', name: 'code' },
            { data: 'city', name: 'city' },
            { data: 'country', name: 'country' },
            { data: 'created_at', name: 'created_at' },
            { data: 'buttons', name: 'buttons', orderable: false, searchable: false },
        ]
    });
});
</script>
@endsection

