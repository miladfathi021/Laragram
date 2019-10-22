@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="w-1/2 mx-auto mt-16">
            <div class="card">
                <div class="card-header">Register</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" novalidate>
                        @csrf

                        <div class="form-group">
                            <label for="name" class="label">Name</label>

                            <input id="name" type="text" class="input @error('name') input--invalid @enderror"
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            <div>
                                @error('name')
                                <span class="feedback feedback--invalid" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email"
                                   class="label">E-Mail Address</label>

                            <input id="email" type="email" class="input @error('email') input--invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email">

                            <div>
                                @error('email')
                                <span class="feedback feedback--invalid" role="alert">
                                        {{ $message }}
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
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm"
                                   class="label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="input"
                                       name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <div class="">
                                <button type="submit" class="btn btn-primary text-white mt-4">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
