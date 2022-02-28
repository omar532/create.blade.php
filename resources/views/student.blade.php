@extends('layouts.test')

@section('content')

    <div class="row">
        @if(count($errors)> 0)
            <ul class="alter alert-danger">
                @foreach($errors->all as $errors)
                    <li>{{$errors}}</li>
                @endforeach
                }
                }
            </ul>
        @endif
        @if(\Session::has('success'))
            <div class="alert alert-success">
            <p>{{\Session::get('success')}}</p>
            </div>
        @endif
        <form method="post" action="studentC">


            <div class="form-group">
                <input type="text" name="first_name">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <input type="text" name="last_name">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary">

            </div>
        </form>

    </div>
@endsection