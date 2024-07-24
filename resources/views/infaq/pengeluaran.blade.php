@extends('template.layout')

@section('judul')
    Pengeluaran Infaq
@endsection

@section('konten')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 bg-white p-4 rounded shadow">
                <button href="#" id="openModalBtn" class="btn btn-primary mb-3 rounded" data-bs-toggle="modal"
                    data-bs-target="#myModal">Tambah Pengeluaran Infaq</button>
                <table class="table table-bordered" id="myTable">
                    <thead>
                        <tr>
                            <th>Nama Pengurus</th>
                            <th>Tanggal</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
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
                    <h5 class="modal-title" id="modalTitle">Tambah Pengeluaran Infaq</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formPengeluaranInfaq">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_pengurus" class="form-label">Nama Pengurus</label>
                            <select class="form-control" id="nama_pengurus" name="nama_pengurus">
                                <!-- Options will be populated by Select2 -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal">
                        </div>
                        <div class="mb-3">
                            <label for="nominal" class="form-label">Nominal</label>
                            <input type="number" class="form-control" id="nominal" name="nominal">
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
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
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- DataTables -->
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for nama_pengurus field
            $('#nama_pengurus').select2({
                placeholder: 'Pilih Nama Pengurus',
                ajax: {
                    url: '{{ route('users.getdata') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.nama_pengurus
                                }
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('pengeluaranInfaqAjax.index') }}",
                    type: 'GET',
                },
                columns: [{
                        data: 'nama_pengurus',
                        name: 'nama_pengurus'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'nominal',
                        name: 'nominal',
                        render: function(data, type, row) {
                            // Format nominal dengan ribuan pemisah
                            return parseFloat(data).toLocaleString('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            });
                        }
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
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
                $('#modalTitle').text('Tambah Pengeluaran Infaq');
                $('#myModal').modal('show');
            });

            $('#myTable').on('click', '.btnEdit', function(e) {
                e.preventDefault();
                id = $(this).data('id');
                $.ajax({
                    url: "{{ route('pengeluaranInfaqAjax.edit', ':id') }}".replace(':id', id),
                    success: function(response) {
                        if (response) {
                            $('#nama_pengurus').val(response.nama_pengurus).trigger('change');
                            $('#tanggal').val(response.tanggal);
                            $('#nominal').val(response.nominal);
                            $('#keterangan').val(response.keterangan);
                            $('#modalTitle').text('Edit Pengeluaran Infaq');
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

            $('#formPengeluaranInfaq').submit(function(event) {
                event.preventDefault();
                simpan();
            });

            function simpan() {
                var formData = {
                    nama_pengurus: $('#nama_pengurus option:selected').text(),
                    tanggal: $('#tanggal').val(),
                    nominal: $('#nominal').val(),
                    keterangan: $('#keterangan').val(),
                };

                var url = id ? "{{ route('pengeluaranInfaqAjax.update', ':id') }}" :
                    "{{ route('pengeluaranInfaqAjax.store') }}";
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
                        $('#myTable').DataTable().ajax.reload();
                    },
                    error: function(response) {
                        alert('Error: ' + response.responseText);
                        console.error(response);
                    }
                });
            }

            $('#myTable').on('click', '.btnDel', function(e) {
                e.preventDefault();
                if (confirm('Anda yakin ingin menghapus data ini?')) {
                    id = $(this).data('id');
                    $.ajax({
                        url: "{{ route('pengeluaranInfaqAjax.delete', ':id') }}".replace(':id', id),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert('Data berhasil dihapus!');
                            $('#myTable').DataTable().ajax.reload();
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
