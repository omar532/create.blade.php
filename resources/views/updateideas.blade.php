@extends('layouts.test')

@section('content')

    <center><h1>Update Ideas</h1></center>
    <table border="1" class="display" id="myTable">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
        <thead>
        <th>Logo</th>
        <th>Address</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th>Title</th>
      </thead>
        <tbody>
        <tr>
            <td><img style="width:150px;height: 150px;border-radius:500px;" src="{{asset($ideas->logo)}}" class="img-thumbnail"  /></td>
            <td><label > {{$ideas->address}}</label></td>
            <td>  <label > {{$ideas->latitude}}</label></td>
            <td><label > {{$ideas->longitude}}</label></td>
            <td><label > {{$ideas->title}}</label></td>
            <td><a href = '{{route('UpIdeas',$ideas->id)}}'>Input</a></td>
        </tr>
        </tbody>
    </table>


    <center><h1>liste Logo Ideas</h1></center>
    <table border="1" class="display" id="myTable1">
        <thead>
        <th>Logo</th>
        <th>Action</th>
        </thead>
        <tbody>
        @foreach($ideas_img as $image)
            <tr>
                <td><img style="width:150px;height: 150px;border-radius:500px;" src="{{asset($image->path)}}" class="img-thumbnail"  /></td>
                <td><form action = "{{route('Archives',$image->id)}}" method = "post">
                        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                        <button Onclick="return ConfirmDelete();" type="submit"
                                name="actiondelete" value="1"><img style="width:20px;height:20px;border-radius:20px;" src="{{asset('dist/img/del-160x160.jpg')}}" alt="Delete"></button>
                    </form></td>            </tr>
        @endforeach
        </tbody>
        <tr>
            <td><h3>Input New Image</h3></td><td>
                <form action = "{{route('InputStudent',$ideas->id)}}" method = "post" enctype="multipart/form-data">
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
