<?php
include 'config.php';


$stmt = $pdo->query("SELECT * FROM recipes");
$recipes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Recipes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">All Recipes</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Recipe ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recipes as $recipe): ?>
                    <tr>
                        <td><?php echo $recipe['id']; ?></td>
                        <td><?php echo $recipe['title']; ?></td>
                        <td><?php echo substr($recipe['description'], 0, 50) . '...'; ?></td>
                        <td>
                            <a href="edit_recipe.php?id=<?php echo $recipe['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_recipe.php?id=<?php echo $recipe['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this recipe?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_recipe.php" class="btn btn-primary">Add New Recipe</a>
        <a href="index.php" class="btn btn-secondary">Go to Home Page</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
