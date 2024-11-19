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
</head>
<body>
    <h2>CRUD - CREAT READ UPDATE DELETE</h2>
    <h3>TELA LOGIN</h3>

    <form method="post">
        <label>Usuário: </label>
        <input type="email" name="email" id=""
        placeholder="Digite seu email.">
        <label>Senha: </label>
        <input type="password" name="senha" id=""
        placeholder="Digite sua senha.">
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
                    // Mensagem de erro quando email/senha estão incorretos
                    echo '<div id="msn-erro">Email e/ou Senha estão incorretos!</div>';
                }
            } else {
                // Mensagem de erro quando há um erro na conexão com o banco
                echo '<div id="msn-erro">Erro: ' . $usuario->msgErro . '</div>';
            }
        } else {
            // Mensagem de erro quando algum campo não foi preenchido
            echo '<div id="msn-erro">Preencha todos os campos</div>';
        }
    }
?>
</body>
</html>