<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Projects</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <?php include 'header.php'?>
    <div class="container mx-auto mt-6 px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (empty($projects)): ?>
                <p class="text-gray-500 text-center col-span-full">no public projects  </p>
            <?php else: ?>
                <?php foreach ($projects as $project): ?>
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($project['name']) ?></h2>
                            <p class="text-gray-600 mt-2"><?= htmlspecialchars($project['description']) ?></p>
                            <div class="mt-4">
                                <p class="text-gray-500"><strong>Start Date:</strong> <?= htmlspecialchars($project['date_commence']) ?></p>
                                <p class="text-gray-500"><strong>End Date:</strong> <?= htmlspecialchars($project['date_fin']) ?></p>
                                <p class="text-gray-500"><strong>Status:</strong> <?= htmlspecialchars($project['status']) ?></p>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-4">
                            <button 
                                class="text-blue-600 hover:underline font-medium view-details-btn"
                                onclick="showRegisterPrompt('<?= htmlspecialchars($project['name']) ?>')">
                                View Details
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
   

   
</body>
</html>