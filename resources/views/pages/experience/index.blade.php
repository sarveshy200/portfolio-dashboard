@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Experience Section</h1>
        <p class="text-sm text-gray-500 italic">Manage your professional experiences</p>
    </div>
    <a href="{{ route('experience.add') }}" class="px-4 py-2 text-sm font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-md shadow-indigo-100">
        <i class="fa-solid fa-plus mr-2"></i>Add New Experience
    </a>
</div>

<div class="bg-white p-6 border border-gray-200 rounded-xl shadow-sm">
    <table id="experienceTable" class="display w-full text-sm">
        <thead class="bg-gray-50 text-gray-700 uppercase font-bold text-xs">
            <tr class="text-left">
                <th class="px-4 py-3">Title & Link</th>
                <th class="px-4 py-3">Job Description</th>
                <th class="px-4 py-3">Duration</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($experiences as $exp)
            <tr class="group hover:bg-gray-50 transition">
                <td class="px-4 py-4">
                    <div class="font-bold text-indigo-600">{{ $exp->title }}</div>
                    @if($exp->company_link)
                        <a href="{{ $exp->company_link }}" target="_blank" class="text-[10px] text-gray-400 hover:text-indigo-500 flex items-center gap-1 mt-1">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Visit Company
                        </a>
                    @endif
                </td>
                <td class="px-4 py-4 text-gray-600 leading-relaxed">
                    {{ Str::limit($exp->content, 100) }} </td>
                <td class="px-4 py-4 text-gray-400 font-medium">
                    {{ $exp->duration }}
                </td>
                <td class="px-4 py-4 text-right">
                    <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition">
                        <a href="{{ route('experience.edit', $exp->id) }}" class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition shadow-sm">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        
                        <form action="{{ route('experience.delete', $exp->id) }}" method="POST" id="delete-form-{{ $exp->id }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="deleteConfirmation({{ $exp->id }})" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition shadow-sm">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#experienceTable').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search experiences...",
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
            text: "This professional experience record will be permanently deleted!",
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