<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Utilisateur</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-5">
        <header class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800">Bienvenue, <?= htmlspecialchars($userName); ?> 🎉</h1>
            <p class="text-gray-600">Voici un aperçu des projets auxquels vous êtes assigné.</p>
        </header>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-800">Vos Projets Assignés</h2>
            <ul class="list-none mb-4">
                <?php foreach ($assignedProjects as $projectItem): ?>
                    <li class="flex justify-between items-center p-4 mb-4 bg-white shadow rounded-lg">
                        <span class="text-gray-800"><?= htmlspecialchars($projectItem['name']); ?></span>
                        <a href="index.php?action=user_dashboard&project_id=<?= $projectItem['id']; ?>" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">
                            Voir les tâches
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <div class="mt-6">
            <a href="index.php?action=logout" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Logout
            </a>
        </div>

        <?php if (isset($project) && !empty($tasks)): ?>
            <section class="mt-8">
                <h2 class="text-2xl font-semibold text-center text-gray-800">Kanban pour le Projet: <?= htmlspecialchars($project['name']); ?></h2>
                <div class="flex space-x-4 mt-6">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-blue-600 mb-4">À faire</h3>
                        <div class="space-y-4">
                            <?php foreach ($tasks as $task): ?>
                                <?php if ($task['status'] === 'toDo'): ?>
                                    <div class="bg-white p-4 rounded-lg shadow">
                                        <h5 class="font-semibold text-gray-800"><?= htmlspecialchars($task['title']); ?></h5>
                                        <p class="text-gray-600"><?= htmlspecialchars($task['description']); ?></p>
                                        <form method="POST" action="index.php?action=update_task_status" class="mt-4">
                                            <input type="hidden" name="task_id" value="<?= $task['id']; ?>">
                                            <input type="hidden" name="project_id" value="<?= $project['id']; ?>">
                                            <button type="submit" name="new_status" value="inProgress" class="bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-600">
                                                Marquer comme En cours
                                            </button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-yellow-600 mb-4">En cours</h3>
                        <div class="space-y-4">
                            <?php foreach ($tasks as $task): ?>
                                <?php if ($task['status'] === 'inProgress'): ?>
                                    <div class="bg-white p-4 rounded-lg shadow">
                                        <h5 class="font-semibold text-gray-800"><?= htmlspecialchars($task['title']); ?></h5>
                                        <p class="text-gray-600"><?= htmlspecialchars($task['description']); ?></p>
                                        <form method="POST" action="index.php?action=update_task_status" class="mt-4">
                                            <input type="hidden" name="task_id" value="<?= $task['id']; ?>">
                                            <input type="hidden" name="project_id" value="<?= $project['id']; ?>">
                                            <button type="submit" name="new_status" value="completed" class="bg-green-500 text-white py-1 px-3 rounded hover:bg-green-600">
                                                Marquer comme Terminé
                                            </button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-green-600 mb-4">Terminé</h3>
                        <div class="space-y-4">
                            <?php foreach ($tasks as $task): ?>
                                <?php if ($task['status'] === 'completed'): ?>
                                    <div class="bg-white p-4 rounded-lg shadow">
                                        <h5 class="font-semibold text-gray-800"><?= htmlspecialchars($task['title']); ?></h5>
                                        <p class="text-gray-600"><?= htmlspecialchars($task['description']); ?></p>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php else: ?>
            <p class="text-center text-gray-600">Aucune tâche à afficher pour ce projet.</p>
        <?php endif; ?>
    </div>
</body>
</html>
