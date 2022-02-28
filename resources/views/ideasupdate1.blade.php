@extends('layouts.test')

@section('content')
    @if(count($errors)> 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Update Ideas</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="container">

        <form method="post" action="{{route('UpdateIdeasText',$ideas->id)}}" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="card-body">
                                         <div class="form-group">
                                        <label for="exampleInputPassword1">Latitude</label>
                                        <label > {{$ideas->latitude}}</label>
                                    </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Longitude</label>
                                            <label > {{$ideas->longitude}}</label>
                                        </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Address</label>
                                        <input type = 'text' name = 'address' value  = "{{$ideas->address}}"/>

                                    </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Title </label>
                                            <input type = 'text' name = 'title' value  = "{{$ideas->title}}"/>
                                        </div>

                                        <div class="form-group">
                                        <label for="exampleInputFile">File Logo</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1"></label>
                                        <img style="width:150px;height: 150px;border-radius:500px;" src="{{asset($ideas->logo)}}" class="img-thumbnail"  />
                                    </div>

                                    <div class="form-group">
                                        <input type="file"  name="image" value  = "{{$ideas->address}}"/>
                                        <LABEL>{{asset($ideas->logo)}}</LABEL>
                                    </div>

                                </div>

                                               <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save Ideas</button>
                                </div>

        </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>

@endsection