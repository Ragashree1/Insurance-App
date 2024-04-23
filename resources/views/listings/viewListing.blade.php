@extends('layout')
@section('content')

<a href="/listings" class="inline-block text-black ml-4 mb-4"
                ><i class="fa-solid fa-arrow-left"></i> Back
</a>

<div class="mx-4">
    <div class="bg-gray-50 border border-gray-200 p-10 rounded-lg flex flex-col md:flex-row items-center justify-center md:justify-start">
        <img class="w-full md:w-80 mr-7 mb-6 md:mb-0" src="{{asset('images/no-image.png')}}" alt="Listing Image">


        <div class="flex flex-col items-center md:items-start text-center md:text-left">
            <h3 class="text-2xl mb-2">{{$listing->title}}</h3>
            <div class="text-xl font-bold mb-4">{{$listing->type}}</div>
            <div class="flex justify-between text-lg mb-4">
                <div class="p-2 bg-gray-200 rounded-lg">
                    <span class="font-bold mr-2">
                        <i class="fa-solid fa-dollar-sign"></i> {{$listing->sale_price}}
                    </span>
                </div>
                <div class="p-2 bg-gray-200 rounded-lg ml-4">
                    <span class="font-bold mr-2">
                        <i class="fa-solid fa-ruler"></i> {{$listing->area}} sq. ft.
                    </span>
                </div>
            </div>
            
            <ul class="flex">
                <li class="flex items-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-sm">
                    <i class="fa-solid fa-bed"></i>
                    &nbsp; {{$listing->num_bedroom}} bedroom
                </li>
                <li class="flex items-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-sm">
                    <i class="fa-solid fa-bath"></i>
                    &nbsp; {{$listing->num_bathroom}} bathroom
                </li>
            </ul>
            <div class="text-lg my-4">
                <i class="fa-solid fa-location-dot"></i> {{$listing->location}}
            </div>
            <div class="border border-gray-200 w-full mb-6"></div>
            <div>
                <h3 class="text-3xl font-bold mb-4">
                    Property Description
                </h3>
                <div class="text-lg space-y-6">
                    {{$listing->description}}
                </div>
            </div>
        </div>
    </div>
</div>



@endsection