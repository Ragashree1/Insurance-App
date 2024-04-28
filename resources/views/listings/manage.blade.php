@extends('layout')
@section('content')

<div class="bg-gray-50 border border-gray-200 rounded p-10">
    <header>
        <h1 class="text-3xl text-center font-bold my-6 uppercase">Manage My Listings</h1>
    </header>

    <form action="/listings/manage/search/2" method="GET">
        @include('partials._search')
    </form>

    <!-- Button to trigger modal -->
    <button id="createButton" onclick="openCreateModal()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md mb-4">
        <i class="fa-solid fa fa-plus"></i>
        Create Listing
    </button>

    <!-- Create Modal -->
    <div id="createModal" class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 hidden overflow-y-auto">
        <div class="bg-white p-8 rounded-lg max-h-full overflow-y-auto" style="width: 50vw;">
            <!-- Modal content -->
            <h2 class="text-2xl font-bold mb-4">Create Listing</h2>

            @include('partials._createForm')
            
        </div>
    </div>
    
    <table class="w-full table-auto rounded-sm border border-gray-300">
        <thead>
            <tr>
                <th class="px-4 py-2 border border-gray-300">Image</th>
                <th class="px-4 py-2 border border-gray-300">ID</th>
                <th class="px-4 py-2 border border-gray-300">Title</th>
                <th class="px-4 py-2 border border-gray-300">Type</th>
                <th class="px-4 py-2 border border-gray-300">Price</th>
                <th class="px-4 py-2 border border-gray-300">Status</th>
                <th class="px-2 py-2 border border-gray-300">Seller_id</th>
                <th class="px-4 py-2 border border-gray-300">Actions</th>
            </tr>
        </thead>
        <tbody>
            @unless(count($listings) == 0)
            @foreach($listings as $listing)
            <tr class="border-gray-300">
                <td class="px-4 py-2 border border-gray-300 text-center">
                    <img src="{{$listing['image'] ? asset('storage/' . $listing['image']) : 
                    asset('images/no-image.png') }}" class="h-12 w-12 rounded-full mx-auto">
                </td>
                <td class="px-4 py-2 border border-gray-300">{{ $listing['id'] }}</td>
                <td class="px-4 py-2 border border-gray-300">
                    <div class="overflow-x-auto" style="max-width: 200px;">
                        {{ $listing['title'] }}
                    </div>
                </td>                
                <td class="px-4 py-2 border border-gray-300">{{ $listing['type'] }}</td>
                <td class="px-4 py-2 border border-gray-300">{{ $listing['sale_price'] }}</td>
                <td class="px-4 py-2 border border-gray-300">{{ $listing['status'] }}</td>
                <td class="px-2 py-2 border border-gray-300">{{ $listing['seller_id'] }}</td>
                <td class="px-4 py-2 border border-gray-300 text-center">
                    <!-- view -->
                    <a href="/listings/{{ $listing['id'] }}" class="inline-block bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-full">
                        <i class="fa-solid fa-eye"></i>
                        View
                    </a>
                    
                    <!-- update -->
                    <a href="/listings/manage/update/{{$listing['id']}}" class="inline-block bg-blue-200 hover:bg-blue-300 px-4 py-2 rounded-full">
                        <i class="fa-solid fa-pen"></i>
                        Update
                    </a>
                    
                    <!-- delete -->
                    <form action="/listings/manage/delete/{{$listing['id']}}" method="POST" class="inline" 
                            onsubmit="return confirm('Confirm delete?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-block bg-red-200 hover:bg-red-300 px-4 py-2 rounded-full">
                            <i class="fa-solid fa-trash"></i>
                            Delete
                        </button>
                    </form>                    
                </td>
            </tr>
            @endforeach
            @else
            <tr class="border-gray-300">
                <td colspan="7" class="px-4 py-2 text-center">No Listing Found</td>
            </tr>
            @endunless
        </tbody>
    </table>
</div>

<!-- JavaScript for modal -->
<script>
    @if ($errors->any())
        // Open the modal if there are validation errors
        openCreateModal();
    @endif

    // Function to open the modal
    function openCreateModal() {
        document.getElementById('createModal').classList.remove('hidden');
    }

    // Function to close the modal
    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
    }
</script>

@endsection
