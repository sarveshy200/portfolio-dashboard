<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Admin</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Modern styling for DataTables to match your UI */
        .dataTables_wrapper .dataTables_length select { padding-right: 2rem; border-radius: 0.5rem; }
        .dataTables_wrapper .dataTables_filter input { border-radius: 0.5rem; padding: 0.4rem 0.8rem; border: 1px solid #e5e7eb; }
        table.dataTable thead th { border-bottom: 1px solid #f3f4f6 !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #4f46e5 !important; color: white !important; border: none; border-radius: 0.4rem; }
    </style>
</head>
<body class="h-full">

    <div class="flex h-screen overflow-hidden">
        @include('partials.sidebar')

        <div class="flex flex-col flex-1 w-full overflow-y-auto">
            @include('partials.header')

            <main class="p-6">
                <div class="mx-auto max-w-10xl">
                    @yield('content')
                </div>
            </main>

            @include('partials.footer')
        </div>
    </div>

    @stack('scripts')

    <script>
        // Set up the Toast configuration
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

        // Trigger Toast for Laravel Session Success
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif

        // Trigger Toast for Laravel Session Error
        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            });
        @endif
    </script>
</body>
</html>