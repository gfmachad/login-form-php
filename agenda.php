<?php
class Usuario
{

  private $pdo;

  //conexão
  public function __construct($dbname, $host, $username, $password)
  {
    try {
      $this->pdo = new PDO("mysql:dbname=" . $dbname . ";host=" . $host, $username, $password);
    } catch (PDOException $e) {
      echo "Error: db" . $e->getMessage();
      exit();
    } catch (Exception $e) {
      echo "Error: geral" . $e->getMessage();
    }
  }
  //buscando dados 
  public function getData()
  {
    $res = array();
    $data = $this->pdo->query("SELECT * FROM usuario ORDER BY user_Nome");
    $res = $data->fetchAll(PDO::FETCH_ASSOC);
    return $res;
  }

  //cadastrar 
  public function registerPerson($user_Nome, $user_Tel, $user_Email)
  {
    //verificar se já existe email 
    $res = $this->pdo->prepare("SELECT user_Id from usuario WHERE user_Email = :e");
    $res->bindValue(":e", $user_Email);
    $res->execute();
    //email existe no banco
    if ($res->rowCount() > 0) {
      return false;
      //email não existe no banco
    } else {
      $res = $this->pdo->prepare("INSERT INTO usuario (user_Nome, user_Tel, user_Email) VALUES (:n, :t, :e)");
      $res->bindValue(":n", $user_Nome);
      $res->bindValue(":t", $user_Tel);
      $res->bindValue(":e", $user_Email);
      $res->execute();
      return true;
    }
  }
  //excluir
  public function excludePerson($user_Id)
  {
    $res = $this->pdo->prepare("DELETE FROM usuario WHERE user_Id = :id");
    $res->bindValue(":id", $user_Id);
    $res->execute();
  }
  //buscar uma pessoa 
  public function searchPerson($user_Id)
  {
    $res = array();
    $data = $this->pdo->prepare("SELECT * FROM usuario WHERE user_Id = :id");
    $data->bindValue(":id", $user_Id);
    $data->execute();
    $res = $data->fetch(PDO::FETCH_ASSOC);
    return $res;
  }

  //atualizar dados no banco
  public function refreshData($user_Id, $user_Nome, $user_Tel, $user_Email)
  {

    $res = $this->pdo->prepare("UPDATE usuario SET user_Nome = :n, user_Tel = :t, user_Email = :e WHERE user_Id = :id");
    $res->bindValue(":id", $user_Id);
    $res->bindValue(":n", $user_Nome);
    $res->bindValue(":t", $user_Tel);
    $res->bindValue(":e", $user_Email);
    $res->execute();
  }
}
