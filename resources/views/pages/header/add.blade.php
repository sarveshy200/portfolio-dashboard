@extends('layouts.app')

@section('content')

<div class="max-w-10xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Add New Header</h1>
            <p class="text-gray-500 font-medium">Customize your portfolio's hero area and social links.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('header') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</a>
            <button type="submit" form="header-form" class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md shadow-indigo-100 transition">Save Changes</button>
        </div>
    </div>

    <form id="header-form" action="{{ route('header.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
            <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-50 pb-4">General Content</h2>
            
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">Main Title / Introduction</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Main Title / Introduction" 
                    class="w-full px-4 py-3 bg-gray-50 border @error('title') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition text-lg font-medium">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">Detailed Description</label>
                <textarea name="content" rows="6" placeholder="Describe your expertise..." 
                    class="w-full px-4 py-3 bg-gray-50 border @error('content') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition resize-none">{{ old('content') }}</textarea>
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
                {{-- Handle old input if validation fails --}}
                @php $links = old('social_name', ['']); @endphp
                @foreach($links as $index => $oldName)
                <div class="social-row grid grid-cols-1 md:grid-cols-3 gap-6 p-4 bg-gray-50 rounded-xl border border-gray-200 relative group animate-fade-in">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Platform Name</label>
                        <input type="text" name="social_name[]" value="{{ $oldName }}" placeholder="GitHub" class="w-full px-4 py-2 bg-white border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-indigo-500/20">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Brand Icon</label>
                        <div class="flex items-center gap-3">
                            <div class="icon-preview-box hidden relative w-12 h-12 flex-shrink-0">
                                <img src="" class="w-full h-full object-contain bg-white border border-gray-200 rounded-lg p-1 shadow-sm">
                                <button type="button" onclick="resetIconInput(this)" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-[10px] shadow hover:bg-red-600 transition">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>

                            <div class="upload-controls flex flex-col items-start gap-1">
                                <label class="cursor-pointer">
                                    <span class="px-3 py-1.5 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-full hover:bg-indigo-100 transition inline-block">
                                        Choose file
                                    </span>
                                    <input type="file" name="social_icon[]" onchange="handleIconPreview(this)" class="hidden icon-input" accept="image/*">
                                </label>
                                <span class="file-name text-[10px] text-gray-400 italic truncate max-w-[150px]">No file chosen</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 relative">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Profile URL</label>
                        <div class="flex gap-2">
                            <input type="url" name="social_url[]" value="{{ old('social_url.'.$index) }}" placeholder="https://..." class="flex-1 px-4 py-2 bg-white border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-indigo-500/20">
                            <button type="button" onclick="removeSocialRow(this)" class="text-red-400 hover:text-red-600 p-2 transition">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
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
    timer: 3000,
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
            Toast.fire({ icon: 'success', title: 'Icon selected' });
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
        Toast.fire({ icon: 'error', title: 'At least one row required' });
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
        Toast.fire({ icon: 'success', title: 'New row added' });
    });

    {{-- Global Flash Messages --}}
    @if(session('success'))
        Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
    @endif

    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Error!', text: "{{ session('error') }}" });
    @endif

    @if($errors->any())
        Toast.fire({ icon: 'error', title: 'Validation failed. Please check the form.' });
    @endif
});
</script>
@endsection