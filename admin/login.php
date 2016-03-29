<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Jekyll CMS</title>
        <link href='https://fonts.googleapis.com/css?family=Share+Tech+Mono' rel='stylesheet' type='text/css'>
        <link href="_/lib/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="_/css/index.css">
    </head>
    <body>
        <div class="login-box container">
            <form id="login-form" action="functionality/login.php" class="form-horizontal">
                <fieldset>

                    <h1>Login</h1>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="usernameinput">Email:</label>
                        <div class="col-md-4">
                            <input id="usernameinput" name="usernameinput" class="form-control input-md" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="passwordinput">Password:</label>
                        <div class="col-md-4">
                            <input id="passwordinput" name="passwordinput" class="form-control input-md" type="password">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <button id="loginbutton" type="submit" name="loginbutton" class="pull-right btn btn-primary">Login</button>
                        </div>
                    </div>

                </fieldset>
            </form>
        </div>
        <script src="_/lib/jquery/dist/jquery.min.js"></script>
        <script src="_/lib/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="_/js/index.js"></script>
    </body>
</html>
