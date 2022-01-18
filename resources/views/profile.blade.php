@extends('layout')

@section('content')
    <div class="container py-5 bg-light row d-flex justify-content-center mx-auto">
        @if (Auth::check())
            {{-- Member --}}
            @if (Auth::user()->role_id == 2)
            <div class="col-3">
                <p>
                    <a href="/Profile" class="text-dark nav-link">
                        <i class="fas fa-user-circle me-2"></i><strong>Profile</strong>
                    </a>
                </p>
                <p>
                    <a href="/TransactionHistory" class="text-dark nav-link" >
                        <i class="fas fa-history opacity-75 me-2"></i><strong class="text-muted">Transaction History</strong>
                    </a>
                </p>
            </div>

            {{-- Admin --}}
            @elseif (Auth::user()->role_id == 1)
            <div class="col-3">
                <p>
                    <a href="/Profile/{{$user->username}}" class="text-dark nav-link">
                        <i class="fas fa-user-circle me-2"></i><span>Profile</span>
                    </a>
                </p>
            </div>
            @endif
        @endif

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
                <h5>{{$user->username}} Profile</h5>
                <small class="text-muted">This information will be displayed publicly so be careful of what you share</small>
            </div>
            <form method="POST" action="{{Route('UpdateProfileForm')}}" class="form-container mt-5" enctype="multipart/form-data">
                @method("PUT")
                {{ csrf_field() }}
                <div class="row align-items-center">
                    <div class="mb-4 col-8">
                        <label for="username" class="form-label opacity-75"><strong>Username</strong></label>
                        <input type="text" class="form-control" name="username" id="username" value={{$user->username}} disabled="disabled">
                    </div>
                    <div class="mb-4 col-2">
                        <label for="level" class="form-label opacity-75"><strong>Level</strong></label>
                        <input type="text" class="form-control" name="level" id="level" value={{$user->level}} disabled="disabled">
                    </div>

                    <div class="mb-4 col">
                        <label>
                            <strong class="opacity-75">Profile Picture</strong>
                            <img src="{{Storage::url($user->profilePic)}}" class="rounded-circle" width="100px" height="100px" alt="profile picture" name="myfile">
                            <input type="file" name="myfile" class="hide">
                        </label>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="fullNameInput" class="form-label opacity-75"><strong>Full Name</strong></label>
                    <input type="text" class="form-control" name="fullName" id="fullNameInput" value="{{$user->fullName}}" >
                </div>

               {{-- password section --}}
                <div class="mb-4">
                    <label for="password" class="form-label opacity-75"><strong>Current Password</strong></label>
                    <input type="password" class="form-control" name="password"  id="password">
                    <small class="text-muted">Fill out this field to check if you are authorized</small>
                </div>
                <div class="mb-4">
                    <label for="newPassword" class="form-label opacity-75"><strong>New Password</strong></label>
                    <input type="password" class="form-control" name="newPassword"  id="newPassword">
                    <small class="text-muted">Only if you want to change your password</small>
                </div>
                <div class="mb-4">
                    <label for="newPassword_Confirmation" class="form-label opacity-75"><strong>Confirm New Password</strong></label>
                    <input type="password" class="form-control" name="newPassword_Confirmation"  id="newPassword_Confirmation">
                    <small class="text-muted">Only if you want to change your password</small>
                </div>
                <button type="submit" class="btn btn-secondary float-end mt-3">Update Profile</button>
            </form>
        </div>
    </div>
@endsection
