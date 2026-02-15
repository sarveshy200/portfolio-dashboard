@extends('layouts.app')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
    <p class="text-gray-600">Portfolio Statistics</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    {{-- TOTAL VIEWS --}}
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="text-indigo-600 bg-indigo-50 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
            <i class="fa-solid fa-eye text-xl"></i>
        </div>
        <h3 class="text-gray-500 text-sm font-medium">Total Views</h3>
        <p class="text-2xl font-bold text-gray-900">
            0
        </p>
    </div>

    {{-- ACTIVE PROJECTS --}}
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="text-emerald-600 bg-emerald-50 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
            <i class="fa-solid fa-diagram-project text-xl"></i>
        </div>
        <h3 class="text-gray-500 text-sm font-medium">Active Projects</h3>
        <p class="text-2xl font-bold text-gray-900">
            {{ $totalProjects }}
        </p>
    </div>

    {{-- CONTACT INQUIRIES --}}
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="text-amber-600 bg-amber-50 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
            <i class="fa-solid fa-envelope text-xl"></i>
        </div>
        <h3 class="text-gray-500 text-sm font-medium">New Inquiries</h3>
        <p class="text-2xl font-bold text-gray-900">
            {{ $totalContacts }}
        </p>
    </div>

</div>

@endsection
