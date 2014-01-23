<?php

class primka{
    public $id_primka;
    public $fk_dobavljaci;
    public $fk_korisnika_primka;
    public $datum_vrijeme;

    public function select($id_primka){

        $query1=mysql_query("SELECT * FROM primka WHERE id_primka='$id_primka'");
        if($row=mysql_fetch_assoc($query1)){
            foreach($row as $key => $val)
            {
                $this->$key = $val;
            }
            return 1;
        }
        return 0;
    }

    public function insert(){
        $sql="INSERT INTO primka (fk_dobavljaci, fk_korisnika_primka, datum_vrijeme) VALUES ('"
            .$this->fk_dobavljaci."', '"
            .$this->fk_korisnika_primka."', '"
            .$this->datum_vrijeme."')";

        $return = mysql_query ($sql);
        $this->id_primka=mysql_insert_id();
        return $return;

    }
    public function update(){

        return	mysql_query("UPDATE primka SET
		fk_dobavljaci='$this->fk_dobavljaci',
		fk_korisnika_primka='$this->fk_korisnika_primka',
		datum_vrijeme='$this->datum_vrijeme'
		WHERE id_primka='$this->id_primka'");

    }
}
?>


