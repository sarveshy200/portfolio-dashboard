@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Technical Skills</h1>
        <p class="text-sm text-gray-500 italic">Manage your expertise and tech stack logos.</p>
    </div>
    <a href="{{ route('skills.add') }}"
       class="px-5 py-2.5 text-sm font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-md shadow-indigo-100">
        <i class="fa-solid fa-plus mr-2"></i>Add New Skill Section
    </a>
</div>

<div class="bg-white p-6 border border-gray-200 rounded-2xl shadow-sm">
    <table id="skillsTable" class="display w-full text-sm">
        <thead class="bg-gray-50 text-gray-700 uppercase font-bold text-xs">
            <tr class="text-left">
                <th class="px-4 py-3">Logos</th>
                <th class="px-4 py-3">Section Title</th>
                <th class="px-4 py-3">Created Date</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">
            @foreach($skills as $skill)
                <tr class="group hover:bg-gray-50 transition">
                    <td class="px-4 py-4">
                        <div class="flex items-center -space-x-2">
                            @if(!empty($skill->skill_data))
                                @foreach(array_slice($skill->skill_data, 0, 4) as $item)
                                    <div class="w-10 h-10 rounded-lg border-2 border-white overflow-hidden bg-white p-1 shadow-sm" title="{{ $item['name'] }}">
                                        @if($item['image'])
                                            <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-contain">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-50 text-gray-300">
                                                <i class="fa-solid fa-image text-xs"></i>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                
                                @if(count($skill->skill_data) > 4)
                                    <div class="w-10 h-10 rounded-lg bg-indigo-50 border-2 border-white flex items-center justify-center text-[10px] font-bold text-indigo-600 shadow-sm">
                                        +{{ count($skill->skill_data) - 4 }}
                                    </div>
                                @endif
                            @endif
                        </div>
                    </td>

                    <td class="px-4 py-4 font-semibold text-indigo-600">
                        {{ $skill->section_title }}
                    </td>

                    <td class="px-4 py-4 text-gray-400">
                        {{ $skill->created_at->format('Y/m/d') }}
                    </td>

                    <td class="px-4 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('skills.edit', $skill->id) }}" class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition shadow-sm">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            <form action="{{ route('skills.delete', $skill->id) }}" method="POST" id="delete-form-{{ $skill->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $skill->id }})" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition shadow-sm">
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
        $('#skillsTable').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                emptyTable: "No skills sections found",
                search: "_INPUT_",
                searchPlaceholder: "Search sections...",
            },
            columnDefs: [
                { orderable: false, targets: [0, 3] }
            ]
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Delete this entire section?',
            text: "All skills and logos in this group will be permanently removed!",
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