<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $title = $_POST['title'];
        $description = $_POST['description'];

        $stmt = $pdo->prepare("INSERT INTO recipes (title, description) VALUES (?, ?)");
        $stmt->execute([$title, $description]);

        $recipe_id = $pdo->lastInsertId();

        $step_descriptions = $_POST['step_description'];
        $step_images = $_FILES['step_image'];

        foreach ($step_descriptions as $index => $description) {
            $image_name = time() . '_' . $_FILES['step_image']['name'][$index];
            $image_path = 'images/recipes/' . $image_name;
            
            if (move_uploaded_file($step_images['tmp_name'][$index], $image_path)) {
                $stmt = $pdo->prepare("INSERT INTO recipe_steps (recipe_id, step_number, description, image_path) VALUES (?, ?, ?, ?)");
                $stmt->execute([$recipe_id, $index + 1, $description, $image_path]);
            }
        }

        header("Location: add_recipe.php?status=success");
        exit();
    } catch (Exception $e) {

        header("Location: add_recipe.php?status=error");
        exit();
    }
}
?>
