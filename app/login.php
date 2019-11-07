<?php

    include_once("share/header-standard.php");

    //ini_set('default_charset', 'utf-8');
    //date_default_timezone_set('America/Sao_Paulo');
    //session_cache_limiter('private, must-revalidate'); 
    //session_cache_expire(120);
    //session_start();


    //define('VCLASSES', 'zshare/classes/');
    //define('VCONFIG', 'zshare/config/');

    //spl_autoload_register(function($class) {
    //    include VCLASSES . $class . '.php';
    //});

    //require_once('../publico/vendor/autoload.php');

    //use PHPMailer\PHPMailer\PHPMailer;
    //use PHPMailer\PHPMailer\Exception;

    //require '../publico/vendor/phpmailer/phpmailer/src/Exception.php';
    //require '../publico/vendor/phpmailer/phpmailer/src/PHPMailer.php';
    //require '../publico/vendor/phpmailer/phpmailer/src/SMTP.php';

    unset(
        $_SESSION['ulogin'],
        $_SESSION['upaswd'],
        $_SESSION['user_id'],
        $_SESSION['profile_id'],    
        $_SESSION['email'],
        $_SESSION['timestamp']
    );

    $acesso = User::getInstance();

?>

<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ial360&#176;</title>
    <meta name="description" content="Plataforma ial360 - Instituto Alpha Lumen">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="../publico/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="../publico/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="../publico/css/fontastic.css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="../publico/css/grasp_mobile_progress_circle-1.0.0.min.css">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="../publico/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="../publico/css/style_ial.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="../publico/css/custom.css">

    <!-- Favicon-->
    <link rel="apple-touch-icon" sizes="57x57" href="../publico/img/projeto/ico/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../publico/img/projeto/ico/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../publico/img/projeto/ico/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../publico/img/projeto/ico/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../publico/img/projeto/ico/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../publico/img/projeto/ico/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../publico/img/projeto/ico/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../publico/img/projeto/ico/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../publico/img/projeto/ico/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="../publico/img/projeto/ico/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../publico/img/projeto/ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../publico/img/projeto/ico/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../publico/img/projeto/ico/favicon-16x16.png">
    <link rel="manifest" href="../publico/img/projeto/ico/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="../publico/img/projeto/ico/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <script src='https://www.google.com/recaptcha/api.js?hl=pt-BR'></script>

</head>

<body>

<form method="post" action="" class="text-center form-validate" autocomplete="off" >
    <div class="page login-page" id="background">
        <div class="container">

            <div class="form-outer d-flex align-items-center">
                <div class="form-inner dashboard-counts" style = "width:100%" >

                    <div class="logo text-uppercase">
                        <img src="../publico/img/projeto/ial360-redo-30.png" alt="ial360" class="img-fluid pb-3" width="200" height="100">
                        <!--    <strong class="text-primary">Plataforma ial360&#176;</strong> -->
                    </div>
                    <h3 class="card-title text-uppercase text-center">L O G I N</h3> 

                    <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2" >

                        <?php
                            if(isset($_SESSION['errorMessage']))
                                if(strlen($_SESSION['errorMessage']) > 0)
                                {
                                    echo "<div class='alert alert-danger alert-dismissible fade show text-left' role='alert'>";
                                    echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                                    echo "<p>Erro: {$_SESSION['errorMessage']}</p>";
                                    echo "</div>";   
                                }

                            if( isset( $_POST['validar'] ) ) {
                                // 6Lcrb6IUAAAAANANFLvosBYtYr6hkddmASqAeE-G
                                // 6Lcrb6IUAAAAAL3bc0bJiLXnBvWtk1xcQgAH1miY
                                //your site secret key
                                //$secret = '6LduuakUAAAAAG0UbI2M3nwLQkGI0SPEaLyd6WuP';
                                //get verify response data
                                //$verifyResponse1 = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
                                //$responseData = json_decode($verifyResponse1);   
                                $cap = true; //$responseData->success;
                                if( $cap ) 
                                {                        
                                    $pwdcrpted = $acesso->passwordCrypt($_POST['upasswd']);
                                    $exist = $acesso->selectAll("login='{$_POST['ulogin']}' AND password='$pwdcrpted'");
                                    
                                    if(count($exist) > 0)
                                    {
                                        $record = (object) $exist[0];
                                        $_SESSION['ulogin']  = $_POST['ulogin'];
                                        $_SESSION['upaswd']  = $_POST['upasswd'];
                                        $_SESSION['user_id']   = $record->id;
                                        $_SESSION['profile_id']= $record->profile_id;
                                        $_SESSION['email']     = $record->email;
                                        $_SESSION['timestamp'] = time();
                                        
                                        //print_r($record);
                                        
                                        if( $record->mustChangePassword == 'Y')
                                            header("Location: change.php");
                                        else 
                                            if( $record->mustUpdateContact == 'Y')
                                                header("Location: change2.php");
                                            else header("Location: index.php");
                                    }
                                    else
                                    {
                                        echo "<div class='alert alert-danger alert-dismissible fade show text-left' role='alert'>";
                                        echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                                        echo "<p>Login ou senha inválido! Tente novamente. Caso tenha esquecido a senha, clique no link abaixo para recuperar uma nova senha.</p>";
                                        echo "</div>";                                
                                    }
                                }else{
                                    echo "<div class='alert alert-danger alert-dismissible fade show text-left' role='alert'>";
                                    echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                                    echo "<p><strong>Por favor, preencha o reCaptcha !</p>";
                                    echo "</div>";                                
                                }
                                unset( $_POST['login'] );
                                unset( $_POST['ulogin'] );
                                unset( $_POST['upasswd'] );
                            }
                        ?>

                        <div class="form-group-material">
                            <!--<label class="form-control-label">Login</label> -->
                            <input id="login-username" name="ulogin" type="text" data-msg="Entre com o login" class="input-material" value="" auto-complete="off" required>
                            <label for="login-username" class="label-material">Login</label>
                        </div>

                        <div class="form-group-material">
                            <!--<label class="form-control-label">Senha</label> -->
                            <input id="login-pwd" name="upasswd" type="password" data-msg="Entre com a senha" class="input-material" value="" auto-complete="off" required>
                            <label for="login-pwd" class="label-material">Senha</label>
                        </div>
                        <!--
                        <div class="form-group ">
                            <div class="g-recaptcha" id="idCaptcha" data-sitekey="6LduuakUAAAAAO1ungSving5vw2bW41PpcEoqqV2"></div>
                        </div>    
                        -->
                        <div class="form-group text-center mt-4">
                            <button class="btn btn-success btn-block " name="validar" type="submit">Entrar</button>
                        </div>

                    </div>
                    <a href="remember.php" class="forgot-pass">Esqueceu a Senha ?</a>
                    <small>Não tem um usuário? </small><a href="register.php" class="signup">Cadastrar</a>
                </div>
            </div>

            <div class="copyrights text-center">
                <p>&copy; 2017-2019 - Instituto Alpha Lumen - Plataforma ial360&#176; - designed by <span class="text-success">Alpha Digital</span></p>
            </div>

        </div>
    </div>
</form>

    <!-- JavaScript files-->
    <script src="../publico/vendor/jquery/jquery.min.js"></script>
    <script src="../publico/vendor/popper.js/umd/popper.min.js"> </script>
    <script src="../publico/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../publico/js/grasp_mobile_progress_circle-1.0.0.min.js"></script>
    <script src="../publico/vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="../publico/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="../publico/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- Main File-->
    <script src="../publico/js/front.js"></script>


</body>
</html>