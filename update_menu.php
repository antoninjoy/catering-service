<?php
include 'includes/db.php';
include 'includes/auth.php';
require_admin();

if (isset($_GET['id'])) {
    $menu_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT name, description, price FROM menu WHERE id = ?");
    $stmt->bind_param("i", $menu_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $menu_item = $result->fetch_assoc();
    $stmt->close();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        $stmt = $conn->prepare("UPDATE menu SET name = ?, description = ?, price = ? WHERE id = ?");
        $stmt->bind_param("ssdi", $name, $description, $price, $menu_id);
        if ($stmt->execute()) {
            header('Location: admin_menu.php?message=Item updated successfully');
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    header('Location: admin_menu.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Menu Item - Catering Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Navigation Bar -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="index.php">Catering Service</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="admin_menu.php">Manage Menu</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Update Menu Form -->
    <main class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Update Menu Item</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Food Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($menu_item['name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"><?php echo htmlspecialchars($menu_item['description']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo $menu_item['price']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update Item</button>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>© 2024 Catering Service</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>