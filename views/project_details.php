<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Project: <?php echo htmlspecialchars($project['name']); ?></h1>
        <div class="mb-6">
            <p><strong>Description:</strong> <?php echo htmlspecialchars($project['description']); ?></p>
            <p><strong>Start Date:</strong> <?php echo htmlspecialchars($project['date_commence']); ?></p>
            <p><strong>End Date:</strong> <?php echo htmlspecialchars($project['date_fin']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($project['status']); ?></p>
        </div>
        <div class="mb-6">
            <a href="index.php?action=create_task&project_id=<?php echo $project['id']; ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create New Task
            </a>
        </div>

        <div class="flex gap-4">
            <div class="flex-1 bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-700">To Do</h2>
                    <span class="bg-gray-200 text-gray-700 rounded-full px-3 py-1 text-sm">
                        <?php echo count(array_filter($tasks, function($task) { return $task['status'] === 'toDo'; })); ?>
                    </span>
                </div>
                <div class="space-y-3">
                    <?php foreach ($tasks as $task): ?>
                        <?php if ($task['status'] === 'toDo'): ?>
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                                <h3 class="font-medium text-gray-800 mb-2"><?php echo htmlspecialchars($task['title']); ?></h3>
                                <div class="mb-6">
            <p><strong>Description:</strong></p>
            <div class="prose">
                <?php echo $task['description_html']; ?>
            </div>
        </div>

                                <div class="flex items-center justify-between mb-2">
                                    <span class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs">Todo</span>
                                    <?php if ($task['priority'] === 'high'): ?>
                                        <span class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">High</span>
                                    <?php elseif ($task['priority'] === 'medium'): ?>
                                        <span class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs">Medium</span>
                                    <?php else: ?>
                                        <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">Low</span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500"><?php echo htmlspecialchars($task['fin_date']); ?></span>
                                    <div class="flex space-x-2">
                                        <a href="index.php?action=update_task&id=<?php echo $task['id']; ?>" class="text-blue-500 hover:text-blue-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        <a href="index.php?action=delete_task&id=<?php echo $task['id']; ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this task?');">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="flex-1 bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-700">In Progress</h2>
                    <span class="bg-gray-200 text-gray-700 rounded-full px-3 py-1 text-sm">
                        <?php echo count(array_filter($tasks, function($task) { return $task['status'] === 'inProgress'; })); ?>
                    </span>
                </div>
                <div class="space-y-3">
                    <?php foreach ($tasks as $task): ?>
                        <?php if ($task['status'] === 'inProgress'): ?>
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                                <h3 class="font-medium text-gray-800 mb-2"><?php echo htmlspecialchars($task['title']); ?></h3>
                                <p class="text-sm text-gray-600 mb-3"><?php echo htmlspecialchars($task['description']); ?></p>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs">In Progress</span>
                                    <?php if ($task['priority'] === 'high'): ?>
                                        <span class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">High</span>
                                    <?php elseif ($task['priority'] === 'medium'): ?>
                                        <span class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs">Medium</span>
                                    <?php else: ?>
                                        <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">Low</span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500"><?php echo htmlspecialchars($task['fin_date']); ?></span>
                                    <div class="flex space-x-2">
                                        <a href="index.php?action=update_task&id=<?php echo $task['id']; ?>" class="text-blue-500 hover:text-blue-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        <a href="index.php?action=delete_task&id=<?php echo $task['id']; ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this task?');">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="flex-1 bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-700">Completed</h2>
                    <span class="bg-gray-200 text-gray-700 rounded-full px-3 py-1 text-sm">
                        <?php echo count(array_filter($tasks, function($task) { return $task['status'] === 'completed'; })); ?>
                    </span>
                </div>
                <div class="space-y-3">
                    <?php foreach ($tasks as $task): ?>
                        <?php if ($task['status'] === 'completed'): ?>
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                                <h3 class="font-medium text-gray-800 mb-2"><?php echo htmlspecialchars($task['title']); ?></h3>
                                <p class="text-sm text-gray-600 mb-3"><?php echo htmlspecialchars($task['description']); ?></p>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">Completed</span>
                                    <?php if ($task['priority'] === 'high'): ?>
                                        <span class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">High</span>
                                    <?php elseif ($task['priority'] === 'medium'): ?>
                                        <span class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs">Medium</span>
                                    <?php else: ?>
                                        <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">Low</span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex space-x-2 mb-3">
        <?php if (!empty($task['tags'])): ?>
            <?php foreach ($task['tags'] as $tag): ?>
                <span class="bg-gray-200 text-gray-700 py-1 px-3 rounded-full text-xs"><?php echo htmlspecialchars($tag['name']); ?></span>
            <?php endforeach; ?>
        <?php else: ?>
            <span class="text-gray-500 text-xs">No tags</span>
        <?php endif; ?>
    </div>

                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500"><?php echo htmlspecialchars($task['fin_date']); ?></span>
                                    <div class="flex space-x-2">
                                        <a href="index.php?action=update_task&id=<?php echo $task['id']; ?>" class="text-blue-500 hover:text-blue-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        <a href="index.php?action=delete_task&id=<?php echo $task['id']; ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this task?');">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <a href="index.php?action=dashboard" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Dashboard
            </a>
        </div>
    </div>
</body>
</html>