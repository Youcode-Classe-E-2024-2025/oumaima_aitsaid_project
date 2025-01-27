<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Task</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Update Task</h1>
        <form action="index.php?action=update_task&id=<?php echo $task['id']; ?>" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <input type="hidden" name="project_id" value="<?php echo htmlspecialchars($project['id']); ?>">

            <!-- Task Title -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    Task Title
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
            </div>

            <!-- Description -->
            <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                Description (Markdown supported)
            </label>
            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" rows="6"><?php echo htmlspecialchars($task['description']); ?></textarea>
        </div>
            
            <!-- Status -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="status">
                    Status
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="status" name="status">
                    <option value="toDo" <?php echo $task['status'] === 'toDo' ? 'selected' : ''; ?>>To Do</option>
                    <option value="inProgress" <?php echo $task['status'] === 'inProgress' ? 'selected' : ''; ?>>In Progress</option>
                    <option value="completed" <?php echo $task['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                </select>
            </div>
            
            <!-- Priority -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="priority">
                    Priority
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="priority" name="priority">
                    <option value="low" <?php echo $task['priority'] === 'low' ? 'selected' : ''; ?>>Low</option>
                    <option value="medium" <?php echo $task['priority'] === 'medium' ? 'selected' : ''; ?>>Medium</option>
                    <option value="high" <?php echo $task['priority'] === 'high' ? 'selected' : ''; ?>>High</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_id">
                    Category
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category_id" name="category_id">
                    <option value="">Select a category</option>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['id']); ?>" <?php echo $category['id'] === $task['category_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($category['name']); ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>No categories available</option>
                    <?php endif; ?>
                </select>
            </div>       

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="assigned_to">
                    Assigned To
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="assigned_to" name="assigned_to">
                    <option value="">Select a user</option>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo htmlspecialchars($user['id']); ?>" <?php echo $user['id'] === $task['assigned_to'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($user['name']); ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>No users available</option>
                    <?php endif; ?>
                </select>
            </div>      

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="due_date">
                    Due Date
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="due_date" type="date" name="fin_date" value="<?php echo htmlspecialchars($task['fin_date']); ?>" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="tags">
                    Tags
                </label>
                <select multiple class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="tags" name="tags[]">
                    <?php if (!empty($tags)): ?>
                        <?php foreach ($tags as $tag): ?>
                            <option value="<?php echo htmlspecialchars($tag['id']); ?>" <?php echo in_array($tag['id'], $task['tags']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($tag['name']); ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>No tags </option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Update Task
                </button>
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="index.php?action=project_details&id=<?php echo htmlspecialchars($project['id']); ?>">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</body>
</html>
