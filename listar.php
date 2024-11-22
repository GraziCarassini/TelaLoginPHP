<?php
    require_once 'usuario.php'; 

    session_start();

    $idUsuarioLogado = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;

    $usuario = new Usuario();  


    $usuario->conectar("cadastroturma32", "localhost", "root", "");

    if ($usuario->msgErro == "") {
        
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

    <link rel="stylesheet" href="estilo.css">
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
        
                if (!empty($usuarios)) {
                    foreach ($usuarios as $usuario) {
                       
                        if ($usuario['id_usuario'] == $idUsuarioLogado) {
                            echo "<tr style='background-color: #d3f8d3;'>";  // pinta a linha logado
                        } else {
                            echo "<tr>";
                        }
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
