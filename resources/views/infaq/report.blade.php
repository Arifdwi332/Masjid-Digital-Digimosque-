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
                            <th>Keterangan</th>
                            <th>Jenis</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated by DataTables -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4">Total Pemasukan:</th>
                            <th id="totalPemasukan"></th>
                        </tr>
                        <tr>
                            <th colspan="4">Total Pengeluaran:</th>
                            <th id="totalPengeluaran"></th>
                        </tr>
                        <tr>
                            <th colspan="4">Total Infaq Tersisa:</th>
                            <th id="totalInfaqTersisa"></th>
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
                    dataSrc: function(json) {
                        // Update totals
                        $('#totalPemasukan').html(formatCurrency(json.totalPemasukan));
                        $('#totalPengeluaran').html(formatCurrency(json.totalPengeluaran));
                        $('#totalInfaqTersisa').html(formatCurrency(json.totalInfaqTersisa));
                        // Format nominal values and return the data
                        json.data.forEach(function(item) {
                            item.nominal = formatCurrency(item.nominal);
                        });
                        return json.data;
                    }
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
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        data: 'jenis',
                        name: 'jenis'
                    },
                    {
                        data: 'nominal',
                        name: 'nominal'
                    }
                ]
            });

            // Function to format number as currency
            function formatCurrency(value) {
                return parseFloat(value).toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                });
            }
        });
    </script>
@endsection
