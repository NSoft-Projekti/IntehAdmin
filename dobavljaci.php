<?php

class dobavljaci{
    public $id_dobavljaci;
    public $ime_dobavljaca;

    public function select($id_dobavljaci){

        $query1=mysql_query("SELECT * FROM dobavljaci WHERE id_dobavljaci='$id_dobavljaci'");
        if($row=mysql_fetch_assoc($query1)){
            foreach($row as $key => $val)
            {
                $this->$key = $val;
            }
            return 1;
        }
        return 0;
    }
    public function delete($id_dobavljaci){

        return mysql_query("DELETE FROM dobavljaci WHERE id_dobavljaci='$id_dobavljaci'");
    }
    public function insert(){
        return mysql_query("INSERT INTO dobavljaci (ime_dobavljaca) VALUES ('"
            .$this->ime_dobavljaca."')");
    }
    public function update(){

        return	mysql_query("UPDATE dobavljaci SET
		ime_dobavljaca='$this->ime_dobavljaca'
		WHERE id_dobavljaci='$this->id_dobavljaci'");
    }
}
?>


