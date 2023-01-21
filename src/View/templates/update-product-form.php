

<form action="/" method="post" name="product">
    <input type="hidden" name="id" value="<?= $product->id(); ?>">
    <label>Product Name:
        <input type="text" name="name" size="20" value="<?= $product->name(); ?>">
    </label>
    <br>
    <label>Product description:
        <input type="text" name="description" size="40" value="<?= $product->description(); ?>">
    </label>
    <br>
    <label>Product price:
        <input type="text" name="price" size="6" value="<?= $product->price(); ?>">
    </label>
    <br>
    <label>Quantity:
        <input type="text" name="quantity" size="6" value="<?= $product->quantity(); ?>">
    </label>
    <br>
    <input type="submit" name="action" value="update_product" class="button small">
</form>
