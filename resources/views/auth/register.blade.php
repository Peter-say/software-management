@extends('auth.layouts.app')

@section('contents')
    <h4 class="text-center mb-4">Sign up your account</h4>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="mb-1"><strong>Full Name (first name first)</strong></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="name"
                value="{{ old('name') }}" required autofocus autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="mb-1"><strong>Email</strong></label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" placeholder="your@example.com" required autofocus autocomplete="email">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="mb-1"><strong>Password</strong></label>
            <input type="password" id="password" type="password" name="password" required autocomplete="new-password"
                class="form-control @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="mb-1"><strong>Confirm Password</strong></label>
            <input type="password" id="password_confirmation"class="form-control" name="password_confirmation" required
                autocomplete="new-password">
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-block">Sign me up</button>
        </div>
    </form>
    <div class="new-account mt-3">
        <p>Already have an account? <a class="text-primary" href="{{ route('login') }}">Sign in</a></p>
    </div>
@endsection
