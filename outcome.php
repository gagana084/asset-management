<?php
session_start();
include 'connection.php';
if (isset($_SESSION['u'])) {

    $user_id = $_SESSION['u']['user_id'];

    $rs = Database::search("SELECT SUM(`income`) AS `total_income` FROM `income` WHERE `user_id` = '$user_id' ");
    $d = $rs->fetch_assoc();


    $rs = Database::search("SELECT `outcome`,`date` FROM `outcome` WHERE `user_id` = '$user_id' ORDER BY `outcome_id` DESC LIMIT 1");
    $d2 = $rs->fetch_assoc();

    $rs = Database::search("SELECT SUM(`outcome`) AS `total_outcome` FROM `outcome` WHERE `user_id` = '$user_id' ");
    $d3 = $rs->fetch_assoc();

    $available_balance = $d['total_income'] - $d3['total_outcome'];

    //Total income
    $rs_income = Database::search("SELECT SUM(`income`) AS total_income FROM `income` WHERE `user_id` = '$user_id'");
    $income_data = $rs_income->fetch_assoc();
    $total_income = (float)$income_data["total_income"];

    //Total outcome
    $rs_outcome = Database::search("SELECT SUM(`outcome`) AS total_outcome FROM `outcome` WHERE `user_id` = '$user_id'");
    $outcome_data = $rs_outcome->fetch_assoc();
    $total_outcome = (float)$outcome_data["total_outcome"];

    //Used percentage
    $used_percentage = 0;
    if ($total_income > 0) {
        $used_percentage = ($total_outcome / $total_income) * 100;
    }


    $user_id = $_SESSION['u']['user_id'];

    //current month's expenses
    $currentMonthExpensesQuery = "
    SELECT SUM(`outcome`) AS `total_expenses`
    FROM `outcome`
    WHERE `user_id` = '$user_id' 
    AND MONTH(`date`) = MONTH(CURRENT_DATE)
    AND YEAR(`date`) = YEAR(CURRENT_DATE)
";
    $currentMonthExpensesResult = Database::search($currentMonthExpensesQuery);
    $currentMonthExpenses = $currentMonthExpensesResult->fetch_assoc()['total_expenses'];

    //last month's expenses
    $lastMonthExpensesQuery = "
    SELECT SUM(`outcome`) AS `total_expenses`
    FROM `outcome`
    WHERE `user_id` = '$user_id' 
    AND MONTH(`date`) = MONTH(CURRENT_DATE) - 1
    AND YEAR(`date`) = YEAR(CURRENT_DATE)
";
    $lastMonthExpensesResult = Database::search($lastMonthExpensesQuery);
    $lastMonthExpenses = $lastMonthExpensesResult->fetch_assoc()['total_expenses'];

    // Calculate percentage
    if ($lastMonthExpenses > 0) {
        $percentageChangeExpenses = (($currentMonthExpenses - $lastMonthExpenses) / $lastMonthExpenses) * 100;
    } else {
        $percentageChangeExpenses = 0;
    }



?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Expenses Management | Outcome</title>
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

            .outcome-card {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border-radius: 15px;
                transition: transform 0.3s ease;
            }

            .outcome-card:hover {
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
            <!-- Outcome Statistics Cards -->
            <div class="row g-4 mb-4">
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="outcome-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Total Expenses</h5>
                            <i class='bx bx-wallet-alt fs-1 text-danger'></i>
                        </div>
                        <h2 class="mb-2">LKR <?php echo ($d3['total_outcome']) ?></h2>
                        <p class="text-danger mb-0">
                            <i class="bx bx-down-arrow-alt"></i> -<?php echo number_format($percentageChangeExpenses, 2); ?>% from last month
                        </p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="outcome-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Last Expense</h5>
                            <i class='bx bx-receipt fs-1 text-warning'></i>
                        </div>
                        <h2 class="mb-2">LKR <?php echo isset($d2['outcome']) ? $d2['outcome'] : 'N/A'; ?></h2>
                        <p class="text-light mb-0">Spent on <?php echo isset($d2['date']) ? $d2['date'] : 'N/A'; ?></p>
                    </div>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="outcome-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Budget Status</h5>
                            <i class='bx bx-pie-chart-alt-2 fs-1 text-info'></i>
                        </div>
                        <h2 class="mb-2"><?php echo (round($used_percentage, 2)) ?>% Used</h2>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 75%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add New Expense Card -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="outcome-card p-4">
                        <h5 class="card-title mb-4">Add New Expense</h5>
                        <form class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Amount (LKR)</label>
                                <input type="number" id="amount" class="form-control" placeholder="Enter amount">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <select class="form-select" id="type">
                                    <option value="0">Select</option>
                                    <?php

                                    $rs = Database::search("SELECT * FROM `outcome_type`");
                                    $num = $rs->num_rows;

                                    for ($i = 0; $num > $i; $i++) {
                                        $d = $rs->fetch_assoc();
                                    ?>
                                        <option value="<?php echo ($d['outcome_type_id']); ?>"><?php echo ($d['outcome_type']); ?></option>

                                    <?php
                                    }


                                    ?>
                                </select>
                            </div>


                            <div class="col-12">
                                <button onclick="addOutcome();" type="button" class="btn btn-danger">
                                    <i class='bx bx-plus-circle me-2'></i>Add Expense
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Expense History Table -->
            <div class="table-container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">Expense History</h5>
                    <div class="d-flex gap-2">
                        <button  onclick="window.print();" class="btn btn-outline-danger btn-sm">
                            <i class='bx bx-export me-2'></i>Export
                        </button>
                      
                    </div>
                </div>

                <div class="table-responsive">

                    <?php
                    $rs = Database::search("
SELECT * FROM `outcome`
INNER JOIN `outcome_type`
ON `outcome`.`outcome_type` = `outcome_type`.`outcome_type_id`
WHERE `outcome`.`user_id` = '$user_id'
");

                    $num = $rs->num_rows;


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
                                $d = $rs->fetch_assoc();
                            ?>
                                <tr>
                                    <td><?php echo ($d['date']) ?></td>
                                    <td><span class="badge bg-primary"><?php echo ($d['outcome_type']) ?></span></td>
                                    <td>LKR <?php echo ($d['outcome']) ?></td>

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