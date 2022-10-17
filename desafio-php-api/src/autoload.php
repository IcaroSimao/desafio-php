<?php
class Autoload {
    public function __construct()
    {
        $folders = scandir(__DIR__."\\");
        foreach ($folders as $folderName) {
            if(!in_array($folderName, ['.', '..'])){
                if($this->is_folder($folderName)){
                    $files = $folders = scandir(__DIR__."\\".$folderName);
                    foreach ($files as $filename) {
                        if(!in_array($filename, ['.', '..'])){
                            include_once __DIR__."\\".$folderName.'\\'.$filename;
                        }
                    }
                }
            }
        }
    }

    private function is_folder($name){
        $str_exploded = explode('.', $name);
        return $str_exploded[sizeof($str_exploded)-1] != 'php';
    }
}