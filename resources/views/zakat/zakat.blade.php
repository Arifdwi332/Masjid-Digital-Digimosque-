@extends('template.layout')

@section('judul')
    Zakat Fitrah
@endsection

@section('konten')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 bg-white p-4 rounded shadow">
                <button href="#" id="openModalBtn" class="btn btn-primary mb-3 rounded" data-bs-toggle="modal"
                    data-bs-target="#myModal">Tambah Zakat Fitrah</button>
                <table class="table table-bordered" id="myTable">
                    <thead>
                        <tr>
                            <th>Nama Pengurus</th>
                            <th>Nama Muzaki</th>
                            <th>Tanggal</th>
                            <th>Jumlah Orang</th>
                            <th>Asal Desa</th>
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
    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="zakatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Zakat Fitrah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formZakat">
                        @csrf
                        <div class="mb-3" style="margin-bottom: 10px;">
                            <label for="nama_pengurus" class="form-label">Nama Pengurus</label>
                            <select class="form-control" id="nama_pengurus" name="nama_pengurus"></select>
                        </div>
                        <div class="mb-3">
                            <label for="nama_muzaki" class="form-label">Nama Muzaki</label>
                            <input type="text" class="form-control" id="nama_muzaki" name="nama_muzaki">
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal">
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_orang" class="form-label">Jumlah Orang</label>
                            <input type="number" class="form-control" id="jumlah_orang" name="jumlah_orang">
                        </div>
                        <div class="mb-3">
                            <label for="asal" class="form-label">Asal Desa</label>
                            <select class="form-control" id="asal" name="asal">
                                <option value="Barepan">Barepan</option>
                                <option value="Setran">Setran</option>
                                <option value="Ngetal">Ngetal</option>
                                <option value="Pringgan">Pringgan</option>
                                <option value="Luar">Luar</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
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

            var id;
            var table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('zakatAjax') }}",
                    type: 'GET',
                },
                columns: [{
                        data: 'nama_pengurus',
                        name: 'nama_pengurus'
                    },
                    {
                        data: 'nama_muzaki',
                        name: 'nama_muzaki'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'jumlah_orang',
                        name: 'jumlah_orang'
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
                $('#modalTitle').text('Tambah Zakat Fitrah');
                id = null;
                $('#myModal').modal('show');
            });

            $('#myTable').on('click', '.btnEdit', function(e) {
                e.preventDefault();
                id = $(this).data('id');
                $.ajax({
                    url: "{{ route('zakatAjax') }}/" + id + "/edit",
                    type: 'GET',
                    success: function(response) {
                        if (response) {
                            $('#nama_pengurus').val(response.nama_pengurus);
                            $('#nama_muzaki').val(response.nama_muzaki);
                            $('#tanggal').val(response.tanggal);
                            $('#jumlah_orang').val(response.jumlah_orang);
                            $('#asal').val(response.asal);
                            $('#modalTitle').text('Edit Zakat Fitrah');
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

            $('#formZakat').submit(function(event) {
                event.preventDefault();
                simpan();
            });

            function simpan() {
                var formData = {
                    nama_pengurus: $('#nama_pengurus option:selected').text(),
                    nama_muzaki: $('#nama_muzaki').val(),
                    tanggal: $('#tanggal').val(),
                    jumlah_orang: $('#jumlah_orang').val(),
                    asal: $('#asal').val(),
                };

                var url = id ? "{{ route('zakatAjax.update', ':id') }}" : "{{ route('zakatAjax.store') }}";
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

            $('#myTable').on('click', '.btnDel', function(e) {
                e.preventDefault();
                if (confirm('Anda yakin ingin menghapus data ini?')) {
                    id = $(this).data('id');
                    $.ajax({
                        url: "{{ route('zakatAjax.delete', ':id') }}".replace(':id', id),
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
