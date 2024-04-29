@extends('layout')
@section('content')

<div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
    <header class="text-center">
        <h2 class="text-2xl font-bold uppercase mb-1">
            Update Listing ID: {{$listing['id']}}
        </h2>
    </header>

    @include('partials._updateForm')
        
</div>

@endsection