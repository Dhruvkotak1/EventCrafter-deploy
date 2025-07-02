@extends('components.layout')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <h2 class="text-3xl font-bold text-center mb-8">Edit Your Profile</h2>

    

    <form action="{{ route('profile.update',auth()->user()->id) }}" method="POST" enctype="multipart/form-data" class="bg-base-100 rounded-2xl shadow-xl p-8 space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Profile Picture with Upload --}}
            <div class="col-span-1 flex flex-col items-center space-y-3">
                <div class="avatar">
                    <div class="w-32 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                        <img id="preview" src="{{ $profile->profile_image ? asset('/uploads/' . $profile->profile_image) : 'https://via.placeholder.com/150' }}">
                    </div>
                </div>
                <label class="btn btn-sm btn-outline btn-primary">
                    Choose Image
                    <input type="file" name="profile_image" accept="image/*" class="hidden" onchange="previewImage(event)">
                </label>
            </div>

            {{-- Profile Fields --}}
            <div class="space-y-4">
                <div>
                    <label class="label"><span class="label-text">Full Name</span></label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="input input-bordered w-full" required>
                </div>

                <div>
                    <label class="label"><span class="label-text">Phone Number</span></label>
                    <input type="tel" maxlength="10" name="phone" value="{{ old('phone', $profile->phone ?? '') }}" class="input input-bordered w-full" required>
                </div>

                <div>
                    <label class="label"><span class="label-text">Gender</span></label>
                    <select name="gender" class="select select-bordered w-full" required>
                        <option value="" disabled>Select Gender</option>
                        <option value="male" {{ old('gender', $profile->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $profile->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender', $profile->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div>
                    <label class="label"><span class="label-text">Date of Birth</span></label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $profile->date_of_birth ?? '') }}" class="input input-bordered w-full" required>
                </div>

                <div>
                    <label class="label"><span class="label-text">Address</span></label>
                    <textarea name="address" rows="3" class="textarea textarea-bordered w-full" required>{{ old('address', $profile->address ?? '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Form Actions --}}
        <div class="flex flex-col md:flex-row justify-between items-center pt-6 border-t">
            <button type="submit" class="btn btn-primary w-full md:w-auto">Save Changes</button>

            <button type="button" class="btn btn-outline btn-error mt-4 md:mt-0" onclick="delete_modal.showModal()">Delete My Account</button>
        </div>
    </form>

    {{-- Delete Modal --}}
    <dialog id="delete_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg text-red-600">Delete Account</h3>
            <p class="py-4">This action is irreversible. Please confirm your password to delete your account:</p>
            <form action="{{ route('profile.destroy',auth()->user()->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="password" name="password" placeholder="Enter Password" class="input input-bordered w-full mb-4" required>
                <div class="modal-action">
                    <button type="submit" class="btn btn-error">Yes, Delete</button>
                    <button type="button" class="btn" onclick="delete_modal.close()">Cancel</button>
                </div>
            </form>
        </div>
    </dialog>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = () => document.getElementById('preview').src = reader.result;
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
