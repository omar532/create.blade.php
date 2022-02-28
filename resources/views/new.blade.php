@extends('layouts.test')

@section('content')
    @if(\Session::has('success'))
    <div class="alert alert-success">
<p>{{\Session::get('success')}}</p>
</div>
     @endif
        <div class="title m-b-md">
                    KidsBook   {{date('y-m-d H:i:s')}}

                </div>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
<div class="box">

            <center><h3 >Liste des Étudiants </h3></center>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>

                <th>Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Image</th>
                <th>DateC</th>
                <th>DateU</th>
                <th>Action</th>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
         <td>{{$user->id}}</td>
         <td>{{$user->first_name}}</td>
         <td>{{$user->last_name}}</td>
         <td>
             <img style="width:150px;height: 150px;border-radius:500px;" src="{{asset($user->image)}}" class="img-thumbnail"  />

         </td>
         <td>{{$user->created_at}}</td>
         <td>{{$user->updated_at}}</td>
         <td><a href = '{{route("showStudent",$user->id)}}'>Edit</a>
             <form action = "{{route("deleteStudent",$user->id)}}" method = "post">
                 <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                 <button Onclick="return ConfirmDelete();" type="submit"
                         name="deleteStudent" value="1"><img style="width:20px;height:20px;border-radius:20px;" src="{{asset('dist/img/del-160x160.jpg')}}" alt="Delete"></button>
             </form></td>

         @endforeach
     </tr>
      </tbody>
        <tfoot>
        <tr>
            <th>Id</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Image</th>
            <th>DateC</th>
            <th>DateU</th>
            <th>Action</th>
        </tr>
        </tfoot>
    </table>
            <script>
                $(function () {
                    $("#example1").DataTable({
                        "responsive": true,
                        "autoWidth": false,
                    });
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "responsive": true,
                    });
                });
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
