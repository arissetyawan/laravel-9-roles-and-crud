@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tiket Monitoring') }}</div>

                <div class="card-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col" class="col-1">#</th>
                        <th scope="col" class="col">Detail</th>
                        <th scope="col" class="col-2">Petugas</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tickets as $ticket)
                     <tr class="{{$ticket->get_class()}}" title="{{$ticket->priority->name}}" >
                        <td>{{ $loop->index+1 }}</td>
                        <td><b>{{ $ticket->category->name }}:</b> {!! $ticket->description !!}&nbsp;<b><sup style="padding: 2px;background-color: yellow">{{ $ticket->get_status_name() }}<small>({{ $ticket->last_status_at}} )</small></sup></b></td>
                        <td>{{ $ticket->get_assigned_name() }}</td>
                        <td>
                    </tr>
                    <tr title="{{$ticket->priority->name}}" >
                        <td></td>
                        <td colspan="3">
                        <small><i class="fa fa-calendar"></i> {{ $ticket->created_at->toDateTimeString() }}</small> oleh {{$ticket->get_reporter_name()}}.
                        @if($ticket->is_selesai())
                            <br />Rating
                            @for ($i = 1; $i < 6; $i++)
                              @if($i<=$ticket->rating)
                              <i class="fa fa-star" style="color: gold"></i>
                              @else
                              <i class="fa fa-star" style="color: grey"></i>
                              @endif
                            @endfor
                            <br />
                            Umpan Balik: {{ $ticket->rating_comment }}
                         @endif
                        </td>
                    </tr>
                @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $tickets->links('pagination.custom') }}
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    setInterval(function() {location.reload(true)}, 10000)
</script>

@endsection
