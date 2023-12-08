@extends('main')

@section('stylesheet')
<link rel="stylesheet" href="/assets/vendor/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="/assets/vendor/@fortawesome/fontawesome-free/css/fontawesome.min.css" />
<link rel="stylesheet" href="/assets/css/container.css">
<link rel="stylesheet" href="/assets/css/text.css">

@endsection

@section('container')
<div class="header bg-success pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="/activities">Kegiatan Harian</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card-wrapper">
                <!-- Custom form validation -->
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h3 class="mb-0">Tambah Kegiatan</h3>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <form id="formupdate" autocomplete="off" method="post" action="/activities" class="needs-validation" enctype="multipart/form-data" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mt-3">
                                    <label class="form-control-label" for="exampleDatepicker">Tanggal <span class="text-danger">*</span></label>
                                    <input name="date" class="form-control @error('date') is-invalid @enderror" placeholder="Select date" type="date" value="{{ @old('date') }}">
                                    @error('date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label class="form-control-label">Waktu <span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col">
                                            <select id="time_start" name="time_start" class="form-control" data-toggle="select" name="time_start" required>
                                                <option value="0" disabled selected> -- Mulai -- </option>
                                                @for($i=7; $i<22; $i++) <option value="{{$i}}" {{ old('time_start') == $i ? 'selected' : '' }}>{{sprintf('%02d', $i)}}:00</option>
                                                    @endfor
                                            </select>
                                            @error('time_start')
                                            <div class="text-valid mt-2">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col">
                                            <select id="time_end" name="time_end" class="form-control" data-toggle="select" name="time_end" required>
                                                <option value="0" disabled selected> -- Selesai -- </option>
                                                @for($i=7; $i<22; $i++) <option value="{{$i}}" {{ old('time_end') == $i ? 'selected' : '' }}>{{sprintf('%02d', $i)}}:00</option>
                                                    @endfor
                                            </select>
                                            @error('time_end')
                                            <div class="text-valid mt-2">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mt-3">
                                    <label class="form-control-label" for="activity_plan">Rencana Kinerja <span class="text-danger">*</span></label>
                                    <textarea name="activity_plan" class="form-control @error('activity_plan') is-invalid @enderror" id="exampleFormControlTextarea1" rows="3">{{ @old('activity_plan') }}</textarea>
                                    @error('activity_plan')
                                    <div class="error-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label class="form-control-label" for="activity_name">Kegiatan <span class="text-danger">*</span></label>
                                    <textarea name="activity_name" class="form-control @error('activity_name') is-invalid @enderror" id="exampleFormControlTextarea1" rows="3">{{ @old('activity_name') }}</textarea>
                                    @error('activity_name')
                                    <div class="error-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label class="form-control-label" for="achievement">Capaian <span class="text-danger">*</span></label>
                                    <textarea name="achievement" class="form-control @error('achievement') is-invalid @enderror" id="exampleFormControlTextarea1" rows="3">{{ @old('achievement') }}</textarea>
                                    @error('achievement')
                                    <div class="error-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mt-3">
                                    <label class="form-control-label" for="proggress">Progres <span class="text-danger">*</span></label>
                                    <input min="1" max="100" type="number" name="proggress" class="form-control @error('proggress') is-invalid @enderror" id="validationCustom03" value="{{ @old('proggress') }}">
                                    @error('proggress')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mt-3">
                                    <label class="form-control-label" for="file">Link Bukti Dukung</label>
                                    <input type="text" name="file" class="form-control @error('file') is-invalid @enderror" id="validationCustom03" value="{{ @old('file') }}">
                                    @error('file')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <button class="btn btn-primary mt-3" id="submit" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('optionaljs')
<script src="/assets/vendor/sweetalert2/dist/sweetalert2.js"></script>
<script src="/assets/vendor/select2/dist/js/select2.min.js"></script>

@endsection