<?php
    require_once 'usuario.php';
    $usuario = new Usuario();


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela Login</title>

    <link rel="stylesheet" href="estilo.css">
</head>
<body>
<div class="container"> 
        <h2>CRUD - CREATE READ UPDATE DELETE</h2>
        <h3>TELA LOGIN</h3>

        <form method="post">
            <label>Usuário: </label>
            <input type="email" name="email" placeholder="Digite seu email.">
            <label>Senha: </label>
            <input type="password" name="senha" placeholder="Digite sua senha.">
            <input type="submit" value="LOGAR">
            <a href="cadastrar.php">CADASTRE-SE</a>
        </form>

    <?php
    if(isset($_POST["email"])){
        $email = addslashes($_POST['email']);
        $senha = addslashes($_POST['senha']);

        if(!empty($email) && !empty($senha)){
            $usuario->conectar("cadastroturma32", "localhost", "root", "");
            if($usuario->msgErro == ""){
                if($usuario->logar($email, $senha)){
                    header("location:areaprivada.php");
                    exit;
                } else {
                    echo '<div id="msn-erro">Email e/ou Senha estão incorretos!</div>';
                }
            } else {
                echo '<div id="msn-erro">Erro: ' . $usuario->msgErro . '</div>';
            }
        } else {
            echo '<div id="msn-erro">Preencha todos os campos</div>';
        }
    }
?>
</body>
</html>