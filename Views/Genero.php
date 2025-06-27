<?php
// Inicializa variables
$data = null;
$nombre = $_POST['nombre'] ?? ''; // Captura el nombre enviado

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Llama a la API Genderize para predecir el género según el nombre
    $api = curl_init();
    curl_setopt($api, CURLOPT_URL, "https://api.genderize.io/?name=" . urlencode($nombre));
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($api);
    curl_close($api);

    // Convierte la respuesta JSON a array PHP
    $data = json_decode($response, true);
}
?>

<!-- Formulario para ingresar el nombre -->
<section class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center rounded-top-4">
            <h3 class="mb-0">🔎 Predecir el género por nombre</h3>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="nombre" class="form-label fw-bold">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" class="form-control form-control-lg rounded-3 shadow-sm" placeholder="Ej. Julian" required>
                </div>
                <button type="submit" class="btn btn-success w-100 fw-bold">Predecir</button>
            </form>

            <!-- Mostrar resultado si hay respuesta de la API -->
            <?php if ($data): ?>
                <div class="alert <?= $data['gender'] === 'male' ? 'alert-male' : 'alert-female' ?> mt-4">

                    <?php
                    // Muestra el género predicho con emoji
                    if ($data['gender'] === 'male') {
                        echo "👨 Se ha predicho que el nombre <strong>$nombre</strong> es del género <strong>Masculino</strong>.";
                        echo "<div class='emoji-big text-primary'>💙</div>";
                    } elseif ($data['gender'] === 'female') {
                        echo "👩 Se ha predicho que el nombre <strong>$nombre</strong> es del género <strong>Femenino</strong>.";
                        echo "<div class='emoji-big' style='color: #e83e8c;'>💖</div>";
                    } else {
                        echo "⚠️ No se pudo determinar el género para <strong>$nombre</strong>.";
                    }
                    ?>

                    <!-- Muestra la confianza del resultado -->
                    <br>
                    <small class="text-muted">
                        🔢 Confianza: <?= round($data['probability'] * 100, 2) ?>% (basado en <?= $data['count'] ?> registros)
                    </small>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
