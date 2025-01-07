<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Timeline</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Project Timeline: <?php echo htmlspecialchars($project['name']); ?></h1>
        
        <div class="bg-white shadow-md rounded-lg p-6">
            <ol class="relative border-l border-gray-200">
                <?php foreach ($activities as $activity): ?>
                    <li class="mb-10 ml-6">
                        <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -left-3 ring-8 ring-white">
                            <svg class="w-3 h-3 text-blue-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </span>
                        <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900">
                            <?php echo htmlspecialchars($activity['action']); ?>
                        </h3>
                        <time class="block mb-2 text-sm font-normal leading-none text-gray-400">
                            <?php echo htmlspecialchars($activity['created_at']); ?>
                        </time>
                        <p class="mb-4 text-base font-normal text-gray-500">
                            <?php echo htmlspecialchars($activity['description']); ?>
                        </p>
                        <p class="text-sm text-gray-500">
                            By: <?php echo htmlspecialchars($activity['user_name']); ?>
                        </p>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>

        <div class="mt-6">
            <a href="index.php?action=project_details&id=<?php echo $project['id']; ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Back to Project Details
            </a>
        </div>
    </div>
</body>
</html>
