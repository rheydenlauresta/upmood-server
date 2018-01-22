@extends('layouts.app')

@section('content')
    <div class="main-content">
        <users-component :results="{{ json_encode($results) }}" ></users-component>
    </div>
@endsection
