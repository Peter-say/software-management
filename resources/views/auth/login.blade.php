@extends('auth.layouts.app')

@section('contents')
    <h4 class="text-center mb-4">Sign in to your account</h4>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="mb-1"><strong>Email</strong></label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="form-control @error('email') is-invalid @enderror">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="mb-1"><strong>Password</strong></label>
            <input type="password" name="password" required autocomplete="current-password"
                class="form-control @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="row d-flex justify-content-between mt-4 mb-2">
            <div class="mb-3">
                <div class="form-check custom-checkbox ms-1">
                    <input name="remember" type="checkbox" class="form-check-input" id="basic_checkbox_1">
                    <label class="form-check-label" for="basic_checkbox_1">Remember my preference</label>
                </div>
            </div>
            <div class="mb-3">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                @endif
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
        </div>
    </form>
    <div class="new-account mt-3">
        <p>Don't have an account? <a class="text-primary" href="{{ route('register') }}">Sign up</a></p>
    </div>
@endsection
