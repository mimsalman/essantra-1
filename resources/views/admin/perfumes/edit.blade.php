@extends('layouts.app')

@section('title', 'Edit Perfume')

@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Perfume</h1>

<div class="bg-white border rounded-lg p-6">
    <form method="POST" action="{{ route('admin.perfumes.update', $perfume) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.perfumes._form', ['perfume' => $perfume])
    </form>
</div>
@endsection
