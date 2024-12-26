<?php


// Always show the sidebar without checking user level
echo '<nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-success p-0">
    <div class="container-fluid d-flex flex-column p-0">
        <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
            <div class="sidebar-brand-text mx-3"><span>WELCOME!</span></div>
        </a>
        <hr class="sidebar-divider my-0" />
        <ul class="navbar-nav" id="accordionSidebar">
            <li class="nav-item">
                <a class="nav-link text-black link-hover" href="dashboard.php">
                    <i class="fas fa-tachometer-alt" style="color: black;"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-black link-hover" href="point-of-sale.php">
                    <i class="fas fa-shopping-cart" style="color: black;"></i>
                    <span>Point of Sale</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-black link-hover" href="inventory.php">
                    <i class="fas fa-plus-circle" style="color: black;"></i>
                    <span>Inventory</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-black link-hover" href="sales.php">
                    <i class="fas fa-table" style="color: black;"></i>
                    <span>Sales Report</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-black link-hover" href="users.php">
                    <i class="fas fa-user" style="color: black;"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-black link-hover" href="logs.php">
                    <i class="fas fa-history" style="color: black;"></i>
                    <span>Logs</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-black link-hover" href="functions/logout.php">
                    <i class="fas fa-sign-out-alt" style="color: black;"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
        <div class="text-center d-none d-md-inline">
            <button id="sidebarToggle" class="btn rounded-circle border-0" type="button"></button>
        </div>
    </div>
</nav>';
?>
