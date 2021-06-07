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
                                <th scope="col">Id</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jobs as $data)
                            <tr row_id="{{$data->id}}">
                                <th scope="row">{{ $data->id }}</th>
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->description }}</td>
                                <td><button type="button" class="btn btn-primary edit" row_id="{{$data->id}}">Apply</button>
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
@endsection