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
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Task Title</th>
                        <th class="py-3 px-6 text-left">Description</th>
                        <th class="py-3 px-6 text-center">Status</th>
                        <th class="py-3 px-6 text-center">Priorité</th>
                        <th class="py-3 px-6 text-center">Category</th>
                        <th class="py-3 px-6 text-center">Due Date</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <?php foreach ($tasks as $task): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?php echo htmlspecialchars($task['title']); ?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left">
                            <div class="flex items-center">
                                <span><?php echo htmlspecialchars($task['description']); ?></span>
                            </div>
                        </td>
                        <!--status-->
                        <td class="py-3 px-6 text-center">

                        <?php   if(htmlspecialchars($task['status']== 'toDo')) { ?>
                            <span class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs">
                               Todo
                            </span><?php } elseif(htmlspecialchars($task['status']== 'inProgress')) {?>
                            <span class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs">in Progress</span>
                             <?php } elseif(htmlspecialchars($task['status'] == 'completed') ) {?>
                                <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">completed</span><?php }?>


                                <!--prioritè-->
                            <td class="py-3 px-6 text-center">
                          <?php if (htmlspecialchars($task['priority']) == 'high') { ?>
                             <span class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">
                       High
                        </span>
                       <?php } elseif (htmlspecialchars($task['priority']) == 'medium') { ?>
                  <span class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs">
                   Medium
                    </span>
                      <?php } elseif (htmlspecialchars($task['priority']) == 'low') { ?>
            <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">
            Low
        </span>
    <?php } ?>
</td>
                        <td class="py-3 px-6 text-center">
                            <span><?php echo htmlspecialchars($task['category_id']); ?></span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <span><?php echo htmlspecialchars($task['fin_date']); ?></span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <a href="index.php?action=update_task&id=<?php echo $task['id']; ?>" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <a href="index.php?action=delete_task&id=<?php echo $task['id']; ?>" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" onclick="return confirm('Are you sure you want to delete this task?');">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            <a href="index.php?action=dashboard" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Dashboard
            </a>
        </div>
    </div>
</body>
</html>

