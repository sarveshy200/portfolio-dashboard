@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto pb-12">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">View Contact Details</h1>
            <p class="text-gray-500 font-medium">Detailed view of the inquiry received from your portfolio.</p>
        </div>

        <div class="flex gap-3">

            <a href="{{ route('contact.index') }}"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Back to List
            </a>

            {{-- MAIL BUTTON --}}
            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}"
                class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md transition">

                <i class="fa-solid fa-reply mr-2"></i>Reply via Email
            </a>

        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-8">

        <div class="space-y-6">

            <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-50 pb-4">
                Sender Information
            </h2>

            {{-- NAME + EMAIL --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                        Full Name
                    </label>
                    <div class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl font-medium text-indigo-600">
                        {{ $contact->name }}
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                        Email Address
                    </label>
                    <div class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl font-medium text-gray-700">
                        {{ $contact->email }}
                    </div>
                </div>

            </div>

            {{-- SUBJECT --}}
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                    Subject
                </label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl font-semibold text-gray-800">
                    {{ $contact->subject }}
                </div>
            </div>

            {{-- MESSAGE --}}
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                    Message Content
                </label>
                <div class="w-full px-6 py-5 bg-gray-50 border border-gray-100 rounded-xl text-gray-600 leading-relaxed min-h-[200px]">
                    {{ $contact->message }}
                </div>
            </div>

            {{-- DATE --}}
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                    Received At
                </label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-gray-700">
                    {{ $contact->created_at->format('d M Y, h:i A') }}
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
