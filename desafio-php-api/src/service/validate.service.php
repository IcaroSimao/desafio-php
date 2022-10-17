<?php 
class ValidateService{
    public function productValidate($product){
        $messages = [];

        if(!isset($product)){
            $messages[] = "Produto não inicializado"; 
        }
        if(!isset($product['name']) || trim(strlen($product['name'])) == 0){
            $messages[] = "Nome obrigatório"; 
        }
        if(!isset($product['quantity']) || trim(strlen($product['quantity'])) == 0){
            $messages[] = "Quantidade obrigatório"; 
        }
        if(!isset($product['price']) || trim(strlen($product['price'])) == 0){
            $messages[] = "Preço obrigatório"; 
        }
        if(!isset($product['type']) || trim(strlen($product['type'])) == 0){
            $messages[] = "Tipo obrigatório"; 
        }

        if(sizeof($messages) > 0){
            return $messages;    
        }

        $messages = $this->productValuesValidate($product);

        return $messages;
    }

    private function productValuesValidate($product){
        $messages = [];
        if(strlen($product['name']) > 50){
            $messages[] = "Nome tamanho máximo 50 caracteres"; 
        }

        if(!$this->is_integer_($product['quantity'])){
            $messages[] = "Quantidade aceita somente numeros inteiros"; 
        }
        
        if(!$this->is_double_($product['price'])){
            $messages[] = "Preço aceita somente números"; 
        }

        return $messages;
    }

    public function productTypeValidate($producttype){
        $messages = [];

        if(!isset($producttype)){
            $messages[] = "Produto não inicializado"; 
        }
        if(!isset($producttype['name']) || trim(strlen($producttype['name'])) == 0){
            $messages[] = "Nome obrigatório"; 
        }
        if(!isset($producttype['tax']) || trim(strlen($producttype['tax'])) == 0){
            $messages[] = "Imposto obrigatório"; 
        }

        if(sizeof($messages) > 0){
            return $messages;    
        }

        $messages = $this->productTypeValuesValidate($producttype);

        return $messages;
    }

    private function productTypeValuesValidate($producttype){
        $messages = [];
        if(strlen($producttype['name']) > 50){
            $messages[] = "Nome tamanho máximo 50 caracteres"; 
        }
        
        if(!$this->is_double_($producttype['tax'])){
            $messages[] = "Imposto aceita somente números"; 
        } else {
            if($producttype['tax'] > 100){
                $messages[] = "Valor máximo de percentagem é 100";
            }
        }

        return $messages;
    }

    private function is_integer_($value){
        return is_integer($value) || (gettype($value) == 'string' && strlen($value) > 0 && ((int) $value) != 0);
    }

    private function is_double_($value){
        return is_double($value) || (gettype($value) == 'string' && strlen($value) > 0 && ((double) $value) != 0);
    }
}