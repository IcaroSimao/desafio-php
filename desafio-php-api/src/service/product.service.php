<?php

class ProductService {

    public function getAll(){
        $response = new ResponseDTO();
        try {
            $response->object = GenericDAO::joinColumnAll(Product::foreign_key(), GenericDAO::executeQueryFetchAll('SELECT * FROM "Product" ORDER BY id'));            
        } catch (\Exception $e) {
            $response->message = $e->getMessage();
        }
        echo GenericService::validateResponse($response);
    }

    public function getById($id){
        $response = new ResponseDTO();
        try {
            $response->object = GenericDAO::joinColumn(Product::foreign_key(), GenericDAO::executeQueryFetch('SELECT * FROM "Product" WHERE id = '.$id));
        } catch (\Exception $e) {
            $response->message = $e->getMessage();
        }
        echo GenericService::validateResponse($response);
    }

    public function insert($id, $body_request){
        $sql = 'INSERT INTO "Product"(id,name,quantity,producttype_id,price) VALUES ';
        $sql .= "({$id},'{$body_request['name']}',{$body_request['quantity']},{$body_request['type']},{$body_request['price']})";
        
        return GenericDAO::executeQuery($sql);
    }
    public function update($body_request){
        $sql = 'UPDATE "Product" SET ';
        foreach ($body_request as $key => $value) {
            if($key == 'type'){
                $sql .= ' producttype_id = \''.$value.'\',';
            }elseif($key != 'id'){
                $sql .= ' '.$key.' = \''.$value.'\',';
            }
        }
        $sql = substr($sql, 0, strlen($sql)-1);

        $sql .= ' WHERE id = '.$body_request['id'];
        
        return GenericDAO::executeQuery($sql);
    }

    public function save(){
        $response = new ResponseDTO();
        $validateService = new ValidateService();
        try {
            $id = GenericDAO::findMaxIdFromTable('Product');
                
            $_POST = json_decode(file_get_contents('php://input'), true);
            $body_request = $_POST;

            $messages = $validateService->productValidate($body_request);

            if(sizeof($messages) > 0){
                $msg_response = '';
                foreach ($messages as $message) {
                    $msg_response .= $message.', ';
                }
                throw new Exception(substr($msg_response, 0, strlen($msg_response)-2));
            }

            $body_request['price'] = str_replace(',', '.', $body_request['price']);

            if(isset($body_request['id'])){
                $this->update($body_request);
            } else {
                $this->insert($id, $body_request);
            }

        } catch (\Exception $e) {
            $response->message = $e->getMessage();
        }

        echo GenericService::validateResponse($response);
    }

    public function delete($id){
        $response = new ResponseDTO();
        try {
            $sql = 'DELETE FROM "Product" WHERE id = '. $id;
            
            if(!GenericDAO::executeQuery($sql)){
                $response->message = 'Erro ao excluir produto';
            };
        } catch (\Exception $e) {
            if($e->getCode() == 23503){
                $response->message = "Produto possui dependência com alguma venda!";
            } else {
                $response->message = $e->getMessage();
            }
            
        }

        echo GenericService::validateResponse($response);
    }
    
}