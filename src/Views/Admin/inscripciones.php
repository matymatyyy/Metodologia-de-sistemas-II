<?php
    $_SESSION['usuario'] = "Admin";
    $_SESSION['rol'] = "Secretario";
?>

<!-- ======= Head ======= -->
<?php include 'src/Views/Admin/Includes/head.php'; ?>

<body>

    <!-- ======= Header ======= -->
    <?php include 'src/Views/Admin/Includes/header.php'; ?>

    <!-- ======= Sidebar ======= -->
    <?php include 'src/Views/Admin/Includes/sidebar.php'; ?>

    <!-- ======= Main Content ======= -->
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Bienvenido al panel, <?php echo $_SESSION['usuario']; ?></h1>
        </div>
    </main>

    <!-- ======= Sidebar ======= -->
    <?php include 'src/Views/Admin/Includes/footer.php'; ?>

    <script src="src/Dist/Admin/inscripciones.js"></script>
</body>

</html>