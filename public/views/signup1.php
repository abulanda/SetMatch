<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/signup.css">
    <title>Sign up!</title>
</head>
<body>
    <div class="header-bar">
        <div class="logo-section">
            <img src="public/img/logo2.svg" alt="SetMatch Logo" class="logo">
        </div>
    </div>
    <div class="container">
        <div class="content-section">
            <div class="welcome-text">
                <h1>Welcome to SetMatch!</h1>
                <p>Your app for organizing and participating in amateur volleyball tournaments.</p>
                <p>Let's create an account!</p>
            </div>
            <form class="registration-form" method="POST" action="signup2">
                <input type="text" name="name" placeholder="name*">
                <input type="text" name="surname" placeholder="surname*" >
                <input type="text" name="username" placeholder="username*">
                <input type="email" name="email" placeholder="email*" >
                <input type="password" name="password" placeholder="password*" >
                <button type="submit">Next</button>
                
            </form>
        </div>
    </div>
</body> 
</html>