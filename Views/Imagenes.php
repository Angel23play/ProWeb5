<?php
/*
8️⃣ Generador de imágenes con IA 🖼️
🔗 API: https://source.unsplash.com/
📌 Descripción:
Ingresar una palabra clave y mostrar una imagen generada basada en la búsqueda.
Formulario: Entrada de texto para la palabra clave.
*/

$api_key = "IC41uTzB7y8IxyGJoI7HI8MM1mnpydn-ufZdVlQNetc"; // tu API key
$img_pedida = $_POST['img_pedida'] ?? '';
$imageUrl = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($img_pedida)) {
    $url = "https://api.unsplash.com/photos/random?query=" . urlencode($img_pedida) . "&client_id=" . $api_key;

    $api = curl_init();
    curl_setopt($api, CURLOPT_URL, $url);
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($api);
    curl_close($api);

    $data = json_decode($response, true);

    // Si la respuesta tiene la url de la imagen, la usamos
    if (isset($data['urls']['regular'])) {
        $imageUrl = $data['urls']['regular'];
    } else {
        $imageUrl = ''; // o URL de placeholder
    }
}
?>

<section class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center rounded-top">
            <h3 class="mb-0">🖼️ Generador de Imágenes con IA</h3>
        </div>
        <div class="card-body">
            <form method="post">
                <label for="img_pedida" class="form-label fw-bold">Palabra clave:</label>
                <input type="text" id="img_pedida" name="img_pedida" class="form-control form-control-lg mb-3 text-center" placeholder="Ej. mountain, cat, beach..." required value="<?= htmlspecialchars($img_pedida) ?>">
                <button class="btn btn-success w-100 fw-bold">Generar Imagen</button>
            </form>
        </div>
    </div>

    <?php if (!empty($imageUrl)): ?>
        <?php if ($imageUrl): ?>
            <div class="card mt-4 shadow mx-auto" style="max-width: 600px;">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">🖼️ Imagen generada para: <?= htmlspecialchars($img_pedida) ?></h5>
                </div>
                <div class="card-body text-center">
                    <p class="text-muted">Palabra clave: <strong><?= htmlspecialchars($img_pedida) ?></strong></p>
                    <img
                        src="<?= htmlspecialchars($imageUrl) ?>"
                        alt="Imagen generada para <?= htmlspecialchars($img_pedida) ?>"
                        class="img-fluid rounded shadow w-100"
                        style="max-height: 350px; object-fit: cover;"
                        onerror="this.onerror=null;this.src='https://via.placeholder.com/600x350?text=No+Image+Found';">
                </div>
            </div>
        <?php endif; ?>


    <?php endif; ?>
</section>