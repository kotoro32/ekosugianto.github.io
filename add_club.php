<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["clubName"];

    // Simpan data klub ke dalam file teks (clubs.txt)
    $file = fopen("clubs.txt", "a");
    fwrite($file, "$name\n");
    fclose($file);

    echo "Klub berhasil ditambahkan.";
}
?>
