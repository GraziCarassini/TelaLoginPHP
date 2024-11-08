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
        <a href="cadastro.php">CADASTRE-SE</a>
    </form>

<?php

    if(isset($_POST["email"])){
        $email = addslashes($_POST['email']);
        $senha = addslashes($_POST['senha']);

        if(!empty($email) && !empty($senha))
        {
            $usuario->conectar("cadastroturma32","localhost","root","");
            if($usuario->msgErro == "")
            {
                if($usuario->logar($email, $senha)){
                    header("location:areaprivada.php");
                }
            }
            else
            {
                ?> 

            <!--essa area vai ser do html-->
           <div id="msn-sucesso">
            Email e/ou Senha estão incorretos!
            </div>
            <!--fim da area html->

            <?php
            }
        
        }
        else
        {
            ?>

                <!--essa area vai ser do html-->
                <div id="msn-sucesso">
                    <?php echo "Erro: ".$usuario->msgErro;?>
                    </div>
                <!--fim da area html->
                <?php
        }

        else
        {
            ?>

                <!--essa area vai ser do html-->
                <div id="msn-sucesso">
                    Preencha todos os campos
                    </div>
                <!--fim da area html->
                <?php
        }
    }

</body>
</html>