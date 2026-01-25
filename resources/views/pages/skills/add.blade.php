@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="max-w-10xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Add Technical Skills</h1>
            <p class="text-gray-500 font-medium">Define your skill section title and add multiple tech stack logos.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('skills') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</a>
            <button type="submit" form="skills-form" class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md shadow-indigo-100 transition">Save All Skills</button>
        </div>
    </div>

    <form id="skills-form" action="{{ route('skills.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
            <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-50 pb-4">Section Header</h2>
            
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">Section Title</label>
                <input type="text" name="section_title" placeholder="e.g., Skills" 
                    class="w-full px-4 py-3 bg-gray-50 border @error('section_title') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition font-medium text-indigo-600">
                @error('section_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">Introductory Content</label>
                <textarea name="section_content" rows="3" placeholder="A brief overview of your tech stack..." 
                    class="w-full px-4 py-3 bg-gray-50 border @error('section_content') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition resize-none text-gray-600"></textarea>
                @error('section_content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <div class="flex items-center justify-between mb-8 border-b border-gray-50 pb-4">
                <h2 class="text-lg font-semibold text-gray-800">Tech Stack Details</h2>
                <button type="button" id="add-skill-row" class="text-sm font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 transition">
                    <i class="fa-solid fa-plus text-xs"></i> Add Skill Row
                </button>
            </div>

            <div id="skills-wrapper" class="space-y-4">
                <div class="skill-row grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-gray-50 rounded-2xl border border-gray-200 relative group transition hover:border-indigo-200">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Skill Name</label>
                        <input type="text" name="name[]" placeholder="e.g., Laravel" 
                            class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-indigo-500/20 transition font-semibold">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Skill Logo</label>
                        <div class="flex items-center gap-4">
                            <div class="icon-preview-box hidden relative w-14 h-14 flex-shrink-0">
                                <img src="" class="w-full h-full object-contain bg-white border border-gray-200 rounded-xl p-2 shadow-sm">
                                <button type="button" onclick="resetSkillIcon(this)" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-[10px] hover:bg-red-600 shadow-md transition">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>

                            <div class="upload-controls flex flex-col gap-1">
                                <label class="cursor-pointer">
                                    <span class="px-4 py-2 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-full hover:bg-indigo-100 transition inline-block">
                                        Choose logo
                                    </span>
                                    <input type="file" name="image[]" onchange="previewSkillIcon(this)" class="hidden skill-input" accept="image/*">
                                </label>
                                <span class="file-name text-[10px] text-gray-400 italic">No file chosen</span>
                            </div>

                            <button type="button" onclick="removeSkillRow(this)" class="ml-auto text-gray-300 hover:text-red-500 p-2 transition">
                                <i class="fa-solid fa-trash-can text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const skillsWrapper = document.getElementById('skills-wrapper');
        const addBtn = document.getElementById('add-skill-row');
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });

        // 1. Image Preview Logic
        window.previewSkillIcon = function(input) {
            const file = input.files[0];
            const row = input.closest('.skill-row');
            const previewBox = row.querySelector('.icon-preview-box');
            const previewImg = previewBox.querySelector('img');
            const fileNameSpan = row.querySelector('.file-name');
            const uploadBtnLabel = row.querySelector('.upload-controls label');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewBox.classList.remove('hidden');
                    fileNameSpan.textContent = file.name;
                    uploadBtnLabel.classList.add('hidden');
                    Toast.fire({ icon: 'success', title: 'Logo selected' });
                }
                reader.readAsDataURL(file);
            }
        };

        // 2. Reset Image Logic
        window.resetSkillIcon = function(btn) {
            const row = btn.closest('.skill-row');
            const input = row.querySelector('.skill-input');
            const previewBox = row.querySelector('.icon-preview-box');
            const fileNameSpan = row.querySelector('.file-name');
            const uploadBtnLabel = row.querySelector('.upload-controls label');

            input.value = '';
            previewBox.classList.add('hidden');
            fileNameSpan.textContent = 'No file chosen';
            uploadBtnLabel.classList.remove('hidden');
        };

        // 3. Clone Row Logic
        addBtn.addEventListener('click', function() {
            const firstRow = document.querySelector('.skill-row');
            const newRow = firstRow.cloneNode(true);

            // Clear all values in new row
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            newRow.querySelector('.icon-preview-box').classList.add('hidden');
            newRow.querySelector('.upload-controls label').classList.remove('hidden');
            newRow.querySelector('.file-name').textContent = 'No file chosen';

            skillsWrapper.appendChild(newRow);
            Toast.fire({ icon: 'success', title: 'New row added' });
        });

        // 4. Remove Row Logic
        window.removeSkillRow = function(btn) {
            const rows = document.querySelectorAll('.skill-row');
            if (rows.length > 1) {
                btn.closest('.skill-row').remove();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Access Denied',
                    text: 'You must have at least one technical skill.',
                    confirmButtonColor: '#4f46e5'
                });
            }
        };
    });
</script>
@endpush
@endsection