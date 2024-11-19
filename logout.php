<?php
    session_start();
    session_destroy(); // apaga todos os dados
    header("Location: index.php"); // redireciona para a página de login
    exit;
?>
