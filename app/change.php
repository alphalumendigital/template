<?php
    include_once("share/header-standard.php");

    $username = $_SESSION['ulogin'];
    $password = $_SESSION['upaswd'];
    $user_id = $_SESSION['user_id'];
    $profile_id = $_SESSION['profile_id'];
    $email = $_SESSION['email'];
    $_SESSION['timestamp'] = time();

    $acesso = User::getInstance();

    $acesso->setLogin($username);
    $acesso->setPassword($password);

    if(!$acesso->passwordCheck() )
        header("Location: login.php");

    $lista = $acesso->select("login='{$username}'");

    $lista = (object) $lista[0];
    $name = $lista->name;
    $email = $lista->email;
    $acesso->setId($lista->id);

?>

<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ial360&#176;</title>
    <meta name="description" content="Plataforma ial360 - Instituto Alpha Lumen">
    <meta name="author" content="">

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

</head>

<body class="pt-0">

<form method="post" action="" class="text-center form-validate">
    <div class="page login-page" id="background">
        <div class="container">

            <div class="form-outer d-flex align-items-center">
                <div class="form-inner dashboard-counts" style = "width:100%" >

                    <div class="logo text-uppercase">
                        <img src="../publico/img/projeto/ial360-redo-30.png" alt="ial360" class="img-fluid pb-3" width="200" height="100">
                            <!--    <strong class="text-primary">Plataforma ial360&#176;</strong> -->
                    </div>
                    <h3 class="card-title text-uppercase ">ALTERAR SENHA</h3> 

                    <?php
                        if(isset($_POST['alterar'])) {

                            if( strlen($_POST['upwd1']) > 5 ){

                                if( $_POST['upwd1'] == $_POST['upwd2'] ){

                                    $acesso->setPassword($_POST['upwd1']);
                                    $acesso->passwordUpdate();
                                    $acesso->mustChangePasswordOff();
                                    
                                    $_SESSION['upaswd'] = $_POST['upwd1'];
                                    $subject = "Alteracão de Senha - Plataforma ial360 - ALPHA LUMEN";
                                    $message = "
                                    Você alterou sua senha:<br>
                                    Senha: {$_POST['upwd1']}<br><br>
                                    ";
                                    EnviaEmail($name, $email, $subject, $message);

                                    if( $lista->mustUpdateContact == 'Y')
                                        header("Location: change2.php");
                                    else
                                        header("Location: index.php");
                                    

                                } else {
                                    echo "<div class='alert alert-danger alert-dismissible fade show text-left' role='alert'>";
                                    echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                                    echo "<p><strong>Erro na senha de confirmação! Tente novamente.</p>";
                                    echo "</div>";                                
                                }
                            } else {
                                echo "<div class='alert alert-danger alert-dismissible fade show text-left' role='alert'>";
                                echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                                echo "<p><strong>A nova senha tem que ter pelo menos 6 caracteres! Tente novamente.</p>";
                                echo "</div>";                                
                            }
                            unset($_POST['alterar']);
                        }
                    ?>

                    <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2 text-left" >

                        <div class="form-group">
                            <label for="login-username" class="form-control-label">Login</label>
                            <input id="login-username" type="text" name="uname" readonly data-msg="" class="form-control form-control-sm" value="<?php echo $username;?>" readonly >
                        </div>

                        <div class="form-group">
                            <label for="login-password" class="form-control-label" >Nova Senha</label>
                            <input name="upwd1" type="password" data-msg="Por favor entre com a Nova Senha" class="form-control form-control-sm" value="" required >
                        </div>
                        <div class="form-group mb-3">
                            <label for="login-password" class="form-control-label" >Confirme Nova Senha</label>
                            <input name="upwd2" type="password" data-msg="Por favor confirme a Nova Senha" class="form-control form-control-sm" value="" required >
                        </div>
                        <div class="form-group text-center mt-4">
                            <button class="btn btn-success btn-block " name="alterar" type="submit">Salvar</button>
                        </div>
                        <p><strong>Observação:</strong> senha com no mínimo 6 caracteres</p>

                    </div>

                </div>
                <div class="copyrights text-center">
                    <p>&copy; 2017-2019 - Instituto Alpha Lumen - Plataforma ial360&#176; - designed by <span class="text-success">Alpha Digital</span></p>
                </div>
            </div>

        </div>
    </div>
</form>
    <script src="https://d19m59y37dris4.cloudfront.net/dashboard-premium/1-4-4/vendor/jquery/jquery.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/dashboard-premium/1-4-4/vendor/popper.js/umd/popper.min.js"> </script>
    <script src="https://d19m59y37dris4.cloudfront.net/dashboard-premium/1-4-4/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/dashboard-premium/1-4-4/js/grasp_mobile_progress_circle-1.0.0.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/dashboard-premium/1-4-4/vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="https://d19m59y37dris4.cloudfront.net/dashboard-premium/1-4-4/vendor/chart.js/Chart.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/dashboard-premium/1-4-4/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/dashboard-premium/1-4-4/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- Main File-->
    <script src="https://d19m59y37dris4.cloudfront.net/dashboard-premium/1-4-4/js/front.js"></script>

</body>
</html>