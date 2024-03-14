<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $homeTeam = $_POST["homeTeam"];
    $awayTeam = $_POST["awayTeam"];
    $homeScore = $_POST["homeScore"];
    $awayScore = $_POST["awayScore"];

    // Proses penyimpanan skor pertandingan ke database (di sini contoh disimpan ke file teks)
    $file = fopen("matches.txt=", "a");
    fwrite($file, "$homeTeam,$awayTeam,$homeScore,$awayScore\n");
    fclose($file);

    echo "Skor berhasil disimpan.";
}
?>
