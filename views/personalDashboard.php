<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Personal Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-2">Total Tasks</h2>
                <p class="text-3xl font-bold"><?php echo $totalTasks; ?></p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-2">Completed Tasks</h2>
                <p class="text-3xl font-bold text-green-500"><?php echo $completedTasks; ?></p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-2">In Progress Tasks</h2>
                <p class="text-3xl font-bold text-yellow-500"><?php echo $inProgressTasks; ?></p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-2">To Do Tasks</h2>
                <p class="text-3xl font-bold text-red-500"><?php echo $todoTasks; ?></p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-semibold mb-4">Your Tasks</h2>
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="text-left">Task</th>
                        <th class="text-left">Status</th>
                        <th class="text-left">Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td class="py-2"><?php echo htmlspecialchars($task['title']); ?></td>
                        <td class="py-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                <?php echo $task['status'] === 'completed' ? 'bg-green-100 text-green-800' : 
                                    ($task['status'] === 'inProgress' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'); ?>">
                                <?php echo ucfirst($task['status']); ?>
                            </span>
                        </td>
                        <td class="py-2"><?php echo htmlspecialchars($task['fin_date']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>