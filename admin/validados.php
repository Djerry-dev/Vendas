<?php
  include ('../config.php');
  $sql = "SELECT * FROM pedidos WHERE status = 1";
  $cursor = mysqli_query($conn, $sql);
  
  if (isset($_GET["aprovar"])){
    $idendtificador = $_GET["aprovar"];
    $sqla = "DELETE FROM pedidos WHERE id =
    $idendtificador";
    $cursora = mysqli_query($conn, $sqla);
  }
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Validados</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <table>
      <thead>
        <tr>
          <th>Bairro</th>
          <th>Tipo Local</th>
          <th>Numero</th>
          <th>Produtos</th>
          <th>Troco Para</th>
          <th>Preço Total</th>
          <th>Data</th>
          <th>Acção</th>
        </tr>
      </thead>
      <tbody id="user-list">
        <?php
          while ($res = mysqli_fetch_row($cursor)){
            $id = $res[0];
            $bairro = $res[1];
            $tipo_local = $res[2];
            $numero= $res[3];
            $produtos = $res[4];
            $troco_para = $res[5];
            $total = $res[6];
            $data = $res[7];
        ?>
        <tr>
          <td><?= $bairro ?></td>
          <td><?= $tipo_local ?></td>
          <td><?= $numero ?></td>
          <td><?= $produtos ?></td>
          <td><?= $troco_para ?></td>
          <td><?= $total ?></td>
          <td><?= $data ?></td>
          <td><a target="_self" href="./validados.php?aprovar=<?= $id ?>" class="lat" >Excluir</a></td>
        </tr>
        <?php
          }
        ?>
      </tbody>
    </table>
  
  </body>
</html>

<?php
 mysqli_close($conn)
?>