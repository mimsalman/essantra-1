@extends('layouts.app')

@section('title', 'Add Perfume')

@section('content')
<h1 class="text-2xl font-bold mb-6">Add Perfume</h1>

<div class="bg-white border rounded-lg p-6">
    <form method="POST" action="{{ route('admin.perfumes.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.perfumes._form')
    </form>
</div>
@endsection
