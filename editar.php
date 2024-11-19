<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php"); // Se não estiver logado, redireciona para o login
    exit;
}

require_once 'usuario.php'; // Inclui a classe de usuário
$usuario = new Usuario();

// Verifica se o parâmetro 'id' foi passado pela URL
if (isset($_GET['id'])) {
    $id_usuario = intval($_GET['id']); // Pega o ID do usuário a ser editado

    // Conectar ao banco de dados
    $usuario->conectar("cadastroturma32", "localhost", "root", "");

    // Verifica se a conexão foi bem-sucedida
    if ($usuario->msgErro != "") {
        echo "Erro ao conectar ao banco de dados: " . $usuario->msgErro;
        exit();
    }

    // Busca os dados do usuário
    $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
    $sql = $usuario->getPdo()->prepare($sql);
    $sql->bindValue(":id_usuario", $id_usuario);
    $sql->execute();

    if ($sql->rowCount() > 0) {
        $usuario_data = $sql->fetch(PDO::FETCH_ASSOC); // Pega os dados do usuário
        $nome = $usuario_data['nome'];
        $telefone = $usuario_data['telefone'];
        $email = $usuario_data['email'];
    } else {
        echo "Usuário não encontrado.";
        exit();
    }

    // Verifica se o formulário foi enviado para atualizar as informações
    if (isset($_POST['nome'])) {
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $senha = $_POST['senha']; // Senha nova (caso o usuário queira alterar)

        // Verificar se os campos obrigatórios estão preenchidos
        if (!empty($nome) && !empty($telefone) && !empty($email)) {
            // Chama a função editar da classe Usuario
            $resultado = $usuario->editar($id_usuario, $nome, $telefone, $email, $senha);

            if ($resultado) {
                echo "<p>Dados atualizados com sucesso!</p>";
            } else {
                echo "<p>Erro ao atualizar os dados.</p>";
            }
        } else {
            echo "<p>Preencha todos os campos obrigatórios.</p>";
        }
    }
} else {
    echo "ID do usuário não informado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
</head>
<body>
    <h2>Editar Perfil</h2>

    <form method="post">
        <label>Nome:</label>
        <input type="text" name="nome" value="<?php echo $nome; ?>" placeholder="Digite seu nome" required><br><br>

        <label>Telefone:</label>
        <input type="text" name="telefone" value="<?php echo $telefone; ?>" placeholder="Digite seu telefone" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $email; ?>" placeholder="Digite seu email" required><br><br>

        <label>Senha:</label>
        <input type="password" name="senha" placeholder="Digite uma nova senha (se quiser alterar)"><br><br>

        <input type="submit" value="Atualizar Perfil">
    </form>

    <br>
    <a href="areaprivada.php">Voltar para a área privada</a>
</body>
</html>
