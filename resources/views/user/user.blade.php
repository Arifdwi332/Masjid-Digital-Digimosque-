@extends('template.layout')

@section('judul', 'Manajemen Pengguna')

@section('konten')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 bg-white p-4 rounded shadow">
                <button id="openModalBtn" class="btn btn-primary mb-3 rounded" data-bs-toggle="modal"
                    data-bs-target="#userModal">Tambah Pengguna</button>
                <table class="table table-bordered" id="userTable">
                    <thead>
                        <tr>
                            <th>Nama Pengurus</th>
                            <th>NIK</th>
                            <th>Email</th>

                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="userModal" class="modal fade" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formUser">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_pengurus" class="form-label">Nama Pengurus</label>
                            <input type="text" class="form-control" id="nama_pengurus" name="nama_pengurus">
                        </div>
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('userAjax.index') }}",
                    type: 'GET',
                },
                columns: [{
                        data: 'nama_pengurus',
                        name: 'nama_pengurus'
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },

                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#openModalBtn').click(function() {
                $('#modalTitle').text('Tambah Pengguna');
                id = null;
                $('#userModal').modal('show');
            });

            $('#userTable').on('click', '.btnEdit', function(e) {
                e.preventDefault();
                id = $(this).data('id');
                $.ajax({
                    url: "{{ route('userAjax.edit', ':id') }}".replace(':id', id),
                    success: function(response) {
                        if (response) {
                            $('#nama_pengurus').val(response.nama_pengurus);
                            $('#nik').val(response.nik);
                            $('#email').val(response.email);
                            $('#password').val('');
                            $('#modalTitle').text('Edit Pengguna');
                            $('#userModal').modal('show');
                        } else {
                            alert('Data tidak ditemukan');
                        }
                    },
                    error: function(response) {
                        alert('Error: ' + response.responseText);
                        console.error(response);
                    }
                });
            });

            $('#formUser').submit(function(event) {
                event.preventDefault();
                simpan();
            });

            function simpan() {
                var formData = {
                    nama_pengurus: $('#nama_pengurus').val(),
                    nik: $('#nik').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                };

                var url = id ? "{{ route('userAjax.update', ':id') }}" : "{{ route('userAjax.store') }}";
                url = url.replace(':id', id);

                var method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert('Data berhasil disimpan!');
                        $('#myModal').on('hidden.bs.modal', function(e) {
                            table.ajax.reload();
                        });
                    },
                    error: function(response) {
                        alert('Error: ' + response.responseText);
                        console.error(response);
                    }
                });
            }

            $('#userTable').on('click', '.btnDel', function(e) {
                e.preventDefault();
                if (confirm('Anda yakin ingin menghapus data ini?')) {
                    id = $(this).data('id');
                    $.ajax({
                        url: "{{ route('userAjax.delete', ':id') }}".replace(':id', id),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert('Data berhasil dihapus!');
                            $('#userTable').DataTable().ajax.reload();
                        },
                        error: function(response) {
                            alert('Error: ' + response.responseText);
                            console.error(response);
                        }
                    });
                }
            });
        });
    </script>
@endsection
