@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <table class="table table-bordered mb-5">
                        <thead>
                            <tr class="table-success">
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $data)
                            <tr row_id="{{$data->id}}">
                                <th scope="row">{{ $data->id }}</th>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td><button type="button" class="btn btn-primary edit" row_id="{{$data->id}}">Edit</button>
                                    <button type="button" class="btn btn-danger delete" row_id="{{$data->id}}">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                </div>
            </div>
            <div class="pagination">
                {{$users->links('pagination::bootstrap-4')}}
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="my-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="px-3">
                    <form id="user_form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group p-lr-30">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" class="form-control" name="name" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group p-lr-30">
                                    <label for="email">Email</label>
                                    <input type="text" id="email" class="form-control" name="email" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="ft-x"></i> Close</button>
                <button type="button" class="btn btn-primary" id="save" edit="false"><i class="fa fa-check-square-o"></i> Save</button>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
    $(document).ready(function() {

        $('#save').on('click', function() {
            var url = 'users';
            var type = 'POST';

            if ($(this).attr('edit') == 'true') {
                url += '/' + $(this).attr('row_id');
                type = 'PATCH'
            }
            $.ajax({
                url: url,
                type: type,
                data: $('#user_form').serialize(),
                complete: function() {},
                success: function(res) {
                    $('#my-modal').modal('hide');
                    toastr.success(res.message);
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var error = jqXHR.responseJSON.errors;
                    $.each(error, function(k, v) {
                        toastr.error(v[0]);
                    });
                }
            });
        });

        $('.edit').click(function() {
            var id = $(this).attr('row_id');
            var url = 'users/' + id;
            $.ajax({
                url: url,
                type: 'GET',
                complete: function() {},
                success: function(res) {
                    if (res.status) {
                        result = res.data;
                        $('#modal_title').text('Edit User');
                        $('#my-modal').modal('show');
                        $('#name').val(result.name);
                        $('#email').val(result.email);
                        $('#save').attr({
                            'edit': true,
                            row_id: id
                        });
                    }
                }
            });
        });

        $('.delete').click(function() {
            var id = $(this).attr('row_id');
            var url = 'users/' + id;
            swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            complete: function() {},
                            success: function(res) {
                                $('tr[row_id="' + id + '"]').remove();
                                toastr.success('User Deleted Successfully');
                                // location.reload();
                            }
                        });
                    } else {
                        swal.fire("Your record is safe!");
                    }
                });
        });
    });
</script>
@endpush
@endsection