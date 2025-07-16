<?php
include 'connection.php';
session_start();
$user_id = $_SESSION['u']['user_id'];

$incomeQuery = "SELECT DATE(`date`) AS `day`, SUM(`Income`) AS `total_income`
                FROM `income`
                WHERE `user_id` = '$user_id'
                GROUP BY DATE(`date`)";

$outcomeQuery = "SELECT DATE(`date`) AS `day`, SUM(`outcome`) AS `total_outcome`
                 FROM `outcome`
                 WHERE `user_id` = '$user_id'
                 GROUP BY DATE(`date`)";


$incomeRs = Database::search($incomeQuery);
$outcomeRs = Database::search($outcomeQuery);

$incomeData = [];
while ($row = $incomeRs->fetch_assoc()) {
    $incomeData[$row['day']] = (float)$row['total_income'];
}

$outcomeData = [];
while ($row = $outcomeRs->fetch_assoc()) {
    $outcomeData[$row['day']] = (float)$row['total_outcome'];
}

$allDates = array_unique(array_merge(array_keys($incomeData), array_keys($outcomeData)));
sort($allDates);

$labels = [];
$incomes = [];
$outcomes = [];

foreach ($allDates as $date) {
    $labels[] = $date;
    $incomes[] = $incomeData[$date] ?? 0;
    $outcomes[] = $outcomeData[$date] ?? 0;
}

echo json_encode([
    "labels" => $labels,
    "income" => $incomes,
    "outcome" => $outcomes
]);
?>
