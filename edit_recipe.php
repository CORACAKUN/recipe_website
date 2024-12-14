<?php
include 'config.php';

if (isset($_GET['id'])) {
    // Fetch the recipe to be edited
    $recipe_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ?");
    $stmt->execute([$recipe_id]);
    $recipe = $stmt->fetch();


    $stmt_steps = $pdo->prepare("SELECT * FROM recipe_steps WHERE recipe_id = ? ORDER BY step_number");
    $stmt_steps->execute([$recipe_id]);
    $steps = $stmt_steps->fetchAll();
} else {
    header("Location: view_recipes.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update recipe title and description
    $title = $_POST['title'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("UPDATE recipes SET title = ?, description = ? WHERE id = ?");
    $stmt->execute([$title, $description, $recipe_id]);


    $step_descriptions = $_POST['step_description'];
    $step_images = $_FILES['step_image'];

    foreach ($step_descriptions as $index => $description) {
        $image_name = null;
        if (isset($step_images['tmp_name'][$index]) && $step_images['tmp_name'][$index] != '') {
            $image_name = time() . '_' . $_FILES['step_image']['name'][$index];
            $image_path = 'images/recipes/' . $image_name;

            if (move_uploaded_file($step_images['tmp_name'][$index], $image_path)) {
                $stmt_update_step = $pdo->prepare("UPDATE recipe_steps SET description = ?, image_path = ? WHERE recipe_id = ? AND step_number = ?");
                $stmt_update_step->execute([$description, $image_path, $recipe_id, $index + 1]);
            }
        } else {
            $stmt_update_step = $pdo->prepare("UPDATE recipe_steps SET description = ? WHERE recipe_id = ? AND step_number = ?");
            $stmt_update_step->execute([$description, $recipe_id, $index + 1]);
        }
    }


    header("Location: view_recipes.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit Recipe</h2>
        <form action="edit_recipe.php?id=<?php echo $recipe['id']; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Recipe Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $recipe['title']; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Recipe Description:</label>
                <textarea class="form-control" id="description" name="description" rows="4" required><?php echo $recipe['description']; ?></textarea>
            </div>

 
            <div id="steps-container">
                <?php foreach ($steps as $index => $step): ?>
                    <div class="form-group step">
                        <label for="step_description">Step <?php echo $index + 1; ?> Description:</label>
                        <textarea class="form-control" name="step_description[]" rows="2" required><?php echo $step['description']; ?></textarea>
                        <label for="step_image">Step <?php echo $index + 1; ?> Image:</label>
                        <input type="file" name="step_image[]" accept="image/*" class="form-control">
                        <?php if ($step['image_path']): ?>
                            <div>
                                <img src="<?php echo $step['image_path']; ?>" alt="Step <?php echo $index + 1; ?> Image" width="100">
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="button" id="add-step" class="btn btn-info">Add Another Step</button><br><br>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('add-step').addEventListener('click', function() {
            var stepCount = document.querySelectorAll('.step').length + 1;
            var stepHTML = `
                <div class="form-group step">
                    <label for="step_description">Step ${stepCount} Description:</label>
                    <textarea class="form-control" name="step_description[]" rows="2" required></textarea>
                    <label for="step_image">Step ${stepCount} Image:</label>
                    <input type="file" name="step_image[]" accept="image/*" class="form-control">
                </div>
            `;
            document.getElementById('steps-container').insertAdjacentHTML('beforeend', stepHTML);
        });
    </script>
</body>
</html>
