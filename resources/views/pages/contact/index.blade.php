@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Contact Inquiries</h1>
        <p class="text-sm text-gray-500 italic">Manage and respond to messages from your portfolio</p>
    </div>
</div>

<div class="bg-white p-6 border border-gray-200 rounded-xl shadow-sm">
    <table id="contactTable" class="display w-full text-sm">
        <thead class="bg-gray-50 text-gray-700 uppercase font-bold text-xs">
            <tr class="text-left">
                <th class="px-4 py-3">Sender Name</th>
                <th class="px-4 py-3">Email Address</th>
                <th class="px-4 py-3">Subject</th>
                <th class="px-4 py-3">Received Date</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>

        <tbody>
        @foreach($contacts as $contact)
        <tr class="group hover:bg-gray-50 transition">
            <td class="px-4 py-4 font-bold text-indigo-600">
                {{ $contact->name }}
            </td>

            <td class="px-4 py-4 text-gray-600">
                {{ $contact->email }}
            </td>

            <td class="px-4 py-4 text-gray-500 italic">
                {{ $contact->subject }}
            </td>

            <td class="px-4 py-4 text-gray-400">
                {{ $contact->created_at->format('Y/m/d') }}
            </td>

            <td class="px-4 py-4 text-right">
                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition">

                    <!-- VIEW -->
                    <a href="{{ route('contact.view', $contact->id) }}"
                        class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white">
                        <i class="fa-solid fa-eye"></i>
                    </a>

                    <!-- DELETE -->
                    <form action="{{ route('contact.delete', $contact->id) }}"
                          method="POST"
                          class="delete-form">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white">
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

{{-- SUCCESS MESSAGE --}}
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Deleted!',
    text: "{{ session('success') }}",
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif

@endsection


@push('scripts')
<script>
$(document).ready(function() {

    // DATATABLE
    $('#contactTable').DataTable({
        responsive: true,
        pageLength: 10,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search inquiries...",
        },
        columnDefs: [{ orderable: false, targets: 4 }]
    });

    // SWEET ALERT DELETE CONFIRMATION
    $('.delete-form').on('submit', function(e){
        e.preventDefault();
        let form = this;

        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete this contact inquiry!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#4f46e5",
            cancelButtonColor: "#ef4444",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });

    });

});
</script>
@endpush
