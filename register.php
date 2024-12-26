<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Register</title>
    <meta name="description" content="Inventory & Point of Sale System">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen">
        <div class="flex flex-wrap bg-white p-10 rounded-lg shadow-2xl max-w-4xl">
            <!-- Left side: Logo -->
            <div class="w-full md:w-2/5 flex items-center justify-center mb-6 md:mb-1 md:pr-5">
                <img src="assets/img/jec.png" alt="JEC Logo" class="max-w-full h-auto">
            </div>

            <!-- Right side: Register form -->
            <div class="w-full md:w-3/5">
                <div class="text-center mb-6">
                    <h1 class="text-4xl font-extrabold text-green-700">JEC GENERAL MERCHANDISE</h1>
                </div>
                <div class="bg-white rounded-lg border">
                    <div class="p-6">
                        <div class="text-center mb-4">
                            <h4 class="text-lg font-semibold text-gray-800">Create an Account</h4>
                        </div>
                        <form action="functions/register.php" method="post" class="space-y-4">
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                                <input id="username" class="w-full p-2 border border-gray-300 rounded-md focus:ring-green-400 focus:border-green-400" type="text" name="username" required>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                    <input id="password" class="w-full p-2 border border-gray-300 rounded-md focus:ring-green-400 focus:border-green-400" type="password" name="password" required>
                                </div>
                                <div>
                                    <label for="password_repeat" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                    <input id="password_repeat" class="w-full p-2 border border-gray-300 rounded-md focus:ring-green-400 focus:border-green-400" type="password" name="password_repeat" required>
                                </div>
                            </div>
                            <button class="w-full py-2 bg-green-700 text-white font-medium rounded-md hover:bg-green-600 focus:ring-4 focus:ring-green-400" type="submit">Register Account</button>
                        </form>
                        <div class="text-center mt-4">
                            <a class="text-sm text-gray-600 hover:text-green-700" href="index.php">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Modal for error message -->
        <?php if (isset($_GET['error']) && $_GET['error'] == 'password_mismatch'): ?>
            <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <h2 class="text-lg font-semibold text-red-600">Error</h2>
                    <p class="text-gray-700 mt-2">The passwords do not match. Please try again.</p>
                    <div class="mt-4 text-right">
                        <button class="px-4 py-2 bg-red-700 text-white font-semibold rounded hover:bg-red-600" onclick="window.location.href='register.php'">Close</button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
