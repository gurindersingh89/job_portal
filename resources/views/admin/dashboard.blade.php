@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" style="float:right;" id="add_button">ADD JOB</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered mb-5">
                        <thead>
                            <tr class="table-success">
                                <th scope="col">Id</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Qualification</th>
                                <th scope="col">Department</th>
                                <th scope="col">Salary</th>
                                <th scope="col">No Of Openings</th>
                                <th scope="col">Job Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jobs as $data)
                            <tr row_id="{{$data->id}}">
                                <th scope="row">{{ $data->id }}</th>
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->description }}</td>
                                <td>{{ $data->qualification }}</td>
                                <td>{{ $data->department }}</td>
                                <td>{{ $data->salary }}</td>
                                <td>{{ $data->no_of_openings }}</td>
                                <td>
                                    <select class="custom-select custom-select-sm update_job_status" row_id="{{$data->id}}">
                                        <option value="Open">Open</option>
                                        <option value="Close" {{ $data->job_status == 'Close' ? 'selected' : '' }}>Close</option>
                                    </select>
                                </td>
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
                {{$jobs->links('pagination::bootstrap-4')}}
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="my-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Add Job</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="px-3">
                    <form id="job_form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group p-lr-30">
                                    <label for="title">Title</label>
                                    <input type="text" id="title" class="form-control" name="title" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group p-lr-30">
                                    <label for="description">Description</label>
                                    <input type="text" id="description" class="form-control" name="description" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group p-lr-30">
                                    <label for="description">Qualification</label>
                                    <input type="text" id="qualification" class="form-control" name="qualification" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group p-lr-30">
                                    <label for="description">No Of Openings</label>
                                    <input type="text" id="no_of_openings" class="form-control" name="no_of_openings" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group p-lr-30">
                                    <label for="description">Salary</label>
                                    <input type="text" id="salary" class="form-control" name="salary" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group p-lr-30">
                                    <label for="description">Department</label>
                                    <input type="text" id="department" class="form-control" name="department" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="created_by" class="form-control" name="created_by" value="{{auth()->user()->name}}" autocomplete="off" />

                        <div class="form-actions">
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

        $('#add_button').on('click', function() {
            $('#job_form').trigger('reset');
            $('#modal_title').text('Add Job');
            $('#my-modal').modal('show');
            $('#save').attr('edit', false);
        });

        $('#save').on('click', function() {
            var name = $('#name').val();
            var url = 'jobs';
            var type = 'POST';

            if ($(this).attr('edit') == 'true') {
                url += '/' + $(this).attr('row_id');
                type = 'PATCH'
            }
            $.ajax({
                url: url,
                type: type,
                data: $('#job_form').serialize(),
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
            var url = 'jobs/' + id;
            $.ajax({
                url: url,
                type: 'GET',
                complete: function() {},
                success: function(res) {
                    if (res.status) {
                        result = res.data;
                        $('#modal_title').text('Edit Job');
                        $('#my-modal').modal('show');
                        $('#title').val(result.title);
                        $('#description').val(result.description);
                        $('#qualification').val(result.qualification);
                        $('#no_of_openings').val(result.no_of_openings);
                        $('#department').val(result.department);
                        $('#salary').val(result.salary);
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
            var url = 'jobs/' + id;
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
                                toastr.success('Job Deleted Successfully');
                                // location.reload();
                            }
                        });
                    } else {
                        swal.fire("Your record is safe!");
                    }
                });
        });

        $('.update_job_status').change(function() {
            var id = $(this).attr('row_id');
            var url = 'jobs/status/update';
            var value = $(this).val();
            $.ajax({
                url: url,
                type: 'POST',
                data : {id, value},
                complete: function() {},
                success: function(res) {
                    if (res.status) {
                        toastr.success(res.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var error = jqXHR.responseJSON.errors;
                    $.each(error, function(k, v) {
                        toastr.error(v[0]);
                    });
                }
            });
        });
    });
</script>
@endpush
@endsection