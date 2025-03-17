<?php
include 'includes/db.php';
include 'includes/auth.php';
require_login();

$stmt = $conn->prepare("SELECT id, name, description, price, image FROM menu");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Catering Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const menuId = this.getAttribute('data-menu-id');
                    const quantityInput = this.closest('.input-group').querySelector('.quantity-input');
                    const quantity = quantityInput.value;
                    if (quantity < 1) {
                        alert('Quantity must be at least 1');
                        return;
                    }
                    fetch('add_to_cart.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `menu_id=${menuId}&quantity=${quantity}`
                    })
                    .then(response => response.text())
                    .then(data => alert(data));
                });
            });
        });
    </script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="index.php">Catering Service</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5">
        <h2 class="text-center">Our Menu</h2>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="<?php echo $row['image'] ?: 'images/placeholder.jpg'; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                            <p class="card-text">Price: &#8377;<?php echo number_format($row['price'], 2); ?></p>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control quantity-input" value="1" min="1">
                                <button class="btn btn-success add-to-cart" data-menu-id="<?php echo $row['id']; ?>">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; $stmt->close(); ?>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>© 2024 Catering Service</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>