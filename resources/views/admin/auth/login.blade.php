@extends('admin.layouts.app')

@section('content')
    <div class="p-3">
        <div class="row justify-content-center vh-100">

            {{-- BG color with logo center --}}
            <div class="col-md-6 vh-100 bg-primary d-flex justify-content-center align-items-center">
                <img src="{{ asset('images/logo/logo.png') }}" alt="Cosha logo" width="300">
            </div>

            {{-- Form --}}
            <div class="col-md-6 vh-100 d-flex justify-content-center align-items-center">
                <div class="card bg-transparent ">
                    <div class="card-body">
                        <div class="heading mb-3">
                            <p class="mb-0 text-white">Cosha admin login</p>
                            <h3 class="mb-1 text-white">Welcome Back</h3>
                        </div>

                        <form method="POST" action="{{ route('admin.login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email" class="form-label text-white">{{ __('Email Address') }}</label>

                                <div class="">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        placeholder="Email Address" value="{{ old('email') }}" required
                                        autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="form-label text-white">{{ __('Password') }}</label>

                                <div class="">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Password" required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="">
                                    <button type="submit" class="btn btn-primary w-100">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
