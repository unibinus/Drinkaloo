@extends('layout')

@section('content')
<div class="p-2">
    <div class="border border-white border-rad-10 p-3 border-2">
        <div class="row">
            <div class="col d-flex align-items-center">
                <small class="border p-2 border-white rounded-circle me-2 text-muted"><strong>01</strong></small>
                <span><strong class="text-muted">Shopping Cart</strong></span>
            </div>
            <div class="col d-flex align-items-center">
                <small class="border p-2 border-white rounded-circle me-2 text-muted"><strong>02</strong></small>
                <span><strong class="text-muted">Transaction Information</strong></span>
            </div>
            <div class="col d-flex align-items-center">
                <small class="border p-2 border-white rounded-circle me-2 text-muted"><strong>03</strong></small>
                <span><strong class="text-muted">Transaction Receipt</strong></span>
            </div>
        </div>
    </div>

    <h2 class="my-4"><strong>Shopping Cart</strong></h2>
    @if (sizeOf($games) > 0)

    <div class="bg-white">
        <div class="">
            @foreach ($games as $game)
            <div id="deleteCart{{$game["id"]}}" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel"  aria-hidden="true">
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
                                        <p class="fw-bold fs-5 mb-1">Delete Drnks</p>
                                        <p>Are you sure you want to delete this drink from your shopping cart ? All of your data will be permanently removed. This action cannot be undone.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end pb-4 pe-4">
                            <button type="button" class="btn btn-outline-dark mx-3" data-bs-dismiss="modal">Cancel</button>
                            <form action="DeleteCart/{{$game["id"]}}" data-id="id" method="POST">
                                @method("DELETE")
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex align-items-center border-bottom p-4">

                    <div class="col">
                        <a href="/Game/{{$game->id}}">
                            <img src="{{Storage::url($game->picture)}}" width="300px" alt="">
                        </a>

                    </div>
                    <div class="col-8">
                        <div class="d-flex align-items-center">
                            <p class="fs-3 m-0 fw-bold">{{$game->name}}</p>
                            <p class="mx-2 mb-0 p-1 bg-dark text-white rounded-pill">
                                {{$game->genre}}
                            </p>
                        </div>
                        <div>
                            <i class="fas fa-tags"></i>
                            <span class="mx-2">Rp. {{number_format($game->price,0,'.','.')}}</span>

                        </div>
                    </div>
                    <div class="col">
                        <button class="btn light-gray-background-color text-start border-rad-10" data-bs-toggle="modal" data-bs-target="#deleteCart{{$game["id"]}}">
                            <i class="fas fa-trash-alt me-2 icon-16"></i>Delete</button>
                    </div>
                </div>
                @endforeach
        </div>
        <div class="p-4">
            <div>Total Price: <span class="fw-bold">Rp. {{number_format($totalPrice,0,'.','.')}}</span></div>
            <div class="mt-3">
                <a href="/TransactionInformation" class="btn light-gray-background-color"><i class="fas fa-truck me-3"></i>Checkout</a>
            </div>
        </div>
    </div>
    @else
    <h1>Your Cart is currently empty</h1>
    @endif
</div>
@endsection
