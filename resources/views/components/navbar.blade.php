<nav class="w-full border-b bg-white">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="{{ route('home') }}" class="text-xl font-extrabold tracking-tight">
            {{ config('app.name') }}
        </a>

        <div class="flex items-center gap-6 text-sm font-medium">
            <a href="{{ route('shop.index') }}" class="text-gray-700 hover:text-black">Shop</a>

            @auth
                <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-black">Dashboard</a>

                @if(auth()->user()->role === 'admin')
                    {{-- IMPORTANT: match your real admin route name --}}
                    <a href="{{ route('admin.perfumes.index') }}" class="text-gray-700 hover:text-black">Admin</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="px-3 py-1 rounded border text-red-600 hover:bg-red-50">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-black">Login</a>
            @endauth
        </div>
    </div>
</nav>
