<?php
session_start();
include 'connection.php';

if (isset($_SESSION['u'])) {

    $user_id = $_SESSION['u']['user_id'];

    $rs = Database::search("SELECT SUM(`outcome`) AS `total_outcome` FROM `outcome` WHERE `user_id` = '$user_id' ");
    $d = $rs->fetch_assoc();

    $rs = Database::search("SELECT SUM(`income`) AS `total_income` FROM `income` WHERE `user_id` = '$user_id' ");
    $d2 = $rs->fetch_assoc();

    $available_balance = $d2['total_income'] - $d['total_outcome'];



?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Expenses Management | Dashboard</title>
        <link rel="shortcut icon" href="./logo.png" style="height: 100%; width:100%;" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
            body {
                padding: 0;
                height: 100vh;
                position: relative;
                background: linear-gradient(135deg, #1e272e 0%, #121212 100%);

            }


            @media (min-width: 992px) {
                body {
                    overflow: hidden;
                }
            }



            .dashboard-container {
                height: calc(100vh - 60px);
                margin-top: 60px;
                padding: 1rem;
            }

            .stats-card {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border-radius: 15px;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .stats-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            }

            .chart-container {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border-radius: 15px;
                padding: 20px;
                height: calc(100vh - 250px);
            }

            .icon-wrapper {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(255, 255, 255, 0.1);
            }

            .stat-value {
                font-size: 1.8rem;
                font-weight: bold;
            }

            .stat-label {
                font-size: 0.9rem;
                opacity: 0.8;
            }

            .trend-indicator {
                font-size: 0.8rem;
                padding: 0.2rem 0.5rem;
                border-radius: 12px;
                background: rgba(255, 255, 255, 0.1);
            }
        </style>

    </head>

    <body class="bg-dark">
        <!-- nav  -->
        <?php
        include 'navBar.php';
        ?>

        <div class="dashboard-container">
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-xl-4">
                    <div class="stats-card p-3 text-white">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="stat-label">Monthly Income</div>
                                <div class="stat-value">LKR <?php echo ($d2['total_income'])  ?></div>
                                <div class="trend-indicator text-success">
                                    <i class="fas fa-arrow-up"></i> 12%
                                </div>
                            </div>
                            <div class="icon-wrapper bg-primary bg-opacity-25">
                                <i class="fas fa-wallet fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="stats-card p-3 text-white">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="stat-label">Monthly Expenses</div>
                                <div class="stat-value">LKR <?php echo ($d['total_outcome'])  ?></div>
                                <div class="trend-indicator text-danger">
                                    <i class="fas fa-arrow-up"></i> 8%
                                </div>
                            </div>
                            <div class="icon-wrapper bg-danger bg-opacity-25">
                                <i class="fas fa-shopping-cart fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="stats-card p-3 text-white">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="stat-label">Net Balance</div>
                                <div class="stat-value">LKR <?php echo ($available_balance) ?></div>
                                <div class="trend-indicator text-info">
                                    <i class="fas fa-arrow-up"></i> 15%
                                </div>
                            </div>
                            <div class="icon-wrapper bg-info bg-opacity-25">
                                <i class="fas fa-chart-line fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="chart-container mb-5">
                        <canvas id="financialChart"></canvas>
                    </div>

                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

        <script>
            function resizeChart() {
                const container = document.querySelector('.chart-container');
                if (container) {
                    const height = Math.max(300, window.innerHeight * 0.5);
                    container.style.height = `${height}px`;
                }
            }

            window.addEventListener('resize', resizeChart);
            resizeChart();

            fetch('financialData.php')
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('financialChart').getContext('2d');

                    const gradientIncome = ctx.createLinearGradient(0, 0, 0, 400);
                    gradientIncome.addColorStop(0, 'rgba(0, 74, 247, 0.4)');
                    gradientIncome.addColorStop(1, 'rgba(75, 192, 192, 0.05)');

                    const gradientExpense = ctx.createLinearGradient(0, 0, 0, 400);
                    gradientExpense.addColorStop(0, 'rgb(255, 0, 0)');
                    gradientExpense.addColorStop(1, 'rgba(255, 99, 132, 0.05)');

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                    label: 'Income',
                                    data: data.income,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: gradientIncome,
                                    pointBackgroundColor: '#fff',
                                    pointBorderColor: 'rgba(75, 192, 192, 1)',
                                    tension: 0.3,
                                    fill: true,
                                },
                                {
                                    label: 'Expenses',
                                    data: data.outcome,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: gradientExpense,
                                    pointBackgroundColor: '#fff',
                                    pointBorderColor: 'rgba(255, 99, 132, 1)',
                                    tension: 0.3,
                                    fill: true,
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: '📈 Financial Overview (Income vs Expenses)',
                                    color: '#ffffff',
                                    font: {
                                        size: 20,
                                        weight: 'bold'
                                    },
                                    padding: {
                                        top: 10,
                                        bottom: 30
                                    }
                                },
                                legend: {
                                    position: 'top',
                                    labels: {
                                        color: '#ffffff',
                                        padding: 20,
                                        boxWidth: 20
                                    }
                                },
                                tooltip: {
                                    backgroundColor: '#222',
                                    titleColor: '#fff',
                                    bodyColor: '#ddd',
                                    borderColor: '#444',
                                    borderWidth: 1
                                }
                            },
                            scales: {
                                x: {
                                    ticks: {
                                        color: '#ffffff',
                                        padding: 10
                                    },
                                    grid: {
                                        color: 'rgba(255, 255, 255, 0.05)'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        color: '#ffffff',
                                        callback: value => 'Rs ' + value.toLocaleString()
                                    },
                                    grid: {
                                        color: 'rgba(255, 255, 255, 0.05)'
                                    }
                                }
                            },
                            interaction: {
                                mode: 'index',
                                intersect: false
                            },
                            animations: {
                                tension: {
                                    duration: 1000,
                                    easing: 'easeInOutQuad',
                                    from: 0.5,
                                    to: 0,
                                    loop: true
                                }
                            }
                        }
                    });
                })
                .catch(err => {
                    console.error('Error loading chart data:', err);
                });
        </script>

    </body>

    </html>

<?php

} else {
    header("location:login.php");
}

?>