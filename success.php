

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>PAYMENT SUCCESS</title>
    <meta name="description" content="Inventory &amp; Point of Sale System">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">

    <style>
        /* Custom styles for the receipt */
        .receipt-container {
            width: 1000px;
            margin: 0 auto;
            padding: 65px;
            border: 2px solid #000;
            font-family: 'Courier New', Courier, monospace;
            font-size: 25px;
            background-color: #fff;
            text-align: left;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .receipt-container h2,
        .receipt-container h4 {
            text-align: center;
        }

        .receipt-container h5 {
            font-size: 30px;
            padding-bottom: 10px;
        }

        .receipt-container .line {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }

        .receipt-container .total {
            font-weight: bold;
            font-size: 30px;
        }

       /* Button styles */
.button-container {
    width: 500px;
    margin: 20px auto 0; /* Match receipt container width */
    display: flex;
    justify-content: space-between; /* Space between buttons */
    gap: 20px; /* Add spacing between buttons */
}

.btn-custom {
    flex: 1; /* Ensure buttons are equal width */
    padding: 15px;
    font-size: 18px;
    font-weight: bold;
    text-align: center;
    background-color: #FFD700; /* Yellow */
    border: none;
    border-radius: 5px;
    color: #000; /* Black text */
    transition: all 0.3s ease;
    text-transform: uppercase;
}

.btn-custom:hover {
    background-color: #FFC107; /* Slightly darker yellow */
    color: #fff; /* White text */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Add shadow effect */
}


        /* Hide other page content when printing */
        @media print {
            body * {
                visibility: hidden;
            }

            .receipt-container,
            .receipt-container * {
                visibility: visible;
            }

            .receipt-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .btn-custom {
                display: none; /* Hide buttons during print */
            }
        }
    </style>
</head>

<body>
    <div class="container py-4 py-xl-5">
        <div class="row mb-5">
            
        </div>
        <div class="receipt-container">
        <div class="col-md-8 col-xl-6 text-center mx-auto">
                <h2>JEC MERCHANDISE Receipt</h2>
            </div>
            <h4>Thanks for Ordering!</h4>
            <br>
            <div class="details">
                <p><strong>Total Price:</strong> ₱ <?php echo $_GET['sales']; ?></p>
                <p><strong>Discount:</strong> ₱ <?php echo $_GET['discount']; ?></p>
                <p><strong>Amount Recieved:</strong> ₱ <?php echo $_GET['amount']; ?></p>
                <p><strong>Total Change:</strong> ₱ <?php echo $_GET['amount'] - $_GET['discounted_sales']; ?></p>
                <p><strong>Purchase Date:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
            </div>

            <div class="line"></div>
            <h4 class="total">TOTAL AMOUNT: ₱ <?php echo $_GET['discounted_sales']; ?></h4>
        </div>

<!-- Buttons -->
<div class="button-container d-flex gap-2">
    <button class="btn btn-success btn-lg flex-fill" onclick="printReceipt()">Print</button>
    <a class="btn btn-success btn-lg flex-fill" role="button" href="point-of-sale.php">Go Back</a>
</div>



    <script>
        function printReceipt() {
            var receipt = document.querySelector('.receipt-container');
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write('<html lang="en"><head><link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"><style>body{font-family:"Courier New", Courier, monospace;} .receipt-container {width: 500px; margin: 0 auto; padding: 40px; border: 1px solid #000; font-size: 18px; background-color: #fff;} .receipt-container h2, .receipt-container h4 {text-align: center;} .line {border-bottom: 1px dashed #000; margin: 10px 0;} .total {font-weight: bold; font-size: 20px;}</style></head><body onload="window.print()">' + receipt.outerHTML + '</body></html>');
            newWin.document.close();
            setTimeout(function () {
                newWin.close();
            }, 10);
        }
    </script>
</body>

</html>
