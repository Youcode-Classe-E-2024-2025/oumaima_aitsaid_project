<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Role.php';
require_once __DIR__ . '/../models/Project.php';
require_once __DIR__ . '/../models/Permission.php';
require_once __DIR__ . '/../config/Database.php';

class AdminController {
    private $userModel;
    private $roleModel;
    private $projectModel;
    private $permissionModel;
    private $db;
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        
        $this->userModel = new User($this->db);
        $this->roleModel = new Role($this->db);
        $this->projectModel = new Project($this->db);
        $this->permissionModel = new Permission($this->db);
    }

    public function dashboard() {
        $totalUsers = $this->userModel->getTotalUsers();
        $totalPermissions = $this->permissionModel->getTotalPermissions();
        $totalRoles = $this->roleModel->getTotalRoles();
        $recentActivities = $this->projectModel->getRecentActivities(5);

        require_once __DIR__ . '/../views/Admin_dashboard.php';
    }

    public function users() {
        $users = $this->userModel->getAllUsers();
        $roles = $this->roleModel->getAllRoles();
        require_once __DIR__ . '/../views/users.php';
    }
    public function deleteUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
            $userId = $_POST['user_id'];
    
            // Create User object and call deleteUser method
            $user = new User($this->db);
            if ($user->deleteUser($userId)) {
                require_once __DIR__ . '/../views/users.php';                exit;
            } else {
                echo "Failed to delete the user.";
            }
        }
    }
    
    
    public function roles() {
        $roles = $this->roleModel->getAllRoles();
        $permissions = $this->roleModel->getAllPermissions();
        require_once __DIR__ . '/../views/roles.php';

    }

    public function projects() {
        $projects = $this->projectModel->getAllProjects();
        require_once __DIR__ . '/../views/project.php';

    }

    public function createUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $roleId = $_POST['role_id'];

            $userId = $this->userModel->createUser($name, $email, $password);
            $this->userModel->assignRole($userId, $roleId);

            require_once __DIR__ . '/../views/users.php';       
                 exit;
        }
    }

    public function createRole() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $permissions = $_POST['permissions'];

            $roleId = $this->roleModel->createRole($name);
            foreach ($permissions as $permissionId) {
                $this->roleModel->assignPermission($roleId, $permissionId);
            }

            require_once __DIR__ . '/../views/roles.php';      
                   exit;
        }
    }   public function assignPermissions() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $roleId = $_POST['role_id'];
            $permissions = isset($_POST['permissions']) ? $_POST['permissions'] : [];

            if ($this->roleModel->assignPermissions($roleId, $permissions)) {
                header('Location: index.php?action=permissions');
                exit;
            } else {
                echo "Erreur lors de l'assignation des permissions.";
            }
        }
    }

    public function permissions() {
        $permissions = $this->permissionModel->getAllPermissions();
        $roles = $this->roleModel->getAllRoles();
        
        // Pour chaque rôle, récupérer ses permissions
        foreach ($roles as &$role) {
            $role['permissions'] = $this->roleModel->getRolePermissions($role['id']);
        }

        require_once __DIR__ . '/../views/permissions.php';
    }
    

    public function updateRole() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['role_id'], $_POST['new_name'])) {
            $roleId = $_POST['role_id'];
            $newName = $_POST['new_name'];

            $updated = $this->roleModel->updateRole($roleId, $newName);

            if ($updated) {
                header('Location:index.php?action=roles');   
            } else {
                                echo "Failed to update the role.";
            }
        }
    }

    public function deleteRole() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['role_id'])) {
            $roleId = $_POST['role_id'];

            $deleted = $this->roleModel->deleteRole($roleId);

            if ($deleted) {
                header('Location:index.php?action=roles');   
                                exit;
            } else {
                echo "Failed to delete the role.";
            }
        }
    }
    
    public function updateUserRole() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'];
            $roleId = $_POST['role_id'];
            
            if ($this->userModel->updateRole($userId, $roleId)) {
                header('Location: index.php?action=users');
                exit;
            } else {
                echo "Error updating role.";
            }
        }}
      
        public function createPermission() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'];
    
                $permissionId = $this->permissionModel->createPermission($name);
    
                if ($permissionId) {
                    header('Location: index.php?action=permissions');
                    exit;
                } else {
                    echo "Failed to create the permission.";
                }
            }
        }
    
        public function updatePermission() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['permission_id'], $_POST['new_name'])) {
                $permissionId = $_POST['permission_id'];
                $newName = $_POST['new_name'];
    
                $updated = $this->permissionModel->updatePermission($permissionId, $newName);
    
                if ($updated) {
                    header('Location: index.php?action=permissions');
                    exit;
                } else {
                    echo "Failed to update the permission.";
                }
            }
        }
    
        public function deletePermission() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['permission_id'])) {
                $permissionId = $_POST['permission_id'];
    
                $deleted = $this->permissionModel->deletePermission($permissionId);
    
                if ($deleted) {
                    header('Location: index.php?action=permissions');
                    exit;
                } else {
                    echo "Failed to delete the permission.";
                }
            }
        
    }
    
    
}

