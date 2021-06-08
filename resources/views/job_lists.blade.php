@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <table class="table table-bordered mb-5">
                        <thead>
                            <tr class="table-success">
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Qualification</th>
                                <th scope="col">Department</th>
                                <th scope="col">Salary</th>
                                <th scope="col">No Of Openings</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jobs as $data)
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->description }}</td>
                                <td>{{ $data->qualification }}</td>
                                <td>{{ $data->department }}</td>
                                <td>{{ $data->salary }}</td>
                                <td>{{ $data->no_of_openings }}</td>
                                <td>
                                    @if(!auth()->user())
                                        <a href="{{url('/login')}}" class="btn btn-primary">Apply</a>
                                    @else
                                        @if($data->job_applies_count > 0)
                                        <button type="button" class="btn btn-primary job_remove" row_id="{{$data->id}}">Remove</button>
                                        @else
                                        <button type="button" class="btn btn-primary job_apply" row_id="{{$data->id}}">Apply</button>
                                        @endif
                                    @endif
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
@push('js')
<script>
    $(document).ready(function() {

        $(document).on('click', '.job_apply', function() {
            var job_id = $(this).attr('row_id');
            var url = 'job/apply';
            swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Apply it!'
                })
                .then((willApply) => {
                    if (willApply.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                job_id
                            },
                            complete: function() {},
                            success: function(res) {
                                if (res.status) {
                                    toastr.success(res.message);
                                    location.reload();
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                var error = jqXHR.responseJSON.errors;
                                $.each(error, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            }
                        });
                    } else {
                        swal.fire("Your record is safe!");
                    }
                });
        });

        $(document).on('click', '.job_remove', function() {
            var job_id = $(this).attr('row_id');
            var url = 'job/remove';
            swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Remove it!'
                })
                .then((willApply) => {
                    if (willApply.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                job_id
                            },
                            complete: function() {},
                            success: function(res) {
                                if (res.status) {
                                    toastr.success(res.message);
                                    location.reload();
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                var error = jqXHR.responseJSON.errors;
                                $.each(error, function(k, v) {
                                    toastr.error(v[0]);
                                });
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