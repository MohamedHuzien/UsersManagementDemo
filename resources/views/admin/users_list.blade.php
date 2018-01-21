@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            @if (Session::has('message'))
            <div class="col-md-12 alert alert-success">
                <strong>Success!</strong> {{Session::get("message")}}.
            </div>
            @endif
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Users  <div class="pull-right"> <a href="{{url("/users/create")}}" class="btn btn-success btn-xs">Add new User</a> </div></div>
                    <div class="panel-body">
                        <!-- users list table -->
                        <div class="col-lg-12">
                            <div class="main-box no-header clearfix">
                                <div class="main-box-body clearfix">
                                    <div class="table-responsive">
                                        <table class="table user-list">
                                            <thead>
                                            <tr>
                                                <th><span>User</span></th>
                                                <th><span>Created</span></th>
                                                <th><span>Email</span></th>
                                                <th>&nbsp;</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {{$users}}
                                            @foreach($users as $user)
                                                <tr>
                                                    <td>
                                                        @if(is_null($user->image))
                                                        <img src="https://bootdey.com/img/Content/user_1.jpg" alt="">
                                                        @else
                                                            <img src="{{asset('storage/uploads/'.$user->image)}}" alt="">
                                                        @endif
                                                        <a href="{{url("/users/{$user->id}")}}" class="user-link">{{$user->name}}</a>
                                                        @if($user->is_admin)
                                                        <span class="user-subhead">Admin</span>
                                                        @else
                                                            <span class="user-subhead">User</span>
                                                        @endif
                                                    </td>
                                                    <td>{{$user->created_at->format("d/m/Y")}}</td>
                                                    <td>
                                                        <a href="#">{{$user->email}}</a>
                                                    </td>
                                                    <td style="width: 20%;">
                                                        <a href="{{url("/users/{$user->id}/edit")}}" class="table-link">
                                                            <span class="fa-stack">
                                                                <i class="fa fa-square fa-stack-2x"></i>
                                                                <i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>
                                                            </span>
                                                        </a>
                                                        <form class="form-inline " onsubmit="return confirmDeleteUser();" method="POST" action="{{url("/users/{$user->id}")}}">
                                                            {{ method_field('DELETE') }}
                                                            {{csrf_field()}}
                                                            <button type="submit" class="btn btn-danger btn-xs">
                                                                <i class="fa fa-trash-o"></i>
                                                            </button>
                                                        </form>

                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection