

<form action="/pricelist-management.php" method="post" name="product">
    <input type="hidden" name="id" value="<?= $product->id(); ?>">
    <label>Product Name:
        <input type="text" name="name" size="20" value="<?= $product->name(); ?>">
    </label>
    <br>
    <label>Product description:
        <textarea name="description" cols="25" rows="2"><?= $product->description(); ?></textarea>
    </label>
    <br>
    <label>Product price:
        <input type="text" name="price" size="6" value="<?= $product->price(); ?>">
    </label>
    <br>
    <label>Quantity:
        <input type="text" name="quantity" size="6" value="<?= $product->quantity(); ?>">
    </label>
    <input type="hidden" name="store" value="yes"/>
    <br>
    <button type="submit" name="action" value="update_product" class="button small">Update product</button>
</form>
