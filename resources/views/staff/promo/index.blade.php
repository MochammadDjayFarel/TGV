@extends('template.staff')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Manajemen Promo</h4>
                    <a href="{{ route('staff.promo.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tambah Promo
                    </a>
                </div>
                <div class="card-body">
                    <table id="promosTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th >ID</th>
                                <th >Judul</th>
                                <th>Deskripsi</th>
                                <th >Diskon (%)</th>
                                <th >Tanggal Mulai</th>
                                <th >Tanggal Akhir</th>
                                <th >Status</th>
                                <th >Dibuat Pada</th>
                                <th >Aksi</th>
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

<!-- Modal for Viewing Promo -->
<div class="modal fade" id="viewPromoModal" tabindex="-1" aria-labelledby="viewPromoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPromoModalLabel">Detail Promo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul:</label>
                    <p id="viewTitle"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Deskripsi:</label>
                    <p id="viewDescription"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Persentase Diskon:</label>
                    <p id="viewDiscount"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Mulai:</label>
                    <p id="viewStartDate"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Akhir:</label>
                    <p id="viewEndDate"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Status:</label>
                    <p id="viewStatus"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Dibuat Pada:</label>
                    <p id="viewCreatedAt"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Promo -->
<div class="modal fade" id="editPromoModal" tabindex="-1" aria-labelledby="editPromoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPromoModalLabel">Edit Promo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPromoForm">
                <input type="hidden" id="editPromoId" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editTitle" class="form-label">Judul Promo</label>
                        <input type="text" class="form-control" id="editTitle" name="title" required>
                        <div class="invalid-feedback" id="editTitleError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                        <div class="invalid-feedback" id="editDescriptionError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editDiscountPercentage" class="form-label">Persentase Diskon</label>
                        <input type="number" class="form-control" id="editDiscountPercentage" name="discount_percentage" min="0" max="100" required>
                        <div class="invalid-feedback" id="editDiscountPercentageError"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editStartDate" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="editStartDate" name="start_date" required>
                                <div class="invalid-feedback" id="editStartDateError"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editEndDate" class="form-label">Tanggal Akhir</label>
                                <input type="date" class="form-control" id="editEndDate" name="end_date" required>
                                <div class="invalid-feedback" id="editEndDateError"></div>
                            </div>
                        </div>
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
    $('#promosTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("staff.promo.data") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description' },
            { data: 'discount_percentage', name: 'discount_percentage' },
            { data: 'start_date', name: 'start_date' },
            { data: 'end_date', name: 'end_date' },
            { data: 'status', name: 'status', orderable: false },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // Handle view button click
    $(document).on('click', '.show-btn', function() {
        var promoId = $(this).data('id');
        $.ajax({
            url: '{{ route("staff.promo.show", ":id") }}'.replace(':id', promoId),
            method: 'GET',
            success: function(data) {
                $('#viewTitle').text(data.title);
                $('#viewDescription').text(data.description || '-');
                $('#viewDiscount').text(data.discount_percentage + '%');

                // Format dates
                var startDate = new Date(data.start_date);
                var endDate = new Date(data.end_date);
                $('#viewStartDate').text(startDate.toLocaleDateString('id-ID'));
                $('#viewEndDate').text(endDate.toLocaleDateString('id-ID'));

                // Determine status
                var today = new Date();
                var status = 'Aktif';
                var statusClass = 'badge bg-success';

                if (endDate < today) {
                    status = 'Kadaluarsa';
                    statusClass = 'badge bg-danger';
                } else if (startDate > today) {
                    status = 'Akan Datang';
                    statusClass = 'badge bg-warning';
                }

                $('#viewStatus').html('<span class="' + statusClass + '">' + status + '</span>');

                var createdAt = new Date(data.created_at);
                $('#viewCreatedAt').text(createdAt.toLocaleString('id-ID'));

                $('#viewPromoModal').modal('show');
            },
            error: function() {
                toastr.error('Gagal memuat data promo.');
            }
        });
    });

    // Handle edit button click
    $(document).on('click', '.edit-btn', function() {
        var promoId = $(this).data('id');
        $.ajax({
            url: '{{ route("staff.promo.show", ":id") }}'.replace(':id', promoId),
            method: 'GET',
            success: function(data) {
                $('#editPromoId').val(data.id);
                $('#editTitle').val(data.title);
                $('#editDescription').val(data.description);
                $('#editDiscountPercentage').val(data.discount_percentage);
                $('#editStartDate').val(data.start_date);
                $('#editEndDate').val(data.end_date);
                $('#editPromoModal').modal('show');
            },
            error: function() {
                toastr.error('Gagal memuat data promo.');
            }
        });
    });

    // Handle form submission for editing promo
    $('#editPromoForm').on('submit', function(e) {
        e.preventDefault();
        $('.invalid-feedback').text('');
        $('.form-control').removeClass('is-invalid');

        var promoId = $('#editPromoId').val();
        $.ajax({
            url: '{{ route("staff.promo.update", ":id") }}'.replace(':id', promoId),
            method: 'PUT',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#editPromoModal').modal('hide');
                    $('#promosTable').DataTable().ajax.reload();
                    toastr.success(response.success);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    for (var field in errors) {
                        var fieldName = field.charAt(0).toUpperCase() + field.slice(1);
                        if (field === 'discount_percentage') {
                            fieldName = 'DiscountPercentage';
                        }
                        $('#edit' + fieldName + 'Error').text(errors[field][0]);
                        $('#edit' + fieldName).addClass('is-invalid');
                    }
                } else {
                    toastr.error('Terjadi kesalahan. Silakan coba lagi.');
                }
            }
        });
    });

    // Handle delete button click
    $(document).on('click', '.delete-btn', function() {
        var promoId = $(this).data('id');
        if (confirm('Apakah Anda yakin ingin menghapus promo ini?')) {
            $.ajax({
                url: '{{ route("staff.promo.destroy", ":id") }}'.replace(':id', promoId),
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#promosTable').DataTable().ajax.reload();
                        toastr.success(response.success);
                    }
                },
                error: function() {
                    toastr.error('Gagal menghapus promo.');
                }
            });
        }
    });
});
</script>
@endsection
