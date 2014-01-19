<?php

class artikli{
    public $id_artikli;
    public $naziv_artikla;
    public $prodajna_cijena;
    public $nabavna_cijena;
    public $stanje;

    public function select($id_artikli){

        $query1=mysql_query("SELECT * FROM artikli WHERE id_artikli='$id_artikli'");
        if($row=mysql_fetch_assoc($query1)){
            foreach($row as $key => $val)
            {
                $this->$key = $val;
            }
            return 1;
        }
        return 0;

    }
    public function delete(){

        return mysql_query("DELETE * FROM artikli WHERE id_artikli='$id_artikli'");
    }
    public function insert(){
        return mysql_query("INSERT INTO artikli (naziv_artikla, prodajna_cijena, nabavna_cijena, stanje) VALUES ('"
            .$this->naziv_artikla."', '"
            .$this->prodajna_cijena."', '"
            .$this->nabavna_cijena."', '"
            .$this->stanje."')");

    }
    public function update(){

        return	mysql_query("UPDATE artikli SET
		naziv_artikla='$this->naziv_artikla',
		prodajna_cijena='$this->prodajna_cijena',
		nabavna_cijena='$this->nabavna_cijena',
		stanje='$this->stanje'
		WHERE id_artikli='$this->id_artikli'");

    }
}
?>


