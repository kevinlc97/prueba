<?php

include_once 'conexionBD/01.conexion.php';
$a = new conexionBD();
$a->conexion();
$a->seleccionar();

if ($_POST){
  $a->nombre = $_POST['nombre'];
  $a->avance = $_POST['avance'];
  $a->duracion = $_POST['duracion'];
  $a->temporada = $_POST['temporada'];
  $a->capitulo = $_POST['capitulo'];
  $a->enlace = $_POST['enlace'];
  $a->insertar();
  header('location:index.php');
}

if ($_GET) {
  $id = $_GET['id'];
  $sql_unico = "SELECT * FROM registro WHERE id=?";
  $gsent_unico = $a->pdo -> prepare($sql_unico);
  $gsent_unico -> execute(array($id));
  $resultado_unico = $gsent_unico->fetch();
}

?>

<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css" integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
        crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Pasatiempos Kevin López</title>
    <link rel="icon" type="image/png" href="imgs/popcorn-icon_640.png" >
</head>

<body>

    <?php if(!$_GET): ?>
      <div id="openModal" class="modalDialog">
      	<div>
      		<a href="#close" title="Close" class="close">X</a>
          <h3 align="center">Registro</h3>
          <form method="post">
            <label>Nombre: Ej. Game Of Thrones</label>
            <input type="text" class="form-control" name="nombre" placeholder="Game Of Thrones" minlength="3" required>
            <label>Avance: Ej. 00:38:00</label>
            <input type="time" class="form-control" name="avance" placeholder="00:38:00" required>
            <label>Duración: Ej. 1:01:00</label>
            <input type="time" class="form-control" name="duracion" placeholder="1:01:00" required>
            <label>Temporada: Ej. 1</label>
            <input type="number" class="form-control" name="temporada" placeholder="1" required>
            <label>Capítulo: Ej. 1</label>
            <input type="number" class="form-control" name="capitulo" placeholder="1" required>
            <label>Enlace: Ej. https://...</label>
            <input type="text" class="form-control" name="enlace" placeholder="https://..." required>
              <button class="btn btn-dark text-success mt-3">Registrar avance</button>
          </form>
      	</div>
      </div>
    <?php endif ?>

    <?php if($_GET): ?>
      <div id="openModal" class="modalDialog">
      	<div>
      		<a href="index.php#close" title="Close" class="close">X</a>
          <h3 align="center">Editar</h3>
          <form method="get" action="conexionBD/02.editar.php">
            <label>Nombre: Ej. Game Of Thrones</label>
            <input type="text" class="form-control" name="nombre" placeholder="Game Of Thrones" value="<?php echo $resultado_unico['nombre']; ?>" minlength="3" required>
            <label>Avance: Ej. 00:38:00</label>
            <input type="time" class="form-control" name="avance" placeholder="00:38:00" value="<?php echo $resultado_unico['avance']; ?>" required>
            <label>Duración: Ej. 1:01:00</label>
            <input type="time" class="form-control" name="duracion" placeholder="1:01:00" value="<?php echo $resultado_unico['duracion']; ?>" required>
            <label>Temporada: Ej. 1</label>
            <input type="number" class="form-control" name="temporada" placeholder="1" value="<?php echo $resultado_unico['temporada']; ?>" required>
            <label>Capítulo: Ej. 1</label>
            <input type="number" class="form-control" name="capitulo" placeholder="1" value="<?php echo $resultado_unico['capitulo']; ?>" required>
            <label>Enlace: Ej. https://...</label>
            <input type="text" class="form-control" name="enlace" placeholder="https://..." value="<?php echo $resultado_unico['enlace']; ?>" required>
            <input type="hidden" class="form-control" name="id"  value="<?php echo $resultado_unico['id']; ?>" required>
              <button class="btn btn-dark text-success mt-3">Editar avance</button>
          </form>
      	</div>
      </div>
    <?php endif ?>



    <div class="container mt-3 bg-secondary">
      <h3 align="center" class="text-dark">Listado general</h3>
      <div id="design-general-modal">
        <a id="design-modal" href="#openModal"><button type="button" class="btn btn-dark text-success">Nuevo Registro</button></a>
      </div></br>
        <div class="card-columns">
        <?php foreach ($a->resultado as $dato): ?>
            <div class="card text-capitalize">
                <img src="imgs/movie_640.jpg" height="200px" class="card-img-top" alt="">
                <div class="card-body">
                    <h5 class="card-title text-success" align="center"><?php echo $dato['nombre']; ?></h5>
                    <p class="card-text text-black-50">
                    Temporada: <?php echo $dato['temporada']; ?></br>
                    Capítulo: <?php echo $dato['capitulo']; ?></br>
                    Avance: <?php echo $dato['avance']; ?></br>
                    Duración: <?php echo $dato['duracion']; ?></br>
                    Seguir mirando: <a href="<?php echo $dato['enlace']; ?>"><img height="22px" width="22px" src="https://img.icons8.com/color/48/000000/visible.png"></a>
                    </p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Última modificación: <?php echo $dato['fecha_actualizacion']; ?></small>
                    <a style="color: rgb(210, 67, 67)" href="conexionBD/03.eliminar.php?id=<?php echo $dato['id'] ?>" class="float-left mr-3">
                      <i class="fas fa-minus-square"></i>
                    </a>
                    <a href="index.php?id=<?php echo $dato['id'] ?>#openModal" class="float-right text-black-50">
                      <i class="fas fa-pencil-alt"></i>
                    </a>
                    <?php
                    $av_res;
                    $av_min;
                    $av_horamin;
                    $av_horamin = (int)substr($dato['avance'], 0, 2);
                    $av_min = (int)substr($dato['avance'], 3, 2);
                    $av_res = $av_min + $av_horamin*60;
                    //echo $av_res;

                    $dur_res;
                    $dur_min;
                    $dur_horamin;
                    $dur_horamin = (int)substr($dato['duracion'], 0, 2);
                    $dur_min = (int)substr($dato['duracion'], 3, 2);
                    $dur_res = $dur_min + $dur_horamin*60;
                    //echo $dur_res;

                    $total;
                    $total = ($av_res*100)/$dur_res;
                    if ($total > 100){
                      $total = 100;
                    }
                    //echo $total;
                    ?>
                    <div class="progress">
                      <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $total."%" ?>" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer style="width:118px; height: 20px; background: <?php echo $a->estadoConCol; ?>; position: fixed; bottom: 0;">
        <p style="font-size: 12px; text-align: center;" class="text-white" text-wrap>Estado:
            <?php echo $a->estadoCon; ?>
        </p>
    </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js" integrity="sha384-7aThvCh9TypR7fIc2HV4O/nFMVCBwyIUKL8XCtKE+8xgCgl/PQGuFsvShjr74PBp"
        crossorigin="anonymous"></script>
</body>

</html>
