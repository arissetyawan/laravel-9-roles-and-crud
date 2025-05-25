@extends('layouts.app')

@section('content')
<center>
<h5>Selamat Datang, <b>{{Auth::user()->name}}</b></h5>
</center>
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
            <div class="card-header fw-bold">{{ __('Statistik Kinerja Petugas') }}</div>
            <div class="card-body">
                <table class="table table-hover table-bordered table-responsive">
                    <thead>
                    <tr>
                        <th scope="col" class="col-1">#</th>
                        <th scope="col" class="col">Petugas</th>
                        <th scope="col" colspan="2" style="vertical-align: top;"class="text-center col">Tiket</th>
                        <th scope="col" colspan="3" style="vertical-align: top;"class="text-center col">Rating</th>
                    </tr>
                    <tr>
                        <th scope="col" class="col-1"></th>
                        <th scope="col" class="col"></th>
                        <th scope="col" class="col text-center ">Total</th>
                        <th scope="col" class="col text-center ">Bobot</th>
                        <th scope="col" class="text-center col">Min</th>
                        <th scope="col" class="text-center col">Max</th>
                        <th scope="col" class="col text-center">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td><a href="/ticket?assigned_id={{$user['id']}}'">{{ $user['name'] }}</td>
                            <td class="text-center ">{{ $user['ticket'] }}</td>
                            <td class="text-center ">{{ $user['bobot'] }}</td>
                            <td class="text-center">{{ $user['min_rating'] }}</td>
                            <td class="text-center">{{ $user['max_rating'] }}</td>
                            <td>{{ $user['rating'] }}  ({{ $user['rating_percentage'] }}%)</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center"><br /></div>

    <div class="row justify-content-center">

        @if(Auth::user()->role->name=='petugas')
        <div class="col-md-6">
            <div class="card">

                <div class="card-header fw-bold">{{ __('Tiket Tugas') }}({{ $counter_assigned }})</div>
                <div class="card-body">

                    <table class="table table-hover table-responsive">
                        <thead>
                        <tr>
                            <th scope="col" class="col-1">#</th>
                            <th scope="col" class="col">Detail</th>
                            <th scope="col" class="col-1"></th>
                        </tr>
                        </thead>
                        <tbody>

                            @foreach($tickets_assigned as $ticket)
                            <tr class="{{$ticket->get_class()}}" title="{{$ticket->priority->name}}" >
                                <td>{{ $loop->index+1 }}</td>
                                <td><b>{{ $ticket->category->name }}:</b> {!! $ticket->description !!}&nbsp;<b><sup style="padding: 2px;background-color: yellow">{{ $ticket->get_status_name() }}
                                    @if(!$ticket->is_new())
                                    <small>({{ $ticket->last_status_at}})</small>
                                    @endif</sup></b></td>
                                <td>
                                    <a href="{{ Route('ticket/edit',$ticket->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                            <tr title="{{$ticket->priority->name}}" >
                                <td></td>
                                <td colspan="2">
                                <small><b>#{{$ticket->get_code()}}</b>&nbsp;<i class="fa fa-calendar"></i> {{ $ticket->created_at->toDateTimeString() }}</small> oleh {{$ticket->get_reporter_name()}}.
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
                        {{ $tickets_assigned->links('pagination.custom') }}
                    </div>
                    <hr />
                </div>

            </div>
        </div>
        @endif

        <div class="col-md-6">
            <div class="card">
                <div class="card-header fw-bold">{{ __('Tiket Laporan') }}({{ $counter_reported }})</div>
                <div class="card-body">

                    <table class="table table-hover table-responsive">
                        <thead>
                        <tr>
                            <th scope="col" class="col-1">#</th>
                            <th scope="col" class="col">Detail</th>
                            <th scope="col" class="col-2">Petugas</th>
                            <th scope="col" class="col-1"></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($tickets_reported as $ticket)
                            <tr class="{{$ticket->get_class()}}" title="{{$ticket->priority->name}}" >
                                <td>{{ $loop->index+1 }}</td>
                                <td><b>{{ $ticket->category->name }}:</b> {!! $ticket->description !!}&nbsp;<b><sup style="padding: 2px;background-color: yellow">{{ $ticket->get_status_name() }}
                                    @if(!$ticket->is_new())
                                    <small>({{ $ticket->last_status_at}})</small>
                                    @endif</sup></b></td>
                                <td>{{ $ticket->get_assigned_name() }}</td>
                                <td>
                                    <a href="{{ Route('ticket/edit',$ticket->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                            <tr title="{{$ticket->priority->name}}" >
                                <td></td>
                                <td colspan="3">
                                <small><b>#{{$ticket->get_code()}}</b>&nbsp;<i class="fa fa-calendar"></i> {{ $ticket->created_at->toDateTimeString() }}</small> oleh {{$ticket->get_reporter_name()}}.
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
                        {{ $tickets_reported->links('pagination.custom') }}
                    </div>
                    <hr />
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    setInterval(function() {location.reload(true)}, 10000)
</script>

@endsection
