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
                                <h3 class="card-title">New User</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->

                            <form method="post" action="{{route('SaveUser')}}" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Name">

                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Mail</label>
                                        <input type="mail" name="email" class="form-control" placeholder="Mail">
                                    </div>
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password" class="col-md-4 control-label">Password</label>

                                        <div class="form-group">
                                            <input id="password" type="password" class="form-control" name="password" required>

                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                        <div class="form-group">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Role</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <select name="role"  class="form-control">
                                                        <option value="User">User</option>
                                                        <option value="Admin">Admin</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>


                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection