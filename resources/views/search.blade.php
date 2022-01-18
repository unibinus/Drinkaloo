@extends('layout')

@section('content')
<div class="p-2">
    <h1>Search Drinks</h1>
    @if (sizeOf($drinks) > 0)
    <div class="row row-cols-1 row-cols-md-4">
        @foreach ($drinks as $drink)
        <div class="col">
            <div class="card card-style shadow-lg mb-5">
                    <img src="{{Storage::url($drink->picture)}}" class="border-rad-10 card-img opacity-50" width="300px" height="250px" alt="eurotruck">
                    <div class="card-img-overlay d-flex align-items-end">
                        <div class="bg-white opacity-75 p-2 border-rad-10">
                            <p class="drink-title fs-5 card-title ">{{$drink->name}}</p>
                            <p class="card-text ">{{$drink->category}}</p>
                        </div>
                        <a href="Drink/{{$drink->id}}" class="btn stretched-link btn-focus-none"></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @elseif (sizeOf($drinks) == 0)
    <p>There are no drinks content can be showed right now</p>
    @endif
</div>
<div class="d-flex justify-content-end">
    {{$drinks->withQueryString()->links()}}
</div>
@endsection
