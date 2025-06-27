<?php
// Inicializa variables
$data = null;
$edad = "";
$imagen = "";
$nombre = $_POST['nombre'] ?? ''; // Captura el nombre enviado por el formulario

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Llama a la API Agify para predecir la edad según el nombre
    $api = curl_init();
    curl_setopt($api, CURLOPT_URL, "https://api.agify.io/?name=" . urlencode($nombre));
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($api);
    curl_close($api);
    $data = json_decode($response, true);

    // Clasifica la edad en tres etapas
    if ($data['age'] < 12) {
        $edad = 'bebe';
    } elseif ($data['age'] >= 12 && $data['age'] < 60) {
        $edad = 'joven';
    } else {
        $edad = 'viejo';
    }

    // Asigna imagen según etapa
    switch ($edad) {
        case 'bebe':
            $imagen = "./img/bebe.jpg";
            break;
        case 'joven':
            $imagen = "./img/Joven.jpeg";
            break;
        case 'viejo':
            $imagen = "./img/viejos.jpg";
            break;
        default:
            $imagen = '';
            break;
    }
}
?>

<!-- Formulario para ingresar nombre -->
<section class="container mt-5">
    <div class="card shadow-lg rounded-4 border-0">
        <div class="card-header bg-primary text-white text-center rounded-top-4">
            <h3 class="mb-0">🔍 Predecir la Edad según el nombre</h3>
        </div>
        <div class="card-body p-4">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="nombre" class="form-label fw-bold">Ingresa un nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" class="form-control form-control-lg rounded-3 shadow-sm" placeholder="Ej. Carlos" required>
                </div>
                <button type="submit" class="btn btn-success w-100 fw-bold rounded-3">Predecir Edad</button>
            </form>
        </div>
    </div>

    <!-- Mostrar resultado si hay datos -->
    <?php if ($data && $edad == 'bebe'): ?>
        <div class="card-shadow text-center mt-4 pd-4 border border-primary">
            <img src='<?= $imagen ?>' class="card-img-top" alt="imagen de referencia">
            <div class="card-body border border-primary">
                <h5 class="card-title">🔎Resultado:</h5>
                <p class="card-text ">Segun el nombre insertado: eres un <?= $edad ?></p>
            </div>
        </div>

    <?php elseif ($data && ($edad == 'joven' || $edad == 'viejo')): ?>
        <div class="card-shadow text-center mt-4 pd-4 border border-primary">
            <img src='<?= $imagen ?>' class="card-img-top" alt="imagen de referencia">
            <div class="card-body border border-primary">
                <h5 class="card-title">🔎Resultado:</h5>
                <p class="card-text ">Segun el nombre insertado: eres <?= $edad ?></p>
            </div>
        </div>
    <?php endif; ?>
</section>
