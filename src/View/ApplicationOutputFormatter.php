<?php
declare(strict_types=1);
namespace WebShoppingApp\View;

use WebShoppingApp\Model\Product;

class ApplicationOutputFormatter
{
    public function productButtonsGenerator(Product $prod): string
    {
        return '<form action="/?mode=manage_price_list" method="post">'.
                '<input type="hidden" name="id" value="'.$prod->id().'">'.
                '<button type="submit" name="action" value="remove_product">Remove</button>'.
                '<button type="submit" name="action" value="update_product">Update</button>'.
                '</form>';
    }
}