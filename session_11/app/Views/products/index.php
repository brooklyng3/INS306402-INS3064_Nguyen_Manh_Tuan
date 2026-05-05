<!-- app/Views/products/index.php -->

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Inventory List</h2>
    <a href="/products/create" style="background: #28a745; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-weight: bold;">+ Add Product</a>
</div>

<table style="width: 100%; border-collapse: collapse; margin-top: 10px; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <thead>
        <tr style="background-color: #f4f4f9; border-bottom: 2px solid #ddd; text-align: left;">
            <th style="padding: 12px;">ID</th>
            <th style="padding: 12px;">Product Name</th>
            <th style="padding: 12px;">Price</th>
            <th style="padding: 12px; text-align: center;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px;"><?= htmlspecialchars($product['id']) ?></td>
                    <td style="padding: 12px;"><?= htmlspecialchars($product['name']) ?></td>
                    <td style="padding: 12px;">$<?= htmlspecialchars(number_format($product['price'], 2)) ?></td>
                    
                    <td style="padding: 12px; text-align: center;">
                        <a href="/products/edit?id=<?= htmlspecialchars($product['id']) ?>" style="color: #0056b3; text-decoration: none; margin-right: 15px; font-weight: bold;">Edit</a>

                        <form action="/products/delete" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
                            <button type="submit" style="background: none; border: none; color: #dc3545; font-weight: bold; cursor: pointer; text-decoration: underline; font-size: 1em;">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" style="padding: 20px; text-align: center; color: #666;">No products found in the database. Try adding one!</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>