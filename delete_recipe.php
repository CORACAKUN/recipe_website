<?php
include 'config.php';

if (isset($_GET['id'])) {
    $recipe_id = $_GET['id'];

    try {
        // Begin transaction
        $pdo->beginTransaction();

        // First, delete all associated steps
        $stmt_steps = $pdo->prepare("DELETE FROM recipe_steps WHERE recipe_id = ?");
        $stmt_steps->execute([$recipe_id]);

        // Then, delete the recipe
        $stmt_recipe = $pdo->prepare("DELETE FROM recipes WHERE id = ?");
        $stmt_recipe->execute([$recipe_id]);

        // Commit the transaction
        $pdo->commit();

        // Redirect or show success message
        header("Location: view_recipes.php");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction if an error occurs
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: view_recipes.php");
    exit();
}
?>
