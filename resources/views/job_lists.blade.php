@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Jobs List') }}</div>
                <table class="table table-bordered mb-5">
                    <thead>
                        <tr class="table-success">
                            <th scope="col">Id</th>
                            <th scope="col">Username</th>
                            <th scope="col">Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobs as $data)
                        <tr row_id="{{$data->id}}">
                            <th scope="row">{{ $data->id }}</th>
                            <td>{{ $data->user->name }}</td>
                            <td>{{ $data->name }}</td>
                            <td><button type="button" class="btn btn-primary edit"  row_id="{{$data->id}}">Edit</button>
                                <button type="button" class="btn btn-danger delete" row_id="{{$data->id}}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection