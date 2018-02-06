@extends('layouts.app')
 
 @section('content')
    <div class="main-content">
        <usersprofile-component :profile="{{ json_encode($profile) }}" :records="{{ json_encode($records) }}" :featured="{{ json_encode($featured) }}"></usersprofile-component>
     </div>
 @endsection