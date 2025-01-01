<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <h1 class="text-2xl font-bold mb-6 text-center">Welcome, <?php echo htmlspecialchars($userName); ?>!</h1>
            <p class="text-center mb-6">This is your dashboard.</p>
            <div class="flex justify-center">
                <a href="index.php?action=logout" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Logout
                </a>
            </div>
        </div>
    </div>
</body>
</html>

