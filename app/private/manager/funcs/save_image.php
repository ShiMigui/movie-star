<?php
function save_image(array $file, string $destiny, ?array $mimeTypes = null): void {
    $mimeTypes ??= [
        'image/jpeg' => fn($origin) => imagecreatefromjpeg($origin),
        'image/png' => fn($origin) => imagecreatefrompng($origin)
    ];

    $type = $file['type'];
    $origin = $file['tmp_name'];
    if (!isset($mimeTypes[$type])) throw new Exception('Formato de imagem inválido.');
    if (!$image = $mimeTypes[$type]($origin)) throw new Exception('Não foi possível carregar a imagem.');
    if (!imagejpeg($image, $destiny, 100)) throw new Exception('Falha ao salvar a imagem.');

    imagedestroy($image);
}
