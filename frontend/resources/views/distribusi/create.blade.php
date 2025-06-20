@extends('layouts.app')

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Home / Distribution
                    </div>
                    <h2 class="page-title">
                        Add Distribution
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="/distribution" class="btn btn-5">
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
            <form action="{{ route('distribution.store', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mb-3">
                    <div class="card-body">

                        <div class="mb-3">
                            <label>Tujuan Distribusi</label>
                            <input type="text" name="destination" class="form-control" placeholder="Tujuan" required>
                        </div>

                        <div class="mb-3">
                            <label>Penerima</label>
                            <select class="form-select" id="select-users" name="user_id" placeholder="Pilih Penerima"
                                required>
                                <option value="" disabled selected hidden>Pilih Penerima</option>
                                @foreach ($users as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    var el = document.getElementById("select-users");
                                    if (window.TomSelect) {
                                        new TomSelect(el, {
                                            placeholder: "Pilih Penerima",
                                            copyClassesToDropdown: false,
                                            dropdownParent: "body",
                                            controlInput: "<input>",
                                            render: {
                                                item: function(data, escape) {
                                                    if (data.customProperties) {
                                                        return (
                                                            '<div><span class="dropdown-item-indicator">' +
                                                            data.customProperties +
                                                            "</span>" +
                                                            escape(data.text) +
                                                            "</div>"
                                                        );
                                                    }
                                                    return "<div>" + escape(data.text) + "</div>";
                                                },
                                                option: function(data, escape) {
                                                    if (data.customProperties) {
                                                        return (
                                                            '<div><span class="dropdown-item-indicator">' +
                                                            data.customProperties +
                                                            "</span>" +
                                                            escape(data.text) +
                                                            "</div>"
                                                        );
                                                    }
                                                    return "<div>" + escape(data.text) + "</div>";
                                                },
                                            },
                                        });
                                    }
                                });
                            </script>
                        </div>

                        <div class="mb-3">
                            <label>Tanggal Distribusi</label>
                            <input type="datetime-local" name="distributed_at" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Catatan</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>

                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Distribusi</button>
            </form>
        </div>
    </div>
@endsection
