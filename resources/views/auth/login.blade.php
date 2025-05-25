@extends('layouts.login')

@section('content')
<form action="{{ route('login') }}" method="POST" class="user">
    @csrf
    <!-- CSRF token required for POST forms -->

    <div class="form-group">
        <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail"
            aria-describedby="emailHelp" placeholder="Enter Email Address..." required autofocus>
    </div>

    <div class="form-group">
        <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword"
            placeholder="Password" required>
    </div>



    <button type="submit" class="btn btn-primary btn-user btn-block">
        Login
    </button>

</form>
@endsection
