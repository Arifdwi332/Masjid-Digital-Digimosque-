@extends('template/layout')

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
                            <th name="nama">Nama Muzaki</th>
                            <th name="tangal">Tanggal</th>
                            <th name="berat">Berat Beras</th>
                            <th name="asal">Asal Desa</th>
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
                    <h5 class="modal-title" id="#">Tambah Zakat Fitrah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formZakat">
                        @csrf
                        <div class="mb-3">
                            <label for="namaMuzaki" class="form-label">Nama Muzaki</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="beratBeras" class="form-label">Berat Beras (kg)</label>
                            <input type="number" class="form-control" id="berat" name="berat" required>
                        </div>
                        <div class="mb-3">
                            <label for="asalDesa" class="form-label">Asal Desa</label>
                            <input type="text" class="form-control" id="asal" name="asal" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="{{ url('celestialAdmin/template/vendors/js/vendor.bundle.base.js') }}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $('#openModalBtn').click(function() {
            $('#myModal').modal('show');
        });

        // Initialize DataTable
        $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('zakatAjax') }}",
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
                    data: 'aksi',
                    name: 'aksi'
                }
            ]
        });

        // Form submit handler
        $('#formZakat').submit(function(event) {
            event.preventDefault();
            simpan();
        });

        function simpan() {
            var formData = new FormData();
            formData.append('nama', $('#nama').val());
            formData.append('tanggal', $('#tanggal').val());
            formData.append('berat', $('#berat').val());
            formData.append('asal', $('#asal').val());

            $.ajax({
                url: "{{ route('zakat.store') }}",
                type: 'POST',
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
    });
</script>
