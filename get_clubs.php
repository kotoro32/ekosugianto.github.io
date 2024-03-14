<?php
// Fetch klub data from database (assuming it's stored in clubs.txt)
$clubs = file('clubs.txt');

$output = [];

foreach ($clubs as $index => $club) {
    $output[] = ['id' => $index + 1, 'name' => trim($club)];
}

header('Content-Type: application/json');
echo json_encode($output);
?>
