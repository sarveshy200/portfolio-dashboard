<aside class="w-64 bg-slate-900 text-white flex-shrink-0 hidden md:flex flex-col">
    <div class="p-6 text-2xl font-bold border-b border-slate-800 text-indigo-400">
        Admin<span class="text-white">Panel</span>
    </div>
    <nav class="flex-1 mt-4 px-4 space-y-2 overflow-y-auto">
        
        <a href="{{ route('dashboard') }}" 
           class="flex items-center p-3 text-sm font-medium rounded-lg transition {{ Request::routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="fa-solid fa-chart-line mr-3 text-lg w-6 text-center"></i> Dashboard
        </a>

        <a href="{{ route('header') }}" 
           class="flex items-center p-3 text-sm font-medium rounded-lg transition {{ Request::routeIs('header*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="fa-solid fa-window-maximize mr-3 text-lg w-6 text-center"></i> Header Section
        </a>

        <a href="{{ route('aboutus') }}" 
           class="flex items-center p-3 text-sm font-medium rounded-lg transition {{ Request::routeIs('aboutus*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="fa-solid fa-address-card mr-3 text-lg w-6 text-center"></i> About Us
        </a>

        <a href="{{ route('skills') }}" 
           class="flex items-center p-3 text-sm font-medium rounded-lg transition {{ Request::routeIs('skills*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="fa-solid fa-screwdriver-wrench mr-3 text-lg w-6 text-center"></i> Skills
        </a>

        <a href="{{ route('education') }}" 
           class="flex items-center p-3 text-sm font-medium rounded-lg transition {{ Request::routeIs('education*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="fa-solid fa-graduation-cap mr-3 text-lg w-6 text-center"></i> Education
        </a>

        <a href="#" 
           class="flex items-center p-3 text-sm font-medium rounded-lg transition {{ Request::routeIs('experience*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="fa-solid fa-briefcase mr-3 text-lg w-6 text-center"></i> Experience
        </a>

        <a href="#" 
           class="flex items-center p-3 text-sm font-medium rounded-lg transition {{ Request::routeIs('projects*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="fa-solid fa-code mr-3 text-lg w-6 text-center"></i> Projects
        </a>

        <a href="#" 
           class="flex items-center p-3 text-sm font-medium rounded-lg transition {{ Request::routeIs('achievements*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="fa-solid fa-trophy mr-3 text-lg w-6 text-center"></i> Achievements
        </a>
        
    </nav>
</aside>