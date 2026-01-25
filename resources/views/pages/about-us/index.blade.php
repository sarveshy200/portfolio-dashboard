@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">About Us Section</h1>
        <p class="text-sm text-gray-500 italic">Manage your professional bio and profile assets.</p>
    </div>
    <a href="{{ route('aboutus.add') }}" class="px-5 py-2.5 text-sm font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-md shadow-indigo-100">
        <i class="fa-solid fa-plus mr-2"></i>Add About Details
    </a>
</div>

<div class="bg-white p-6 border border-gray-200 rounded-2xl shadow-sm">
    <table id="aboutTable" class="display w-full text-sm">
        <thead class="bg-gray-50 text-gray-700 uppercase font-bold text-xs">
            <tr class="text-left">
                <th class="px-4 py-3">Photo</th>
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Bio Preview</th>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($abouts as $about)
            <tr class="group hover:bg-gray-50 transition">
                <td class="px-4 py-4">
                    <div class="w-12 h-12 rounded-lg border border-gray-200 overflow-hidden shadow-sm bg-gray-50 flex items-center justify-center">
                        @if($about->profile_image)
                            <img src="{{ asset('storage/' . $about->profile_image) }}" class="w-full h-full object-cover" alt="{{ $about->name }}">
                        @else
                            <i class="fa-solid fa-user text-xl text-gray-300"></i>
                        @endif
                    </div>
                </td>
                <td class="px-4 py-4 font-semibold text-indigo-600">
                    {{ $about->name }}
                </td>
                <td class="px-4 py-4 text-gray-500">
                    {{ Str::limit($about->about_content, 60) }}
                </td>
                <td class="px-4 py-4 text-gray-400">
                    {{ $about->created_at->format('Y/m/d') }}
                </td>
                <td class="px-4 py-4 text-right">
                    <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition">
                        <a href="{{ route('aboutus.edit', $about->id) }}" class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition shadow-sm" title="Edit Profile">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        
                        <button type="button" onclick="confirmAboutDelete({{ $about->id }})" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition shadow-sm" title="Delete Profile">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>

                        <form id="delete-form-{{ $about->id }}" action="{{ route('aboutus.delete', $about->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@push('scripts')
<script>
     $(document).ready(function() {
        $('#aboutTable').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search headers...",
                lengthMenu: "Show _MENU_ entries"
            },
            columnDefs: [
                { orderable: false, targets: 3 } 
            ]
        });
    });

    function confirmAboutDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the bio and associated files!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush
@endsection