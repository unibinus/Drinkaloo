@extends('layout')

@section('content')
<div class="p-2">
    <div class="border border-white border-rad-10 p-3 border-2">
        <div class="row">
            <div class="col d-flex align-items-center">
                <i class="fas fa-check-circle me-2 fa-2x"></i>
                <span><strong>Shopping Cart</strong></span>
            </div>
            <div class="col d-flex align-items-center">
                <i class="fas fa-check-circle me-2 fa-2x"></i>
                <span><strong>Transaction Information</strong></span>
            </div>
            <div class="col d-flex align-items-center">
                <small class="border p-2 border-white rounded-circle me-2 text-muted"><strong>03</strong></small>
                <span><strong class="text-muted">Transaction Receipt</strong></span>
            </div>
        </div>
    </div>
</div>

<div class="p-2">
    <h1>Transaction Receipt</h1>
    <div class="bg-white p-3">
    @if (sizeOf($transactionReceipt) > 0)

        @foreach ($transactionReceipt as $receipt)
        <div class="border-bottom py-3">
            <div>
                Transaction ID: {{$receipt['transactionID']}}
            </div>
            <div>
                {{-- Purchased Date: 21-05-2021 07:20:40 --}}
                {{-- Purchased Date: {{date('F j, Y',strtotime($gameDetail->releaseDate))}} --}}
                Purchased Date: {{date('j-m-Y H:i:s',strtotime($receipt['purchaseDate']))}}

            </div>
        </div>
        @foreach ($receipt['games'] as $game)
        <div class="row d-flex align-items-center border-bottom py-3">

            <div class="col">
                <img src="{{Storage::url($game->picture)}}" width="300px" alt="">
            </div>

            <div class="col-9">
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

        </div>
        @endforeach
        <div class="d-flex align-items-center">
            <p class="mt-2 d-flex align-items-center">Total Price <span class="mx-2 fs-4"><strong>Rp. {{number_format($receipt['totalPrice'],0,'.','.')}}</strong></span></p>
        </div>
        @endforeach
    </div>
    @else
    <h1>There are no transaction receipt right now</h1>
    @endif

</div>

@endsection
