<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">User Management</h1>

        <!-- Users Table -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Users List</h2>
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="py-2 px-4 font-medium text-gray-700">ID</th>
                        <th class="py-2 px-4 font-medium text-gray-700">Name</th>
                        <th class="py-2 px-4 font-medium text-gray-700">Email</th>
                        <th class="py-2 px-4 font-medium text-gray-700">Roles</th>
                        <th class="py-2 px-4 font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr class="border-t">
                        <td class="py-2 px-4 text-gray-700"><?php echo $user['id']; ?></td>
                        <td class="py-2 px-4 text-gray-700"><?php echo $user['name']; ?></td>
                        <td class="py-2 px-4 text-gray-700"><?php echo $user['email']; ?></td>
                        <td class="py-2 px-4 text-gray-700"><?php echo $user['roles']; ?></td>
                        <td class="py-2 px-4">
                     
                     <form action="index.php?action=updateUserRole" method="POST" class="inline-block mr-2">
    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>" />
    <select name="role_id" class="p-2 border border-gray-300 rounded w-full sm:w-auto" required>
        <?php 
        $userRoles = explode(',', $user['role_ids']); 
        foreach ($roles as $role): ?>
            <option value="<?php echo $role['id']; ?>" 
                <?php echo in_array($role['id'], $userRoles) ? 'selected' : ''; ?>>
                <?php echo $role['name']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="bg-blue-600 text-white py-1 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600">Update Role</button>
</form>

                         
                            <form action="index.php?action=deleteUser" method="POST" class="inline-block">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>" />
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this user?')" class="bg-red-600 text-white py-1 px-4 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Create New User Form -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Create New User</h2>
            <form action="index.php?action=createUser" method="POST">
                <div class="mb-4">
                    <label for="name" class="block text-lg font-medium text-gray-700">Name:</label>
                    <input type="text" id="name" name="name" required class="mt-2 p-2 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-indigo-600">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-lg font-medium text-gray-700">Email:</label>
                    <input type="email" id="email" name="email" required class="mt-2 p-2 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-indigo-600">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-lg font-medium text-gray-700">Password:</label>
                    <input type="password" id="password" name="password" required class="mt-2 p-2 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-indigo-600">
                </div>
                <div class="mb-4">
                    <label for="role_id" class="block text-lg font-medium text-gray-700">Role:</label>
                    <select id="role_id" name="role_id" required class="mt-2 p-2 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-indigo-600">
                        <?php foreach ($roles as $role): ?>
                            <option value="<?php echo $role['id']; ?>"><?php echo $role['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600">Create User</button>
            </form>
        </div>
    </div>
</body>
</html>
