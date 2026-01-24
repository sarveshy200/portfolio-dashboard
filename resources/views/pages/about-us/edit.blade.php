@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="max-w-10xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit About Us</h1>
            <p class="text-gray-500 font-medium">Update your professional bio, profile picture, and resume.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('aboutus') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</a>
            <button type="submit" form="about-form" class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md shadow-indigo-100 transition">Save Changes</button>
        </div>
    </div>

    <form id="about-form" action="{{ route('aboutus.update', $about->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT') 

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
            <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-50 pb-4">Professional Bio</h2>
            
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">Display Name</label>
                <input type="text" name="name" value="{{ old('name', $about->name) }}" 
                    class="w-full px-4 py-3 bg-gray-50 border @error('name') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition text-lg font-medium">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">About Content</label>
                <textarea name="about_content" rows="10" 
                    class="w-full px-4 py-3 bg-gray-50 border @error('about_content') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition resize-none">{{ old('about_content', $about->about_content) }}</textarea>
                @error('about_content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
                <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-50 pb-4">Profile Photo</h2>
                
                <div id="image-preview-box" class="relative group w-48 h-64 mx-auto overflow-hidden rounded-xl border border-gray-100 shadow-sm mb-4">
                    <img id="profile-display" src="{{ $about->profile_image ? asset('storage/' . $about->profile_image) : 'https://i.pravatar.cc/150?u=default' }}" class="w-full h-full object-cover">
                </div>

                <div class="upload-area">
                    <label class="cursor-pointer block">
                        <div class="px-4 py-3 bg-indigo-50 border-2 border-dashed border-indigo-200 rounded-xl text-center group hover:bg-indigo-100 transition">
                            <i class="fa-solid fa-camera text-indigo-600 mb-1 text-lg"></i>
                            <p class="text-xs font-bold text-indigo-700">Change Photo</p>
                            <input type="file" name="profile_image" id="profile-input" onchange="previewProfileImage(this)" class="hidden" accept="image/*">
                        </div>
                    </label>
                </div>
                @error('profile_image') <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p> @enderror
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
                <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-50 pb-4">Resume / CV</h2>
                
                @if($about->resume)
                <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-200 mb-4">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm mr-3">
                        <i class="fa-solid fa-file-pdf text-red-500 text-xl"></i>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-gray-900 truncate">{{ basename($about->resume) }}</p>
                        <p class="text-[10px] text-gray-400">Current active file</p>
                    </div>
                </div>
                @endif

                <label class="cursor-pointer block">
                    <div class="px-4 py-8 border-2 border-dashed border-gray-200 rounded-2xl text-center hover:bg-gray-50 hover:border-indigo-300 transition">
                        <i class="fa-solid fa-cloud-arrow-up text-gray-300 text-2xl mb-2"></i>
                        <p class="text-sm font-semibold text-gray-700">Upload New Resume</p>
                        <p id="resume-name" class="text-xs text-gray-400 mt-1">PDF format (Max: 20MB)</p>
                        <input type="file" name="resume" onchange="updateResumeName(this)" class="hidden" accept=".pdf,.doc,.docx">
                    </div>
                </label>
                @error('resume') <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p> @enderror
            </div>
        </div>
    </form>
</div>

<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});

function previewProfileImage(input) {
    const file = input.files[0];
    const previewImg = document.getElementById('profile-display');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            Toast.fire({ icon: 'success', title: 'New photo selected' });
        }
        reader.readAsDataURL(file);
    }
}

function updateResumeName(input) {
    const fileName = input.files[0].name;
    const label = document.getElementById('resume-name');
    label.textContent = fileName;
    label.classList.replace('text-gray-400', 'text-indigo-600');
    label.classList.add('font-bold');
    Toast.fire({ icon: 'success', title: 'New resume attached' });
}
</script>
@endsection