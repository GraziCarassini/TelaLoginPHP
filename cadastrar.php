<?php
    require_once 'usuario.php';
    $usuario = new Usuario();


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <h2>CADASTRO</h2>
    <form action="" method="post">
        <label>Nome:</label> 
        <input type="text" name="nome" id="" placeholder="Digite seu nome: ">

        <label>Telefone:</label> 
        <input type="tel" name="tel" id="" placeholder="Digite seu telefone: ">

        <label>Email:</label> 
        <input type="email" name="email" id="" placeholder="Digite seu email: ">

        <label>Senha:</label> 
        <input type="password" name="senha" id="" placeholder="Digite sua senha: ">

        <label>Confirmar Senha:</label> 
        <input type="password" name="confsenha" id="" placeholder="Confirme sua senha: ">

        <input type="submit" value="cadastrar">

        <a href="index.php">VOLTAR</a>
       

    </form>

    <?php
    if(isset($_POST['nome']))
    {
        $nome = $_POST['nome'];
        $telefone = $_POST['tel'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $confSenha = addslashes( $_POST['confsenha']);

        // Verificar se todos os campos estao preenchidos
        if(!empty($nome) && !empty($telefone) && !empty($email) && !empty($senha))
        {
            $usuario->conectar("cadastroturma32", "localhost", "root", "");
            if($usuario->msgErro == "")
            {
                if($senha == $confSenha)
                {
                    if($usuario->cadastrar($nome,$telefone,$email,$senha))
                    {
                        ?>

                            <div id="msn-sucesso">
                                Cadastrado com sucesso
                                Clique <a href="index.php">aqui</a> para logar
                            </div>
                        <?php
                        
                    }
                    else
                    {
                        ?>
                        <div id="msn-sucesso">
                            E-mail já cadasatrado! 
                        </div>
                        <?php
                    }
                }
                else
                {
                    ?>
                    <div id="msn-sucesso">
                        A senha e Confirmar Senha não conferem!
                    </div>
                    <?php
                }
            }
            else
            {
                ?>
                <div id="msn-sucesso">
                    <?php echo "Erro: ".$usuario->msgErro;?>
                </div>
                <?php
            }
        }
        else
        {
            ?>
            <div id="msn-sucesso">
                Preencha todos os campos!
            </div>
            <?php
        }
    }

?>
</body>
</html>

  