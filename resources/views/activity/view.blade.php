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
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
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
                        <h3 class="mb-0">Detail Kegiatan</h3>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mt-3">
                                <label class="form-control-label" for="exampleDatepicker">Nama Pegawai</label>
                                <input disabled style="background-color: transparent;" name="user" class="form-control" type="text" id="user" value="{{$activity->user->name}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mt-3">
                                <label class="form-control-label" for="exampleDatepicker">Tanggal</label>
                                <input disabled style="background-color: transparent;" name="date" class="form-control" type="text" id="date">
                            </div>
                            <div class="col-md-4 mt-3">
                                <label class="form-control-label">Waktu</label>
                                <div class="row">
                                    <div class="col">
                                        <input disabled style="background-color: transparent;" name="time_start" class="form-control" type="text" value="{{ substr($activity->time_start, 0, 5) }}">
                                    </div>
                                    <div class="col">
                                        <input disabled style="background-color: transparent;" name="time_end" class="form-control" type="text" value="{{ substr($activity->time_end, 0, 5) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mt-3">
                                <label class="form-control-label" for="activity_plan">Rencana Kinerja</label>
                                <textarea disabled style="background-color: transparent;" name="activity_plan" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $activity->activity_plan }}</textarea>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label class="form-control-label" for="activity_name">Kegiatan</label>
                                <textarea disabled style="background-color: transparent;" name="activity_name" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $activity->activity_name }}</textarea>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label class="form-control-label" for="achievement">Capaian</label>
                                <textarea disabled style="background-color: transparent;" name="achievement" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $activity->achievement }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mt-3">
                                <label class="form-control-label" for="proggress">Progres</label>
                                <input disabled style="background-color: transparent;" min="1" max="100" type="number" name="proggress" class="form-control" id="validationCustom03" value="{{ $activity->proggress }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mt-3">
                                <label class="form-control-label" for="file">Link Bukti Dukung</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                @if($activity->file != null)
                                <a id="file" target='_blank' href="" class='btn btn-primary btn-round btn-sm btn-icon' data-toggle='tooltip' data-original-title='Link'>
                                    <span class='btn-inner--icon'><i class='ni ni-active-40'></i></span>
                                    <span class='btn-inner--text'>Klik Di Sini</span>
                                </a>
                                @else
                                <h4 class='mb-0'><span class='badge badge-danger'> Link Belum Ada </span></h4>
                                @endif
                            </div>
                        </div>
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
<script src="/assets/vendor/momentjs/moment-with-locales.js"></script>

<script>
    function getDate(date) {
        let localLocale = moment(date);
        localLocale.locale('id');
        return localLocale.format('LL')
    }

    function getUrl(data) {
        url = data
        if (data.substring(0, 4) != 'http') {
            url = '//' + data
        }
        return url
    }

    document.getElementById('date').value = getDate('{{ $activity->date }}')
    document.getElementById('file').href = getUrl('{{ $activity->file }}')
</script>
@endsection