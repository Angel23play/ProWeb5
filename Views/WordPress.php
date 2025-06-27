
<?php
/*
6️⃣ Noticias desde WordPress 📰
🔗 API: [Buscar una API de WordPress REST]'https://wordpress.com/es/blog/category/noticias/'
📌 Descripción:

Obtener las últimas 3 noticias de una página hecha con WordPress.
Mostrar el logo de la página, los titulares, resúmenes y enlaces.
Formulario: Selección de una página de noticias para extraer los datos.
*/

$data = null;
$error = '';
$sitio = $_POST['sitio'] ?? 'es.blog.wordpress.com';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $api_url = "https://public-api.wordpress.com/wp/v2/sites/{$sitio}/posts?per_page=3";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $api_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);

    // Verificamos que $data sea un array y que no sea un mensaje de error
    if (!is_array($data)) {
        $error = "No se pudo obtener noticias. Verifica el dominio del sitio.";
        $data = null;
    } else if (isset($data['message'])) {
        //la API devuelve un error en 'message'
        $error = "Error API: " . $data['message'];
        $data = null;
    }
}
?>

<section class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center rounded-top-4">
            <h3>📰 Últimas 3 Noticias desde WordPress</h3>
        </div>
        <div class="card-body">
            <form method="post" class="mb-4">
                <label for="sitio" class="form-label fw-bold">Dominio del sitio WordPress (ejemplo: wordpress.com):</label>
                <input type="text" name="sitio" id="sitio" value="<?= htmlspecialchars($sitio) ?>" class="form-control" required>
                <button type="submit" class="btn btn-success mt-3 w-100">Obtener Noticias</button>
            </form>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if (is_array($data)): ?>
                <div class="text-center mb-4">
                    <img src="https://th.bing.com/th/id/OIP.m0SzThoEy2Q6Ij_PlgSMngHaEK?r=0&rs=1&pid=ImgDetMain&cb=idpwebpc2" alt="Logo WordPress" width="300px">
                </div>

                <?php foreach ($data as $post): ?>
                    <?php if (is_array($post) && isset($post['title']['rendered'], $post['excerpt']['rendered'], $post['link'])): ?>
                        <div class="mb-4 p-3 border rounded shadow-sm">
                            <h4><?= htmlspecialchars($post['title']['rendered']) ?></h4>
                            <p><?= strip_tags($post['excerpt']['rendered']) ?></p>
                            <a href="<?= htmlspecialchars($post['link']) ?>" target="_blank" rel="noopener noreferrer">Leer más</a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
