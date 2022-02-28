@extends('layouts.test')

@section('content')
    <div class="container">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Update Student</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="container">

        <form method="post" action="{{route('UpdateStudent',$student->id)}}" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">


                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">First Name</label>
                                        <input type = 'text' name = 'first_name' value  = "{{$student->first_name}}"/>

                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Last Name</label>
                                        <input type = 'text' name = 'last_name' value = "{{$student->last_name}}"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">File image</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1"></label>
                                        <img style="width:150px;height: 150px;border-radius:500px;" src="{{asset($student->image)}}" class="img-thumbnail"  />
                                    </div>

                                    <div class="form-group">
                                        <input type="file"  name="image" value  = "{{$student->first_name}}"/>
                                        <LABEL>{{$student->image}}</LABEL>
                                    </div>

                                    </div>

                                               <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save Student</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>

@endsection