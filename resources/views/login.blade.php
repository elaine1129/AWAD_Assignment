@extends('layouts.main-layout')

<html>

<head>
    <title>Login page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<header>
    <div class="container">
        <h1> Login </h1>
    </div>
</header>

<body>
    <div class="login-background">
        <div class="container">

            <div class="col">
                <!-- NO IMAGE
                <img src="img/login-pic.jpg" alt="login-pic" style="width:375px;height:400px;" />
                -->
            </div>

            <div class="tw-items-center tw-justify-center">
                <h1 class="text-primary">Login Account</h1>

                <form method="post">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="submit" name="login" value="Login">
                </form>
                <div class="bottom-container">
                    <br>
                    <span class="rgt">No account?<a href="signup.php"> Register now!!</a></span>
                </div>
            </div>
        </div>
    </div>

</body>

</html>