<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/login.css">
    <title>SetMatch</title>
</head>
<body>
    <div class="container">
        <div class="main-section">
            <div class="logo">
                <img src="public/img/logo.svg" alt="SetMatch Logo">
            </div>
            <form method="POST" action="login">
                <div class="messages">
                    <?php
                        if(isset($messages)){
                            foreach($messages as $message) {
                                echo $message;
                            }
                        }
                    ?>
                </div>
                <input name="login" type="text" placeholder="login">
                <input name="password" type="password" placeholder="password">
                <button class="continue" type="submit" ">continue</button>
                <div class="footer-links">
                    <a href="#">forgot a password?</a>
                    <a href="signup1">sign up</a>
                </div>
            </form>
        </div> 
    </div>
</body> 
</html>