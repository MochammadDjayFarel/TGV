@extends('template.staff')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Manajemen Jadwal Penerbangan</h4>
                    <a href="{{ route('staff.jadwal.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tambah Jadwal
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="jadwalTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nomor Penerbangan</th>
                                    <th>Maskapai</th>
                                    <th>Pilot</th>
                                    <th>Status</th>
                                    <th>Dibuat Pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('scripts')
<script>
$(document).ready(function() {
    var pilotId = $(this).data('id');
    $('#jadwalTable').DataTable({
        ajax: '{{ route("staff.jadwal.data") }}',
        columns: [
            { data: 'id' },
            { data: 'flight_number' },
            { data: 'airline' },
            { data: 'pilot' },
            { data: 'status' },
            { data: 'created_at' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });


    // Update Jadwal
    $('#editJadwalForm').submit(function(e){
        e.preventDefault();

        var id = $('#editJadwalId').val();

        $.ajax({
            url: '{{ route("staff.jadwal.update", ":id") }}'.replace(':id', id),
            method: "PUT",
            data: $(this).serialize(),
            success: function(res){
                toastr.success(res.success);
                $('#editJadwalModal').modal('hide');
                $('#jadwalTable').DataTable().ajax.reload();
            },
            error: function(xhr){
                if(xhr.status === 422){
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, val){
                        $('#edit' + key.replace(/_/g,'').replace(/\b\w/g,c=>c.toUpperCase()) + 'Error').text(val[0]);
                        $('#edit' + key.replace(/_/g,'').replace(/\b\w/g,c=>c.toUpperCase())).addClass('is-invalid');
                    });
                }
            }
        });
    });

    // Delete Jadwal
    $(document).on('click', '.delete-btn', function(){
        var id = $(this).data('id');
        if(!confirm("Hapus jadwal ini?")) return;

        $.ajax({
            url: '{{ route("staff.jadwal.destroy", ":id") }}'.replace(':id', id),
            method: "DELETE",
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function(res){
                toastr.success(res.success);
                $('#jadwalTable').DataTable().ajax.reload();
            }
        });
    });

    // Change Status
    $(document).on('change', '.status-select', function(){
        var id = $(this).data('id');
        var status = $(this).val();

        if(!confirm("Yakin ubah status ke " + status + " ?")) {
            $('#jadwalTable').DataTable().ajax.reload();
            return;
        }

        $.ajax({
            url: '{{ route("staff.jadwal.update", ":id") }}'.replace(':id', id),
            method: "PATCH",
            data: {
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res){
                toastr.success(res.success);
                $('#jadwalTable').DataTable().ajax.reload();
            }
        });
    });

});
</script>
@endsection
