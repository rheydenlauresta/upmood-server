@extends('layouts.app')

@section('content')
    <div class="main-content">
        <users-component :results="{{ json_encode($results) }}" :filters="{{ json_encode($filters) }}"></users-component>
    </div>
@endsection
