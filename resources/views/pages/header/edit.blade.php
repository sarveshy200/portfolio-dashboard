@extends('layouts.app')

@section('content')

<div class="max-w-10xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Header</h1>
            <p class="text-gray-500 font-medium">Update your portfolio's introduction and social links.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('header') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</a>
            <button type="submit" form="header-form" class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md shadow-indigo-100 transition">Update Header</button>
        </div>
    </div>

    <form id="header-form" action="{{ route('header.update', $header->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
            <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-50 pb-4">General Content</h2>
            
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">Main Title / Introduction</label>
                <input type="text" name="title" value="{{ old('title', $header->title) }}" placeholder="e.g., Hello, I'm Sarvesh..." 
                    class="w-full px-4 py-3 bg-gray-50 border @error('title') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition font-medium">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">Detailed Description</label>
                <textarea name="content" rows="6" class="w-full px-4 py-3 bg-gray-50 border @error('content') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition resize-none">{{ old('content', $header->content) }}</textarea>
                @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
            <div class="flex items-center justify-between border-b border-gray-50 pb-4">
                <h2 class="text-lg font-semibold text-gray-800">Social Connections</h2>
                <button type="button" id="add-social-btn" class="text-sm font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 transition">
                    <i class="fa-solid fa-plus text-xs"></i> Add Another Link
                </button>
            </div>

            <div id="social-wrapper" class="space-y-4">
               {{-- Loop through existing social links from your JSON --}}
                @foreach($header->social_links as $index => $link)

                <div class="social-row grid grid-cols-1 md:grid-cols-3 gap-6 p-4 bg-gray-50 rounded-xl border border-gray-200 relative">
                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-400 uppercase">Platform Name</label>
                        <input type="text" name="social_name[]" value="{{ $link['name'] }}" class="w-full px-4 py-2 rounded-lg border border-gray-200">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-400 uppercase">Brand Icon</label>
                        <div class="flex items-center gap-3">
                            {{-- Check if icon exists in the link array --}}
                            <div class="icon-preview-box {{ $link['icon'] ? '' : 'hidden' }} relative w-12 h-12 flex-shrink-0">
                                {{-- IMPORTANT: Use the asset helper with the storage/ prefix --}}
                                <img src="{{ asset('storage/' . $link['icon']) }}" 
                                    class="w-full h-full object-contain bg-white border border-gray-200 rounded-lg p-1 shadow-sm">
                                
                                {{-- Remove/Reset button as seen in your reference --}}
                                <button type="button" onclick="resetIconInput(this)" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-[10px] hover:bg-red-600 transition">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>

                            <div class="upload-controls flex flex-col items-start gap-1">
                                <label class="cursor-pointer {{ $link['icon'] ? 'hidden' : '' }}">
                                    <span class="px-3 py-1.5 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-full hover:bg-indigo-100 transition inline-block">
                                        Choose file
                                    </span>
                                    <input type="file" name="social_icon[]" onchange="handleIconPreview(this)" class="hidden icon-input" accept="image/*">
                                </label>
                                {{-- Show filename if exists, otherwise show default text --}}
                                <span class="file-name text-[10px] text-gray-400 italic truncate max-w-[150px]">
                                    {{ $link['icon'] ? basename($link['icon']) : 'No file chosen' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-400 uppercase">Profile URL</label>
                        <input type="url" name="social_url[]" value="{{ $link['url'] }}" class="w-full px-4 py-2 rounded-lg border border-gray-200">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </form>
</div>

<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
});

function handleIconPreview(input) {
    const file = input.files[0];
    const row = input.closest('.grid');
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
            Toast.fire({ icon: 'success', title: 'New icon selected' });
        }
        reader.readAsDataURL(file);
    }
}

function resetIconInput(btn) {
    const row = btn.closest('.grid');
    const input = row.querySelector('.icon-input');
    const previewBox = row.querySelector('.icon-preview-box');
    const fileNameSpan = row.querySelector('.file-name');
    const uploadBtnLabel = row.querySelector('.upload-controls label');

    input.value = ''; 
    previewBox.classList.add('hidden'); 
    fileNameSpan.textContent = 'No file chosen'; 
    uploadBtnLabel.classList.remove('hidden'); 
}

function removeSocialRow(btn) {
    const rows = document.querySelectorAll('.social-row');
    if (rows.length > 1) {
        btn.closest('.social-row').remove();
    } else {
        Toast.fire({ icon: 'error', title: 'At least one connection required' });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const socialWrapper = document.getElementById('social-wrapper');
    const addBtn = document.getElementById('add-social-btn');

    addBtn.addEventListener('click', function() {
        const firstRow = socialWrapper.querySelector('.social-row');
        const newRow = firstRow.cloneNode(true);
        newRow.querySelectorAll('input').forEach(input => input.value = '');
        newRow.querySelector('.icon-preview-box').classList.add('hidden');
        newRow.querySelector('.upload-controls label').classList.remove('hidden');
        newRow.querySelector('.file-name').textContent = 'No file chosen';
        socialWrapper.appendChild(newRow);
    });
});
</script>
@endsection