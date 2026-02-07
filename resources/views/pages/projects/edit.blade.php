@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Project</h1>
            <p class="text-gray-500 font-medium">Modify the details and technical stack of your project.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('projects') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</a>
            <button type="submit" form="project-form" class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md transition">Update Project</button>
        </div>
    </div>

    <form id="project-form" action="{{ route('project.update', $project->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="space-y-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Project Title</label>
                    <input type="text" name="title" value="{{ old('title', $project->title) }}" placeholder="Add title" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition font-semibold text-lg text-indigo-600">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Content / Description</label>
                    <textarea name="description" rows="6" placeholder="Describe your project..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition resize-none text-gray-600">{{ old('description', $project->description) }}</textarea>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700"><i class="fa-solid fa-link mr-1"></i> Live Link</label>
                    <input type="url" name="link" value="{{ old('link', $project->link) }}" placeholder="https://..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none transition">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700"><i class="fa-brands fa-github mr-1"></i> Github Link</label>
                    <input type="url" name="github_link" value="{{ old('github_link', $project->github_link) }}" placeholder="https://github.com/..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none transition">
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <label class="text-sm font-medium text-gray-700 block mb-4">Project Thumbnail / Image</label>
                <div class="flex items-center gap-6 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                    <div id="preview-container" class="relative w-32 h-20 flex-shrink-0">
                        <img id="image-display" src="{{ asset('storage/' . $project->image) }}" class="w-full h-full object-cover bg-white border border-gray-200 rounded-xl shadow-sm">
                        <button type="button" onclick="removeImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-md hover:bg-red-600 transition">
                            <i class="fa-solid fa-xmark text-xs"></i>
                        </button>
                    </div>

                    <div id="upload-controls" class="hidden flex-1 text-center py-2">
                        <label class="cursor-pointer group">
                            <span class="px-5 py-2.5 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-lg hover:bg-indigo-100 transition inline-block">
                                <i class="fa-solid fa-image mr-2"></i> Change Image
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
                    @foreach($project->technologies as $index => $tech)
                    <div class="tech-row flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="flex-1">
                            <input type="text" name="tech_name[]" value="{{ $tech['name'] }}" placeholder="Tech Name" class="w-full px-4 py-2 bg-white border border-gray-200 rounded-lg outline-none">
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="tech-preview w-10 h-10 bg-white rounded border border-gray-200 p-1">
                                <img src="{{ asset('storage/' . $tech['icon']) }}" class="w-full h-full object-contain">
                            </div>
                            <label class="cursor-pointer px-3 py-2 bg-white border border-gray-200 rounded-lg text-[10px] font-bold text-gray-500 hover:bg-gray-100">
                                Change Icon
                                <input type="file" name="tech_icon[]" onchange="previewTechIcon(this)" class="hidden" accept="image/*">
                            </label>
                        </div>
                        <button type="button" onclick="removeTechRow(this)" class="text-gray-300 hover:text-red-500 transition"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
</div>

<div id="row-template" class="hidden">
    <div class="tech-row flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
        <div class="flex-1">
            <input type="text" name="tech_name[]" placeholder="Tech Name" class="w-full px-4 py-2 bg-white border border-gray-200 rounded-lg outline-none">
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
        <button type="button" onclick="removeTechRow(this)" class="text-gray-300 hover:text-red-500 transition"><i class="fa-solid fa-trash-can"></i></button>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true
        });

        // Main Image logic
        window.previewImage = function(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('image-display').src = e.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                    document.getElementById('upload-controls').classList.add('hidden');
                    Toast.fire({ icon: 'success', title: 'New image selected' });
                }
                reader.readAsDataURL(file);
            }
        };

        window.removeImage = function() {
            document.getElementById('logo-input').value = '';
            document.getElementById('preview-container').classList.add('hidden');
            document.getElementById('upload-controls').classList.remove('hidden');
            Toast.fire({ icon: 'info', title: 'Current image marked for replacement' });
        };

        // Tech Row Logic
        const techWrapper = document.getElementById('tech-wrapper');
        const rowTemplate = document.getElementById('row-template').firstElementChild;

        document.getElementById('add-tech-row').addEventListener('click', () => {
            const newRow = rowTemplate.cloneNode(true);
            techWrapper.appendChild(newRow);
            Toast.fire({ icon: 'success', title: 'Row added' });
        });

        window.removeTechRow = function(btn) {
            const rows = techWrapper.querySelectorAll('.tech-row');
            if (rows.length > 1) {
                btn.closest('.tech-row').remove();
                Toast.fire({ icon: 'info', title: 'Row removed' });
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
                    previewBox.querySelector('img').src = e.target.result;
                    previewBox.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        };

        // Validation Toast handling
        @if($errors->any())
            @foreach($errors->all() as $error)
                Toast.fire({ icon: 'error', title: "{{ $error }}" });
            @endforeach
        @endif
    });
</script>
@endpush
@endsection