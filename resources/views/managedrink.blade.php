@extends('layout')

@section('content')
@if (session('Success'))
<div class="container-fluid fixed-top d-flex justify-content-center">
    <div class="w-auto alert alert-success alert-dismissible m-2 fade show position" role="alert">
        {{session('Success')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

<div class="container-fluid px-3">
    <h1>Manage Drink</h1>
    <p class="fw-bold fs-5 mb-2">Filter by Drink Name</p>
    <form action="{{Route('FilterDrink')}}" method="GET">
    <div class="input-group mb-2">
        <span class="fas fa-search input-group-text py-2 light-theme-form">
        </span>
        <div class="width-300">
                <input class="form-control mr-sm-2 light-theme-form" name="search" type="search" placeholder="Drink Name"
                aria-label="Search">
            </div>
        </div>
        <p class="fw-bold fs-5">Filter by Drink Category</p>
        <div class="container-fluid">
            <div class="row row-cols-auto">
                <div class="col ps-0">
                    <div class="form-check form-check-inline">
                        {{-- dalam bentuk array, biar bisa dipilih dan dapetin multiple value --}}
                        <input class="form-check-input" type="checkbox" name="filterCheckbox[]" value="Alcohol">
                        <label class="form-check-label" for="inlineCheckbox1">Alcohol</label>
                    </div>
                    <br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="filterCheckbox[]" value="Juice">
                        <label class="form-check-label" for="inlineCheckbox1">Juice</label>
                    </div>
                </div>
                <div class="col ps-0">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="filterCheckbox[]" value="Mineral">
                        <label class="form-check-label" for="inlineCheckbox1">Mineral</label>
                    </div>
                    <br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="filterCheckbox[]" value="Tea">
                        <label class="form-check-label" for="inlineCheckbox1">Tea</label>
                    </div>
                </div>
                <div class="col ps-0">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="filterCheckbox[]" value="Coffee">
                        <label class="form-check-label" for="inlineCheckbox1">Coffee</label>
                    </div>
                    <br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="filterCheckbox[]" value="Milk">
                        <label class="form-check-label" for="inlineCheckbox1">Milk</label>
                    </div>

                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-dark my-3">Search</button>
    </form>
    @if (sizeOf($drinks) > 0)
    <div class="row row-cols-1 row-cols-md-4">
        @foreach ($drinks as $drink)
        <div id="deleteDrink{{$drink["id"]}}" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content">
                    <div class="modal-body border-0">
                        <div class="container">
                            <div class="row">
                                <div class="col-1 px-1">
                                    <div class=" text-center">
                                        <i class=" circle-icon-danger p-2 fas fa-exclamation-triangle"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="fw-bold fs-5 mb-1">Delete Drink</p>
                                    <p>Are you sure you want to delete this drink? All of your data will be permanently removed from our servers forever. This action cannot be undone.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end pb-4 pe-4">
                        <button type="button" class="btn btn-outline-dark mx-3" data-bs-dismiss="modal">Cancel</button>
                        <form action="DeleteDrink/{{$drink["id"]}}" data-id="id" method="POST">
                            @method("DELETE")
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col mb-5">
            <div class="card card-style shadow-lg">
                            <img src="{{Storage::url($drink["picture"])}}" class="border-rad-10 card-img opacity-50" height="400px" alt="eurotruck">
                            <div class="card-img-overlay d-flex align-items-end">
                                <div class="bg-white opacity-75 p-2 border-rad-10">
                                    <p class="bold-900 fs-5 card-title ">{{$drink["name"]}}</p>
                                    <p class="card-text ">{{$drink["category"]}}</p>
                                </div>
                                <a href="/Drink/{{$drink["id"]}}" class="btn stretched-link"></a>
                            </div>
                        </div>
                        <ul class="list-group">
                            <a href="/UpdateDrink/{{$drink["id"]}}" class="btn btn-light text-start my-4 border-rad-10">
                                <i class="fas fa-pencil-alt me-2 icon-16"></i>Update</a>
                            <button class="btn btn-danger text-start border-rad-10 mb-4" data-bs-toggle="modal" data-bs-target="#deleteDrink{{$drink["id"]}}">
                                <i class="fas fa-trash-alt me-2 icon-16"></i>Delete</button>
                        </ul>
                    </div>

                    @endforeach
                </div>
                <div class="d-flex justify-content-between">
                    <p>Showing {{$drinks->firstItem()}} to {{$drinks->lastItem()}} of {{$drinks->total()}} results</p>
                    {{$drinks->withQueryString()->links()}}
                </div>
            </div>

        </div>

    @else
    <p>There are no drinks content can be showed right now</p>
    @endif
        <a href="/CreateDrink" class="text-decoration-none fixed-bottom d-flex justify-content-end m-4">
            <i class="btn far fa-plus-square circle-icon-create p-3"></i>
        </a>
    </div>
@endsection
