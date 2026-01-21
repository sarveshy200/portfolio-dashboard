@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Header Section</h1>
        <p class="text-sm text-gray-500 italic">Manage your hero introductions</p>
    </div>
    <a href="{{ route('header.add') }}" class="px-4 py-2 text-sm font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-md shadow-indigo-100">
        <i class="fa-solid fa-plus mr-2"></i>Add New Header
    </a>
</div>

<div class="bg-white p-6 border border-gray-200 rounded-xl shadow-sm">
    <table id="headerTable" class="display w-full text-sm">
        <thead class="bg-gray-50">
            <tr class="text-left">
                <th class="px-4 py-3">Title</th>
                <th class="px-4 py-3">Content</th>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($headers as $header)
            <tr class="group hover:bg-gray-50">
                <td class="px-4 py-4 font-semibold text-indigo-600">
                    {{ Str::limit($header->title, 40) }}
                </td>

                <td class="px-4 py-4 text-gray-500">
                    {{ Str::limit($header->content, 60) }}
                </td>

                <td class="px-4 py-4 text-gray-400">
                    {{ $header->created_at->format('Y/m/d') }}
                </td>

                <td class="px-4 py-4 text-right">
                    <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition">
                        <a href="{{ route('header.edit', $header->id) }}" 
                        class="p-1.5 bg-indigo-50 text-indigo-600 rounded-md hover:bg-indigo-600 hover:text-white transition">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <button type="button" 
                                onclick="deleteConfirmation({{ $header->id }})"
                                class="p-1.5 bg-red-50 text-red-600 rounded-md hover:bg-red-600 hover:text-white transition">
                            <i class="fa-solid fa-trash"></i>
                        </button>

                        <form id="delete-form-{{ $header->id }}" action="{{ route('header.delete', $header->id) }}" method="POST" class="hidden">
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
        $('#headerTable').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search headers...",
                lengthMenu: "Show _MENU_ entries"
            },
            columnDefs: [
                { orderable: false, targets: 3 } // Disable sorting on the Actions column
            ]
        });
    });

    function deleteConfirmation(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This header record will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5', // Matches indigo-600
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