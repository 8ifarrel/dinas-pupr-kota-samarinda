<nav class="bg-blue-700 text-white p-4 mb-6">
    <div class="container mx-auto flex justify-between items-center">
        <span class="font-semibold text-lg">E-Panel Admin</span>
        
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
            @csrf
        </form>

        <a href="#" class="text-white hover:underline"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
    </div>
</nav>