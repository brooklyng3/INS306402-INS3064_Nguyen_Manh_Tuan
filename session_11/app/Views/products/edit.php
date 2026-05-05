<!-- app/Views/products/edit.php -->

<div style="max-width: 500px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">Edit Product</h2>
        <a href="/products" style="color: #666; text-decoration: none; font-size: 0.9em;">&larr; Back to List</a>
    </div>

    <form action="/products/edit" method="POST">
        
        <input type="hidden" name="id" value="<?= htmlspecialchars($product['id'] ?? '') ?>">
        
        <div style="margin-bottom: 15px;">
            <label for="name" style="display: block; font-weight: bold; margin-bottom: 5px;">Product Name</label>
            <input type="text" id="name" name="name" 
                   value="<?= htmlspecialchars($product['name'] ?? '') ?>" 
                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
            
            <?php if (isset($errors['name'])): ?>
                <span style="color: #dc3545; font-size: 0.85em; display: block; margin-top: 5px;">
                    <?= $errors['name'] ?>
                </span>
            <?php endif; ?>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="price" style="display: block; font-weight: bold; margin-bottom: 5px;">Price ($)</label>
            <input type="number" step="0.01" id="price" name="price" 
                   value="<?= htmlspecialchars($product['price'] ?? '') ?>" 
                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
            
            <?php if (isset($errors['price'])): ?>
                <span style="color: #dc3545; font-size: 0.85em; display: block; margin-top: 5px;">
                    <?= $errors['price'] ?>
                </span>
            <?php endif; ?>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
            <a href="/products" style="padding: 10px 15px; background: #eee; color: #333; text-decoration: none; border-radius: 4px; font-weight: bold;">Cancel</a>
            <button type="submit" style="padding: 10px 20px; background: #0056b3; color: #fff; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Update Product</button>
        </div>
        
    </form>
</div>