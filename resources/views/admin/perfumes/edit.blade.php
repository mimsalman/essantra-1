@extends('layouts.store')

@section('title', 'Edit Perfume')

@section('content')
<h1 class="text-3xl font-extrabold">Edit Perfume</h1>

<div class="mt-6 bg-white border rounded-2xl p-6">
    <form method="POST" action="{{ route('admin.perfumes.update', $perfume) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.perfumes._form', ['perfume' => $perfume])
        <div class="mt-6 flex gap-3">
            <button class="px-5 py-3 rounded-xl bg-rose-600 text-white font-semibold hover:bg-rose-700">Update</button>
            <a href="{{ route('admin.perfumes.index') }}" class="px-5 py-3 rounded-xl border hover:bg-gray-50">Cancel</a>
        </div>
    </form>
</div>
@endsection
