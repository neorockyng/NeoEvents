@extends('ManageUser.Layouts.Master')

@section('title')
    @parent
    {{ trans('User.dashboard') }}
@endsection

@section('top_nav')
    @include('ManageUser.Partials.TopNav')
@stop
@section('page_title')

@stop

@section('menu')
    @include('ManageUser.Partials.Sidebar')
@stop

@section('head')

    
@stop

@section('content')
<div class="row">
    <div class="col-sm-6">
        <div class="stat-box bg-primary">
            <h3>{{ $events->count() }}</h3>
            <span>Upcoming Events</span>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="stat-box bg-success">
            <h3>{{ $events->sum(fn($tickets) => $tickets->sum('quantity')) }}</h3>
            <span>Total Tickets</span>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <h4>Tickets for Upcoming Events</h4>
        @if ($events->isEmpty())
            <p>No tickets found for upcoming events.</p>
        @else
            @foreach ($events as $eventId => $tickets)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>{{ $tickets->first()->event_title }}</h5>
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($tickets->first()->start_date)->format('d M Y, h:i A') }}</p>
                        <p><strong>Venue:</strong> {{ $tickets->first()->venue_name }}</p>
                        <h6>Tickets:</h6>
                        <ul>
                            @foreach ($tickets as $ticket)
                                <li>
                                    {{ $ticket->ticket_title }} ({{ $ticket->quantity }} x ${{ number_format($ticket->unit_price, 2) }})
                                    <a href="{{ route('showOrderTickets', ['order_reference' => $ticket->order_reference, 'ticket_id' => $ticket->ticket_id, 'download' => 1]) }}" class="btn btn-link">
                                        Download Ticket
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="col-md-4">
        <h4>Event Details</h4>
        @if ($events->isEmpty())
            <p>No upcoming events found.</p>
        @else
            <ul class="list-group">
                @foreach ($events as $eventId => $tickets)
                    <li class="list-group-item">
                        <h5>{{ $tickets->first()->event_title }}</h5>
                        <p>Date: {{ \Carbon\Carbon::parse($tickets->first()->start_date)->format('d M Y, h:i A') }}</p>
                        <p>Venue: {{ $tickets->first()->venue_name }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@stop
