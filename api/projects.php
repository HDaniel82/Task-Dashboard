<?php
// 1. Bring in the database connection
require_once '../include/db.php';

// 2. Tell the browser we are returning JSON data
header('Content-Type: application/json');

// 3. Figure out what HTTP method the frontend used
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // READ: Fetch all projects
        $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
        $projects = $stmt->fetchAll();
        echo json_encode($projects);
        break;

    case 'POST':
        // CREATE: Add a new project
        // We use php://input to read the raw JSON body sent by jQuery
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (isset($data['title']) && !empty(trim($data['title']))) {
            $stmt = $pdo->prepare("INSERT INTO projects (title, description) VALUES (:title, :description)");
            $stmt->execute([
                ':title' => trim($data['title']),
                ':description' => $data['description'] ?? ''
            ]);
            // Return the ID of the newly created project
            echo json_encode(['status' => 'success', 'id' => $pdo->lastInsertId()]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Project title is required']);
        }
        break;

    case 'PUT':
        // UPDATE: Modify an existing project
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (isset($data['id'], $data['title'])) {
            $stmt = $pdo->prepare("UPDATE projects SET title = :title, description = :description WHERE id = :id");
            $stmt->execute([
                ':id' => $data['id'],
                ':title' => trim($data['title']),
                ':description' => $data['description'] ?? ''
            ]);
            echo json_encode(['status' => 'success']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Project ID and title are required']);
        }
        break;

    case 'DELETE':
        // DELETE: Remove a project (and its tasks, due to ON DELETE CASCADE)
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'] ?? $_GET['id'] ?? null;
        
        if ($id) {
            $stmt = $pdo->prepare("DELETE FROM projects WHERE id = :id");
            $stmt->execute([':id' => $id]);
            echo json_encode(['status' => 'success']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Project ID is required']);
        }
        break;

    default:
        // Reject any other methods like PATCH or OPTIONS
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
        break;
}
?>