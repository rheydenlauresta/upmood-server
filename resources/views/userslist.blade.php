@extends('layouts.app')

@section('content')
    <div class="main-content">
        <users-component :results="{{ json_encode($results) }}" :countries="{{ json_encode($countries)}}" ></users-component>
    </div>
@endsection
