@extends('layouts.auth')
@section('title', 'Reset Password')
@section('content')
<div class="login-container">
    <div class="login-right" style="max-width:420px;margin:40px auto;">
        <h2 class="welcome">RESET PASSWORD</h2>
        <form method="POST" action="{{ route('password.update') }}" class="login-form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <label class="form-label">EMAIL</label>
            <input type="email" name="email" value="{{ old('email', $email) }}" required style="width:100%;padding:10px;margin-bottom:12px;">
            <label class="form-label">PASSWORD BARU</label>
            <input type="password" name="password" required style="width:100%;padding:10px;margin-bottom:12px;">
            <label class="form-label">KONFIRMASI PASSWORD</label>
            <input type="password" name="password_confirmation" required style="width:100%;padding:10px;margin-bottom:16px;">
            <button type="submit" class="btn-login">UBAH PASSWORD</button>
        </form>
    </div>
</div>
@endsection
