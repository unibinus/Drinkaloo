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

<div class="px-3">
    <h1>Create Games</h1>
    <form action="{{Route('CreateGame')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Game Name</label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label fw-bold">Game Description</label>
            <textarea class="form-control" name="description" rows="2"></textarea>
            <div id="emailHelp" class="mt-2 form-text">Write a single sentence about the game.</div>
        </div>
        <div class="mb-3">
            <label for="longDescription" class="form-label fw-bold">Game Long Description</label>
            <textarea class="form-control" name="longDescription" rows="5"></textarea>
            <div id="emailHelp" class="mt-2 form-text">Write a few sentences about the game.</div>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label fw-bold">Game Category</label>
            <select class="form-select" name="category">
                <option value="Idle">Idle</option>
                <option value="Horror">Horror</option>
                <option value="Adventure">Adventure</option>
                <option value="Action">Action</option>
                <option value="Sports">Sports</option>
                <option value="Strategy">Strategy</option>
                <option value="Role-playing">Role-playing</option>
                <option value="Puzzle">Puzzle</option>
                <option value="Simulation">Simulation</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="developer" class="form-label fw-bold">Game Developer</label>
            <input type="text" class="form-control" name="developer">
        </div>
        <div class="mb-3">
            <label for="publisher" class="form-label fw-bold">Game Publisher</label>
            <input type="text" class="form-control" name="publisher">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label fw-bold">Game Price</label>
            <input type="text" class="form-control" name="price">
        </div>
        <div class="mb-3">
            <label for="cover" class="form-label fw-bold">Game Cover</label>
            <input type="file" class="form-control" name="cover">
        </div>
        <div class="mb-3">
            <label for="trailer" class="form-label fw-bold">Game Trailer</label>
            <input type="file" class="form-control " id="trailerUpload" name="trailer">
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="adultChk" name="adultChk">
            <label class="form-check-label" for="adultChk">
              Only for adult ?
            </label>
        </div>
        <hr class="hr-style hr-light-style my-4">
        <div class="d-flex justify-content-end mb-4">
            <a href="/ManageGame" class="btn btn-light mx-3" >Cancel</a>
            <button type="submit" class="btn btn-dark darkgray-background-color">Save</button>
        </div>
</div>
</form>
@endsection
