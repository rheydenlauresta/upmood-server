@extends('layouts.app')

@section('content')
    <div class="main-content">
        <dashboard :users="{{ json_encode($users_activity) }}" :countries="{{ json_encode($countries) }}"></dashboard>
    </div>
@endsection
