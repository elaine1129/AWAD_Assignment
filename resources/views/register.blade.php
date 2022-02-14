@extends('layouts.main-layout')

<html>

<head>
    <title>Register page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<header>
    <div class="container">
        <h1> Register </h1>
    </div>
</header>

<h1 style="tw-items-center tw-justify-center">Register a account!</h1>
<div class="signupform">
    <form action="" method="POST">
        @csrf
        <div class="label">
            <label for="username"> Username*: </label>
        </div>
        <div class="input">
            <input type="text" placeholder="Enter username" name="username" required>
        </div>

        <div class="label">
            <label for="password">Password*:</label>
        </div>
        <div class="input">
            <input type="password" placeholder="Minimum 6 characters" name="password" required>
        </div>

        <div class="label">
            <label for="FullName"> Full Name: </label>
        </div>
        <div class="input">
            <input type="text" placeholder="First name" name="first_name" required>
        </div>

        <div class="label"><label></label></div>
        <div class="input">
            <input type="text" placeholder="Last name" name="last_name" required>
        </div>

        <div class="label">
            <label for="email"> Email: </label>
        </div>
        <div class="input">
            <input type="email" placeholder="Enter your email" name="email" required>
        </div>

        <div class="label">
            <label for="phone_number"> Phone Number: </label>
        </div>
        <div class="input">
            <input type="text" placeholder="Ex: 0123456677" name="phone_number" required>
        </div>

        <div class="label">
            <label for="address">Address: </label>
        </div>

        <textarea id="address" name="address" placeholder="Enter address" style="height:50px;width:200px;"></textarea>

        <div class="label">
            <label for="gender"> Gender: </label>
        </div>
        <div class="labelgender">
            <label for="gender"><input type="radio" name="gender" required value="men">Men </label>
            <label for="gender"><input type="radio" name="gender" required value="women">Women </label>
        </div>

        <div class="signup">
            <input type="submit" name="register" value="Register">
        </div>

        <p style="font-size:15px;">By signing up, you agree to our <b>Policy</b>.</p><br>
        <p>Have an account?<a href="login.php"> Log in</a></p>
    </form>
</div>

</body>

</html>