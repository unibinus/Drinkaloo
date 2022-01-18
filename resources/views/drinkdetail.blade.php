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
    <div class="w-50 alert alert-danger alert-dismissible m-2 fade show position pb-0" role="alert">
        <i class="fas fa-times-circle p-2"></i>
        There were 1 errors with your submission
        <br>
        <ul class=" ms-4">
            <li>
                {{session('Error')}}
            </li>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

<div class="p-3">
    <nav class="bread-crump-divider" aria-label="breadcrumb">
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item"><i class="fas fa-home"></i></li>
      <li class="breadcrumb-item active divider-padding" aria-current="page">{{$drinkDetail->genre}}</li>
      <li class="breadcrumb-item active divider-padding" aria-current="page">{{$drinkDetail->name}}</li>
    </ol>
  </nav>
    <div class="">
        <div class="row">
            <img src="{{Storage::url($drinkDetail->picture)}}" class="border-rad-20" height="250px" alt="">
        </div>
        <div class="my-1 row">
            <p class="my-2 fs-5 text fw-bold">{{$drinkDetail->name}}</p>
            <p class="m-0">
                {{$drinkDetail->description}}
            </p>
        </div>
        <div class="my-2 row">
            <div class="d-flex">
                <p class="m-0"><strong>Category: </strong> {{$drinkDetail->genre}} </p>
            </div>
        </div>
        <div class="my-2 row">
            <div class="d-flex">
                <p class="m-0"><strong>Release Date: </strong> {{date('F j, Y',strtotime($drinkDetail->releaseDate))}}</p>
            </div>
        </div>
    </div>
    <div class="p-4 shadow fw-bold my-4 position-relative bg-light">

        {{-- Kalau admin atau member punya drinknya, maka hide add to cart--}}
        @if (Session::has('mySession'))
            @if (Session::get('mySession')['role_id'] == 1 || $drinkOwned)
            <form action="AddToCart/{{$drinkDetail->id}}" class="hide" method="POST">
                {{ csrf_field() }}
                <div class="position-absolute add-to-cart">
                    {{-- top 70 left 85 --}}
                    <button class="btn btn-dark d-flex align-items-center" type="submit">Rp. {{number_format($drinkDetail->price,0,'.','.')}}
                        <div class="vr mx-3"></div>
                        <i class="fas fa-shopping-cart me-2"></i> Add To Cart</button>
                </div>
            </form>
            @else
            {{-- user logged in belum punya drink--}}
            <form action="AddToCart/{{$drinkDetail->id}}" method="POST">
                {{ csrf_field() }}
                <div class="position-absolute add-to-cart">
                    {{-- top 70 left 85 --}}
                    <button class="btn btn-dark d-flex align-items-center" type="submit">Rp. {{number_format($drinkDetail->price,0,'.','.')}}
                        <div class="vr mx-3"></div>
                        <i class="fas fa-shopping-cart me-2"></i> Add To Cart</button>
                </div>
            </form>
            @endif
            @else
            {{-- guest--}}
            <form action="AddToCart/{{$drinkDetail->id}}" method="POST">
                {{ csrf_field() }}
                <div class="position-absolute add-to-cart">
                    {{-- top 70 left 85 --}}
                    <button class="btn btn-dark d-flex align-items-center" type="submit">Rp. {{number_format($drinkDetail->price,0,'.','.')}}
                        <div class="vr mx-3"></div>
                        <i class="fas fa-shopping-cart me-2"></i> Add To Cart</button>
                </div>
            </form>
        @endif



        <div>
            Buy {{$drinkDetail->name}}
        </div>
    </div>
    <div class="pt-4">
        <p class="fw-bold fs-5">ABOUT THIS DRINK</p>
        <hr class="hr-dark-style darkgray-background-color">
        <div>
            {{$drinkDetail->longDescription}}
        </div>
    </div>
</div>
@endsection