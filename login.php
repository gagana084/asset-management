<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Management - Login</title>
    <link rel="shortcut icon" href="./logo.png" style="height: 100%; width:100%;" type="image/x-icon">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-800 min-h-screen flex items-center justify-center p-4">
    <div class="container mx-auto px-4 py-8 md:px-8 lg:px-16 max-w-7xl">
        <div class="bg-gray-700 rounded-3xl shadow-xl overflow-hidden">
            <div class="flex flex-col md:flex-row">
                <!-- Left Side - Image Only -->
                <div class="md:w-1/2 relative overflow-hidden">
                    <img src="https://www.sunsmart.co.in/wp-content/uploads/product/asset-management.png" alt="Asset Management System"
                        class="w-full h-48 md:h-full object-cover rounded-t-3xl md:rounded-l-3xl md:rounded-tr-none transition-transform duration-500 hover:scale-105" />
                </div>

                <!-- Right Side - Login Form -->
                <div class="md:w-1/2 px-6 py-8 md:px-10 md:py-12 bg-gray-700">
                    <div class="mb-2 md:mb-10">
                        <h2 class="text-2xl md:text-3xl font-bold text-[#ffffff] mb-2">AssetPro</h2>
                    </div>

                    <form>
                        <h6 class="text-red-600 mb-4" id="alert2"></h6>

                        <div class="mb-6 relative">
                            <label for="email" class="block text-sm font-medium text-[#fff] mb-2">Email address</label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="email" id="email" placeholder="name@company.com"
                                    class="w-full h-14 px-12 rounded-xl border-2 border-gray-200 focus:border-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-all text-base" />
                            </div>
                        </div>

                        <div class="mb-6 relative">
                            <label for="password" class="block text-sm font-medium text-[#fff] mb-2">Password</label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="password" id="password" placeholder="••••••••"
                                    class="w-full h-14 px-12 rounded-xl border-2 border-gray-200 focus:border-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-all text-base" />
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-8">
                            <div class="flex items-center">
                                <input class="w-4 h-4 border-2 border-gray-300 rounded mr-2" type="checkbox" id="rememberMe" />
                                <label class="text-gray-500 text-sm cursor-pointer" for="rememberMe">
                                    Remember me
                                </label>
                            </div>
                            <a href="#" class="text-blue-600 text-sm font-medium hover:underline">Forgot password?</a>
                        </div>

                        <button onclick="login();" type="button"
                            class="w-full h-14 rounded-xl bg-gradient-to-r from-blue-600 to-[#172061] text-white font-semibold text-base transition-all hover:-translate-y-0.5 hover:shadow-lg flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                        </button>

                        <div class="text-center mt-8">
                            <p class="text-gray-500 text-sm">Don't have an account? <a href="./register.php" class="text-blue-600 font-semibold hover:underline">Create account</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>