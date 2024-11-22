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
            <h3>{{ $orderCount }}</h3>
            <span>Total Orders</span>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="stat-box bg-success">
            <h3>{{ $ticketCount }}</h3>
            <span>Total Tickets</span>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <h4>Order Details</h4>
        <div class="card">
            <div class="card-body">
                @if ($orders->isEmpty())
                    <p>No orders found.</p>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Event Title</th>
                                <th>Tickets</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->event->title ?? 'N/A' }}</td>
                                    <td>{{ $order->attendees->count() }}</td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <h4>Upcoming Events</h4>
        <div class="card">
            <div class="card-body">
                @if ($upcomingEvents->isEmpty())
                    <p>No upcoming events found.</p>
                @else
                    <ul class="list-group">
                        @foreach ($upcomingEvents as $event)
                            <li class="list-group-item">
                                <h5>{{ $event->title }}</h5>
                                <p>Date: {{ Carbon\Carbon::parse($event->start_date)->format('d M Y, h:i A') }}</p>
                                <p>Venue: {{ $event->venue_name }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@stop
