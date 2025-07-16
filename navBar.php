
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow fixed-top">
  <div class="container px-4">
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
      <i class="fas fa-wallet fs-4"></i>
      <span>Expenses Management</span>
    </a>

    <!-- Offcanvas toggle only for small screens -->
    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar"
      aria-controls="offcanvasSidebar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Regular navbar links (hidden on small devices) -->
    <div class="collapse navbar-collapse d-none d-lg-block" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto gap-2">
        <li class="nav-item">
          <a class="nav-link active bg-primary bg-opacity-75 text-white rounded-pill px-3 py-1 d-flex align-items-center gap-2" href="index.php">
            <i class="fas fa-tachometer-alt"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link bg-success bg-opacity-75 text-white rounded-pill px-3 py-1 d-flex align-items-center gap-2" href="income.php">
            <i class="fas fa-coins"></i> Income
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link bg-danger bg-opacity-75 text-white rounded-pill px-3 py-1 d-flex align-items-center gap-2" href="outcome.php">
            <i class="fas fa-arrow-circle-down"></i> Outcome
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Offcanvas Sidebar for Small Devices -->
<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1"style="width: 260px; height: 300px; border-bottom-right-radius: 25px;"
id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasSidebarLabel"><i class="fas fa-wallet me-2"></i>Expenses Menu</h5>
    <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="navbar-nav gap-2">
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center gap-2" href="index.php">
          <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center gap-2" href="income.php">
          <i class="fas fa-coins"></i> Income
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center gap-2" href="outcome.php">
          <i class="fas fa-arrow-circle-down"></i> Outcome
        </a>
      </li>
    </ul>
  </div>
</div>