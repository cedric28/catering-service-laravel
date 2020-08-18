@extends('layouts.app')

@section('content')
<!-- Main content -->
<div class="content-wrapper">
    <!-- Content area -->
    <div class="content d-flex justify-content-center align-items-center">
        <!-- Login form -->
        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="card mb-0">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
                        <h5 class="mb-0">Login to your account</h5>
                        <span class="d-block text-muted">Enter your credentials below</span>
                    </div>

                    <div class="form-group form-group-feedback form-group-feedback-left">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="E-mail" value="{{ old('email') }}" name="email" required autocomplete="email" autofocus>
                        <div class="form-control-feedback">
                            <i class="icon-user text-muted"></i>
                        </div>
                    </div>

                    <div class="form-group form-group-feedback form-group-feedback-left">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                        <div class="form-control-feedback">
                            <i class="icon-lock2 text-muted"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }} <i class="icon-circle-right2 ml-2"></i></button>
                    </div>

                    

                    <div class="text-center">
                        @if (Route::has('password.request'))
                            <a  href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>
        <!-- /login form -->
    </div>
    <!-- /content area -->
</div>
@endsection
