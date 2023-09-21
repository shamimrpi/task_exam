@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __(' User List') }}</div>
              
                <div class="card-body">
                    <table class="table table-responsive">
                        <thead>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Account Type</th>
                            <th>Action</th>
                        </thead>
                        @foreach ($users as $key=> $user)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td>{{ $user->name}}</td>
                                <td>{{ $user->email}}</td>
                                <td>{{ $user->account_type}}</td>
                                <td>
                                    <a class="btn btn-sm btn-info" href="{{route('user.edit',$user->id)}}">Edit</a>
                                    <form id="delete_form{{$user->id}}" action="{{ route('user.destroy',$user->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('delete')
                                    </form>
                                    <a class="btn btn-danger btn-sm" href="{{ route('user.destroy',$user->id)}}"
                                       onclick="event.preventDefault();
                                                  document.getElementById('delete_form{{$user->id}}').submit();">
                                     {{ __('Delete') }}
                                 </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                  
                 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
