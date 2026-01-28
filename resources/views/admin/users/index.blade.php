@extends('layouts.app')
@section('title','Admin - Users')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-4xl font-bold text-white">Admin: Users</h1>
</div>

{{-- Tabs --}}
@include('admin.partials.tabs')
<!-- BG image-->
    <div class="fixed inset-0 -z-10">
        <div
            class="absolute inset-0 bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('images/perfume-bg3.jpg') }}');">
        </div>

        <!-- overlay contrast-->
        <!--<div class="absolute inset-0 bg-white/20"></div>-->
    </div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-6">

    {{-- Add User --}}
    <div class="lg:col-span-4">
        <div class="bg-white border rounded-2xl p-6 shadow-sm">
            <h2 class="font-semibold text-lg">Add User</h2>

            <form method="POST" action="{{ route('admin.users.store') }}" class="mt-4 space-y-3">
                @csrf
                <input name="name" class="w-full border rounded-xl px-4 py-2.5" placeholder="Name" required>
                <input name="email" type="email" class="w-full border rounded-xl px-4 py-2.5" placeholder="Email" required>
                <input name="password" type="password" class="w-full border rounded-xl px-4 py-2.5" placeholder="Password" required>

                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_admin" value="1">
                    Make admin
                </label>

                <button class="w-full bg-gray-900 hover:bg-black text-white font-semibold px-4 py-2.5 rounded-xl">
                    Add User
                </button>
            </form>
        </div>
    </div>

            {{-- Users table --}}
            <div class="lg:col-span-8">
                <div class="bg-white border rounded-2xl shadow-sm p-6">
            <h2 class="text-lg font-bold">Registered Users</h2>

            {{-- CUSTOMERS --}}
                <div class="mt-5">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-gray-800">Customers</h3>
                        <span class="text-xs text-gray-500">{{ $customers->count() }} users</span>
                    </div>

                    <div class="overflow-hidden rounded-xl border">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr class="text-left text-gray-600">
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Email</th>
                                    <th class="px-4 py-3">Joined</th>
                                    <th class="px-4 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse($customers as $u)
                                    <tr>
                                        <td class="px-4 py-3 font-semibold">{{ $u->name }}</td>
                                        <td class="px-4 py-3">{{ $u->email }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $u->created_at->format('d M Y') }}</td>
                                        <td class="px-4 py-3 text-right">
                                            <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}"
                                                onsubmit="return confirm('Delete this user?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600 hover:underline font-semibold">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">No customers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ADMINS --}}
                <div class="mt-8">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-gray-800">Admins</h3>
                        <span class="text-xs text-gray-500">{{ $admins->count() }} admins</span>
                    </div>

                    <div class="overflow-hidden rounded-xl border">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr class="text-left text-gray-600">
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Email</th>
                                    <th class="px-4 py-3">Joined</th>
                                    <th class="px-4 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse($admins as $u)
                                    <tr>
                                        <td class="px-4 py-3 font-semibold">
                                            {{ $u->name }}
                                            @if($u->id === auth()->id())
                                                <span class="ml-2 text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-700">You</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">{{ $u->email }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $u->created_at->format('d M Y') }}</td>
                                        <td class="px-4 py-3 text-right">
                                            @if($u->id === auth()->id())
                                                <span class="text-xs text-gray-400">Not allowed</span>
                                            @else
                                                <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}"
                                                    onsubmit="return confirm('Delete this admin?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="text-red-600 hover:underline font-semibold">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">No admins found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
