<?php
    $_SESSION['rol'] = "Secretario";
?>

<!-- ======= Head ======= -->
<?php include_once 'src/Views/Admin/Includes/head.php'; ?>

<body>

    <!-- ======= Header ======= -->
    <?php include_once 'src/Views/Admin/Includes/header.php'; ?>

    <!-- ======= Sidebar ======= -->
    <?php include_once 'src/Views/Admin/Includes/sidebar.php'; ?>

    <!-- ======= Main Content ======= -->
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Bienvenido al panel, <?php echo $_SESSION['user']['name']; ?></h1>
        </div>
    </main>

    <!-- ======= Sidebar ======= -->
    <?php include_once 'src/Views/Admin/Includes/footer.php'; ?>

    <script src="src/Dist/Admin/admin.js"></script>
</body>

</html>