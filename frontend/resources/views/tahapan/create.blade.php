@extends('layouts.app')

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Home / Product / Stage
                    </div>
                    <h2 class="page-title">
                        Create Stage
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="/product/{{ $product->id }}/stage" class="btn btn-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M5 12l6 6" />
                                <path d="M5 12l6 -6" />
                            </svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('stage.store', $product) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Nama Tahapan</label>
                            <input type="text" name="stage_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Lokasi</label>
                            <input type="text" name="location" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Pelaksana</label>
                            <input type="text" name="performed_by" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Tanggal Pelaksanaan</label>
                            <input type="datetime-local" name="performed_at" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Catatan</label>
                            <textarea name="notes" class="form-control"></textarea>
                        </div>
                        <button class="btn btn-primary">Simpan Tahapan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
