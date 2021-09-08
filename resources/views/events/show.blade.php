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
    
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-header">
                        <div class="col-md-12">
                            <h4 class="card-title">Event View Page
                            </h4>
                        </div>

                        <div class="col-md-12">
                            <h5>Event Title : {{ $event->title }} </h5> 
                            <h5>Event Occurences : {{ $event->recurrence_1. " ". $event->recurrence_2 }} </h5> 
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th>Date</th>
                                    <th>Day Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $event->id }}</td>
                                    <td>{{ date('d-M-Y', strtotime($event->start_date)) }}</td>
                                    <td>{{ $event->recurrence_1 . " ". $event->recurrence_2}}</td>
                                </tr>
                            </tbody>
                        </table>
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

        var table = $('.data-table1').DataTable({
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
                    orderable: false,
                    searchable: false
                },
            ]
        });

    });
</script>

</html>