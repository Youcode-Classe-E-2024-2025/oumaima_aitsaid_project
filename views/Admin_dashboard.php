<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
            </div>
        </header>
        <main class="flex-grow">
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- Statistics cards -->
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900"><?php echo $totalUsers; ?></dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Permissions</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900"><?php echo $totalPermissions; ?></dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Roles</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900"><?php echo $totalRoles; ?></dd>
                        </div>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <a href="index.php?action=create_user" class="bg-white overflow-hidden shadow rounded-lg px-4 py-5 sm:p-6 hover:bg-gray-50 transition duration-150 ease-in-out">
                        <h3 class="text-lg font-medium text-gray-900">Manage Users</h3>
                        <p class="mt-1 text-sm text-gray-500">View and manage user accounts</p>
                    </a>
                    <a href="index.php?action=permissions" class="bg-white overflow-hidden shadow rounded-lg px-4 py-5 sm:p-6 hover:bg-gray-50 transition duration-150 ease-in-out">
                        <h3 class="text-lg font-medium text-gray-900">Manage Permissions</h3>
                        <p class="mt-1 text-sm text-gray-500">View and manage Permissions</p>
                    </a>
                    <a href="index.php?action=roles" class="bg-white overflow-hidden shadow rounded-lg px-4 py-5 sm:p-6 hover:bg-gray-50 transition duration-150 ease-in-out">
                        <h3 class="text-lg font-medium text-gray-900">Manage Roles</h3>
                        <p class="mt-1 text-sm text-gray-500">View and manage user roles</p>
                    </a>
                </div>

                <!-- Recent activities -->
                <div class="mt-8">
                    <h2 class="text-lg leading-6 font-medium text-gray-900">Recent Activities</h2>
                    <div class="mt-2 bg-white shadow overflow-hidden sm:rounded-md">
                        <ul role="list" class="divide-y divide-gray-200">
                            <?php foreach ($recentActivities as $activity): ?>
                                <li>
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-indigo-600 truncate">
                                                <?php echo htmlspecialchars($activity['user_name']); ?>
                                            </p>
                                            <div class="ml-2 flex-shrink-0 flex">
                                                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    <?php echo htmlspecialchars($activity['action']); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mt-2 sm:flex sm:justify-between">
                                            <div class="sm:flex">
                                                <p class="flex items-center text-sm text-gray-500">
                                                    Project: <?php echo htmlspecialchars($activity['project_name']); ?>
                                                </p>
                                            </div>
                                            <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                                <p>
                                                    <?php echo htmlspecialchars($activity['created_at']); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

