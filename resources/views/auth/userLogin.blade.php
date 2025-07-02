@extends('components.layout')
@section('content')
<section class="h-[calc(100vh-4rem)] flex justify-center items-center px-4">
    <div class="w-full max-w-md bg-base-200 shadow-xl rounded-lg px-8 py-6">
      <h2 class="text-2xl font-bold text-center mb-1">Welcome Back</h2>
      <p class="text-center mb-4 text-sm">Login to continue to your EventCrafter dashboard</p>
      <form action="/login" method="POST" class="space-y-3">
        @csrf
        <!-- Email -->
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text">Email</span>
          </label>
          <input type="email" name="email" class="input input-bordered w-full" placeholder="user@example.com" required>
        </div>

        <!-- Password -->
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text">Password</span>
          </label>
          <input type="password" name="password" class="input input-bordered w-full" placeholder="••••••••" required>
        </div>

        <!-- Remember me -->
      <div class="form-control">
        <label class="label cursor-pointer gap-2 justify-start">
          <input
            type="checkbox"
            name="remember"
            class="checkbox checkbox-primary"
          >
          <span class="label-text">Remember&nbsp;me</span>
        </label>
      </div>

        <div class="form-control mb-3">
          <label class="label justify-between">
              <a href="/forgotPassword" class="label-text-alt link link-hover">Forgot Password?</a>
          </label>
      </div>

      

        <!-- Submit -->
        <div class="form-control mt-2">
          <button class="btn btn-primary w-full" type="submit">Login</button>
        </div>

        <p class="text-sm text-center mt-2">Don't have an account? <a href="/register" class="link link-secondary">Register now</a></p>

      </form>
    </div>
  </section>
@endsection