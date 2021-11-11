<?php

require_once 'agenda.php';
//conexão
$u = new Usuario("agenda", "localhost", "root", '');

//incluindo a sessão de login
include('checkLogin.php');

//salvar ou atualizar
if (isset($_POST['nome'])) {

  //atualizar
  if (isset($_GET["user_Id_up"]) && !empty($_GET["user_Id_up"])) {
    $user_Id_upD = ($_GET['user_Id_up']);
    $user_Nome = ($_POST['nome']);
    $user_Tel = ($_POST['tel']);
    $user_Email = ($_POST['email']);
    if (!empty($user_Nome) && !empty($user_Tel) && !empty($user_Email)) {
      //atualizar
      $u->refreshData($user_Id_upD, $user_Nome, $user_Tel, $user_Email);
      header("Location: dashboard.php");
    } else {
      echo "Todos os campos são obrigatórios";
    }
  }
  //salvar
  else {
    $user_Nome = addslashes($_POST['nome']);
    $user_Tel = addslashes($_POST['tel']);
    $user_Email = addslashes($_POST['email']);
    if (!empty($user_Nome) && !empty($user_Tel) && !empty($user_Email)) {
      //salvar
      if (!$u->registerPerson($user_Nome, $user_Tel, $user_Email)) {
        echo "Email já cadastrado";
      };
    } else {
      echo "Todos os campos são obrigatórios";
    }
  }
}

//pegando id para excluir
if (isset($_GET["user_Id"])) {
  $id_User = addslashes($_GET["user_Id"]);
  $u->excludePerson($id_User);
  header("Location: dashboard.php");
}
//pegando id para editar
if (isset($_GET["user_Id_up"])) {
  $id_Update = addslashes($_GET["user_Id_up"]);
  $res = $u->searchPerson($id_Update);
};
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="stylesheet" href="dashStyle.css">

  <title>Agenda</title>
</head>

<body>
  <div class="container">
    <p class="title">AGENDA</p>
    <div class="form">
      <form class="form-form" method="POST">

        <input class="form-input" id="nome" type="text" name="nome" placeholder="Digite o nome" value="<?php if (isset($res)) {
                                                                                                          echo $res['user_Nome'];
                                                                                                        } ?>" />
        <input class="form-input" id="tel" type="text" name="tel" placeholder="Digite o telefone" value="<?php if (isset($res)) {
                                                                                                            echo $res['user_Tel'];
                                                                                                          } ?>" />
        <input class="form-input" id="email" type="email" name="email" placeholder="Digite o email" value="<?php if (isset($res)) {
                                                                                                              echo $res['user_Email'];
                                                                                                            } ?>" />

        <button class="btn-form" type="submit"><?php if (isset($res)) {
                                                  echo "ATUALIZAR";
                                                } else {
                                                  echo "SALVAR";
                                                }; ?></button>
      </form>
    </div>

    <div class="table">
      <table>
        <tr class="table-table">
          <td>Nome</td>
          <td>Tel</td>
          <td colspan="2" right>Email</td>
        </tr>
        <?php
        $data = $u->getData();
        if (count($data) > 0) {
          for ($i = 0; $i < count($data); $i++) {
            echo "<tr>";
            foreach ($data[$i] as $k => $v) {
              if ($k != "user_Id") {
                echo "<td>" . $v . "</td>";
              }
            }
        ?>
            <td>
              <a class="edit-del" href="dashboard.php?user_Id_up=<?php echo $data[$i]['user_Id']; ?>">EDIT</a>
              <a class="edit-del" href="dashboard.php?user_Id=<?php echo $data[$i]['user_Id']; ?>">DEL</a>
            </td>
        <?php
            echo "</tr>";
          }
        } else {
          echo "<span>*não há ninguém na agenda</span>";
        };
        ?>
        </tr>
      </table>
      <a class="btnLogout" href='logout.php'>SAIR</a>
    </div>
  </div>
</body>

</html>