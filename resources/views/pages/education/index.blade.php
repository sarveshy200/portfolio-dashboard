@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Education Section</h1>
        <p class="text-sm text-gray-500 italic">Manage your education details</p>
    </div>
    <a href="{{ route('education.add') }}" class="px-4 py-2 text-sm font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-md shadow-indigo-100">
        <i class="fa-solid fa-plus mr-2"></i>Add New Education
    </a>
</div>

<div class="bg-white p-6 border border-gray-200 rounded-xl shadow-sm">
    <table id="educationTable" class="display w-full text-sm">
        <thead class="bg-gray-50 text-gray-700 uppercase font-bold text-xs">
            <tr class="text-left">
                <th class="px-4 py-3">Logo</th>
                <th class="px-4 py-3">College & Course</th>
                <th class="px-4 py-3">Duration</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($educations as $edu)
            <tr class="group hover:bg-gray-50 transition">
                <td class="px-4 py-4">
                    <div class="w-12 h-12 rounded-lg border border-gray-100 overflow-hidden bg-white p-1">
                        @if($edu->college_image)
                            <img src="{{ asset('storage/' . $edu->college_image) }}" class="w-full h-full object-contain" alt="College Logo">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-50 text-gray-300">
                                <i class="fa-solid fa-university"></i>
                            </div>
                        @endif
                    </div>
                </td>
                <td class="px-4 py-4">
                    <div class="font-bold text-indigo-600">{{ $edu->college_name }}</div>
                    <div class="text-xs text-gray-500">{{ $edu->course }}</div>
                    @if($edu->college_link)
                        <a href="{{ $edu->college_link }}" target="_blank" class="text-[10px] text-gray-400 hover:text-indigo-500 flex items-center gap-1 mt-1">
                            <i class="fa-solid fa-link"></i> Visit Website
                        </a>
                    @endif
                </td>
                <td class="px-4 py-4 text-gray-600 font-medium">
                    {{ $edu->duration }}
                </td>
                <td class="px-4 py-4 text-right">
                    <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition">
                        <a href="{{ route('education.edit', $edu->id) }}" class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('education.delete', $edu->id) }}" method="POST" id="delete-form-{{ $edu->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="deleteConfirmation({{ $edu->id }})" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
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
        $('#educationTable').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search education...",
                lengthMenu: "Show _MENU_ entries"
            },
            columnDefs: [
                { orderable: false, targets: 3 } 
            ]
        });
    });

    function deleteConfirmation(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This Education record will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5', 
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endpush
@endsection