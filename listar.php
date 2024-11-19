<?php
    require_once 'usuario.php'; 

    $usuario = new Usuario();  

    
    $usuario->conectar("cadastroturma32", "localhost", "root", "");

    // Verificar se a conexão foi bem-sucedida
    if ($usuario->msgErro == "") {
        // Buscar todos os usuários do banco de dados
        $usuarios = $usuario->listar();
    } else {
        echo "Erro: " . $usuario->msgErro;
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Usuários</title>
</head>
<body>
    <h2>Lista de Usuários</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Verifica se existe usuários na lista
                if (!empty($usuarios)) {
                
                    foreach ($usuarios as $usuario) {
                        echo "<tr>";
                        echo "<td>" . $usuario['id_usuario'] . "</td>";
                        echo "<td>" . $usuario['email'] . "</td>";
                        echo "<td>
                                <a href='editar.php?id=" . $usuario['id_usuario'] . "'>Editar</a> | 
                                <a href='deletar.php?id=" . $usuario['id_usuario'] . "'>Deletar</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhum usuário encontrado.</td></tr>";
                }
            ?>
        </tbody>
    </table>
    <br>
    <a href="index.php">Voltar para a página de login</a>
</body>
</html>
