<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $file_type = $_POST['file_type'];

    if ($file_type == "image") {
        $upload_dir = "uploads/images/";
        $allowed_extensions = array('jpg', 'png', 'bmp');
    } elseif ($file_type == "pdf") {
        $upload_dir = "uploads/pdfs/";
        $allowed_extensions = array('pdf');
    } else {
        echo "Tipo de arquivo inválido.";
        exit();
    }

    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_extensions)) {
        echo "Extensão de arquivo não permitida.";
        exit();
    }

    if (is_uploaded_file($file_tmp)) {

        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        

        if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {

            if ($file_type == "image") {
                echo '<img src="' . $upload_dir . $file_name . '" alt="Uploaded Image">';
            } elseif ($file_type == "pdf") {
                echo '<a href="' . $upload_dir . $file_name . '">Download PDF</a>';
            }
        } else {
            echo "Erro ao fazer o upload do arquivo.";
        }
    } else {
        echo "Erro ao carregar o arquivo.";
    }
}
?>
