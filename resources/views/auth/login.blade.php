@extends('components.layout')
@section('content')
<section class="h-[calc(100vh-4rem)] grid grid-cols-1 md:grid-cols-2">
    <!-- Admin Login Option -->
    <div class="flex flex-col justify-center items-center bg-base-200 p-8 text-center">
      <h2 class="text-3xl font-bold mb-2">Admin Panel Access</h2>
      <p class="mb-4 max-w-md">For administrative users who manage platform operations, analytics, and system controls.</p>
      <a href="{{route('admin.login')}}" class="btn btn-primary">Go to Admin Login</a>
    </div>

    <!-- Organizer/Customer Login Option -->
    <div class="flex flex-col justify-center items-center bg-base-300 p-8 text-center">
      <h2 class="text-3xl font-bold mb-2">User Access</h2>
      <p class="mb-4 max-w-md">If you are a customer looking to book events or an organizer managing events, click below to login.</p>
      <a href="/userLogin" class="btn btn-secondary">Customer / Organizer Login</a>
    </div>
  </section>
@endsection