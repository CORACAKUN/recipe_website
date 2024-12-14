<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    
    <div id="addMain" class="container mt-5">
        <h2 class="text-center mb-4" >Add New Recipe</h2>
        <form action="save_recipe.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Recipe Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Recipe Description:</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>

            <!-- Recipe Steps -->
            <div id="steps-container">
                <div class="form-group step">
                    <label for="step_description">Step 1 Description:</label>
                    <textarea class="form-control" name="step_description[]" rows="2" required></textarea>
                    <label for="step_image">Step 1 Image:</label>
                    <input type="file" name="step_image[]" accept="image/*" class="form-control" required>
                </div>
            </div>

            <button type="button" id="add-step" class="btn btn-info">Add Another Step</button><br><br>
            <button type="submit" class="btn btn-primary">Submit Recipe</button>
            <a href="index.php" class="btn btn-secondary">Home</a>
        </form>
    </div>

    <!-- Modal for Success/Error -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Operation Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalMessage">
                    <!-- Message will be inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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
                    <input type="file" name="step_image[]" accept="image/*" class="form-control" required>
                </div>
            `;
            document.getElementById('steps-container').insertAdjacentHTML('beforeend', stepHTML);
        });

        
    </script>
</body>
</html>
