@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded shadow">
        {{ session('error') }}
    </div>
@endif
@if($errors->any())
    <div class="mb-4 p-4 bg-red-50 text-red-700 rounded shadow">
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif 