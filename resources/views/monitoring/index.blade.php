@extends('main')

@section('stylesheet')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <link rel="stylesheet" href="/assets/vendor/select2/dist/css/select2.min.css"> -->
<link rel="stylesheet" href="/assets/vendor/datatables2/datatables.min.css" />
<link rel="stylesheet" href="/assets/vendor/@fortawesome/fontawesome-free/css/fontawesome.min.css" />
<link rel="stylesheet" href="/assets/css/container.css">
<link rel="stylesheet" href="/assets/css/text.css">
<link rel="stylesheet" href="/assets/vendor/select2/dist/css/select2.min.css">

@endsection

@section('container')
<div class="header bg-success pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Monitoring</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt--6">

    @if (session('success-edit') || session('success-create'))
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <span class="alert-icon"><i class="fas fa-check-circle"></i></span>
        <span class="alert-text"><strong>Sukses! </strong>{{ session('success-create') }} {{ session('success-edit') }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    @endif

    @if (session('success-delete'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span class="alert-icon"><i class="fas fa-check-circle"></i></span>
        <span class="alert-text"><strong>Sukses! </strong>{{ session('success-delete') }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    @endif

    <div class="row">
        <div class="col">
            <div class="card-wrapper">
                <!-- Custom form validation -->
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header pb-0">
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <h3>Monitoring Kegiatan Harian</h3>
                                <p class="mb-0"> <small>*Tabel ini menunjukkan daftar kegiatan pegawai</small></p>
                                <p class="mb-0"> <small>*Gunakan kotak search untuk melakukan pencarian bersarkan nama pegawai, rencana kinerja, kegiatan atau capaian</small></p>
                                <p class="mb-0"> <small>*Tabel bisa discroll ke kanan-kiri (tampilan mobile)</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h4>Filter</h4>
                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="col-md-3">
                                <label class="form-control-label" for="user">Pegawai</label>
                                <select onchange="userChange()" class="form-control d-inline" data-toggle="select" name="user" id="user">
                                    <option value="all">Semua Pegawai</option>
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col">
                                        <label class="form-control-label" for="subround">Mulai</label>
                                        <input onchange="startChange()" name="start" id="start" class="form-control" placeholder="Mulai" type="date">
                                    </div>
                                    <div class="col">
                                        <label class="form-control-label" for="subround">Selesai</label>
                                        <input onchange="endChange()" name="end" id="end" class="form-control" placeholder="Selesai" type="date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3">
                                <button onclick="getData()" class="btn btn-primary d-inline mb-2" type="button">
                                    <span class="btn-inner--icon"><i class="fas fa-eye"></i></span>
                                    <span class="btn-inner--text">Tampilkan</span>
                                </button>
                                <form id="downloadform" class="d-inline" method="POST" action="/activities/download" data-toggle="tooltip" data-original-title="Unduh Jadwal Panen">
                                    @csrf
                                    <input type="hidden" name="monitoringhidden" value="true">
                                    <input type="hidden" name="userhidden" id="userhidden" value="all">
                                    <input type="hidden" name="starthidden" id="starthidden" value="all">
                                    <input type="hidden" name="endhidden" id="endhidden" value="all">
                                    <button onclick="downloadData()" class="btn btn-icon btn-outline-primary mb-2" type="submit">
                                        <span class="btn-inner--icon"><i class="fas fa-download"></i></span>
                                        <span class="btn-inner--text">Download</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="d-flex">
                                    <p class="mr-3 mb-0"><small>Filter yang diterapkan:</small> </p>
                                    <p id="no-filter" class="mb-0"><small>Tidak ada filter</small></p>
                                    <h4 id="user-filter" class='mb-0' style="display: none;"><span class='badge badge-info mr-1'> Belum Ada </span></h4>
                                    <h4 id="start-filter" class='mb-0' style="display: none;"><span class='badge badge-info mr-1'> Belum Ada </span></h4>
                                    <h4 id="end-filter" class='mb-0' style="display: none;"><span class='badge badge-info mr-1'> Belum Ada </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="row-table">
                            <div class="table-responsive">
                                <table class="table" id="datatable-id" width="100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Nama</th>
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
<script src="/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
    // $('#datatable-id thead tr')
    //     .clone(true)
    //     .addClass('filters')
    //     .appendTo('#datatable-id thead');

    var table = $('#datatable-id').DataTable({
        "orderCellsTop": true,
        "order": [],
        "serverSide": true,
        "processing": true,
        // "responsive": true,
        "ajax": {
            "url": '/activities/data/true/all/all/all',
            "type": 'GET',
        },
        "columns": [{
                "responsivePriority": 8,
                "width": "10%",
                "data": "user_name",
            }, {
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
                    return "<a href=\"/activities/" + data + "\" class=\"btn btn-outline-success  btn-sm\" role=\"button\" aria-pressed=\"true\" data-toggle=\"tooltip\" data-original-title=\"Ubah Data\">" +
                        "<span class=\"btn-inner--icon\"><i class=\"fas fa-eye\"></i></span></a>";
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

    function getUrl() {
        var e = document.getElementById('user');
        var user = e.options[e.selectedIndex].value;
        var start = 'all'
        if (document.getElementById('start').value != null && document.getElementById('start').value != '') {
            start = document.getElementById('start').value;
        }
        var end = 'all'
        if (document.getElementById('end').value != null && document.getElementById('end').value != '') {
            end = document.getElementById('end').value;
        }

        return '/true/' + user + "/" + start + "/" + end;
    }

    function userChange() {
        var e = document.getElementById('user');
        document.getElementById('userhidden').value = e.options[e.selectedIndex].value;
    }

    function startChange() {
        var start = 'all'
        if (document.getElementById('start').value != null && document.getElementById('start').value != '') {
            start = document.getElementById('start').value;
        }
        document.getElementById('starthidden').value = start
    }

    function endChange() {
        console.log('djasda')

        var end = 'all'
        if (document.getElementById('end').value != null && document.getElementById('end').value != '') {
            end = document.getElementById('end').value;
        }
        document.getElementById('endhidden').value = end
    }

    function downloadData() {
        event.preventDefault()
        document.getElementById('downloadform').submit()
    }

    function getData() {
        table.ajax.url('/activities/data' + getUrl()).load()
        showHideFilter()
    }

    function showHideFilter() {
        if (document.getElementById('user').value != 'all') {
            document.getElementById('no-filter').style.display = 'none'
            document.getElementById('user-filter').style.display = 'block'
            document.getElementById('user-filter').innerHTML = "<h4 class='mb-0'><span class='badge badge-info mr-1'> " + document.getElementById('user').options[document.getElementById('user').selectedIndex].innerHTML + " </span></h4>"
        } else {
            document.getElementById('user-filter').style.display = 'none'
        }
        if (document.getElementById('start').value != null && document.getElementById('start').value != '') {
            document.getElementById('no-filter').style.display = 'none'
            document.getElementById('start-filter').style.display = 'block'
            document.getElementById('start-filter').innerHTML = "<h4 class='mb-0'><span class='badge badge-info mr-1'> " + getDate(document.getElementById('start').value) + " </span></h4>"
        } else {
            document.getElementById('start-filter').style.display = 'none'
        }
        if (document.getElementById('end').value != null && document.getElementById('end').value != '') {
            document.getElementById('no-filter').style.display = 'none'
            document.getElementById('end-filter').style.display = 'block'
            document.getElementById('end-filter').innerHTML = "<h4 class='mb-0'><span class='badge badge-info mr-1'> " + getDate(document.getElementById('end').value) + " </span></h4>"
        } else {
            document.getElementById('end-filter').style.display = 'none'
        }
    }

    function getDate(date) {
        let localLocale = moment(date);
        localLocale.locale('id');
        return localLocale.format('LL')
    }
</script>

<script>
    function deleteSchedule(id, name) {
        event.preventDefault();
        Swal.fire({
            title: 'Yakin Hapus Kegiatan Ini?',
            text: name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formdelete' + id).submit();
            }
        })
    }
</script>

@endsection