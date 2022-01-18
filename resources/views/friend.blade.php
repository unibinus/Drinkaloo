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
                <a href="/Friend" class="text-dark nav-link">
                    <i class="far fa-heart me-2"></i><strong>Friends</strong>
                </a>
            </p>
            <p>
                <a href="/TransactionHistory" class="text-dark nav-link" >
                    <i class="fas fa-history opacity-75 me-2"></i><strong class="text-muted">Transaction History</strong>
                </a>
            </p>
        </div>
            
        @if ($errors->any())
        <div class="container-fluid fixed-top d-flex justify-content-center">
            <div class="w-50 alert alert-danger alert-dismissible m-2 fade show position pb-0" role="alert">
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
        @else
            @if (session('Success'))
            <div class="container-fluid fixed-top d-flex justify-content-center">
                <div class="w-auto alert alert-success alert-dismissible m-2 fade show position" role="alert">
                    {{session('Success')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            @endif
        @endif
        <div class="col-9">
            <div>
                <h5>Friends</h5>
            </div>
            {{-- Add Friends --}}
            <form method="POST" action="{{Route('AddFriend')}}" class="form-container mt-5">
                {{ csrf_field() }}
                <label for="addFriend" class="form-label"><strong>Add Friend</strong></label>
                <div class="row align-items-center">
                    <div class="col-3">
                        <input type="text" class="form-control" name="addFriend"  id="addFriend" placeholder="Username">
                    </div>
                    <div class="col-1">
                        <button type="submit" class="btn btn-secondary float-end">Add</button>
                    </div>
                </div>
            </form>

            {{-- Incoming Friend Requests --}}
            <div class="mt-4">
                <form method="POST" action="{{Route('IncomingRequest')}}" class="form-container mt-5">
                    {{ csrf_field() }}
                    <label for="addFriend" class="form-label"><strong>Incoming Friend Request</strong></label>
                    @if (sizeof($incomeFriends)>0)
                    @foreach($incomeFriends as $incomeFriend)
                    <div class="card border-0 shadow p-2 mb-5 bg-dark rounded" style="width: 20rem;">
                        <div class="card-body">
                            <div class="row">
                                <span class="card-title col-6 text-light"><strong>{{$incomeFriend->friend->fullName}}</strong></span>
                                <span class="text-muted col-3"><strong>{{$incomeFriend->friend->level}}</strong></span>
                                <img src="{{Storage::url($incomeFriend->friend->profilePic)}}" class="rounded-circle col-3" width="50px" height="50px" alt="profile picture" name="myfile">
                                <p class="card-subtitle text-muted">Member</p>
                            </div>
                        </div>
                        <div class="card-body d-flex justify-content-between">
                            <button type="submit" class="btn btn-secondary float-end" name="btnAcc" value="{{$incomeFriend->friend->id}}">Accept</button>
                            <button type="submit" class="btn btn-secondary float-end" name="btnRej" value="{{$incomeFriend->friend->id}}">Reject</button>
                        </div>
                    </div>
                    @endforeach
                    @else
                        <p>There is no incoming friend request.</p>
                    @endif
                </form>
            </div>
            
            {{-- Pending Friend Requests --}}
            <div class="mt-4">
                <form method="POST" action="{{Route('CancelRequest')}}" class="form-container mt-5">
                    {{ csrf_field() }}
                    <label for="addFriend" class="form-label"><strong>Pending Friend Request</strong></label>
                    @if (sizeof($friendsPens)>0)
                    @foreach($friendsPens as $friendPen)
                    <div class="card border-0 shadow mb-5 bg-dark rounded" style="width: 20rem;">
                        <div class="card-body">
                            <div class="card-body">
                                <div class="row">
                                    <span class="card-title col-6 text-light"><strong>{{$friendPen->user->fullName}}</strong></span>
                                    <span class="text-muted col-3"><strong>{{$friendPen->user->level}}</strong></span>
                                    <img src="{{Storage::url($friendPen->user->profilePic)}}" class="rounded-circle col-3" width="50px" height="50px" alt="profile picture" name="myfile">
                                    <p class="card-subtitle text-muted">Member</p>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-secondary float-end" name="cancelReq" id="cancelReq" value="{{$friendPen->user->id}}">Cancel</button>
                        </div>
                    </div>
                    @endforeach
                    @else
                        <p>There is no pending friend request.</p>
                    @endif
                </form>
            </div>

            {{-- Your Friends --}}
            <div class="mt-4">
                <label for="addFriend" class="form-label"><strong>Your Friends</strong></label>
                @if (sizeOf($friends)>0)
                {{-- friends ini jumlah teman yang dimiliki --}}
                @foreach($friends as $friend)
                <div class="card border-0 shadow p-2 mb-5 bg-dark rounded" style="width: 20rem;">
                    <div class="card-body">
                        <div class="row">
                            <span class="card-title col-6 text-light"><strong>{{$friend->user->fullName}}</strong></span>
                            <span class="text-muted col-3"><strong>{{$friend->user->level}}</strong></span>
                            <img src="{{Storage::url($friend->user->profilePic)}}" class="rounded-circle col-3" width="50px" height="50px" alt="profile picture" name="myfile">
                            <p class="card-subtitle text-muted">Member</p>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                    <p>There is no friend.</p>
                @endif
                
            </div>

        </div>
    </div>
@endsection