<form action="/listings/manage/update/{{$listing['id']}}" method="POST" enctype="multipart/form-data">
    @csrf   <!-- prevent cross site scripting -->
    @method('PUT')
        <div class="mb-6">
            <label
                for="title"
                class="inline-block text-sm mb-2"
                >Title</label
            >
            <input
                type="text"
                class="border border-gray-200 rounded p-2 w-full"
                name="title"
                value="{{$listing['title']}}"
            />
            
            @error('title')
                <p class="text-red-500 text-sm mt-1"> {{$message}}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="type" class="inline-block text-s mb-2"
                >type</label
            >
            <input
                type="text"
                class="border border-gray-200 rounded p-2 w-full"
                name="type"
                placeholder="Example: Condo, HDB..."
                value="{{$listing['type']}}"
            />
            @error('type')
                <p class="text-red-500 text-sm mt-1"> {{$message}}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="num_bedroom" class="inline-block text-s mb-2"
                >number of bedrooms</label
            >
            <input
                type="number"
                class="border border-gray-200 rounded p-2 w-full"
                name="num_bedroom"
                value="{{$listing['num_bedroom']}}"
            />
            @error('num_bedroom')
                <p class="text-red-500 text-sm mt-1"> {{$message}}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="num_bathroom" class="inline-block text-s mb-2"
                >number of bathroom</label
            >
            <input
                type="number"
                class="border border-gray-200 rounded p-2 w-full"
                name="num_bathroom"
                value="{{$listing['num_bathroom']}}"
            />
            @error('num_bathroom')
                <p class="text-red-500 text-sm mt-1"> {{$message}}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="area" class="inline-block text-sm mb-2">Area (in square feet)</label>
            <input type="number" 
                class="border border-gray-200 rounded p-2 w-full" 
                name="area" 
                placeholder="Example: 1500"
                value="{{$listing['area']}}"
            >
            @error('area')
                <p class="text-red-500 text-sm mt-1"> {{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label for="sale_price" class="inline-block text-sm mb-2">Sale Price ($)</label>
            <input type="number" class="border border-gray-200 rounded p-2 w-full" 
                name="sale_price" 
                placeholder="Example: 250000" 
                value="{{$listing['sale_price']}}"
            >
            @error('sale_price')
                <p class="text-red-500 text-sm mt-1"> {{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label for="status" class="inline-block text-sm mb-2">Status</label>
            <select name="status" id="status" class="border border-gray-200 rounded p-2 w-full">
                <option value="" disabled selected>Select status</option>
                <option value="new" @if($listing['status'] == 'new') selected @endif>New</option>
                <option value="sold" @if($listing['status'] == 'sold') selected @endif>Sold</option>
            </select>
            @error('status')
                <p class="text-red-500 text-sm mt-1"> {{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label 
                for="seller_id" 
                class="inline-block text-sm mb-2">
                    Seller ID
            </label>
            <input type="text" class="border border-gray-200 rounded p-2 w-full" 
                name="seller_id" 
                placeholder="Example: 123456" 
                value="{{$listing['seller_id']}}"
            >
            @error('seller_id')
                <p class="text-red-500 text-sm mt-1"> {{ $message }}</p>
            @enderror
        </div>        

        <div class="mb-6">
            <label
                for="location"
                class="inline-block text-sm mb-2"
                >Location
            </label>
            <input
                type="text"
                class="border border-gray-200 rounded p-2 w-full"
                name="location"
                placeholder="Example: Remote, Boston MA, etc"
                value = "{{$listing['location']}}"
            />
            @error('location')
                <p class="text-red-500 text-sm mt-1"> {{$message}}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="image" class="inline-block text-sm mb-2">
                Image
            </label>
            <input
                type="file"
                class="border border-gray-200 rounded p-2 w-full"
                name="image"
            />

            <img
                class="w-48 mr-6 mb-6"
                src="{{$listing['image'] ? asset('storage/' . $listing['image']) : 
                        asset('images/no-image.png') }}"
                alt=""
                style="width: 150px; height: 100px;"
            />

            @error('image')
                <p class="text-red-500 text-sm mt-1"> {{$message}}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label
                for="description"
                class="inline-block text-sm mb-2"
            >
                Description
            </label>
            <textarea
                class="border border-gray-200 rounded p-2 w-full"
                name="description"
                rows="5"
                placeholder="Include tasks, requirements, salary, etc"
            >{{$listing['description']}}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1"> {{$message}}</p>
            @enderror
        </div>

        <div class="mb-6">
            <button
                class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
            >
                Update Listing
            </button>

            <button type="button" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md" onclick="window.history.back()">
                Close
            </button>
        </div>
    </form>