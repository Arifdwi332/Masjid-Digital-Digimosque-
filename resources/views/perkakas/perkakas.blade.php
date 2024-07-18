@extends('template.layout')

@section('judul')
    Perkakas
@endsection

@section('konten')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 bg-white p-4 rounded shadow">
                <button href="#" id="openModalBtn" class="btn btn-primary mb-3 rounded" data-bs-toggle="modal"
                    data-bs-target="#myModal">Tambah Perkakas</button>
                <table class="table table-bordered" id="perkakasTable">
                    <thead>
                        <tr>
                            <th>Nama Item</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Perkakas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formPerkakas">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_item" class="form-label">Nama Item</label>
                            <input type="text" class="form-control" id="nama_item" name="nama_item">
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah">
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

            $('#perkakasTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('perkakas.index') }}",
                    type: 'GET',
                },
                columns: [{
                        data: 'nama_item',
                        name: 'nama_item'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'id',
                        name: 'aksi',
                        render: function(data, type, row) {
                            return `<a class="btn btn-primary btn-sm mx-1 btnEdit" href="#" data-id="${data}">Edit</a>
                                <a class="btn btn-danger btn-sm mx-1 btnDel" href="#" data-id="${data}">Hapus</a>`;
                        }
                    }
                ]
            });

            $('#openModalBtn').click(function() {
                id = null;
                $('#modalTitle').text('Tambah Perkakas');
                $('#formPerkakas')[0].reset();
                $('#myModal').modal('show');
            });


            $('#perkakasTable').on('click', '.btnEdit', function(e) {
                e.preventDefault();
                id = $(this).data('id');
                $.ajax({
                    url: "{{ route('perkakas.edit', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        if (response) {
                            $('#nama_item').val(response.nama_item);
                            $('#jumlah').val(response.jumlah);
                            $('#modalTitle').text('Edit Perkakas');
                            $('#myModal').modal('show');
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

            $('#formPerkakas').submit(function(event) {
                event.preventDefault();
                simpan();
            });

            function simpan() {
                var formData = {
                    nama_item: $('#nama_item').val(),
                    jumlah: $('#jumlah').val(),
                };

                var url = id ? "{{ route('perkakas.update', ':id') }}" : "{{ route('perkakas.store') }}";
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
                        $('#myModal').modal('hide');
                        table.ajax.reload();
                    },
                    error: function(response) {
                        alert('Error: ' + response.responseText);
                        console.error(response);
                    }
                });
            }


            $('#perkakasTable').on('click', '.btnDel', function(e) {
                e.preventDefault();
                if (confirm('Anda yakin ingin menghapus data ini?')) {
                    id = $(this).data('id');
                    $.ajax({
                        url: "{{ route('perkakas.delete', ':id') }}".replace(':id', id),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert('Data berhasil dihapus!');
                            table.ajax.reload();
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
