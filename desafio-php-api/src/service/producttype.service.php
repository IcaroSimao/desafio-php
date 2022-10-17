<?php

class ProductTypeService {
    public function getAll(){
        $response = new ResponseDTO();
        try {
            $response->object = GenericDAO::executeQueryFetchAll('SELECT * FROM "ProductType" ORDER BY id');
        } catch (\Exception $e) {
            $response->message = $e->getMessage();
        }
        echo GenericService::validateResponse($response);
    }

    public function getById($id){
        $response = new ResponseDTO();
        try {
            $response->object = GenericDAO::executeQueryFetchAll('SELECT * FROM "ProductType" WHERE id = '.$id);;
        } catch (\Exception $e) {
            $response->message = $e->getMessage();
        }
        echo GenericService::validateResponse($response);
    }

    public function insert($id, $data){
        $sql = 'INSERT INTO "ProductType"(id,name,tax) VALUES ';
        $sql .= "({$id},'{$data['name']}',{$data['tax']})";
        
        return GenericDAO::executeQuery($sql);
    }

    public function update($data){
        $sql = 'UPDATE "ProductType" SET ';
        foreach ($data as $key => $value) {
            if($key != 'id'){
                $sql .= ' '.$key.' = \''.$value.'\',';
            }
        }
        $sql = substr($sql, 0, strlen($sql)-1);

        $sql .= ' WHERE id = '.$data['id'];
        
        return GenericDAO::executeQuery($sql);
    }

    public function save($data){
        $response = new ResponseDTO();
        $validateService = new ValidateService();
        
        try {
            $id = GenericDAO::findMaxIdFromTable('ProductType');
            
            $_POST = json_decode(file_get_contents('php://input'), true);
            $data = $_POST;

            $messages = $validateService->productTypeValidate($data);

            if(sizeof($messages) > 0){
                $msg_response = '';
                foreach ($messages as $message) {
                    $msg_response .= $message.', ';
                }
                throw new Exception(substr($msg_response, 0, strlen($msg_response)-2));
            }
                
            if(isset($data['id'])){
                $this->update($data);
            } else {
                $this->insert($id, $data);
            }

        } catch (\Exception $e) {
            $response->message = $e->getMessage();
        }

        echo GenericService::validateResponse($response);
    }

    public function delete($id){
        $response = new ResponseDTO();
        try {
            $sql = 'DELETE FROM "ProductType" WHERE id = '. $id;
            
            if(!GenericDAO::executeQuery($sql)){
                $response->message = 'Erro ao excluir tipo';
            };
        } catch (\Exception $e) {
            if($e->getCode() == 23503){
                $response->message = "Tipo possui dependência com algum produto!";
            } else {
                $response->message = $e->getMessage();
            }
        }

        echo GenericService::validateResponse($response);
    }
    
}