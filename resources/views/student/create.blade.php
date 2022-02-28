@extends('layouts.test')
@section('content')

    <style>
    body {
        background-image: url('{{asset('dist/img/user2-160x160.jpg')}}');

    }

</style>

    <div class="content">
        @yield('content')
        <div class="title m-b-md">
            <center> <H3>KidsBook</H3></center>

        </div>
    </div>

@endsection
