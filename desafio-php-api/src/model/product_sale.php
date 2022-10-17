<?php
class ProductSale {
    public static function foreign_key() {
        return [
            'Sale' => 'sale_id',
            'Product' => 'product_id'
        ];
    }
}