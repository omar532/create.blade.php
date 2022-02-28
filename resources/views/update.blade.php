@extends('layouts.test')

@section('content')

        <center><h1>Update Student</h1></center>
        <table border="1" class="display" id="myTable">
                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
            <thead>
            <th>Image</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Action</th>
            </thead>
            <tbody>
            <tr>
                <td><img style="width:150px;height: 150px;border-radius:500px;" src="{{asset($student->image)}}" class="img-thumbnail"  /></td>
                <td><label > {{$student->first_name}}</label></td>
                <td>  <label > {{$student->last_name}}</label></td>

                <td><a class="btn btn-app" href="{{route('UpdateStudentName',$student->id)}}">Update</a> </td>

            </tr>

            </tbody>
  </table>


    <center><h1>liste Image</h1></center>
    <table border="1" class="display" id="myTable1">
        <thead>
        <th>Image</th>
        <th>Action</th>
        </thead>
        <tbody>


        @foreach ($images as $image)

            <tr>
            <td><img style="width:150px;height: 150px;border-radius:500px;" src="{{asset($image->path)}}" class="img-thumbnail"  /></td>
                <td><form action = "{{route('archive',$image->id)}}" method = "post">
                        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                        <button Onclick="return ConfirmDelete();" type="submit"
                                name="actiondelete" value="1"><img style="width:20px;height:20px;border-radius:20px;" src="{{asset('dist/img/del-160x160.jpg')}}" alt="Delete"></button>
                    </form></td>            </tr>
        @endforeach
        </tbody>
        <tr>
            <td><h3>Input New Image</h3></td><td>
            <form action = "{{route('UpdateStudent',$student->id)}}" method = "post" enctype="multipart/form-data">
                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                <input type="file" name="image" class="form-control">
                <input type="submit" class="btn btn-primary">
            </form></td>
        </tr>
    </table>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
    <script>
        $(document).ready( function () {
            $('#myTable1').DataTable();
        } );
    </script>
        <script>
            function ConfirmDelete()
            {
                var x = confirm("Are you sure you want to delete?");
                if (x)
                    return true;
                else
                    return false;
            }
        </script>
@endsection
