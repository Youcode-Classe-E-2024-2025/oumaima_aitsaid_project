<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permission Management</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Permission Management</h1>
        
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Permissions List</h2>
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="py-2 px-4 font-medium text-gray-700">ID</th>
                        <th class="py-2 px-4 font-medium text-gray-700">Name</th>
                        <th class="py-2 px-4 font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($permissions as $permission): ?>
                    <tr class="border-t">
                        <td class="py-2 px-4 text-gray-700"><?php echo $permission['id']; ?></td>
                        <td class="py-2 px-4 text-gray-700"><?php echo $permission['name']; ?></td>
                        <td class="py-2 px-4">
                            <!-- Edit Permission Form -->
                            <form action="index.php?action=updatePermission" method="POST" class="inline-block mr-2">
                                <input type="hidden" name="permission_id" value="<?php echo $permission['id']; ?>" />
                                <input type="text" name="new_name" value="<?php echo $permission['name']; ?>" class="p-2 border border-gray-300 rounded w-full sm:w-auto" required />
                                <button type="submit" class="bg-indigo-600 text-white py-1 px-4 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600">Update</button>
                            </form>

                            <!-- Delete Permission Form -->
                            <form action="index.php?action=deletePermission" method="POST" class="inline-block">
                                <input type="hidden" name="permission_id" value="<?php echo $permission['id']; ?>" />
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this permission?')" class="bg-red-600 text-white py-1 px-4 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

       
 <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Assigner des Permissions à un Rôle</h2>
            <form action="index.php?action=assignPermissions" method="POST">
                <div class="mb-4">
                    <label for="role" class="block text-lg font-medium text-gray-700">Sélectionner un Rôle:</label>
                    <select id="role" name="role_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Choisir un rôle</option>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?php echo $role['id']; ?>"><?php echo $role['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-6">
                    <h3 class="text-xl font-medium text-gray-700 mb-2">Permissions:</h3>
                    <?php foreach ($permissions as $permission): ?>
                    <div class="mb-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="permissions[]" value="<?php echo $permission['id']; ?>" class="form-checkbox h-5 w-5 text-indigo-600">
                            <span class="ml-2 text-gray-700"><?php echo $permission['name']; ?></span>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600">Assigner les Permissions</button>
            </form>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-6 mt-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Permissions Actuelles par Rôle</h2>
            <?php foreach ($roles as $role): ?>
                <div class="mb-4">
                    <h3 class="text-xl font-medium text-gray-700"><?php echo $role['name']; ?></h3>
                    <ul class="list-disc pl-5">
                        <?php foreach ($role['permissions'] as $permission): ?>
                            <li><?php echo $permission['name']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
