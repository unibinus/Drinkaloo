@extends('layout')

@section('content')
<div class="container py-5 bg-light row d-flex justify-content-center mx-auto">
    <div class="col-3">
        <p>
            <a href="/Profile" class="text-dark nav-link">
                <i class="fas fa-user-circle me-2 opacity-75"></i><strong class="text-muted">Profile</strong>
            </a>
        </p>
        <p>
            <a href="/TransactionHistory" class="text-dark nav-link" >
                <i class="fas fa-history me-2"></i><strong>Transaction History</strong>
            </a>
        </p>
    </div>
        
    <div class="col-9">
        <div>
            <h5 class="mb-4">Transaction History</h5>
        </div>
        @if (sizeOf($filteredTransactions) > 0)
            @foreach($filteredTransactions as $transaction)
            <div>
                <p class="mb-0">Transaction ID: {{$transaction['transactionID']}}</p>
                <p>Purchase Date: {{$transaction['purchaseDate']}}</p>

                @foreach($transaction['drinks'] as $drink)
                
                <img src="{{Storage::url($drink->picture)}}" class="mx-3" height="150px" width="150px" style="background-color: white; background-size: contain;background-position: center" alt="">
                @endforeach
                <p class="mt-2">Total Price: <strong>Rp. {{number_format($transaction['totalPrice'],0,'.','.')}}</strong></p>
            </div>
            <hr>
            @endforeach
        @else
            <p>Your transaction history is empty.</p>
        @endif
        
    </div>
</div>
@endsection