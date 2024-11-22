<?php
    session_start();

    if (!isset($_SESSION['id_usuario'])) {
        header("Location: index.php");
        exit;
    }

    require_once 'usuario.php';
    $usuario = new Usuario();
    $usuario->conectar("cadastroturma32", "localhost", "root", "");
    if ($usuario->msgErro != "") {
        echo "Erro ao conectar ao banco de dados: " . $usuario->msgErro;
        exit();
    }
    
    $pdo = $usuario->getPdo();

    
    $id_usuario = $_SESSION['id_usuario'];
    $sql = "SELECT email FROM usuarios WHERE id_usuario = :id";
    $sql = $pdo->prepare($sql);
    $sql->bindValue(":id", $id_usuario);
    $sql->execute();
    
    if ($sql->rowCount() > 0) {
        $usuario_data = $sql->fetch(PDO::FETCH_ASSOC); 
        $email_usuario = $usuario_data['email']; 
    } else {
        echo "Erro ao recuperar os dados do usuário.";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Privada</title>

    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h2>Bem-vindo à Área Privada!</h2>


    <p><strong>Email:</strong> <?php echo $email_usuario; ?></p>

    <h3>Opções de Acesso:</h3>
    <ul>
        <li><a href="listar.php">Listar Usuários</a></li>
        <li><a href="editar.php?id=<?php echo $id_usuario; ?>">Editar Meu Perfil</a></li>
        <li><a href="deletar.php?id=<?php echo $id_usuario; ?>">Deletar Conta</a></li>
    </ul>

    
    <a href="logout.php">Sair</a>
</body>
</html>
