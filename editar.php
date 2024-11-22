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

if (isset($_GET['id'])) {
    $id_usuario = intval($_GET['id']); 

    
    $sql = "SELECT * FROM usuarios WHERE id_usuario = :id";
    $sql = $usuario->getPdo()->prepare($sql);
    $sql->bindValue(":id", $id_usuario);
    $sql->execute();

    if ($sql->rowCount() > 0) {
        $usuario_data = $sql->fetch(PDO::FETCH_ASSOC);
        $nome = $usuario_data['nome'];
        $telefone = $usuario_data['telefone'];
        $email = $usuario_data['email'];
    } else {
        echo "Usuário não encontrado.";
        exit();
    }

    
    if (isset($_POST['nome'])) {
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];

        
        if (!empty($nome) && !empty($telefone) && !empty($email)) {
            
            $resultado = $usuario->editar($id_usuario, $nome, $telefone, $email);

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

    <link rel="stylesheet" href="estilo.css">
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

       

        <input type="submit" value="Atualizar Perfil">
    </form>

    <br>
    <a href="areaprivada.php">Voltar para a área privada</a>
</body>
</html>
