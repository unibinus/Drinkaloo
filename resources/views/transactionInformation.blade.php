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
    <div class="p-2">
        <div class="border border-white border-rad-10 p-3 border-2">
            <div class="row">
                <div class="col d-flex align-items-center">
                    <i class="fas fa-check-circle me-2 fa-2x"></i>
                    <span><strong>Shopping Cart</strong></span>
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

        <h2 class="my-4"><strong>Transaction Information</strong></h2>
        <form method="POST" enctype="multipart/form-data" action={{Route('TransactionInformation')}}>
            @csrf
            <div class="form-group">
                <label><strong class="text-muted">Card Name</strong></label>
                <input name="cardName" type="text" class="form-control" placeholder="Card Name">
            </div>
            <div class="form-group mt-3">
                <label><strong class="text-muted">Card Number</strong></label>
                <input name="cardNumber" type="text" class="form-control" placeholder="0000 0000 0000 0000">
                <small class="text-muted">VISA or Master Card.</small>
            </div>

            <div class="row mt-4">
                <div class="form-group col-4">
                    <label><strong class="text-muted">Expired Date</strong></label>
                    <input name="expiredDateMonth" type="text" class="form-control" placeholder="MM">
                </div>
                <div class="form-group col-4">
                    <label></label>
                    <input name="expiredDateYear" type="text" class="form-control" placeholder="YYYY">
                </div>
                <div class="form-group col-4">
                    <label><strong class="text-muted">CVC / CVV</strong></label>
                    <input name="cvcNumber" type="text" class="form-control" placeholder="3 or 4 digit number">
                </div>
            </div>

            <div class="row mt-3">
                <div class="form-group col-8">
                    <label><strong class="text-muted">Country</strong></label>
                    <select name="country" id="inputCountry" class="form-control">
                    <option selected>Indonesia</option>
                    <option>Japan</option>
                    <option>Singapore</option>
                    <option>South Korea</option>
                    <option>Malaysia</option>
                    <option>Vietnam</option>
                    </select>
                </div>
                <div class="form-group col">
                    <label><strong class="text-muted">Zip</strong></label>
                    <input type="text" class="form-control" placeholder="ZIP" name="zip">
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <a href="/Cart" class="btn btn-light py-2 px-3 me-3"><strong class="text-muted">Cancel</strong></a>
                    <button type="submit" class="btn py-2 px-3 light-gray-background-color"><i class="fas fa-truck me-2"></i><strong>Check Out</strong></button>
                </div>
            </div>
        </form>
    </div>
@endsection
