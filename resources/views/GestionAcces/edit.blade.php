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
    <center><h1>Update Utilisateur</h1>
        <section>
            <form method="post" action={{route('Edit',$users->id)}}>
                <table class="display" id="myTable">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                       <tr>
                            <td><label>{{$users->id}}</label></td>
                            <td><input type="text" name="name" value="{{($users->name)}}"/></td>
                            <td><select name="role" multiple size="3">
                                    <optgroup label="{{$users->role}}">
                                        <option value="User">User</option>
                                        <option value="Admin">Admin</option></optgroup>
                                    <option value="{{$users->role}}" type="hidden" selected></option>
                                </select></td>
                           <td><button type="submit" class="btn btn-primary">Save User</button>
                           </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </section>
    </center>
    </div>
    <!-- /.content -->

    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>

@endsection