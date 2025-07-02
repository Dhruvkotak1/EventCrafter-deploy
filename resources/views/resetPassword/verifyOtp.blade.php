@extends('components.layout')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-base-200">
    <div class="card w-full max-w-md shadow-2xl bg-base-100">
        <div class="card-body">
            <h2 class="text-2xl font-bold text-center mb-4">Verify OTP</h2>
            <p class="text-sm text-center text-base-content/70 mb-4">
                Enter the 6-digit OTP sent to your email.
            </p>

            

            <form method="POST" action="/verifyOtp">
                @csrf

                <div class="form-control mb-4 flex items-center justify-center">
                    
                    <input type="text" name="userotp" class="input input-bordered text-center tracking-widest text-lg"
                           maxlength="6" minlength="6" pattern="\d{6}" required placeholder="______">
                    <input type="text" value="{{$token}}" name="token" hidden>
                </div>

                <div class="form-control flex items-center justify-center">
                    <button type="submit" class="btn btn-success w-1/2">Verify</button>
                    <span id="resendTimer" class="text-xs mt-3 text-base-content/60 hidden"></span>
                </div>
            </form>

            
        </div>
    </div>
</div>


@endsection
