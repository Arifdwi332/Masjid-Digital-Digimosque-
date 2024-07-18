@extends('template.layout')

@section('judul')
    Pengeluaran Zakat Fitrah
@endsection

@section('konten')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 bg-white p-4 rounded shadow">
                <button href="#" id="openModalBtn" class="btn btn-primary mb-3 rounded" data-bs-toggle="modal"
                    data-bs-target="#myModal">Tambah Pengeluaran Zakat Fitrah</button>
                <table class="table table-bordered" id="myTable">
                    <thead>
                        <tr>
                            <th>Nama Penerima</th>
                            <th>Tanggal</th>
                            <th>Berat Beras</th>
                            <th>Desa Tujuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="zakatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Pengeluaran Zakat Fitrah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formPengeluaranZakat">
                        @csrf

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Penerima</label>
                            <input type="text" class="form-control" id="nama" name="nama">
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal">
                        </div>
                        <div class="mb-3">
                            <label for="Berat" class="form-label">Berat Beras (kg)</label>
                            <input type="number" class="form-control" id="berat" name="berat">
                        </div>
                        <div class="mb-3">
                            <label for="desa" class="form-label">Desa Tujuan</label>
                            <input type="text" class="form-control" id="asal" name="asal">
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
            var id;


            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('pengeluaranZakatAjax.index') }}",
                    type: 'GET',
                },
                columns: [{
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'berat',
                        name: 'berat'
                    },
                    {
                        data: 'asal',
                        name: 'asal'
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
                $('#formPengeluaranZakat')[0].reset();
                $('#modalTitle').text('Tambah Pengeluaran Zakat Fitrah');
                id = null;
                $('#myModal').modal('show');
            });


            $('#myTable').on('click', '.btnEdit', function(e) {
                e.preventDefault();
                id = $(this).data('id');
                $.ajax({
                    url: "{{ route('pengeluaranZakatAjax.edit', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        if (response) {
                            $('#nama').val(response.nama);
                            $('#tanggal').val(response.tanggal);
                            $('#berat').val(response.berat);
                            $('#asal').val(response.asal);
                            $('#modalTitle').text('Edit Pengeluaran Zakat Fitrah');
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


            $('#formPengeluaranZakat').submit(function(event) {
                event.preventDefault();
                simpan();
            });

            function simpan() {
                var formData = {
                    nama: $('#nama').val(),
                    tanggal: $('#tanggal').val(),
                    berat: $('#berat').val(),
                    asal: $('#asal').val(),
                };

                var url = id ? "{{ route('pengeluaranZakatAjax.update', ':id') }}" :
                    "{{ route('pengeluaranZakatAjax.store') }}";
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
        });

        $('#myTable').on('click', '.btnDel', function(e) {
            e.preventDefault();
            if (confirm('Anda yakin ingin menghapus data ini?')) {
                id = $(this).data('id');
                $.ajax({
                    url: "{{ route('pengeluaranZakatAjax.delete', ':id') }}".replace(':id', id),
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
    </script>
@endsection
