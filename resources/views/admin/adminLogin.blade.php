@extends('components.layout')
@section('content')
<section class="h-[calc(100vh-4rem)] flex justify-center items-center px-4">
    <div class="w-full max-w-md bg-base-200 shadow-xl rounded-lg px-8 py-6">
      <h2 class="text-2xl font-bold text-center mb-4">Admin Login</h2>
      <form action="{{route('admin.loginPost')}}" method="POST" class="space-y-2">
        @csrf
        <!-- Email -->
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text">Email</span>
          </label>
          <input type="email" name="email" class="input input-bordered w-full" placeholder="admin@example.com" required>
        </div>

        <!-- Password -->
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text">Password</span>
          </label>
          <input type="password" name="password" class="input input-bordered w-full" placeholder="••••••••" required>
        </div>

        <!-- Secret Code -->
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text">Secret Numeric Code</span>
          </label>
          <input type="password" name="secret_code" class="input input-bordered w-full" placeholder="Enter your admin code" required>
        </div>

        <!-- Submit -->
        <div class="form-control mt-2">
          <button class="btn btn-primary w-full">Login</button>
        </div>

        <p class="text-sm text-center mt-2">Not an admin? <a href="/login" class="link link-secondary">Go back</a></p>
      </form>
    </div>
  </section>
@endsection