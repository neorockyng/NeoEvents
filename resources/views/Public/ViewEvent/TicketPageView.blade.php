@extends('Public.ViewEvent.Layouts.EventPage')

@section('content')
    
    @include('Public.ViewEvent.Partials.PDFTicket')
    @include('Public.ViewEvent.Partials.EventViewOrderSection')
    @include('Public.ViewEvent.Partials.EventFooterSection')
    
@stop
