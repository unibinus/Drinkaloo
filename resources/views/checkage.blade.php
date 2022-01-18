@extends('layout')

@section('content')
<div class="my-5 pt-5">
    <div class="position-relative border border-2 border-dark">
        <div class="position-absolute top-0 start-50 translate-middle translate-middle">
            {{-- <img src="{{Storage::url(Session::get('gameDetailSession')->picture)}}" width="200px"  alt=""> --}}
            <img src="{{Storage::url($game->picture)}}" width="200px"  alt="">
        </div>
        <div class="text-center d-flex flex-column align-items-center mt-5 pt-5">
            {{-- <form action="Game/CheckAge/{{Session::get('gameDetailSession')->id}}" method="POST" class="form-container"> --}}
            <form action="CheckAge/{{$game->id}}" method="POST" class="form-container">
                <p class="fw-bold">CONTENT IN THIS PRODUCT MAY NOT BE APPROPRIATE FOR ALL AGES, OR MAY NOT <br>BE APPROPRIATE FOR VIEWING AT WORK.</p>
                <div class="p-4 shadow fw-bold" style="background-color: #E5E7EB">
                <p>Please enter your birth date to continue:</p>
                    {{ csrf_field() }}
                    <div class="d-flex justify-content-center text-start fw-bold">
                        <div class="mx-1">
                            <label for="day">Day</label>
                            <br>
                            <select class="form-select" name="day" id="">
                                @for ($i = 1; $i <= 31; $i++)
                                    @if ($i == 1)
                                        <option selected value="{{$i}}">{{$i}}</option>
                                    @else
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                        <div class="">
                            <label for="month">Month</label>
                            <br>
                            <select class="form-select dropup" name="month" id="">
                                    <option value="1">January</option>
                                    <option value="2">Febuary</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                            </select>
                        </div>
                        <div class="mx-1">
                            <label for="year">Year</label>
                            <br>
                            <select class="form-select" name="year" id="">
                                @for ($i = date('Y'); $i >= 1900; $i--)
                                    @if ($i == date('Y'))
                                        <option value="{{$i}}" selected>{{$i}}</option>
                                    @else
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="py-3">
                    <button type="submit" class="btn btn-dark gray-background-color me-2">View Page</button>
                    <a href="/" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
