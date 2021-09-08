<!DOCTYPE html>
<html>

<head>
    <title>Manage Event</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.17/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.17/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>

<body class="bg-dark">
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-header">
                        <div class="col-md-12">
                            <h4 class="card-title">Manage Event
                                <a class="btn btn-success ml-5" href="javascript:void(0)" id="createNewEvent"> Create New Event</a>
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('layouts.errors-and-messages')
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th>Title</th>
                                    <th>Dates</th>
                                    <th>Occurences</th>
                                    <th width="25%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="ajaxModel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="modelHeading"></h4>
                                </div>
                                <div class="modal-body">
                                    <form id="EventForm" name="EventForm" class="form-horizontal">
                                        <input type="hidden" name="Event_id" id="Event_id">

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 control-label">Title</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="" maxlength="50" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="col-sm-4 control-label">Start Date</label>
                                            <div class="col-sm-12">
                                                <input type="date" class="form-control" id="start_date" name="start_date" value="" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="col-sm-4 control-label">End Date</label>
                                            <div class="col-sm-12">
                                                <input type="date" class="form-control" id="end_date" name="end_date" value="" required="">
                                            </div>
                                        </div>

                                        <?php
                                            use Illuminate\Support\Facades\Config;

                                            // Get event config data
                                            $eventConfiggurations = Config::get('eventconfig.recurrence1');
                                            $eventConfiggurationsRecurrence2 = Config::get('eventconfig.recurrence2');
                                        ?>
                                        <div class="form-row">
                                            <div class="form-group col-sm-6">
                                                <label for="recurrence_1">Reccurence </label>
                                                <select class="form-control" name="recurrence_1" id="recurrence_1">
                                                    @foreach($eventConfiggurations as $config)
                                                    <option value="{{ $config }}">{{ $config }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label for="recurrence_2">Reccurence </label>
                                                <select class="form-control" name="recurrence_2" id="recurrence_2">
                                                    @foreach($eventConfiggurationsRecurrence2 as $config)
                                                    <option value="{{ $config }}">{{ $config }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-offset-4 col-sm-10">
                                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                    <br/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('events.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'start_date',
                    name: 'start_date'
                },
                {
                    data: 'recurrence_1',
                    name: 'recurrence_1'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#createNewEvent').click(function() {
            $('#saveBtn').val("create-Event");
            $('#Event_id').val('');
            $('#EventForm').trigger("reset");
            $('#modelHeading').html("Create New Event");
            $('#ajaxModel').modal('show');
        });

        $('body').on('click', '.editEvent', function() {
            var Event_id = $(this).data('id');
            $.get("{{ route('events.index') }}" + '/' + Event_id + '/edit', function(data) {
                $('#modelHeading').html("Edit Event");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#Event_id').val(data.id);
                $('#title').val(data.title);
                $('#start_date').val(data.start_date);
                $('#end_date').val(data.end_date);
                $('#recurrence_1').val(data.recurrence_1);
                $('#recurrence_2').val(data.recurrence_2);
            })
        });

        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#EventForm').serialize(),
                url: "{{ route('events.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#EventForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            });
        });

        $('body').on('click', '.deleteEvent', function() {

            var Event_id = $(this).data("id");
            confirm("Are You sure want to delete !");

            $.ajax({
                type: "DELETE",
                url: "{{ route('events.store') }}" + '/' + Event_id,
                success: function(data) {
                    table.draw();
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });

    });
</script>

</html>