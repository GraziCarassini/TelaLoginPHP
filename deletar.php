<?php
    session_start();

    //verifica se está logado
    if (!isset($_SESSION['id_usuario'])) {
        header("Location: index.php"); // Se não vai para login
        exit;
    }

    require_once 'usuario.php';
    $usuario = new Usuario();


    if (isset($_GET['id'])) {
        $id_usuario = intval($_GET['id']);

    
        $usuario->conectar("cadastroturma32", "localhost", "root", "");
        if ($usuario->msgErro != "") {
            echo "Erro ao conectar ao banco de dados: " . $usuario->msgErro;
            exit();
        }

        // Chama o método deletar
        if ($usuario->deletar($id_usuario)) {
            // Se der certo vai para listar
            header("Location: listar.php");
            exit();
        } else {
            echo "Erro ao deletar o usuário.";
            exit();
        }
    } else {
        echo "ID do usuário não informado.";
        exit();
    }
?>

