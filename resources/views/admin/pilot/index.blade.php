@extends('template.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Manajemen Pilot</h4>
                    <a href="{{ route('admin.pilot.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tambah Pilot
                    </a>
                    <a href="{{ route('admin.pilot.export.excel') }}" class="btn btn-success">
                        <i class="fa fa-plus"></i> Export Excel
                    </a>
                </div>
                <div class="card-body">
                    <table id="pilotsTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Pilot</th>
                                <th>Nomor Lisensi</th>
                                <th>Email</th>
                                <th>Telepon</th>
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



<!-- Modal for Editing Pilot -->
<div class="modal fade" id="editPilotModal" tabindex="-1" aria-labelledby="editPilotModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPilotModalLabel">Edit Pilot</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPilotForm">
                <input type="hidden" id="editPilotId" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Nama Pilot</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                        <div class="invalid-feedback" id="editNameError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editLicenseNumber" class="form-label">Nomor Lisensi</label>
                        <input type="text" class="form-control" id="editLicenseNumber" name="license_number" maxlength="20" required>
                        <div class="invalid-feedback" id="editLicenseNumberError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                        <div class="invalid-feedback" id="editEmailError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editPhone" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="editPhone" name="phone" required>
                        <div class="invalid-feedback" id="editPhoneError"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#pilotsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.pilot.data") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'license_number', name: 'license_number' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });



    // Handle edit button click
    $(document).on('click', '.edit-btn', function() {
        var pilotId = $(this).data('id');
        $.ajax({
            url: '{{ route("admin.pilot.show", ":id") }}'.replace(':id', pilotId),
            method: 'GET',
            success: function(data) {
                $('#editPilotId').val(data.id);
                $('#editName').val(data.name);
                $('#editLicenseNumber').val(data.license_number);
                $('#editEmail').val(data.email);
                $('#editPhone').val(data.phone);
                $('#editPilotModal').modal('show');
            },
            error: function() {
                toastr.error('Gagal memuat data pilot.');
            }
        });
    });

    // Handle form submission for editing pilot
    $('#editPilotForm').on('submit', function(e) {
        e.preventDefault();
        $('.invalid-feedback').text('');
        $('.form-control').removeClass('is-invalid');

        var pilotId = $('#editPilotId').val();
        $.ajax({
            url: '{{ route("admin.pilot.update", ":id") }}'.replace(':id', pilotId),
            method: 'PUT',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#editPilotModal').modal('hide');
                    $('#pilotsTable').DataTable().ajax.reload();
                    toastr.success(response.success);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    for (var field in errors) {
                        $('#edit' + field.charAt(0).toUpperCase() + field.slice(1) + 'Error').text(errors[field][0]);
                        $('#edit' + field.charAt(0).toUpperCase() + field.slice(1)).addClass('is-invalid');
                    }
                } else {
                    toastr.error('Terjadi kesalahan. Silakan coba lagi.');
                }
            }
        });
    });

    // Handle delete button click
    $(document).on('click', '.delete-btn', function() {
        var pilotId = $(this).data('id');
        if (confirm('Apakah Anda yakin ingin menghapus pilot ini?')) {
            $.ajax({
                url: '{{ route("admin.pilot.delete", ":id") }}'.replace(':id', pilotId),
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#pilotsTable').DataTable().ajax.reload();
                        toastr.success(response.success);
                    }
                },
                error: function() {
                    toastr.error('Gagal menghapus pilot.');
                }
            });
        }
    });
});
</script>
@endsection
