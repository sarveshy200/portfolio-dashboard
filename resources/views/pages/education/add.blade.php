@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class=" mx-auto pb-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Add Education</h1>
            <p class="text-gray-500 font-medium">Add a new academic milestone to your portfolio.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('education') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</a>
            <button type="submit" form="edu-form" class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md transition">Save Record</button>
        </div>
    </div>

    <form id="edu-form" action="{{ route('education.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-8">
            
            <div class="space-y-6">
                <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-50 pb-4">Academic Details</h2>
                
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">College/University Name</label>
                    <input type="text" name="college_name" placeholder="e.g., XYZ University" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition font-medium">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Course Name</label>
                    <input type="text" name="course" placeholder="e.g., B.Tech in Computer Science" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition font-medium">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Duration</label>
                    <input type="text" name="duration" placeholder="e.g., 2018 - 2022" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">College Link (Optional)</label>
                    <input type="url" name="college_link" placeholder="https://..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition">
                </div>
            </div>

            <div class="space-y-4">
                <label class="text-sm font-medium text-gray-700">College Logo</label>
                <div class="flex items-center gap-6 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                    <div id="preview-container" class="hidden relative w-24 h-24 flex-shrink-0">
                        <img id="image-display" src="" class="w-full h-full object-contain bg-white border border-gray-200 rounded-xl p-2 shadow-sm">
                        <button type="button" onclick="removeImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-md hover:bg-red-600 transition">
                            <i class="fa-solid fa-xmark text-xs"></i>
                        </button>
                    </div>

                    <div id="upload-controls" class="flex-1 text-center py-4">
                        <label class="cursor-pointer group">
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mb-2 group-hover:bg-indigo-100 transition">
                                    <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                                </div>
                                <span class="text-sm font-bold text-gray-700">Click to upload logo</span>
                                <span class="text-xs text-gray-400 mt-1">PNG, JPG up to 2MB</span>
                            </div>
                            <input type="file" name="college_image" id="logo-input" onchange="previewImage(this)" class="hidden" accept="image/*">
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@push('scripts')
<script>
    function previewImage(input) {
        const file = input.files[0];
        const container = document.getElementById('preview-container');
        const display = document.getElementById('image-display');
        const uploadControls = document.getElementById('upload-controls');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                display.src = e.target.result;
                container.classList.remove('hidden'); // Show preview
                uploadControls.classList.add('hidden'); // Hide upload prompt
                
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Logo selected',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
            reader.readAsDataURL(file);
        }
    }

    function removeImage() {
        const input = document.getElementById('logo-input');
        const container = document.getElementById('preview-container');
        const uploadControls = document.getElementById('upload-controls');
        
        input.value = ''; // Clear file input
        container.classList.add('hidden'); // Hide preview
        uploadControls.classList.remove('hidden'); // Show upload prompt again
    }
</script>
@endpush
@endsection