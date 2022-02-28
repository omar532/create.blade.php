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
    @if(\Session::has('success'))
        <div class="alert alert-success">
            <p>{{\Session::get('success')}}</p>
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
                        <h3 class="card-title">New Student</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <form method="post" action="{{route('storeProduct')}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">First Name</label>
                                <input type="text" name="first_name" class="form-control" placeholder="first_name">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Last Name</label>
                                <input type="text" name="last_name" class="form-control" placeholder="last_name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">File image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file"  name="image" class="form-control">
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputFile">File images</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file"  multiple name="images[]" class="form-control">
                                    </div>

                                </div>
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
</section>
</div>
@endsection