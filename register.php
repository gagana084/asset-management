<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Asset Management - Create Account</title>
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

<body class="bg-gray-800 py-8 px-4 flex items-center">
  <div class="container mx-auto max-w-7xl">
    <div class="flex justify-center ">
      <div class="w-full lg:w-10/12">
        <div class="bg-gray-700 rounded-2xl shadow-lg overflow-hidden">
          <div class="flex flex-col md:flex-row">
            <!-- Left Side - Image (Hidden on mobile) -->
            <div class="hidden md:block md:w-1/2">
              <img src="https://www.sunsmart.co.in/wp-content/uploads/product/asset-management.png" alt="Asset Management System"
                class="h-full w-full object-cover" />
            </div>

            <!-- Right Side - Registration Form -->
            <div class="w-full md:w-1/2 p-6 md:p-8 lg:p-10 bg-gray-700">
              <h2 class="text-4xl font-bold text-gray-100 mb-1 text-center">AssetPro</h2>

              <form>
                <h6 id="alert" class="text-red-600 mb-4"></h6>

                <!-- Full Name Field -->
                <div class="mb-5">
                  <label for="fullName" class="block text-sm font-medium text-gray-200 mb-2">Full Name</label>
                  <div class="flex">
                    <span class="inline-flex items-center px-3 bg-gray-100 text-gray-500 border border-r-0 border-gray-300 rounded-l-lg">
                      <i class="fas fa-user"></i>
                    </span>
                    <input type="text" id="fullName" placeholder="John Doe"
                      class="flex-1 py-3 px-4 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" />
                  </div>
                </div>

                <!-- Email Field -->
                <div class="mb-5">
                  <label for="email" class="block text-sm font-medium text-gray-200 mb-2">Email address</label>
                  <div class="flex">
                    <span class="inline-flex items-center px-3 bg-gray-100 text-gray-500 border border-r-0 border-gray-300 rounded-l-lg">
                      <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" id="email" placeholder="name@company.com"
                      class="flex-1 py-3 px-4 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" />
                  </div>
                </div>

                <!-- Password Field -->
                <div class="mb-5">
                  <label for="password" class="block text-sm font-medium text-gray-200 mb-2">Password</label>
                  <div class="flex">
                    <span class="inline-flex items-center px-3 bg-gray-100 text-gray-500 border border-r-0 border-gray-300 rounded-l-lg">
                      <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" id="password" placeholder="••••••••"
                      class="flex-1 py-3 px-4 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" />
                  </div>
                </div>

                <!-- Confirm Password Field -->
                <div class="mb-5">
                  <label for="confirmPassword" class="block text-sm font-medium text-gray-200 mb-2">Confirm Password</label>
                  <div class="flex">
                    <span class="inline-flex items-center px-3 bg-gray-100 text-gray-500 border border-r-0 border-gray-300 rounded-l-lg">
                      <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" id="confirmPassword" placeholder="••••••••"
                      class="flex-1 py-3 px-4 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" />
                  </div>
                </div>

                <!-- Terms Checkbox -->
                <div class="mb-6">
                  <div class="flex items-start">
                    <input class="w-4 h-4 mt-1 mr-2 border border-gray-300 rounded" type="checkbox" id="agreeTerms" />
                    <label class="text-sm text-gray-600" for="agreeTerms">
                      I agree to the <a href="#" class="text-blue-600 hover:underline">Terms of Service</a> and <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>
                    </label>
                  </div>
                </div>

                <!-- Submit Button -->
                <button onclick="register();" type="button"
                  class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200 flex items-center justify-center">
                  <i class="fas fa-user-plus mr-2"></i>Create Account
                </button>

                <!-- Sign In Link -->
                <div class="text-center mt-6">
                  <p class="text-gray-500 text-sm">Already have an account? <a href="./login.php" class="text-blue-600 font-semibold hover:underline">Sign in</a></p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="script.js"></script>
</body>

</html>