<?php
session_start();
include 'connection.php';
if (isset($_SESSION['u'])) {
    $user_id = $_SESSION['u']['user_id'];

    $rs = Database::search("SELECT SUM(`income`) AS `total_income` FROM `income` WHERE `user_id` = '$user_id' ");
    $d = $rs->fetch_assoc();


    $rs = Database::search("SELECT `income`,`date` FROM `income` WHERE `user_id` = '$user_id' ORDER BY `income_id` DESC LIMIT 1");
    $d2 = $rs->fetch_assoc();

    $rs = Database::search("SELECT SUM(`outcome`) AS `total_outcome` FROM `outcome` WHERE `user_id` = '$user_id' ");
    $d3 = $rs->fetch_assoc();

    $available_balance = $d['total_income'] - $d3['total_outcome'];



    //current month's income
    $currentMonthIncomeQuery = "
    SELECT SUM(`Income`) AS `total_income`
    FROM `income`
    WHERE `user_id` = '$user_id' 
    AND MONTH(`date`) = MONTH(CURRENT_DATE)
    AND YEAR(`date`) = YEAR(CURRENT_DATE)
";
    $currentMonthIncomeResult = Database::search($currentMonthIncomeQuery);
    $currentMonthIncome = $currentMonthIncomeResult->fetch_assoc()['total_income'];

    //last month's income
    $lastMonthIncomeQuery = "
    SELECT SUM(`Income`) AS `total_income`
    FROM `income`
    WHERE `user_id` = '$user_id' 
    AND MONTH(`date`) = MONTH(CURRENT_DATE) - 1
    AND YEAR(`date`) = YEAR(CURRENT_DATE)
";
    $lastMonthIncomeResult = Database::search($lastMonthIncomeQuery);
    $lastMonthIncome = $lastMonthIncomeResult->fetch_assoc()['total_income'];

    // Calculate percentage
    if ($lastMonthIncome > 0) {
        $percentageChange = (($currentMonthIncome - $lastMonthIncome) / $lastMonthIncome) * 100;
    } else {
        $percentageChange = 0;
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Expenses Management | Income</title>
        <link rel="shortcut icon" href="./logo.png" style="height: 100%; width:100%;" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
            body {
                padding: 0;
                min-height: 100vh;
                position: relative;
            }

            body::before {
                display: block;
                content: "";
                height: 60px;
            }

            @media (max-width: 992px) {
                body::before {
                    display: block;
                    content: "";
                    height: 50px;
                }
            }

            .chart-container {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border-radius: 15px;
                padding: 20px;
                margin-top: 20px;
            }

            .income-card {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border-radius: 15px;
                transition: transform 0.3s ease;
            }

            .income-card:hover {
                transform: translateY(-5px);
            }

            .table-container {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border-radius: 15px;
                padding: 20px;
                margin-top: 20px;
            }

            @media print {

                /* Hide everything except the table */
                body * {
                    visibility: hidden;
                }

                .table-container,
                .table-container * {
                    visibility: visible;
                }

                .table-container {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    background: white;
                    /* Ensures the table background is white for print */
                }

                /* Remove unwanted elements like navbar, buttons, etc */
                .navbar,
                .btn,
                .income-card,
                .chart-container {
                    display: none;
                }

                /* Adjust the table for print formatting */
                table {
                    width: 100%;
                    border-collapse: collapse;
                }

                th,
                td {
                    padding: 2px;
                    text-align: left;
                    border: 1px solid #ddd;
                }

                th {
                    background-color: #f2f2f2;
                }

                /* Optional: Adjust page margins */
                @page {
                    margin: 20mm;
                }
            }
        </style>

    </head>

    <body class="bg-dark text-light">
        <!-- nav  -->
        <?php
        include 'navBar.php';
        ?>

        <div class="container-fluid px-4 py-3">
            <!-- Income Statistics Cards -->
            <div class="row g-4 mb-4">
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="income-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Total Income</h5>
                            <i class='bx bx-dollar-circle fs-1 text-primary'></i>
                        </div>
                        <h2 class="mb-2">LKR <?php echo ($d['total_income'])  ?></h2>
                        <p class="text-success mb-0 d-flex align-items-center fs-5">
                            <i class="bx bx-up-arrow-alt me-2"></i>+<?php echo number_format($percentageChange, 2); ?>% from last month
                        </p>

                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="income-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Last Income</h5>
                            <i class='bx bx-money fs-1 text-success'></i>
                        </div>
                        <h2 class="mb-2">LKR <?php echo isset($d2['income']) ? $d2['income'] : 'N/A'; ?></h2>
                        <p class="text-light mb-0">Received on <?php echo isset($d2['date']) ? $d2['date'] : 'N/A'; ?></p>
                    </div>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="income-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Current Balance</h5>
                            <i class='bx bx-wallet fs-1 text-info'></i>
                        </div>
                        <h2 class="mb-2">LKR <?php echo ($available_balance)  ?></h2>
                        <p class="text-info mb-0">Available to spend</p>
                    </div>
                </div>
            </div>

            <!-- Add New Income Card -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="income-card p-4">
                        <h5 class="card-title mb-4">Add New Income</h5>
                        <form class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Amount (LKR)</label>
                                <input id="amount" type="number" class="form-control" placeholder="Enter amount">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Type</label>
                                <select class="form-select" id="type">
                                    <option value="0">Select</option>

                                    <?php

                                    $rs = Database::search("SELECT * FROM `income_type`");
                                    $num = $rs->num_rows;
                                    for ($i = 0; $num > $i; $i++) {
                                        $d = $rs->fetch_assoc();
                                    ?>
                                        <option value="<?php echo ($d['income_type_id'])  ?>"><?php echo ($d['income_type'])  ?></option>

                                    <?php
                                    }
                                    ?>

                                </select>
                            </div>
                            <div class="col-12">
                                <button onclick="addIncome();" type="button" class="btn btn-primary">
                                    <i class='bx bx-plus-circle me-2'></i>Add Income
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Income History Table -->
            <div class="table-container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">Income History</h5>
                    <div class="d-flex gap-2">
                        <button onclick="window.print();" class="btn btn-outline-primary btn-sm">
                            <i class='bx bx-export me-2'></i>Export
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <?php

                    $rs2 = Database::search("
SELECT * FROM `income` 
INNER JOIN `income_type` 
ON `income`.`income_type` = `income_type`.`income_type_id`
WHERE `income`.`user_id` = '$user_id'
");
                    $num = $rs2->num_rows;


                    ?>
                    <table class="table table-hover table-dark">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            for ($i = 0; $num > $i; $i++) {
                                $data = $rs2->fetch_assoc();
                                // print_r($data); // Debug line


                            ?>
                                <tr>
                                    <td><?php echo ($data['date']) ?></td>
                                    <td><?php echo ($data['income_type']) ?></td>
                                    <td>LKR <?php echo isset($data['Income']) ? $data['Income'] : 'N/A'; ?></td>


                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    </body>

    </html>

<?php } else {
    header("location:login.php");
} ?>