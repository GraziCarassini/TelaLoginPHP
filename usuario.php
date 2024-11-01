<?php

    Class Usuario{
        private $pdo;

        public $msgErro="";

        public function conectar($nome, $host, $usuario, $senha){
            global $pdo;

            try{
                $pdo = new PDO("mysql:dbname=".$nome,$usuario,$senha);
            }
            catch (PDOException $erro){
                $msgErro = $erro->getMessage();
            }
        }

        public function cadastrar($nome,$telefone,$email,$senha){
            global $pdo;
            //Verificar se o email já está cadastrado//
            $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :m");
            $sql->bindValue(":m, $email");
            $sql->execute();
            if($sql->rowCount()>0){
                return false;
            }
            else{
                $sql = $pdo->prepare("INSERT INTO usuarios (nome,telefone,email,senha VALUES (:n, :t, :e, :s)");
                $sql->bindValue(":n", $nome);
                $sql->bindValue(":t", $telefone);
                $sql->bindValue(":e", $email);
                $sql->bindValue(":s", $senha);
                $sql->execute();
                return true;
            }
        }
    }
        
        
?>