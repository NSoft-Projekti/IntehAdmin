<?php

class stavke_primke{
    public $id_stavke_primke;
    public $kolicina_primke;
    public $fk_artikla_st_pr;
    public $fk_primke;

    public function select($fk_artikla_st_pr){

        $query1=mysql_query("SELECT * FROM stavke_primke WHERE id_stavke_primke='$id_stavke_primke'");
        if($row=mysql_fetch_assoc($query1)){
            foreach($row as $key => $val)
            {
                $this->$key = $val;
            }
            return 1;
        }
        return 0;
    }

    public function delete($id_stavke_primke){

        return mysql_query("DELETE FROM stavke_primke WHERE id_stavke_primke='$id_stavke_primke'");
    }
    public function insert(){
        $sql="INSERT INTO stavke_primke (kolicina_primke, fk_artikla_st_pr, fk_primke, fk_dobavljaca_st_pr, fk_korisnika_st_pr) VALUES ('"
            .$this->kolicina_primke."', '"
            .$this->fk_artikla_st_pr."', '"
            .$this->fk_primke."',1,1)";
        echo $sql;
        return mysql_query ($sql);


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


