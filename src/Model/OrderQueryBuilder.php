<?php
declare(strict_types=1);
namespace WebShoppingApp\Model;


class OrderQueryBuilder
{

    protected string $mode;
    private array $allowed = ['select', 'select-item-by-id', 'insert', 'insert-item'];

    public function modifyQueryMode(string $mode): self
    {
        $mode = strtolower($mode);
        if (in_array($mode,$this->allowed)) $this->mode = $mode;
        return $this;
    }

    public function build(): string
    {
        $query['select'] =<<<SELECTALL
                SELECT  oi.*, orders.total, orders.completed_at
                   FROM order_items AS oi 
                   JOIN  orders
                   ON oi.order_id = orders.id
                   WHERE (orders.visibility > 0 AND oi.visibility > 0)
                   ORDER BY orders.completed_at;
                SELECTALL;

        $query['select-item-by-id'] =<<<SELECTED
                SELECT  oi.*, prod.name, orders.total, orders.completed_at
                   FROM order_items AS oi 
                   JOIN  orders
                   ON oi.order_id = orders.id
                   JOIN products AS prod
                   ON  oi.product_id = prod.id
                   WHERE oi.order_id = :id  AND (orders.visibility > 0 AND oi.visibility > 0)
                   ORDER BY orders.completed_at;
                SELECTED;

        $query['insert'] =<<<ORDER
                INSERT INTO orders (id, total, completed_at)
                     VALUES
                     ( :order_id, :total, :completed_at );
                ORDER;

        $query['insert-item'] =<<<ITEM
                INSERT INTO order_items  (order_id, product_id, quantity, price)
                    VALUES
                    (:order_id, :product_id, :quantity, :price);
                ITEM;

        return $query[$this->mode];
    }


}