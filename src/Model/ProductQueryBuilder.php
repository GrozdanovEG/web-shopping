<?php
declare(strict_types=1);
namespace WebShoppingApp\Model;

class ProductQueryBuilder
{
    protected string $mode;
    private array $allowed = ['select', 'insert', 'update', 'delete'];

    public function modifyQueryMode(string $mode): self
    {
        $mode = strtolower($mode);
        if (in_array($mode,$this->allowed)) $this->mode = $mode;
        return $this;
    }

    public function build(): string
    {
        $query['select'] = 'SELECT * FROM products WHERE visibility > 0';

        $query['select-item-by-id'] = 'SELECT * FROM products WHERE id = :id AND visibility > 0';

        $query['insert'] ='INSERT INTO products (id, name, description, price, quantity)
                           VALUES (:id, :name, :description, :price, :quantity)';

        $query['update'] = 'UPDATE products
                            SET  id = :id, name = :name, description = :description, price = :price, quantity = :quantity
                            WHERE id = :id';

        $query['delete'] = 'UPDATE products
                            SET  visibility = :visibility
                            WHERE id = :id';

        return $query[$this->mode];
    }

}