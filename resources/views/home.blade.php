@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">profile <div class="pull-right"> <a href="{{url("users/".$user->id."/edit")}}" class="btn btn-success btn-xs">Edit</a> </div> </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div class="card hovercard">
                            <div class="cardheader">

                            </div>
                            <div class="avatar">
                                @if(is_null($user->image))
                                    <img src="https://bootdey.com/img/Content/user_1.jpg" alt="">
                                @else
                                    <img src="{{asset('storage/uploads/'.$user->image)}}" alt="">
                                @endif
                            </div>
                            <div class="info">
                                <div class="title">
                                    <a target="_blank" href="#">{{$user->name}}</a>
                                </div>
                                <div class="desc">{{$user->email}}</div>
                                @if($user->is_admin)
                                    <div class="desc">Admin</div>
                                @else
                                    <div class="desc">User</div>
                                @endif

                            </div>

                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
