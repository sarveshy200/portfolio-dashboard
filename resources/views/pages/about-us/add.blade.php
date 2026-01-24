@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="max-w-10xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Add About Details</h1>
            <p class="text-gray-500 font-medium">Create your professional profile, upload a photo, and attach your resume.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</a>
            <button type="submit" form="about-form" class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md shadow-indigo-100 transition">Save Profile</button>
        </div>
    </div>

    <form id="about-form" action="{{ route('aboutus.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
            <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-50 pb-4">Professional Bio</h2>
            
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g., Full Name" 
                    class="w-full px-4 py-3 bg-gray-50 border @error('name') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition text-lg font-medium">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">About Content</label>
                <textarea name="about_content" rows="8" placeholder="Tell us about your expertise and journey..." 
                    class="w-full px-4 py-3 bg-gray-50 border @error('about_content') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition resize-none">{{ old('about_content') }}</textarea>
                @error('about_content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
                <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-50 pb-4">Profile Photo</h2>
                
                <div id="image-preview-container" class="hidden relative w-48 h-64 mx-auto overflow-hidden rounded-xl border border-gray-100 shadow-md mb-4">
                    <img id="profile-display" src="" class="w-full h-full object-cover">
                    <button type="button" onclick="resetProfileImage()" class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-lg hover:bg-red-700 transition">
                        <i class="fa-solid fa-trash-can text-xs"></i>
                    </button>
                </div>

                <div id="upload-placeholder" class="upload-area">
                    <label class="cursor-pointer block">
                        <div class="px-4 py-12 border-2 border-dashed border-gray-200 rounded-2xl text-center group hover:bg-indigo-50/50 hover:border-indigo-300 transition">
                            <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                                <i class="fa-solid fa-user-plus text-2xl"></i>
                            </div>
                            <p class="text-sm font-semibold text-gray-700">Click to upload photo</p>
                            <p class="text-xs text-gray-400 mt-2">JPG, PNG or SVG</p>
                            <input type="file" name="profile_image" id="profile-input" onchange="previewProfileImage(this)" class="hidden" accept="image/*">
                        </div>
                    </label>
                </div>
                @error('profile_image') <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p> @enderror
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
                <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-50 pb-4">Resume / CV</h2>
                
                <div class="flex flex-col h-full justify-center">
                    <label class="cursor-pointer block">
                        <div id="resume-dropzone" class="px-4 py-12 border-2 border-dashed border-gray-200 rounded-2xl text-center group hover:bg-gray-50 hover:border-indigo-300 transition">
                           <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:text-red-500 transition">
                                <i class="fa-solid fa-file-pdf text-3xl"></i>
                            </div>
                            <p class="text-sm font-semibold text-gray-700">Attach Professional CV</p>
                            <p id="resume-name" class="text-xs text-gray-400 mt-2">PDF format preferred (Max: 20MB)</p>
                            <input type="file" name="resume" onchange="updateResumeName(this)" class="hidden" accept=".pdf,.doc,.docx">
                        </div>
                    </label>
                    @error('resume') <p class="text-red-500 text-xs mt-4 text-center">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </form>
</div>

<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2500,
    timerProgressBar: true,
});

function previewProfileImage(input) {
    const file = input.files[0];
    const container = document.getElementById('image-preview-container');
    const placeholder = document.getElementById('upload-placeholder');
    const display = document.getElementById('profile-display');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            display.src = e.target.result;
            container.classList.remove('hidden');
            placeholder.classList.add('hidden');
            Toast.fire({ icon: 'success', title: 'Image uploaded' });
        }
        reader.readAsDataURL(file);
    }
}

function resetProfileImage() {
    const input = document.getElementById('profile-input');
    const container = document.getElementById('image-preview-container');
    const placeholder = document.getElementById('upload-placeholder');
    
    input.value = '';
    container.classList.add('hidden');
    placeholder.classList.remove('hidden');
    Toast.fire({ icon: 'info', title: 'Image removed' });
}

function updateResumeName(input) {
    const fileName = input.files[0].name;
    const label = document.getElementById('resume-name');
    label.textContent = fileName;
    label.classList.replace('text-gray-400', 'text-indigo-600');
    label.classList.add('font-bold');
    Toast.fire({ icon: 'success', title: 'Resume attached' });
}

// Global Validation Tost
@if($errors->any())
    Toast.fire({ icon: 'error', title: 'Please fix the errors below.' });
@endif
</script>
@endsection