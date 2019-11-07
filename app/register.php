<?php

    include_once("share/header-standard.php");

    unset(
        $_SESSION['ulogin'],
        $_SESSION['upaswd'],
        $_SESSION['user_id'],
        $_SESSION['profile_id'],    
        $_SESSION['email'],
        $_SESSION['timestamp']
    );
    
    $acesso = User::getInstance();
    $contato = Contact::getInstance();

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
        
                    <h3 class="card-title text-uppercase text-center">CADASTRO</h3> 

                    <?php
                        if( isset( $_POST['register'] ) ) {

                            //your site secret key
                            //$secret = '6LduuakUAAAAAG0UbI2M3nwLQkGI0SPEaLyd6WuP';
                            //get verify response data
                            //$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
                            //$responseData = json_decode($verifyResponse);   
                            $cap = true;//$responseData->success;

                            if( $cap ) { 
                                if($_POST['inEmail'] == $_POST['inEmail2'])
                                {
                                    $name = $_POST['inName'];
                                    $email = $_POST['inEmail'];

                                    if(substr_count($name, ' ') > 0)
                                        $login = mb_strtolower(substr( $name, 0, strpos($name, " ")), 'UTF-8');
                                    else
                                        $login =  mb_strtolower($name, 'UTF-8');

                                    $acesso->setName(mb_convert_case($name, MB_CASE_TITLE, "UTF-8"));
                                    $acesso->setLogin($login);
                                    $acesso->setEmail($email);

                                    $acesso->setProfileId(20);
                                    $passwd = $acesso->codeGenerate(8);
                                    $acesso->setPassword($passwd);

                                    $exist = $acesso->selectAll("email='{$email}' AND name LIKE '%".mb_strtolower(substr( $name, 0, strpos($name, " ")), 'UTF-8')."%'");
                                    $erro = true;
                                    if(count($exist) > 0)
                                    {
                                        $exist = (object) $exist[0];
                                        $acesso->passwordUpdate();
                                        $subject = "Cadastro de Usuário - Plataforma ial360 - ALPHA LUMEN";
                                        $message = "
                                            Recebemos sua solicitação e você já possui um usuário. Segue abaixo as informações de acesso a plataforma:<br>
        
                                            <strong>Login:</strong> {$exist->login}<br>
                                            <strong>Senha Temporária:</strong> {$passwd}<br><br>
                                        ";
                                        $erro = false;
                                    }
                                    else
                                    {
                                        $user = $acesso->insert();
                                        $login = $acesso->getLogin();
                                        if(count($user) > 0){
                                            $contato->setName($name);
                                            $contato->setEmail($email);
                                            $contato->setUserId($user['id']);
                                            $status = $contato->insertQuick();
       
                                            if(count($status) > 0){
                                                $subject = "Cadastro de Usuário - Plataforma ial360 - ALPHA LUMEN";
                                                $message = "
                                                    Recebemos sua solicitação e estamos enviando os dados para você acessar a plataforma e finalizar o cadastro.<br>
                
                                                    <strong>Login:</strong> {$login}<br>
                                                    <strong>Senha Temporária:</strong> {$passwd}<br><br>
                                                ";
                                                $erro = false;
                                            }
                                        }
                                    }

                                    if(!$erro)
                                    {
                                        EnviaEmail($name, $email, $subject, $message);

                                        echo '<div class="alert alert-info alert-dismissible fade show text-left" role="alert">';
                                        echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                                        echo "<p>Enviamos um email para <b>".$email."</b> com um usuário e senha para você acessar a plataforma.<br> Caso não tenha recebido verifique a caixa de SPAM de seu email.</p>";
                                        echo '</div>';

                                        unset( $_POST['inName'] );
                                        unset( $_POST['inEmail'] );
                                        unset( $_POST['inEmail2'] );
                                    }
                                    else
                                    {
                                        echo '<div class="alert alert-danger alert-dismissible fade show text-left" role="alert">';
                                        echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                                        echo "Erro na criação do usuário ! Tente novamente.";
                                        echo '</div>';                            
                                    }
                                }
                                else
                                {
                                    echo '<div class="alert alert-danger alert-dismissible fade show text-left" role="alert">';
                                    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                                    echo "Endereço de e-mail não confere! Tente novamente.";
                                    echo '</div>';                            
                                }
                            }
                            else
                            {
                                echo '<div class="alert alert-danger alert-dismissible fade show text-left" role="alert">';
                                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                                echo "Por favor preencha a validação do reCAPTCHA.";
                                echo '</div>';                            
                            }
                            unset( $_POST['register'] );
                        }
                    ?>

                    <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2" >

                        <div class="form-group text-left ">
                            <label class="form-control-label">Nome</label>
                            <input name="inName" type="text" data-msg="Nome completo" class="form-control form-control-sm" value="" autocomplete="off" required>
                        </div>

                        <div class="form-group text-left ">
                            <label class="form-control-label">E-mail</label>
                            <input name="inEmail" type="email" data-msg="Endereço de email" class="form-control form-control-sm" value="" autocomplete="off" required>
                        </div>
                        
                        <div class="form-group text-left ">
                            <label class="form-control-label">E-mail - Confirme o endereço de email</label>
                            <input name="inEmail2" type="email" data-msg="Confirmação do endereço de email" class="form-control form-control-sm" value="" autocomplete="off" required>
                        </div>
                        <!--
                        <div class="form-group ">
                            <div class="g-recaptcha" id="idCaptcha" data-sitekey="6LduuakUAAAAAO1ungSving5vw2bW41PpcEoqqV2"></div>
                        </div>    
                        -->
                        <div class="form-group text-center mt-4">
                            <button class="btn btn-success btn-block " name="register" type="submit">Cadastrar</button>
                        </div>

                    </div>
                    <a href="login.php" class="forgot-pass">Já tem login ?</a>
                    <a href="remember.php" class="forgot-pass">Esqueceu a Senha ?</a>

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