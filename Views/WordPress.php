<?php
/*
6️⃣ Noticias desde WordPress 📰
🔗 API: https://public-api.wordpress.com/wp/v2/sites/{dominio}/posts
📌 Descripción:
Este script obtiene las 3 noticias más recientes de un sitio creado en WordPress, usando su API pública.
El usuario debe escribir el dominio del sitio WordPress, por ejemplo: es.blog.wordpress.com
*/

$data = null;              // Variable donde se guardarán los datos de respuesta de la API
$error = '';               // Para guardar posibles mensajes de error
$sitio = $_POST['sitio'] ?? 'es.blog.wordpress.com'; // Dominio del sitio, por defecto uno válido

// Si se envió el formulario por método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // URL para obtener los últimos 3 posts
    $api_url = "https://public-api.wordpress.com/wp/v2/sites/{$sitio}/posts?per_page=3";

    // Inicializamos cURL
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $api_url);               // URL a consultar
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);        // Esperamos respuesta como string
    $response = curl_exec($curl);                            // Ejecutamos la llamada
    curl_close($curl);                                       // Cerramos cURL

    $data = json_decode($response, true);                    // Convertimos JSON a array asociativo

    // Validamos que se obtuvo un array de noticias
    if (!is_array($data)) {
        $error = "No se pudo obtener noticias. Verifica el dominio del sitio.";
        $data = null;
    } else if (isset($data['message'])) {
        // Si viene un mensaje de error en la respuesta
        $error = "Error API: " . $data['message'];
        $data = null;
    }
}
?>

<!-- Interfaz de usuario -->
<section class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center rounded-top-4">
            <h3>📰 Últimas 3 Noticias desde WordPress</h3>
        </div>
        <div class="card-body">

            <!-- Formulario para ingresar el dominio del sitio -->
            <form method="post" class="mb-4">
                <label for="sitio" class="form-label fw-bold">Dominio del sitio WordPress (ejemplo: wordpress.com):</label>
                <input type="text" name="sitio" id="sitio" value="<?= htmlspecialchars($sitio) ?>" class="form-control" required>
                <button type="submit" class="btn btn-success mt-3 w-100">Obtener Noticias</button>
            </form>

            <!-- Mostrar errores si los hay -->
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <!-- Mostrar resultados si existen -->
            <?php if (is_array($data)): ?>
                <div class="text-center mb-4">
                    <!-- Logo WordPress (fijo) -->
                    <img src="https://th.bing.com/th/id/OIP.m0SzThoEy2Q6Ij_PlgSMngHaEK?r=0&rs=1&pid=ImgDetMain&cb=idpwebpc2" alt="Logo WordPress" width="300px">
                </div>

                <!-- Iteramos cada post recibido -->
                <?php foreach ($data as $post): ?>
                    <?php if (is_array($post) && isset($post['title']['rendered'], $post['excerpt']['rendered'], $post['link'])): ?>
                        <div class="mb-4 p-3 border rounded shadow-sm">
                            <!-- Título -->
                            <h4><?= htmlspecialchars($post['title']['rendered']) ?></h4>

                            <!-- Resumen (sin etiquetas HTML) -->
                            <p><?= strip_tags($post['excerpt']['rendered']) ?></p>

                            <!-- Enlace a la noticia -->
                            <a href="<?= htmlspecialchars($post['link']) ?>" target="_blank" rel="noopener noreferrer">Leer más</a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
