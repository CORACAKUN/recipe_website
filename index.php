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
    <title>Recipes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>


  
    </style>
</head>
<body>
    <header class="fixed-header bg-dark text-white py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3 m-0" >Recipe Website</h1>
            <!-- Navigation -->
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a href="index.php" class="nav-link text-white">Home</a></li>
                    <li class="nav-item"><a href="add_recipe.php" class="nav-link text-white">Add Recipe</a></li>
                    <li class="nav-item"><a href="view_recipes.php" class="nav-link text-white">View Recipes</a></li>
                    <li class="nav-item"><a href="contact.php" class="nav-link text-white">Contact Us</a></li>
                </ul>
            </nav>
        </div>
    </header>
<main>
<div class="container">
        <h2 class="text-center mb-4" style="margin-top: 20px;">Recipes</h2>
        <?php foreach ($recipes as $recipe): ?>
            <div class="recipe card mb-4 p-3">
                <h3><?php echo $recipe['title']; ?></h3>
                <p><?php echo $recipe['description']; ?></p>

                <h4>Steps:</h4>
                <?php
                $stmt = $pdo->prepare("SELECT * FROM recipe_steps WHERE recipe_id = ?");
                $stmt->execute([$recipe['id']]);
                $steps = $stmt->fetchAll();
                ?>
                <ul class="list-unstyled">
                    <?php foreach ($steps as $step): ?>
                        <li>
                            <p><?php echo $step['description']; ?></p>
                            <img src="<?php echo $step['image_path']; ?>" alt="Step Image" class="img-fluid">
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</main>


    <footer class="footer">
        <div class="container">
            <p class="m-0">&copy; 2024 Recipe Website. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
