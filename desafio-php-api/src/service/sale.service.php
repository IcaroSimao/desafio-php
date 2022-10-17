<?php

class SaleService {
    public function getAll(){
        $response = new ResponseDTO();
        try {
            $response->object = GenericDAO::executeQueryFetchAll('SELECT * FROM "Sale" ORDER BY "createdAt" DESC');
        } catch (\Exception $e) {
            $response->message = $e->getMessage();
        }
        
        echo GenericService::validateResponse($response);
    }

    public function getById($id){
        $response = new ResponseDTO();
        try {
            $response->object = GenericDAO::executeQueryFetch('SELECT * FROM "Sale" WHERE id = '.$id);
            $response->object['products'] = $this->getProductsOfSale($id);
        } catch (\Exception $e) {
            $response->message = $e->getMessage();
        }
        echo GenericService::validateResponse($response);
    }

    private function getProductsOfSale($sale_id, $totalQuantity = false){
        try {
            $sale_products = GenericDAO::joinColumnAll(ProductSale::foreign_key(), GenericDAO::executeQueryFetchAll('SELECT * FROM "Product_Sale" WHERE sale_id = '.$sale_id));
            $products = [];
            foreach ($sale_products as $sp) {
                if($totalQuantity){
                    $sp['product']['totalQuantity'] = $sp['product']['quantity'];
                }
                $sp['product']['quantity'] = $sp['quantity'];
                unset($sp['product']['producttype_id']);
                unset($sp['product']['price']);
                $products[] = $sp['product'];
            }
            return $products;

        } catch (\Exception $e) {
            return null;
        }
        return null;
    }

    public function save($data){
        $response = new ResponseDTO();
        
        try {
            $id = GenericDAO::findMaxIdFromTable('Sale');
            $_POST = json_decode(file_get_contents('php://input'), true);
            $data = $_POST;
            
            $totalValue = $this->sumTotal($data);
            $totalTax = $this->sumTotalTax($data);
            $quantityItems = $this->sumQuantityItems($data);

            $timestamp = date('Y-m-d H:i:s');

            $sql = 'INSERT INTO "Sale"(id,"quantityItems","totalValue","totalTax","createdAt") VALUES ';
            $sql .= "({$id},'{$quantityItems}',{$totalValue},{$totalTax}, '{$timestamp}')";
            
            if(!GenericDAO::executeQuery($sql)){
                $response->message = 'Erro ao cadastrar venda';
            } else {
                $this->saveProduct_Sale($id, $data);
                $products = GenericDAO::joinColumnAll(Product::foreign_key(), GenericDAO::executeQueryFetchAll('SELECT * FROM "Product"'));

                foreach ($data as $product) {
                    foreach ($products as $p) {
                        if($p['id'] == $product['id']){
                            $sql = 'UPDATE "Product" SET "quantity" = '.(((int)$p['quantity'])-((int)$product['quantity']));
                            $sql .= ' WHERE id = '. $product['id'];
                            GenericDAO::executeQuery($sql);
                        }
                    }
                }
            };
        } catch (\Exception $e) {
            $response->message = $e->getMessage();
        }

        echo GenericService::validateResponse($response);
    }

    public function delete($id){
        $response = new ResponseDTO();
            
        try {

            $products = $this->getProductsOfSale($id, true);
            foreach ($products as $name => $product) {
                $sql = 'UPDATE "Product" SET "quantity" = '.(((int)$product['quantity'])+((int)$product['totalQuantity']));
                $sql .= ' WHERE id = '. $product['id'];
                GenericDAO::executeQuery($sql);
            }

            GenericDAO::executeQuery('DELETE FROM "Product_Sale" WHERE sale_id = '. $id);
            GenericDAO::executeQuery('DELETE FROM "Sale" WHERE id = '. $id);
        } catch (\Exception $e) {
            $response->message = $e->getMessage();
        }

        echo GenericService::validateResponse($response);
    }

    private function sumTotal(array $products){
        $total = 0.0;
        foreach ($products as $product) {
            $total += ($product['quantity'] * $product['price']);
        }
        return $total + $this->sumTotalTax($products);
    }
    private function sumTotalTax(array $products){
        $total = 0.0;
        foreach ($products as $product) {
            $total += $product['quantity'] * ($product['price'] * $product['producttype']['tax'] / 100);
        }
        return $total;
    }
    private function sumQuantityItems(array $products){
        $total = 0.0;
        foreach ($products as $product) {
            $total += $product['quantity'];
        }
        return $total;
    }
    private function saveProduct_Sale($sale_id, array $products){
        $success = false;
        try {
            $id = GenericDAO::findMaxIdFromTable('Product_Sale');
            
            $sql = 'INSERT INTO "Product_Sale"(id,sale_id,product_id,quantity) VALUES ';
            foreach ($products as $product) {
                // // DAO
                $sql .= "({$id},'{$sale_id}',{$product['id']},{$product['quantity']}),";
                $id++;
            }
            $sql = substr($sql,0,strlen($sql)-1);

            if(GenericDAO::executeQuery($sql)){
                 $success = true;
            };

        } catch (\Exception $e) {
            $success = false;
        }
    }
    
}