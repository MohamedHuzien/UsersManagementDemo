@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Create New User</div>
                    <div class="panel-body">
                        <!-- CREATE USER FORM -->
                        <form class="form" method="post" action="{{url("/users/{$user->id}")}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            {{ method_field('PUT') }}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="{{$user->name}}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" value="{{$user->email}}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            @if(Auth::user()->is_admin)
                                <div class="form-group{{ $errors->has('rule') ? ' has-error' : '' }}">
                                    <label>Rule</label>
                                    <select class="form-control" name="rule">
                                        <option @if(!$user->is_admin) selected @endif value="0">User</option>
                                        <option @if($user->is_admin) selected @endif  value="1">Admin</option>
                                    </select>
                                    @if ($errors->has('rule'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('rule') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            @endif
                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label>Image</label>
                                <input type="file" class="form-control-file" name="image">
                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <button class="btn btn-primary">Update</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection