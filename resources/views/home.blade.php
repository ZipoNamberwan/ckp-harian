@extends('main')

@section('stylesheet')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="/assets/vendor/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="/assets/vendor/datatables2/datatables.min.css" />
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
                    <h6 class="h2 text-white d-inline-block mb-0">Default</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-4 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Kegiatan Saya</h5>
                                    <span class="h2 font-weight-bold mb-0">{{count($myactivities)}}</span>
                                </div>
                                <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                    <i class="ni ni-chart-bar-32"></i>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <span class="text-nowrap">Hari Ini</span>
                            </p>
                        </div>
                    </div>
                </div>
                @hasrole('Admin|Coordinator|Chief')
                <div class="col-xl-4 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Kegiatan Staff</h5>
                                    <span class="h2 font-weight-bold mb-0">{{count($staffactivities)}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                        <i class="ni ni-active-40"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <span class="text-nowrap">Hari Ini</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Pegawai Sudah Mengentri</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$total_user_has_entried}}/{{$total_user}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                        <i class="ni ni-chart-pie-35"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <span class="text-nowrap">Hari Ini</span>
                            </p>
                        </div>
                    </div>
                </div>
                @endhasrole
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt--6">

    <div class="row">
        <div class="col">
            <div class="card-wrapper">
                <!-- Custom form validation -->
                @hasrole('Admin|Coordinator|Chief')
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header pb-0">
                        <div class="row mb-3">
                            <div class="col-md-7">
                                <h3>Daftar Pegawai Yang Belum Entri Kegiatan Hari Ini</h3>
                            </div>
                        </div>
                    </div>
                    <!-- Card body -->
                    @if(count($users_has_not_entried) > 0)

                    <div class="row">
                        <div class="col-12" id="row-table">
                            <div class="table-responsive">
                                <table class="table" id="datatable-id-2" width="100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Peran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users_has_not_entried as $user)
                                        <tr>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->getRoleNames()[0]}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="card-body">
                        <p>Semua Pegawai Sudah Mengentri Kegiatan Hari Ini</p>
                    </div>
                    @endif
                </div>
                @endhasrole
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header pb-0">
                        <div class="row mb-3">
                            <div class="col-md-7">
                                <h3>Daftar Kegiatan Saya Hari Ini</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12" id="row-table">
                            <div class="table-responsive">
                                <table class="table" id="datatable-id" width="100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jam</th>
                                            <th>Rencana Kinerja</th>
                                            <th>Kegiatan</th>
                                            <th>Capaian</th>
                                            <th>Progres</th>
                                            <th>Link Bukti Dukung</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
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
<script src="/assets/vendor/select2/dist/js/select2.min.js"></script>
<script src="/assets/vendor/sweetalert2/dist/sweetalert2.js"></script>
<script src="/assets/vendor/datatables2/datatables.min.js"></script>
<script src="/assets/vendor/momentjs/moment-with-locales.js"></script>

<script>
    var today = '{{$today}}';
    var table = $('#datatable-id').DataTable({
        "orderCellsTop": true,
        "order": [],
        "serverSide": true,
        "processing": true,
        // "responsive": true,
        "ajax": {
            "url": '/activities/data/false/{{Auth::user()->id}}/' + today + '/' + today + '',
            "type": 'GET',
        },
        "columns": [{
                "responsivePriority": 1,
                "width": "3%",
                "data": "date",
                "render": function(data, type, row) {
                    if (type === 'display') {
                        let localLocale = moment(data);
                        localLocale.locale('id');
                        return localLocale.format('LL')
                    }
                    return data;
                }
            },
            {
                "responsivePriority": 1,
                "width": "3%",
                "data": "time_start",
                "orderable": false,
                "render": function(data, type, row) {
                    if (type === 'display') {
                        return data.substring(0, 5) + "-" + (row.time_end).substring(0, 5);
                    }
                    return data;
                }
            },
            {
                "responsivePriority": 8,
                "width": "10%",
                "data": "activity_plan",
            },
            {
                "responsivePriority": 1,
                "width": "10%",
                "data": "activity_name",
            },
            {
                "responsivePriority": 1,
                "width": "10%",
                "data": "achievement",
            },
            {
                "responsivePriority": 1,
                "width": "5%",
                "data": "proggress",
                "render": function(data, type, row) {
                    if (type === 'display') {
                        return data + "%";
                    }
                    return data;
                }
            },
            {
                "responsivePriority": 1,
                "width": "5%",
                "data": "file",
                "orderable": false,
                "render": function(data, type, row) {
                    if (type === 'display') {
                        if (data === null || data === '') {
                            return "<h4 class='mb-0'><span class='badge badge-danger'> Belum Ada </span></h4>";
                        } else {
                            url = data
                            if (data.substring(0, 4) != 'http') {
                                url = '//' + data
                            }
                            return "<a target='_blank' href='" + url + "' class='btn btn-primary btn-round btn-sm btn-icon' data-toggle='tooltip' data-original-title='Link'>" +
                                "<span class='btn-inner--icon'><i class='ni ni-active-40'></i></span>" +
                                "<span class='btn-inner--text'>Link</span></a>"
                        }


                    }
                    return data;
                }
            },
            {
                "responsivePriority": 1,
                "width": "5%",
                "data": "id",
                "orderable": false,
                "render": function(data, type, row) {
                    return "<a href=\"/activities/" + data + "/edit\" class=\"btn btn-outline-info  btn-sm\" role=\"button\" aria-pressed=\"true\" data-toggle=\"tooltip\" data-original-title=\"Ubah Data\">" +
                        "<span class=\"btn-inner--icon\"><i class=\"fas fa-edit\"></i></span></a>" +
                        "<form class=\"d-inline\" id=\"formdelete" + data + "\" name=\"formdelete" + data + "\" onsubmit=\"deleteSchedule('" + data + "','" + row.activity_name + "')\" method=\"POST\" action=\"/activities/" + data + "\">" +
                        '@method("delete")' +
                        '@csrf' +
                        "<button class=\"btn btn-icon btn-outline-danger btn-sm\" type=\"submit\" data-toggle=\"tooltip\" data-original-title=\"Hapus Data\">" +
                        "<span class=\"btn-inner--icon\"><i class=\"fas fa-trash-alt\"></i></span></button></form>";
                }
            },
        ],
        // "initComplete": function() {
        //     var api = this.api();
        //     api.columns().eq(0).each(function(colIdx) {
        //         var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
        //         var title = $(cell).text();
        //         $(cell).html('<input class="form-control" type="text" placeholder="' + title + '" />');
        //         $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
        //             .off('keyup change')
        //             .on('keyup change', function(e) {
        //                 e.stopPropagation();
        //                 $(this).attr('title', $(this).val());
        //                 var regexr = '({search})'; //$(this).parents('th').find('select').val();
        //                 var cursorPosition = this.selectionStart;
        //                 api
        //                     .column(colIdx)
        //                     .search((this.value != "") ? regexr.replace('{search}', '(((' + this.value + ')))') : "", this.value != "", this.value == "")
        //                     .draw();
        //                 $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
        //             });
        //     });
        // },
        "language": {
            'paginate': {
                'previous': '<i class="fas fa-angle-left"></i>',
                'next': '<i class="fas fa-angle-right"></i>'
            }
        }
    });
</script>
@endsection