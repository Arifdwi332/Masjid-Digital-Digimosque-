@extends('template.layout')

@section('judul')
    Laporan Infaq
@endsection

@section('konten')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 bg-white p-4 rounded shadow">
                <table class="table table-bordered" id="myTable">
                    <thead>
                        <tr>
                            <th>Nama Pengurus</th>
                            <th>Tanggal</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Jenis</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">Total Pengeluaran:</th>

                            <th colspan="2"></th>
                        </tr>
                        <tr>
                            <th colspan="2">Total Pemasukan:</th>

                            <th colspan="2"></th>
                        </tr>
                        <tr>
                            <th colspan="2">Total Infaq Tersisa:</th>

                            <th colspan="2"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- DataTables -->
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('report.data') }}",
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
                        name: 'nominal'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        data: 'jenis',
                        name: 'jenis'
                    }
                ],

            });
        });
    </script>
@endsection
