@extends('components.layout')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-base-200">
    <div class="card w-full max-w-md shadow-2xl bg-base-100">
        <div class="card-body">
            <h2 class="text-2xl font-bold text-center mb-4">Set New Password</h2>
            <p class="text-sm text-center text-base-content/70 mb-4">
                Create a strong password to protect your EventCrafter account.
            </p>

            <form method="POST" action="/setNewPassword">
                @csrf

                <div class="form-control mb-4 flex items-center justify-center">
                    
                    <input type="password" name="password" class="input input-bordered" required minlength="4"
                           placeholder="Password" autocomplete="new-password">
                </div>

                <div class="form-control mb-4 flex items-center justify-center">
                    
                    <input type="password" name="confirm_password" class="input input-bordered" required minlength="4"
                           placeholder="Confirm Password" autocomplete="new-password">
                </div>

                <p class="text-sm text-base-content/60 mb-4 flex items-center justify-center">
                    Password must be at least 4 characters long.
                </p>

                <div class="form-control flex items-center justify-center">
                    <button type="submit" class="btn btn-primary">Set Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
