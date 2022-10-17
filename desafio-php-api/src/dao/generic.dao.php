<?php
class GenericDAO {

    public static function executeQueryFetch(string $query){
        $db = Database::getConnection();
        $rs = $db->prepare($query);
        $rs->execute();
        return $rs->fetch(PDO::FETCH_ASSOC);
    } 
    
    public static function executeQuery(string $query){
        $db = Database::getConnection();
        $rs = $db->prepare($query);
        return $rs->execute();
    } 

    public static function findMaxIdFromTable(string $table){
        $db = Database::getConnection();
        $rs = $db->prepare('SELECT max(id) FROM "'.$table.'"');
        $rs->execute();
        $response = $rs->fetch(PDO::FETCH_ASSOC);
        
        return ((int) $response['max'])+1 ;
    } 

    public static function executeQueryFetchAll(string $query){
        $db = Database::getConnection();
        $rs = $db->prepare($query);
        $rs->execute();
        return $rs->fetchAll(PDO::FETCH_ASSOC);
    } 
    
    public static function joinColumnAll(array $foreing_key, array $obj){
        if(sizeof($foreing_key) > 0 && sizeof($obj) > 0){
            $array_aux = [];
            foreach ($foreing_key as $table => $foreing_key_name) {
                foreach ($obj as $item) {
                    if(!is_null($item[$foreing_key_name])){
                        $itemAux = GenericDAO::executeQueryFetch('SELECT * FROM "'.$table.'" WHERE id = '.$item[$foreing_key_name]);
                        $item[str_replace("_id", "", "$foreing_key_name")] = $itemAux;
                        unset($item[$foreing_key_name]);
                        foreach ($array_aux as $index => $array_aux_item) {
                            if($item['id'] == $array_aux_item['id']){
                                $item = $array_aux[$index];
                                unset($array_aux[$index]);
                                $item[str_replace("_id", "", "$foreing_key_name")] = $itemAux;
                                unset($item[$foreing_key_name]);
                            }
                        }
                    }

                    $array_aux[] = $item;
                }
            }
            $obj = $array_aux;
        } 
        return $obj;
    } 

    public static function joinColumn(array $foreing_key, array $obj){
        if(sizeof($foreing_key) > 0 && sizeof($obj) > 0){
            $array_aux = [];
            foreach ($foreing_key as $table => $foreing_key_name) {
                if(!is_null($obj[$foreing_key_name])){
                    $itemAux = GenericDAO::executeQueryFetch('SELECT * FROM "'.$table.'" WHERE id = '.$obj[$foreing_key_name]);
                    $obj[str_replace("_id", "", "$foreing_key_name")] = $itemAux;
                    unset($obj[$foreing_key_name]);
                    foreach ($array_aux as $index => $array_aux_item) {
                        if($obj['id'] == $array_aux_item['id']){
                            $obj = $array_aux[$index];
                            unset($array_aux[$index]);
                            $obj[str_replace("_id", "", "$foreing_key_name")] = $itemAux;
                            unset($obj[$foreing_key_name]);
                        }
                    }
                }
                $array_aux[] = $obj;
            }
            $obj = $array_aux;
        } 
        return $obj;
    } 
}