<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Sales Report</title>
    <meta name="description" content="Inventory &amp; Point of Sale System">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <script>
        // Print function for the Sales List table
        function printSalesList() {
            const table = document.querySelector('#salesListTable').outerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write(`
                <html>
                    <head>
                        <title>JEC GENERAL MERCHANDISE - Sales List Report</title>
                        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
                    </head>
                    <body>
                        <h3 class="text-center">Sales List Report</h3>
                        ${table}
                    </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        }

        // Print function for the Product Sales table
        function printProductSales() {
            const table = document.querySelector('#productSalesTable').outerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write(`
                <html>
                    <head>
                        <title>JEC GENERAL MERCHANDISE - Product Sales Report</title>
                        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
                    </head>
                    <body>
                        <h3 class="text-center">Product Sales Report</h3>
                        ${table}
                    </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php
        include_once 'functions/authentication.php';
        include_once 'functions/sidebar.php';
        ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid">
                        <span class="text-black font-bold">JEC GENERAL MERCHANDISE</span>
                    </div>
                </nav>



                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-primary py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-danger fw-bold text-xs mb-1"><span>Earnings (today)</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span>₱<?php include_once 'functions/dashboard-today-sales.php'; ?></span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-success py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Earnings (month)</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span>₱<?php include_once 'functions/dashboard-month-sales.php'; ?></span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-success py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Earnings (annual)</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span>₱<?php include_once 'functions/dashboard-year-sales.php'; ?></span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>







                <div class="container-fluid">
                    <!-- Sales List -->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Sales List</p>
                        </div>
                        <div class="card-body">
                            <!-- Date Filter Form -->
                            <form method="GET" action="sales.php" id="salesListForm">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="transaction_date" class="form-label">Transaction Date</label>
                                        <input type="date" id="transaction_date" name="transaction_date" class="form-control" value="<?php echo isset($_GET['transaction_date']) ? $_GET['transaction_date'] : ''; ?>">
                                    </div>
                                    <div class="col-md-6 d-flex align-items-end">
                                        <!-- Updated filter button with Font Awesome icon -->
                                        <button type="submit" class="btn btn-dark me-2"><i class="fas fa-search"></i></button>
                                        <!-- Updated reset button with Font Awesome icon -->
                                        <a href="sales.php" class="btn btn-secondary me-2"><i class="fas fa-sync-alt"></i></a>
                                        <button type="button" class="btn btn-primary" onclick="printSalesList()">Print</button>
                                    </div>
                                </div>
                            </form>
                            <!-- Sales Table -->
                            <div class="table-responsive table mt-2" id="salesListWrapper">
                                <table class="table table-hover table-bordered my-0" id="salesListTable">
                                    <thead>
                                        <tr>
                                            <th>Product Total</th>
                                            <th>Discount</th>
                                            <th>Receive Amount</th>
                                            <th>Final Total</th>
                                            <th>Transaction Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include_once 'functions/view-sales.php'; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Product Sales -->
                    <div class="card shadow mt-4">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Product Sales</p>
                        </div>
                        <div class="card-body">
                            <!-- Product Name Filter Form -->
                            <form method="GET" action="sales.php" id="productSalesForm">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                    <label for="product_name" class="form-label">Product Name</label>
<input type="text" id="product_name" name="product_name" class="form-control" value="<?php echo isset($_GET['product_name']) ? $_GET['product_name'] : ''; ?>" placeholder="Enter product name">

                                    </div>
                                    <div class="col-md-6 d-flex align-items-end">
                                        <!-- Updated filter button with Font Awesome icon -->
                                        <button type="submit" class="btn btn-dark me-2"><i class="fas fa-search"></i></button>
                                        <!-- Updated reset button with Font Awesome icon -->
                                        <a href="sales.php" class="btn btn-secondary me-2"><i class="fas fa-sync-alt"></i></a>
                                        <button type="button" class="btn btn-primary" onclick="printProductSales()">Print</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Product Sales Table -->
                            <div class="table-responsive table mt-2" id="productSalesWrapper">
                                <table class="table table-hover table-bordered my-0" id="productSalesTable">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Transaction Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include_once 'functions/view-transaction.php'; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
