@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Add New Project</h1>
            <p class="text-gray-500 font-medium">Create a new showcase for your portfolio.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('projects') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</a>
            <button type="submit" form="project-form" class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md transition">Save Project</button>
        </div>
    </div>

    <form id="project-form" action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="space-y-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Project Title</label>
                    <input type="text" name="title" placeholder="Add title" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition font-semibold text-lg">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Content / Description</label>
                    <textarea name="description" rows="6" placeholder="Describe your project workflow and features..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition resize-none"></textarea>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700"><i class="fa-solid fa-link mr-1"></i> Live Link</label>
                    <input type="url" name="link" placeholder="https://your-project.com" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700"><i class="fa-brands fa-github mr-1"></i> Github Link</label>
                    <input type="url" name="github_link" placeholder="https://github.com/your-username/repo" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <label class="text-sm font-medium text-gray-700 block mb-4">Project Thumbnail / Image</label>
                <div class="flex items-center gap-6 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                    <div id="preview-container" class="hidden relative w-32 h-20 flex-shrink-0">
                        <img id="image-display" src="" class="w-full h-full object-cover bg-white border border-gray-200 rounded-xl shadow-sm">
                        <button type="button" onclick="removeImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-md hover:bg-red-600 transition">
                            <i class="fa-solid fa-xmark text-xs"></i>
                        </button>
                    </div>

                    <div id="upload-controls" class="flex-1 text-center py-2">
                        <label class="cursor-pointer group">
                            <span class="px-5 py-2.5 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-lg hover:bg-indigo-100 transition inline-block">
                                <i class="fa-solid fa-image mr-2"></i> Add Image
                            </span>
                            <input type="file" name="image" id="logo-input" onchange="previewImage(this)" class="hidden" accept="image/*">
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-center justify-between mb-6 border-b border-gray-50 pb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Technologies Used</h2>
                    <button type="button" id="add-tech-row" class="text-sm font-bold text-indigo-600 hover:text-indigo-700">+ Add Row</button>
                </div>
                
                <div id="tech-wrapper" class="space-y-4">
                    <div class="tech-row flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="flex-1">
                            <input type="text" name="tech_name[]" placeholder="Tech Name (e.g. Laravel)" class="w-full px-4 py-2 bg-white border border-gray-200 rounded-lg outline-none">
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="tech-preview hidden w-10 h-10 bg-white rounded border border-gray-200 p-1">
                                <img src="" class="w-full h-full object-contain">
                            </div>
                            <label class="cursor-pointer px-3 py-2 bg-white border border-gray-200 rounded-lg text-[10px] font-bold text-gray-500 hover:bg-gray-100">
                                Upload Icon
                                <input type="file" name="tech_icon[]" onchange="previewTechIcon(this)" class="hidden" accept="image/*">
                            </label>
                        </div>
                        <button type="button" onclick="removeTechRow(this)" class="text-gray-300 hover:text-red-500 transition">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        /**
         * 1. Standardized Toast Configuration
         */
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000, // Slightly longer to read specific errors
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        /**
         * 2. Handle Laravel Validation Errors as Toasts
         * This loop captures every missing required field and shows it as a small alert.
         */
        @if($errors->any())
            @foreach($errors->all() as $error)
                Toast.fire({
                    icon: 'error',
                    title: "{{ $error }}"
                });
            @endforeach
        @endif

        /**
         * 3. Handle Success/General Error Sessions
         */
        @if(session('success'))
            Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
        @endif

        @if(session('error'))
            Toast.fire({ icon: 'error', title: "{{ session('error') }}" });
        @endif

        // --- Keep your existing image and row logic below ---
        
        window.previewImage = function(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('image-display').src = e.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                    document.getElementById('upload-controls').classList.add('hidden');
                    Toast.fire({ icon: 'success', title: 'Main image selected' });
                }
                reader.readAsDataURL(file);
            }
        };

        window.removeImage = function() {
            document.getElementById('logo-input').value = '';
            document.getElementById('preview-container').classList.add('hidden');
            document.getElementById('upload-controls').classList.remove('hidden');
            Toast.fire({ icon: 'info', title: 'Main image removed' });
        };

        const techWrapper = document.getElementById('tech-wrapper');
        document.getElementById('add-tech-row').addEventListener('click', function() {
            const firstRow = techWrapper.querySelector('.tech-row');
            const newRow = firstRow.cloneNode(true);
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            const previewBox = newRow.querySelector('.tech-preview');
            previewBox.classList.add('hidden');
            previewBox.querySelector('img').src = '';
            techWrapper.appendChild(newRow);
            Toast.fire({ icon: 'success', title: 'Technology row added' });
        });

        window.removeTechRow = function(btn) {
            const rows = techWrapper.querySelectorAll('.tech-row');
            if (rows.length > 1) {
                btn.closest('.tech-row').remove();
                Toast.fire({ icon: 'info', title: 'Technology row removed' });
            } else {
                Toast.fire({ icon: 'warning', title: 'At least one row is required' });
            }
        };

        window.previewTechIcon = function(input) {
            const file = input.files[0];
            const row = input.closest('.tech-row');
            const previewBox = row.querySelector('.tech-preview');
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    row.querySelector('.tech-preview img').src = e.target.result;
                    previewBox.classList.remove('hidden');
                    Toast.fire({ icon: 'success', title: 'Icon selected' });
                }
                reader.readAsDataURL(file);
            }
        };

        const projectForm = document.getElementById('project-form');
        if(projectForm) {
            projectForm.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin mr-2"></i> Saving...';
            });
        }
    });
</script>
@endpush
@endsection