<section class="container mt-5">
    <?php
    $data = null;
    $nombre = $_POST['nombre'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $api = curl_init();
        curl_setopt($api, CURLOPT_URL, "https://api.genderize.io/?name=" . urlencode($nombre));
        curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($api);
        curl_close($api);
        $data = json_decode($response, true);
    }
    ?>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">🔎 Predecir el género por nombre</h3>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Predecir</button>
            </form>

            <?php if ($data): ?>
                <div class="alert <?= $data['gender'] === 'male' ? 'alert-male' : 'alert-female' ?> mt-4">

                    <?php if ($data['gender'] === 'male') {
                        echo "👨 Se ha predicho que el nombre " . "<strong>$nombre</strong>" . " es del género <strong>Masculino</strong>.";
                        echo "<div class='emoji-big text-primary'>💙</div>";
                    } elseif ($data['gender'] === 'female') {
                        echo "👩 Se ha predicho que el nombre " . "<strong>$nombre</strong>" . " es del género <strong>Femenino</strong>.";
                        echo "<div class='emoji-big' style='color: #e83e8c;'>💖</div>";
                    } else {

                        echo "⚠️ No se pudo determinar el género para" . "<strong>$nombre</strong>.";
                    }
                    ?>

                    <br>
                    <small class="text-muted">🔢 Confianza: <?= round($data['probability'] * 100, 2) ?>% (basado en <?= $data['count'] ?> registros)</small>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>