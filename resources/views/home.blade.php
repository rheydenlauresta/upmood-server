@extends('layouts.app')

@section('content')
    <div class="main-content">
        <dashboard :users="{{ json_encode($users_activity) }}" :countries="{{ json_encode($countries) }}" :inquiries="{{ json_encode($inquiries) }}"></dashboard>
    </div>
@endsection
