@extends('layout')
@section('content')
@include('partials._hero')
@include('partials._search')

<div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">

    @unless(count($listings) == 0)
    @foreach($listings as $listing)
    
    <div class="relative bg-gray-50 border border-gray-200 rounded p-6">
        <div class="flex">
            <img class="hidden w-48 mr-6 md:block" src="{{asset('images/no-image.png')}}" alt="" />
            <div>
                <h3 class="text-2xl">
                    <a href="/listings/{{$listing['id']}}" style="text-decoration: underline;">
                        {{$listing['title']}}
                    </a>
                </h3>
                <div class="text-xl font-bold mb-4">{{$listing['type']}}</div>
                <ul class="flex">
                    <li class="flex items-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-sm">
                        <i class="fa-solid fa-bed"></i>
                        &nbsp; {{$listing['num_bedroom']}} &nbsp;bedroom
                    </li>
                    <li class="flex items-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-sm">
                        <i class="fa-solid fa-bath"></i>
                        &nbsp; {{$listing['num_bathroom']}} bathroom
                    </li>
                </ul>
                <div class="text-lg mt-4">
                    <i class="fa-solid fa-location-dot"></i> {{$listing['location']}}
                </div>
                <div class="text-lg mt-4 text-green-600 font-semibold">
                    <i class="fa-solid fa-dollar-sign"></i> {{$listing['sale_price']}}
                </div>                    
            </div>
        </div>
        <div class="absolute bottom-0 right-0 bg-{{ $listing['status'] === 'new' ? 'green' : 'red' }}-500 text-white px-3 py-3 rounded-bl rounded-tr text-base font-semibold">
            {{ ucfirst($listing['status']) }}
        </div>
        <div class="text-sm text-gray-500 mt-4">
            <br>
            Posted on: {{ date('Y-m-d', strtotime($listing['create_date']))}}
        </div>            
    </div>
    
    @endforeach
    @else 
    <p>No Listings found</p>
    @endunless

</div>

@endsection
