<?php

class otpremnica{

    public $id_otpremnica;
    public $fk_korisnika_otp;
    public $fk_poslovnice;
    public $datum_vrijeme;

    public function select($id_otpremnica){

        $query1=mysql_query("SELECT * FROM otpremnica WHERE id_otpremnica='$id_otpremnica'");
        if($row=mysql_fetch_assoc($query1)){
            foreach($row as $key => $val)
            {
                $this->$key = $val;
            }
            return 1;
        }
        return 0;
    }

    public function delete($id_otpremnica){

        return mysql_query("DELETE FROM otpremnica WHERE id_otpremnica='$id_otpremnica'");
    }
    public function insert(){
        $sql="INSERT INTO otpremnica (id_otpremnica, fk_korisnika_otp, fk_poslovnice, datum_vrijeme) VALUES ('"
            .$this->id_otpremnica."', '"
            .$this->fk_korisnika_otp."', '"
            .$this->fk_poslovnice."','"
            .$this->datum_vrijeme."')";


        $return = mysql_query ($sql);
        $this->id_otpremnica=mysql_insert_id();
        return $return;
    }
    public function update(){

        return	mysql_query("UPDATE otpremnica SET
		fk_korisnika_otp='$this->fk_korisnika_otp',
		fk_poslovnice='$this->fk_poslovnice',
		datum_vrijeme='$this->datum_vrijeme'
		WHERE id_otpremnica='$this->id_otpremnica'");
    }
}
?>