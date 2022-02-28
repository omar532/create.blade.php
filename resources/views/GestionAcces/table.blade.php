@extends('layouts.test')
@section('content')
    @if(\Session::has('success'))
        <div class="alert alert-success">
            <p>{{\Session::get('success')}}</p>
        </div>
    @endif
    <center><h1>Gestion des utilisateurs</h1>
    <section>
      <table class="display" id="myTable">
      <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
          <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Action</th>
                            <th><a href='{{route('AddUser')}}' class="badge bg-success">Ajouter des utilisateurs</a></th>
                        </tr>
          </thead>
          <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                           <td><label> {{$user->name}}</label></td>
                            <td><label > {{$user->role}}</label></td>
                            <td>
                                <a href = '{{route('updateRole',$user->id)}}' class="badge bg-primary">Modifier</a>
                          <a href = '{{route('DelRole',$user->id)}}' class="badge bg-danger">Supprimer</a></td>
                            <td></td>
                        </tr>

                        @endforeach
          </tbody>
                    </table>
    </section>
    </center>
    <!-- /.content -->
    <center><h1>Liste des Invitation</h1>
        <section>
            <table class="display" id="myTable1">
                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Mail</th>
                    <th>Accepter </th>
                    <th>Refuser</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($listeInvitation as $demande)
                    <tr>
                        <td>{{$demande->id}}</td>
                        <td><label> {{$demande->name}}</label></td>
                        <td><label > {{$demande->email}}</label></td>
                        <td>
                            <div class="btn-group">
                            <a class="btn btn-info" href='{{route('AdminRole',$demande->id)}}'>Admin</a>
                                <a class="btn btn-info" href='{{route('UserRole',$demande->id)}}'>User</a></div></td>
                          <td><a href = '{{route('RefuserUser',$demande->id)}}' class="badge bg-danger">refuser</a></td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </section>
    </center>

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
<script>
    $(document).on('change', ':checkbox', function() {
        $(this).parents('tr').toggleClass('warning');
        $(this).hide().parent().append('<i class="fa fa-refresh fa-spin"></i>');
        var token = $('input[name="_token"]').val();
        $.ajax({
            url: '{!! url('userseen') !!}' + '/' + this.value,
            type: 'PUT',
            data: "seen=" + this.checked + "&_token=" + token
        })
            .done(function() {
                $('.fa-spin').remove();
                $('input[type="checkbox"]:hidden').show();
            })
            .fail(function() {
                $('.fa-spin').remove();
                var chk = $('input[type="checkbox"]:hidden');
                chk.show().prop('checked', chk.is(':checked') ? null:'checked').parents('tr').toggleClass('warning');
                alert('{{ trans('back/users.fail') }}');
            });
    });

</script>
    @endsection