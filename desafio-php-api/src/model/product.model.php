<?php
class Product {
    private $id;
    private $name;
    private $quantity;
    private $producttype_id;
    private $image;

    public function get_id(){
        return $this->id;
    }
    public function set_id($id){
        $this->id = $id;
    }
    public function get_name(){
        return $this->name;
    }
    public function set_name($name){
        $this->name = $name;
    }
    public function get_quantity(){
        return $this->quantity;
    }
    public function set_quantity($quantity){
        $this->quantity = $quantity;
    }
    public function get_producttype_id(){
        return $this->producttype_id;
    }
    public function set_producttype_id($producttype_id){
        $this->producttype_id = $producttype_id;
    }
    public function get_image(){
        return $this->image;
    }
    public function set_image($image){
        $this->image = $image;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'producttype_id' => $this->producttype_id,
            'image' => $this->image
        ];
    }
    public static function foreign_key() {
        return [
            'ProductType' => 'producttype_id'
        ];
    }
}