@extends('layout')

@section('content')
    @if (session('Success'))
    <div class="container-fluid fixed-top d-flex justify-content-center">
        <div class="w-auto alert alert-success alert-dismissible m-2 fade show position" role="alert">
            {{session('Success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @elseif (session('Error'))
    <div class="container-fluid fixed-top d-flex justify-content-center">
        <div class="w-auto alert alert-danger alert-dismissible m-2 fade show position" role="alert">
            {{session('Error')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif
    <div class="p-2">
        <h1>Top Drinks</h1>
        @if (sizeOf($randomDrinks) > 0)
        <div class="row row-cols-1 row-cols-md-4">
            @foreach ( $randomDrinks as $drink)
            <div class="col">
                <div class="card card-style shadow-lg mb-5">
                        <img src="{{Storage::url($drink->picture)}}" class="border-rad-10 card-img opacity-50" width="300px" height="250px" alt="eurotruck">
                        <div class="card-img-overlay d-flex align-items-end">
                            <div class="bg-white opacity-75 p-2 border-rad-10">
                                <p class="bold-900 fs-5 card-title ">{{$drink->name}}</p>
                                <p class="card-text ">{{$drink->genre}}</p>
                            </div>
                            <a href="/Drink/{{$drink->id}}" class="btn stretched-link btn-focus-none"></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @elseif (sizeOf($drinks) == 0)
        <p>There are no drinks content can be showed right now</p>
        @endif
    </div>
@endsection
