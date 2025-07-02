@extends('components.layout')
@section('content')
<section class="h-[calc(100vh-4rem)] flex justify-center items-center px-4">
  <div class="w-full max-w-md bg-base-200 shadow-xl rounded-lg px-8 py-6">
    <h2 class="text-2xl font-bold text-center mb-4">Create Your EventCrafter Account</h2>
    <form action="/register" method="POST" class="space-y-2">
      @csrf
      <!-- Username -->
      <div class="form-control w-full">
        <label class="label">
          <span class="label-text">Username</span>
        </label>
        <input type="text" name="username" class="input input-bordered w-full" placeholder="Your full name" required>
      </div>

      <!-- Email -->
      <div class="form-control w-full">
        <label class="label">
          <span class="label-text">Email</span>
        </label>
        <input type="email" name="email" class="input input-bordered w-full" placeholder="email@example.com" required>
      </div>

      <!-- Password -->
      <div class="form-control w-full">
        <label class="label">
          <span class="label-text">Password</span>
        </label>
        <input type="password" name="password" class="input input-bordered w-full" placeholder="••••••••" required>
      </div>

      <!-- Confirm Password -->
      <div class="form-control w-full">
        <label class="label">
          <span class="label-text">Confirm Password</span>
        </label>
        <input type="password" name="password_confirmation" class="input input-bordered w-full" placeholder="••••••••" required>
      </div>

      <!-- Role -->
      <div class="form-control w-full">
        <label class="label">
          <span class="label-text">Register As</span>
        </label>
        <select name="role" class="select select-bordered w-full" required>
          <option value="customer">Customer</option>
          <option value="organizer">Organizer</option>
        </select>
      </div>

      <!-- Submit -->
      <div class="form-control mt-2">
        <button class="btn btn-primary w-full" type="submit">Sign Up</button>
      </div>

      <p class="text-sm text-center mt-2">Already have an account? <a href="/login" class="link link-primary">Login here</a></p>
    </form>
  </div>
</section>

@endsection