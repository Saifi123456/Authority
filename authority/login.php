<?php
include 'php/functions.php';
if ($_SESSION['loggedIn']) {
    invalidPage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Authority</title>
    <? echoHeader(); ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<? echoNavBar() ?>
<body>
<div class="main">
    <div class="gameContainer">
        <div class="row">
            <div class="col-sm"></div>
            <div class="col-sm-4">
                <br/>
                <h2>Login</h2>
                <hr/>
                <form method="POST" class="tableForm" id="captchaVerify">
                    <table class="table table-striped table-responsive">
                        <tr>
                            <td><b>Username</b></td>
                            <td><input type='text' name='username' class='form-control'
                                       placeholder='Enter Username Here' required pattern="[^()/><\][\\\x22,;|]+"></td>
                        </tr>
                        <tr>
                            <td><b>Password</b></td>
                            <td><input type='password' name='password' class='form-control'
                                       placeholder='Enter Password Here' required pattern="[^()/><\][\\\x22,;|]+"></td>
                        </tr>
                        <tr>
                            <td>
                                <b>ReCAPTCHA</b>
                                <br/>
                                <i style="margin-top:2px">Captcha is required to prevent bruteforce login attempts.</i>
                            </td>
                            <td>
                                <button class="g-recaptcha btn btn-primary"
                                data-sitekey="6LdvMycaAAAAANsGtPBR4rOBfPldDV37imU42rwc"
                                data-callback="enableBtn"
                                data-action='submit'>Click Here</button>
                            </td>
                        </tr>
                    </table>
                    <label>
                        <input type='submit' class="btn btn-primary" value="Login" name="signIn">
                    </label>
                </form>

            </div>
            <div class="col-sm"></div>
        </div>
        <script>
            function onSubmit(token) {
                document.getElementById("captchaVerify").submit();
            }
        </script>
    </div>
    <? echoFooter() ?>
</div>
</html>
<?php
if(isset($_POST['signIn'])) {
    $captcha = $_POST['g-recaptcha-response'];
    $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdvMycaAAAAAEwRGaDzTK_zwNiano4IN5Du8eOM&response=" .
        $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']), true);

    if ($response['success']) {
        login($_POST['username'], $_POST['password']);
    }
    else{
        alert("Error!","There was an error with the captcha. Try again?");
    }
}
