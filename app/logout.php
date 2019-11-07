
<?php
session_start();
session_destroy();

//remove todas a informações contidas na variavel.
unset(
    $_SESSION['username'],
    $_SESSION['password'],
    $_SESSION['profile'],
    $_SESSION['name'],
    $_SESSION['user_id'],
    $_SESSION['profile_id'],
    $_SESSION['contact_id'],
    $_SESSION['email'],
    $_SESSION['user_type'],
    $_SESSION['timestamp']
);
//redireciona para tela de login
header("Location: ../index.php");
?>

