
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <link href="{{ asset('/css/login-regis.css') }}" rel="stylesheet">

    <title>Register</title>
</head>
<body>
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
    <div class="row">
        <div class="col-3 sub-container-regis">
            <h1>Register Page</h1>
            <form action="{{Route('RegisterForm')}}" method="POST" class="form-container">
                {{ csrf_field() }}
                <div class="mb-4">
                    <label for="usernameInput" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="usernameInput">
                </div>
                <div class="mb-4">
                    <label for="fullNameInput" class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="fullName" id="fullNameInput">
                </div>
                <div class="mb-4">
                    <label for="passwordInput" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password"  id="passwordInput">
                </div>
                <div class="form-group mb-4">
                    <label for="roleInput">Role</label>
                    <select id="roleInput" class="form-select" name="role" >
                      <option>Member</option>
                      <option>Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn form-control mb-3">Sign Up</button>
                <a href="/Login" class="link">Already have an account?</a>
            </form>
         </div>
         <div class="col ">
            <img src="{{Storage::url('public/images/RegisterImage.jpg')}}" height="103%" width="103%" alt="">
         </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>
</html>
