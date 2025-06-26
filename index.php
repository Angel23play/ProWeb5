<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="./Styles/style.css">
</head>

<body>


    <!-- Hecho por Angel Tejeda 2024-0222 -->
    <?php include('./Views/Components/navbar.php'); ?>

    <div class="container home">
        <?php
        $vista = $_GET['vista'] ?? 'home';

        if ($_GET['vista'] === null) {
            $vista = 'home';
        }
        switch ($vista) {
            case 'home':
                include('./Views/home.php');
                break;
            case 'about':
                include('./Views/about.php');
                break;
            case 'genero':
                include('./Views/Genero.php');
                break;
            case 'edad':
                include('./Views/Edad.php');
                break;
            case 'universidades':
                include('./Views/Universidades.php');
                break;
            case 'clima':
                include('./Views/Clima.php');
                break;
            case 'pokemon':
                include('./Views/Pokemon.php');
                break;
            case 'wordpress':
                include('./Views/WordPress.php');
                break;
            case 'monedas':
                include('./Views/Monedas.php');
                break;
            case 'imagenes':
                include('./Views/Imagenes.php');
                break;
            case 'pais':
                include('./Views/Pais.php');
                break;
            case 'chistes':
                include('./Views/Chistes.php');
                break;
        }
        ?>

    </div>
    <?php include('./Views/Components/footer.php'); ?>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</html>