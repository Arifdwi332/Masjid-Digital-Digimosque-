@extends('template/layout')

@section('judul')
    Home
@endsection

@section('konten')
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between">

            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Card for Total Infaq -->
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Total Infaq</h5>
                                    <p class="card-text">
                                        Total infaq saat ini adalah: Rp <span
                                            id="totalInfaq">{{ number_format($totalInfaqTersisa, 0, ',', '.') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
