@extends('layout.mainLogin')

@section('container')
<div class="container" id="container">

    <div class="form-container sign-in-container">
        <img src="/images/square-asnet.png" alt="" class="images-signin">
        <form action="{{Route('login.authentication')}}" method="POST">
            @csrf
            <h1>Sign in</h1>

            <span>or use your account</span>
            <input type="username" name="username" required placeholder="Username" />
            <input type="password" name="password" required placeholder="Password" />
            <button>Sign In</button>
        </form>
    </div>
    <div class="overlay-container">
   	<img src="/images/square.png" class="imgasss" alt="">     
        <div class="overlay">
            <div class="overlay-panel overlay-right">
               
		 
            </div>
        </div>
    </div>
</div>


<!-- <div class="forms-container">
    <div class="signin-signup">

        <form action="{{Route('login.authentication')}}" method="POST" class="sign-in-form">
            @csrf
            <h2 class="title">Sign in</h2>
            <div class="input-field">

                <i><img src="/images/icon/user.svg" alt=""></i>
                <input type="text" name="username" placeholder="Username" />
            </div>
            <div class="input-field">
                <i><img src="/images/icon/lock.svg" alt=""></i>
                <input type="password" name="password" placeholder="Password" />
            </div>
            <input type="submit" value="Login" class="btn solid" />

        </form>
    </div>
</div>

<div class="panels-container">
    <div class="panel left-panel">
        <div class="content">


        </div>
        <img src="/images/register.svg" class="image" alt="" />
    </div>
</div> -->
@endsection
