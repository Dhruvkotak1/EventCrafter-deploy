@extends('components.layout')

@section('content')
<div class=" min-h-screen flex items-center justify-center bg-base-200">
    <div class=" card w-full max-w-md shadow-2xl bg-base-100">
        <div class="card-body">
            <h2 class="text-2xl font-bold text-center mb-4">Forgot Password</h2>
            <p class="text-sm text-center mb-4 text-base-content/70">
                Enter your registered email to receive an OTP for password reset.
            </p>

            

            <form method="POST" action="/forgotPassword" id="form">
                @csrf

                <div class="form-control mb-4 flex items-center justify-center">
                    
                    <input type="email" name="email" class="input input-bordered" required>
                </div>

                <div class="form-control flex items-center justify-center">
                    <button id="sendOtpBtn" type="submit" class="btn btn-primary w-1/2">
                        Send OTP
                    </button>
                    <span id="timer" class="text-xs mt-2 hidden text-base-content/60 text-center"></span>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const sendOtpBtn = document.getElementById('sendOtpBtn');
    const timerDisplay = document.getElementById('timer');
    const form = document.getElementById('Form');

    sendOtpBtn.addEventListener('click', function (e) {
        // Prevent submission if email field is empty
        const emailInput = form.querySelector('input[name="email"]');
        if (!emailInput.value.trim()) {
            emailInput.focus();
            return;
        }

        // Proceed with timer logic
        let seconds = 60;
        sendOtpBtn.disabled = true;
        sendOtpBtn.classList.add("btn-disabled");
        timerDisplay.classList.remove('hidden');

        const interval = setInterval(() => {
            if (seconds <= 0) {
                clearInterval(interval);
                sendOtpBtn.disabled = false;
                sendOtpBtn.classList.remove("btn-disabled");
                timerDisplay.classList.add('hidden');
            } else {
                timerDisplay.innerText = `You can resend OTP in ${seconds}s`;
                seconds--;
            }
        }, 1000);

        // Remove this `e.preventDefault()` if backend logic is ready
        e.preventDefault();
    });
</script>
@endsection
