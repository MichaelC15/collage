<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Especifica el tamaño del collage
$collageWidth = 400;
$collageHeight = 400;

// Crea una imagen en blanco
$collage = imagecreatetruecolor($collageWidth, $collageHeight);
if ($collage === false) {
    die('No se pudo crear la imagen.');
}

// Habilitar transparencia
imagesavealpha($collage, true);
$trans_colour = imagecolorallocatealpha($collage, 0, 0, 0, 127);
imagefill($collage, 0, 0, $trans_colour);

// Lista de imágenes
$images = ['images/image1.png', 'images/image2.png', 'images/image3.png', 'images/image4.png'];

$x = 0;
$y = 0;
$imageSize = 200;

foreach ($images as $imagePath) {
    if (!file_exists($imagePath)) {
        die('La imagen no existe: ' . $imagePath);
    }
    
    $image = imagecreatefrompng($imagePath);
    if ($image === false) {
        die('No se pudo cargar la imagen: ' . $imagePath);
    }
    
    imagecopyresized($collage, $image, $x, $y, 0, 0, $imageSize, $imageSize, imagesx($image), imagesy($image));
    $x += $imageSize;
    if ($x >= $collageWidth) {
        $x = 0;
        $y += $imageSize;
    }
    imagedestroy($image);
}

// Enviar el collage como imagen PNG
header('Content-Type: image/png');
imagepng($collage);
imagedestroy($collage);
?>
