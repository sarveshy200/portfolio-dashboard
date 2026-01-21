<header class="bg-white border-b border-gray-200 sticky top-0 z-10">
    <div class="flex items-center justify-between h-16 px-8">
        <h2 class="text-xl font-semibold text-gray-800">Overview</h2>
        
        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-500 italic">Welcome Back, Admin</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition shadow-md shadow-red-100">
                    <i class="fa-solid fa-right-from-bracket mr-2"></i>Logout
                </button>
            </form>
        </div>
    </div>
</header>