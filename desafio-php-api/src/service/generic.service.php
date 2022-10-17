<?php
class GenericService {
    public static function validateResponse(ResponseDTO $response){
        if(is_null($response->message ?? null)){
            $response->success = true;
        } else {
            $response->success = false;
        }
        return json_encode($response);
    } 
}