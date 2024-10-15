@extends('admin.layouts.app')
@section('title')

@endsection
@section('content')
<div class="row">
          <div class="col-md-5">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Edit Profile</h5>
              </div>
              <div class="card-body">
              <form method="POST" action="{{ route('profiles.update') }}">
                        @csrf
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" class="form-control" value="{{ $data->uid }}" readonly>
                    </div>
                    <div class="form-group">
                      <label>Full Name</label>
                      <input type="text" class="form-control" name="name" value="{{ $data->name }}">
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" name="email" value="{{ $data->email }}">
                    </div>
                                        <div class="update ml-auto mr-auto">
                      <button type="submit" class="btn btn-primary btn-round">Update</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Edit Password</h5>
              </div>
              <div class="card-body">
              <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                    <div class="form-group">
                    <label for="current_password">Current Password</label>
                            <input id="current_password" type="password"
                                class="form-control @error('current_password') is-invalid @enderror" name="current_password"
                                required autocomplete="current-password">

                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                    <label for="password">New Password</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                            <label for="password_confirmation">{{ __('Confirm Password') }}</label>

                            <input id="password_confirmation" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>
                    <div class="update ml-auto mr-auto">
                      <button type="submit" class="btn btn-primary btn-round">Update Password</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>

@endsection