<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Management</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Role Management</h1>
        
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Roles List</h2>
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="py-2 px-4 font-medium text-gray-700">ID</th>
                        <th class="py-2 px-4 font-medium text-gray-700">Name</th>
                        <th class="py-2 px-4 font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roles as $role): ?>
                    <tr class="border-t">
                        <td class="py-2 px-4 text-gray-700"><?php echo $role['id']; ?></td>
                        <td class="py-2 px-4 text-gray-700"><?php echo $role['name']; ?></td>
                        <td class="py-2 px-4">
                            <!-- Edit Role Form -->
                            <form action="index.php?action=updateRole" method="POST" class="inline-block mr-2">
                                <input type="hidden" name="role_id" value="<?php echo $role['id']; ?>" />
                                <input type="text" name="new_name" value="<?php echo $role['name']; ?>" class="p-2 border border-gray-300 rounded w-full sm:w-auto" required />
                                <button type="submit" class="bg-indigo-600 text-white py-1 px-4 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600">Update</button>
                            </form>

                            <!-- Delete Role Form -->
                            <form action="index.php?action=deleteRole" method="POST" class="inline-block">
                                <input type="hidden" name="role_id" value="<?php echo $role['id']; ?>" />
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this role?')" class="bg-red-600 text-white py-1 px-4 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-6 mt-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Create New Role</h2>
            <form action="index.php?action=createRole" method="POST">
                <div class="mb-4">
                    <label for="name" class="block text-lg font-medium text-gray-700">Role Name:</label>
                    <input type="text" id="name" name="name" required class="mt-2 p-2 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-indigo-600">
                </div>
                <div class="mb-6">
                    <h3 class="text-xl font-medium text-gray-700 mb-2">Permissions:</h3>
                    <?php foreach ($permissions as $permission): ?>
                    <div class="mb-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="permissions[]" value="<?php echo $permission['id']; ?>" class="mr-2 h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-600">
                            <span class="text-gray-700"><?php echo $permission['name']; ?></span>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600">Create Role</button>
            </form>
        </div>
    </div>
</body>
</html>
