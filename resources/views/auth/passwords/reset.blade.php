@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="w-1/2 mx-auto">
            <div class="card">
                <div class="card-header">Reset Password</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group">
                            <label for="email"
                                   class="label">E-Mail Address</label>

                            <input id="email" type="email" class="input @error('email') input--invalid @enderror"
                                   name="email" value="{{ $email ?? old('email') }}" required autocomplete="email"
                                   autofocus>

                            <div>
                                @error('email')
                                <span class="feedback feedback--invalid" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password"
                                   class="label">Password</label>

                            <input id="password" type="password"
                                   class="input @error('password') input--invalid @enderror" name="password"
                                   required autocomplete="new-password">

                            <div>

                                @error('password')
                                <span class="feedback feedback--invalid" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm"
                                   class="label">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="form-group mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ 'Reset Password' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
