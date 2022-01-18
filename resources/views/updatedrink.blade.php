@extends('layout')

@section('content')
@if ($errors->any())
<div class="container-fluid fixed-top d-flex justify-content-center">
    <div class="w-50 alert alert-danger alert-dismissible m-2 fade show position pb-0" role="alert">
        <i class="fas fa-times-circle p-2"></i>
        There were {{sizeOf($errors)}} errors with your submission
        <br>
        <ul class=" ms-4">
        @foreach ($errors->all() as $error)
            <li>
                {{$error}}
            </li>
        @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif
{{-- BREAD CRUMP --}}
<nav class="bread-crump-divider" aria-label="breadcrumb">
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item"><i class="fas fa-home"></i></li>
      <li class="breadcrumb-item active divider-padding" aria-current="page">{{$drinkDetail->genre}}</li>
      <li class="breadcrumb-item active divider-padding" aria-current="page">{{$drinkDetail->name}}</li>
    </ol>
  </nav>
<div class="px-3">
    <h1>Update Drinks</h1>
    <form action="/UpdateDrink/{{$drinkDetail->id}}" method="POST" enctype="multipart/form-data">
        @method("PUT")
        {{ csrf_field() }}
        <div class="mb-3">
            <label for="description" class="form-label fw-bold">Drink Description</label>
            <textarea class="form-control" name="description" rows="2">{{$drinkDetail->description}}</textarea>
            <div id="emailHelp" class="mt-2 form-text">Write a single sentence about the drink.</div>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label fw-bold">Drink Category</label>
            <select class="form-select" name="category" aria-selected="Action">
                <option value="Idle" {{$drinkDetail->genre == "Idle"? "Selected":""}}>Idle</option>
                <option value="Horror" {{$drinkDetail->genre == "Horror"? "Selected":""}}>Horror</option>
                <option value="Adventure" {{$drinkDetail->genre == "Adventure"? "Selected":""}}>Adventure</option>
                <option value="Action" {{$drinkDetail->genre == "Action"? "Selected":""}}>Action</option>
                <option value="Sports" {{$drinkDetail->genre == "Sports"? "Selected":""}}>Sports</option>
                <option value="Strategy" {{$drinkDetail->genre == "Strategy"? "Selected":""}}>Strategy</option>
                <option value="Role-playing" {{$drinkDetail->genre == "Role-playing"? "Selected":""}}>Role-playing</option>
                <option value="Puzzle" {{$drinkDetail->genre == "Puzzle"? "Selected":""}}>Puzzle</option>
                <option value="Simulation" {{$drinkDetail->genre == "Simulation"? "Selected":""}}>Simulation</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label fw-bold">Drink Price</label>
            <input type="text" class="form-control" name="price" value="{{$drinkDetail->price}}">
        </div>
        <div class="mb-3">
            <label for="cover" class="form-label fw-bold">Drink Cover</label>
            <input type="file" class="form-control" name="cover">
        </div>
        <hr class="hr-style hr-light-style my-4">
        <div class="d-flex justify-content-end mb-4">
            <a href="/ManageDrink" class="btn btn-light mx-3" >Cancel</a>
            <button type="submit" class="btn btn-dark darkgray-background-color">Save</button>
        </div>
</div>
</form>
@endsection
