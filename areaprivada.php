<?php
    session_start();

    // Verifica se o usuário está logado
    if (!isset($_SESSION['id_usuario'])) {
        header("Location: index.php"); // Se não estiver logado, redireciona para o login
        exit;
    }

    require_once 'usuario.php'; // Inclui a classe de usuário
    $usuario = new Usuario();
    $usuario->conectar("cadastroturma32", "localhost", "root", "");
    if ($usuario->msgErro != "") {
        echo "Erro ao conectar ao banco de dados: " . $usuario->msgErro;
        exit();
    }
    
    $pdo = $usuario->getPdo();

    // Pega as informações do usuário logado, por exemplo, o ID
    $id_usuario = $_SESSION['id_usuario'];
    $sql = "SELECT email FROM usuarios WHERE id_usuario = :id";
    $sql = $pdo->prepare($sql);
    $sql->bindValue(":id", $id_usuario);
    $sql->execute();
    
    if ($sql->rowCount() > 0) {
        $usuario_data = $sql->fetch(PDO::FETCH_ASSOC); // Pega os dados do usuário
        $email_usuario = $usuario_data['email']; // Exemplo de exibição do email
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
</head>
<body>
    <h2>Bem-vindo à Área Privada!</h2>

    <!-- Exibe o email do usuário logado -->
    <p><strong>Email:</strong> <?php echo $email_usuario; ?></p>

    <h3>Opções de Acesso:</h3>
    <ul>
        <li><a href="listar.php">Listar Usuários</a></li>
        <li><a href="editar.php?id=<?php echo $id_usuario; ?>">Editar Meu Perfil</a></li>
        <li><a href="deletar.php?id=<?php echo $id_usuario; ?>">Deletar Conta</a></li>
    </ul>

    <!-- Link para logout -->
    <a href="logout.php">Sair</a>
</body>
</html>
