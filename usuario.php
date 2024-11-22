<?php

    Class Usuario{
        private $pdo;

        public $msgErro="";

        public function conectar($nome, $host, $usuario, $senha){

            try{
                $this->pdo = new PDO("mysql:dbname=".$nome.";host=".$host, $usuario, $senha);
            }
            catch (PDOException $erro){
                $this->msgErro = $erro->getMessage();
            }
        }

        public function getPdo() {
            return $this->pdo;
        }

        public function cadastrar($nome,$telefone,$email,$senha){
            //Verificar se o email já está cadastrado//
            $sql = $this->pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :m");
            $sql->bindValue(":m", $email);
            $sql->execute();
            if($sql->rowCount()>0){
                return false;
            }
            else{
                $sql = $this->pdo->prepare("INSERT INTO usuarios (nome,telefone,email,senha) VALUES (:n, :t, :e, :s)");
                $sql->bindValue(":n", $nome);
                $sql->bindValue(":t", $telefone);
                $sql->bindValue(":e", $email);
                $sql->bindValue(":s", md5($senha));
                $sql->execute();
                return true;
            }
        }

        public function logar($email,$senha){

            $sql = $this->pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e AND senha = :s");
            $sql->bindValue(":e", $email);
            $sql->bindValue(":s", md5($senha));
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $dados = $sql->fetch();
                session_start();
                $_SESSION['id_usuario'] = $dados['id_usuario'];
                return true;
            } else {
                return false;
            }
        }



        public function listar() {
            $sql = "SELECT id_usuario, email FROM usuarios"; // seleciona todos os  do BD
            $sql = $this->pdo->query($sql); // Executa a query
    
            if ($sql->rowCount() > 0) {
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        }

        
        public function editar($id_usuario, $nome, $telefone, $email) {
            
            $sql = "UPDATE usuarios SET nome = :nome, telefone = :telefone, email = :email WHERE id_usuario = :id_usuario";
        
            
            $sql = $this->pdo->prepare($sql);
            
            
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":telefone", $telefone);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":id_usuario", $id_usuario);
            
            
            return $sql->execute();
        }
        
        
        

        public function deletar($id_usuario) {
           
            $sql = $this->pdo->prepare("DELETE FROM usuarios WHERE id_usuario = :id_usuario");
            $sql->bindValue(":id_usuario", $id_usuario);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                return true;
            }
            return false;
        }
        
        
    }    
?>