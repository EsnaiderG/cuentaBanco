<?php
require_once ('../database/conexion.php');
$db = conectar();

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

$emailUsuario = $_SESSION['email'];

$consultaUsuario = $db->prepare("
    SELECT usuario.nombre AS NombreUsuario, cuenta.saldo
    FROM usuario
    JOIN cuenta ON usuario.id_usuario = cuenta.fk_usuario
    WHERE usuario.email = :email
");
$consultaUsuario->bindParam(':email', $emailUsuario);
$consultaUsuario->execute();

$resultadoUsuario = $consultaUsuario->fetch(PDO::FETCH_ASSOC);

if ($resultadoUsuario) {
    $nombreUsuario = $resultadoUsuario['NombreUsuario'];
    $saldoUsuario = $resultadoUsuario['saldo'];
} else {
    $nombreUsuario = "Usuario Desconocido";
    $saldoUsuario = 0;
}

if (isset($_POST['cerrar_sesion'])) {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}

// Obtener movimientos de la base de datos
$consultaMovimientos = $db->prepare("
    SELECT tipo, monto, fecha
    FROM transaccion
    WHERE fk_usuario = (SELECT id_usuario FROM usuario WHERE email = :email)
    ORDER BY fecha DESC
");
$consultaMovimientos->bindParam(':email', $emailUsuario);
$consultaMovimientos->execute();
$movimientos = $consultaMovimientos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta Banco</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.0.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
</head>

<body>
    <form class="modal-content animate" action="../index.php" method="POST">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content" class="mb-5">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card border rounded-lg mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Bienvenido,
                                            <?php echo htmlspecialchars($nombreUsuario); ?>
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="card bg-light text-center mb-4">
                                            <div class="card-header">
                                                <i class="fa-solid fa-receipt"></i>
                                                Movimientos
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Movimiento</th>
                                                            <th scope="col">Monto</th>
                                                            <th scope="col">Fecha</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($movimientos as $movimiento): ?>
                                                            <tr>
                                                                <td>
                                                                    <span
                                                                        class="badge bg-<?php echo ($movimiento['tipo'] == 'consignacion') ? 'success' : 'danger'; ?> rounded-pill w-25">
                                                                        <i
                                                                            class="fa-solid fa-circle-arrow-<?php echo ($movimiento['tipo'] == 'consignacion') ? 'up' : 'down'; ?>"></i>
                                                                    </span>

                                                                </td>
                                                                <td>$<?php echo htmlspecialchars($movimiento['monto']); ?>
                                                                </td>
                                                                <td><?php echo htmlspecialchars($movimiento['fecha']); ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div
                                                class="card-footer d-flex align-items-center text-center justify-content-between">
                                                <div class="w-100">
                                                    <a href="dashboard2.php" class="btn btn-outline-danger shadow-sm"
                                                        style="width: 110px;"><i class="fa-solid fa-xmark"></i>
                                                        Cancelar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <form method="POST" class="d-inline">
                                            <input type="submit" class="btn btn-danger" name="cerrar_sesion"
                                                value="Cerrar Sesión">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </form>
</body>

</html>