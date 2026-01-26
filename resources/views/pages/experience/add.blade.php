@extends('layouts.app')

@section('content')

<div class=" mx-auto pb-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Add Experience</h1>
            <p class="text-gray-500 font-medium">Record your professional journey and career milestones.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('experience') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</a>
            <button type="submit" form="exp-form" class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md transition">Save Experience</button>
        </div>
    </div>

    <form id="exp-form" action="{{ route('experience.store') }}" method="POST">
        @csrf
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-8">
            
            <div class="space-y-6">
                <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-50 pb-4">Professional Details</h2>
                
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Experience Title</label>
                    <input type="text" name="title" placeholder="e.g., Senior Web Developer at XYZ" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition font-medium text-indigo-600">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Duration</label>
                    <input type="text" name="duration" placeholder="e.g., Oct 2023 - Present" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition font-medium">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Company Link (Optional)</label>
                    <input type="url" name="company_link" placeholder="https://company-website.com" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Job Description</label>
                    <textarea name="content" rows="6" placeholder="Describe your roles, responsibilities, and achievements..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 outline-none transition resize-none text-gray-600"></textarea>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Define the standardized Toast configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // 1. Success Message Toast
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif

        // 2. Error Message Toast
        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            });
        @endif

        // 3. Validation Fail Toast
        @if($errors->any())
            Toast.fire({
                icon: 'error',
                title: 'Validation failed. Please check the form.'
            });
        @endif

        // 4. Form Submission Protection with Loading State
        const expForm = document.getElementById('exp-form');
        if(expForm) {
            expForm.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin mr-2"></i> Saving...';
            });
        }
    });
</script>
@endpush
@endsection