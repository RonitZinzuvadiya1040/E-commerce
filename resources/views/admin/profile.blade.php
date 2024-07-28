@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Profile') }}</div>

                    <div class="card-body">
                        @if (session('profile_status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('profile_status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name', Auth::user()->name) }}" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="email">Email Address</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-outline-success">
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center pt-2">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Password</div>

                    <div class="card-body">
                        @if (session('password_status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('password_status') }}
                            </div>
                        @endif

                        <!-- Password Update Form -->
                        <form method="POST" action="{{ route('admin.profile.update.password') }}" class="mt-4">
                            @csrf
                            @method('PUT')

                            <div class="form-group mt-3">
                                <label for="password">Old Password</label>
                                <div class="input-group">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password" autofocus>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="newpassword">New Password</label>
                                <div class="input-group">
                                    <input id="newpassword" type="password"
                                        class="form-control @error('newpassword') is-invalid @enderror" name="newpassword">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('newpassword')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="newpassword_confirmation">Confirm Password</label>
                                <div class="input-group">
                                    <input id="newpassword_confirmation" type="password" class="form-control"
                                        name="newpassword_confirmation">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('newpassword_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-outline-success">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
