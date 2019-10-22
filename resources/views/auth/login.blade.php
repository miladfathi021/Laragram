@extends('layouts.app')

@section('content')
<div class="container">
        <div class="w-1/2 mx-auto mt-20">
            <div class="card">
                <div class="card-header">Login</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" novalidate>
                        @csrf

                        <div class="form-group">
                            <label for="email" class="label">E-Mail Address</label>

                            <input id="email" type="email" class="input @error('email') input--invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            <div>
                                @error('email')
                                <span class="feedback feedback--invalid" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="label">Password</label>

                            <input id="password" type="password" class="input @error('password') input--invalid @enderror" name="password" required autocomplete="current-password">

                            <div>
                                @error('password')
                                    <span class="feedback feedback--invalid" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary text-white">
                                    Login
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="is-link ml-6" href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
@endsection
