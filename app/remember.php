<?php
    ini_set('default_charset', 'utf-8');
    date_default_timezone_set('America/Sao_Paulo');
    session_cache_limiter('private, must-revalidate'); 
    session_cache_expire(120);
    session_start();

    define('VCLASSES', 'share/classes/');
    define('VCONFIG', 'share/config/');

    spl_autoload_register(function($class) {
        include VCLASSES . $class . '.php';
    });

    require_once('../publico/vendor/autoload.php');

    include_once("share/envia-mail.php");

    unset(
        $_SESSION['contact_id'],
        $_SESSION['name'],
        $_SESSION['email'],
        $_SESSION['user_id'],
        $_SESSION['login'],
        $_SESSION['password'],
        $_SESSION['profile'],
        $_SESSION['profile_id']    
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

<form method="post" action="" class="text-center form-validate">
    <div class="page login-page" id="background">
        <div class="container">

            <div class="form-outer d-flex align-items-center">
                <div class="form-inner dashboard-counts" style = "width:100%" >

                    <div class="logo text-uppercase">
                        <img src="../publico/img/projeto/ial360-redo-30.png" alt="ial360" class="img-fluid pb-3" width="200" height="100">
                        <!--    <strong class="text-primary">Plataforma ial360&#176;</strong> -->
                    </div>

                    <h3 class="card-title text-uppercase text-center">RECUPERAR SENHA</h3> 

                    <?php
                        if( isset( $_POST['remember'] ) ) {

                            //your site secret key
                            //$secret = '6LduuakUAAAAAG0UbI2M3nwLQkGI0SPEaLyd6WuP';
                            //get verify response data
                            //$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
                            //$responseData = json_decode($verifyResponse);   
                            $cap = true;//$responseData->success;

                            if( $cap ) {                        
                                $name = $_POST['inName'];
                                $email = $_POST['inEmail'];

                                $lista = $acesso->select("email='{$email}'");
                                $lista = (object) $lista[0];

                                $acesso->setId($lista->id);
                                $acesso->setName($lista->name);
                                $acesso->setEmail($lista->email);
                                $acesso->setLogin($lista->login);
                                $senha = $acesso->codeGenerate(12);
                                $acesso->setPassword($senha);
                                $status = $acesso->passwordUpdate();
                                if($status){

                                    $subject = "Senha Temporária - Processo Seletivo - ALPHA LUMEN";
                                    $message = "Recebemos sua solicitação e estamos enviando uma senha temporária:<br>
                                    <strong>Login:</strong> {$lista->login}<br>
                                    <strong>Senha Temporária:</strong> {$senha}<br><br>";
                                    EnviaEmail($name, $email, $subject, $message);
    
                                    echo '<div class="alert alert-primary alert-dismissible fade show text-left" role="alert">';
                                    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                                    echo "Uma mensagem com a senha temporária foi enviada para <strong>'{$email}'</strong>";
                                    echo '</div>';                            
                                }
                                else{
                                    echo '<div class="alert alert-danger alert-dismissible fade show text-left" role="alert">';
                                    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                                    echo "Erro de reset de senha! Por favor tente novamente.";
                                    echo '</div>';                            
                                }
                            }else{
                                echo '<div class="alert alert-danger alert-dismissible fade show text-left" role="alert">';
                                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                                echo "Por favor preencha o reCAPTCHA.";
                                echo '</div>';                            
                            }
                        }
                    ?>
                    <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2" >

                        <div class="form-group has-danger text-left">
                            <label for="inName" class="form-control-label">Nome</label>
                            <input name="inName" id="inName" type="text" data-msg="Por favor entre com o nome" class="form-control form-control-sm " value="" required>
                        </div>

                        <div class="form-group has-danger text-left">
                            <label for="inEmail" class="form-control-label">E-mail</label>
                            <input name="inEmail" id="inEmail" type="text" data-msg="Por favor entre com o email" class="form-control form-control-sm" value="" required>
                        </div>
                        <!--
                        <div class="form-group-material ">
                            <div class="g-recaptcha" id="idCaptcha" data-sitek ey="6LduuakUAAAAAO1ungSving5vw2bW41PpcEoqqV2"></div>
                        </div>    
                        -->
                        <div class="form-group text-center mt-4">
                            <button class="btn btn-success btn-block " name="remember" type="submit">Recuperar</button>
                        </div>

                    </div>

                    <a href="login.php" class="forgot-pass">Já tem login?</a>
                    <small>Não tem um usuário? </small><a href="register.php" class="signup">Cadastrar</a>

                </div>
                <div class="copyrights text-center">
                    <p>&copy; 2017-2019 - Instituto Alpha Lumen - Plataforma ial360&#176; - designed by <span class="text-success">Alpha Digital</span></p>
                </div>

            </div>

        </div>
    </div>
</form>

    <!-- JavaScript files-->
    <script src="../publico/vendor/jquery/jquery.min.js"></script>
    <script src="../publico/vendor/popper.js/umd/popper.min.js"> </script>
    <script src="../publico/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../publico/js/grasp_m
    obile_progress_circle-1.0.0.min.js"></script>
    <script src="../publico/vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="../publico/vendor/chart.js/Chart.min.js"></script>
    <script src="../publico/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="../publico/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- Main File-->
    <script src="../publico/js/front.js"></script>


    <script type="text/javascript">
        $("#txttel").mask("(00) 0000-0000");
    </script>

</body>
</html>