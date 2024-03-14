<?php
// Baca skor pertandingan dari file (matches.txt)
$matches = file('matches.txt');

// Inisialisasi array asosiatif untuk menyimpan statistik klub
$scores = [];

// Inisialisasi array untuk menyimpan daftar nama klub
$clubNames = [];

foreach ($matches as $match) {
    $matchData = explode(",", $match);
    $homeTeam = trim($matchData[0]);
    $awayTeam = trim($matchData[1]);
    $homeScore = intval($matchData[2]);
    $awayScore = intval($matchData[3]);

    // Tambahkan nama klub ke array klub jika belum ada
    if (!in_array($homeTeam, $clubNames)) {
        $clubNames[] = $homeTeam;
    }
    if (!in_array($awayTeam, $clubNames)) {
        $clubNames[] = $awayTeam;
    }

    // Inisialisasi statistik klub jika belum ada
    if (!isset($scores[$homeTeam])) {
        $scores[$homeTeam] = ['name' => $homeTeam, 'played' => 0, 'won' => 0, 'lost' => 0, 'draw' => 0, 'goals_for' => 0, 'goals_against' => 0];
    }
    if (!isset($scores[$awayTeam])) {
        $scores[$awayTeam] = ['name' => $awayTeam, 'played' => 0, 'won' => 0, 'lost' => 0, 'draw' => 0, 'goals_for' => 0, 'goals_against' => 0];
    }

    // Update statistik pertandingan
    $scores[$homeTeam]['played']++;
    $scores[$awayTeam]['played']++;
    $scores[$homeTeam]['goals_for'] += $homeScore;
    $scores[$homeTeam]['goals_against'] += $awayScore;
    $scores[$awayTeam]['goals_for'] += $awayScore;
    $scores[$awayTeam]['goals_against'] += $homeScore;

    // Tentukan hasil pertandingan dan update statistik
    if ($homeScore > $awayScore) {
        $scores[$homeTeam]['won']++;
        $scores[$awayTeam]['lost']++;
    } elseif ($homeScore < $awayScore) {
        $scores[$awayTeam]['won']++;
        $scores[$homeTeam]['lost']++;
    } else {
        $scores[$homeTeam]['draw']++;
        $scores[$awayTeam]['draw']++;
    }
}

// Buat array klubNames dengan mengonversi nomor menjadi nama klub
$clubNames = array_combine($clubNames, $clubNames);

// Urutkan klub berdasarkan poin (descending)
uasort($scores, function($a, $b) {
    if ($a['won'] * 3 + $a['draw'] !== $b['won'] * 3 + $b['draw']) {
        return ($a['won'] * 3 + $a['draw']) <=> ($b['won'] * 3 + $b['draw']);
    }
    if ($a['goals_for'] - $a['goals_against'] !== $b['goals_for'] - $b['goals_against']) {
        return ($a['goals_for'] - $a['goals_against']) <=> ($b['goals_for'] - $b['goals_against']);
    }
    return $a['goals_for'] <=> $b['goals_for'];
});

// Tampilkan klasemen
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klasemen</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Klasemen</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Klub</th>
                <th>Main</th>
                <th>Menang</th>
                <th>Kalah</th>
                <th>Seri</th>
                <th>Goal Menang</th>
                <th>Goal Kalah</th>
                <th>Poin</th>
            </tr>
        </thead>
        <tbody>
            <?php $counter = 1; ?>
            <?php foreach ($scores as $clubName => $score): ?>
                <?php
                    $played = $score['played'];
                    $won = $score['won'];
                    $lost = $score['lost'];
                    $draw = $score['draw'];
                    $goalsFor = $score['goals_for'];
                    $goalsAgainst = $score['goals_against'];
                    $points = $won * 3 + $draw;
                ?>
                <tr>
                    <td><?= $counter++ ?></td>
                    <td><?= $clubNames[$clubName] ?></td>
                    <td><?= $played ?></td>
                    <td><?= $won ?></td>
                    <td><?= $lost ?></td>
                    <td><?= $draw ?></td>
                    <td><?= $goalsFor ?></td>
                    <td><?= $goalsAgainst ?></td>
                    <td><?= $points ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
