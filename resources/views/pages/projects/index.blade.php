@extends('layouts.app')

@section('content')

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Project Section</h1>
        <p class="text-sm text-gray-500 italic">Showcase and manage your creative and technical works</p>
    </div>
    <a href="{{ route('project.add') }}"
       class="px-4 py-2 text-sm font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md">
        <i class="fa-solid fa-plus mr-2"></i>Add New Project
    </a>
</div>

<div class="bg-white p-6 border border-gray-200 rounded-xl shadow-sm">
    <table id="projectTable" class="display w-full text-sm">
        <thead class="bg-gray-50 text-gray-700 uppercase font-bold text-xs">
            <tr>
                <th>Thumbnail</th>
                <th>Project Details</th>
                <th>Technologies</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">

        @forelse($projects as $project)
            <tr class="group hover:bg-gray-50 transition">

                {{-- Thumbnail --}}
                <td class="px-4 py-4">
                    <div class="w-16 h-12 rounded-lg border overflow-hidden bg-gray-100 flex items-center justify-center">
                        @if($project->image)
                            <img src="{{ asset('storage/'.$project->image) }}"
                                 class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-image text-gray-300"></i>
                        @endif
                    </div>
                </td>

                {{-- Details --}}
                <td class="px-4 py-4">
                    <div class="font-bold text-indigo-600">
                        {{ $project->title }}
                    </div>

                    <div class="text-xs text-gray-500 mt-1 line-clamp-1">
                        {{ $project->description }}
                    </div>

                    @if($project->link)
                        <a href="{{ $project->link }}" target="_blank"
                           class="text-[10px] text-gray-400 hover:text-indigo-500 flex items-center gap-1 mt-1">
                            <i class="fa-solid fa-external-link-alt"></i> Live Demo
                        </a>
                    @endif
                </td>

                {{-- Technologies --}}
                <td class="px-4 py-4">
                    <div class="flex flex-wrap gap-1">
                        @foreach($project->technologies ?? [] as $tech)
                            <span
                                class="px-2.5 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-bold rounded-full uppercase">
                                {{ $tech['name'] }}
                            </span>
                        @endforeach
                    </div>
                </td>

                {{-- Actions --}}
                <td class="px-4 py-4 text-right">
                    <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition">
                        <a href="{{ route('project.edit', $project->id) }}"
                           class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <button type="button"
                                onclick="deleteConfirmation({{ $project->id }})"
                                class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>

                        <form id="delete-form-{{ $project->id }}"
                              action="{{ route('project.delete', $project->id) }}"
                              method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center py-10 text-gray-400">
                    No projects found. Start by adding one 🚀
                </td>
            </tr>
        @endforelse

        </tbody>
    </table>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    $('#projectTable').DataTable({
        responsive: true,
        pageLength: 10,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search projects...",
            lengthMenu: "Show _MENU_ entries"
        },
        columnDefs: [
            { orderable: false, targets: [0, 3] }
        ]
    });
});

function deleteConfirmation(id) {
    Swal.fire({
        title: 'Delete Project?',
        text: "This project and its assets will be permanently removed!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4f46e5',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endpush
