<?php

class stavke_otpremnice{

    public $id_st_otp;
    public $kolicina_otpremnice;
    public $fk_artikla;
    public $fk_otpremnice_st_otp;
    public $fk_korisnika_st_otp;
    public $fk_poslovnice_st_otp;

    public function select($id_st_otp){

        $query1=mysql_query("SELECT * FROM stavke_otpremnice WHERE id_st_otp='$id_st_otp'");
        if($row=mysql_fetch_assoc($query1)){
            foreach($row as $key => $val)
            {
                $this->$key = $val;
            }
            return 1;
        }
        return 0;
    }

    public function delete($id_st_otp){

        return mysql_query("DELETE FROM stavke_otpremnice WHERE id_st_otp='$id_st_otp'");
    }
    public function insert(){
        return mysql_query("INSERT INTO stavke_otpremnice (kolicina_otpremnice, fk_artikla, fk_otpremnice_st_otp, fk_korisnika_st_otp, fk_poslovnice_st_otp) VALUES ('"
            .$this->kolicina_otpremnice."', '"
            .$this->fk_artikla."', '"
            .$this->fk_otpremnice_st_otp."',1,1)");
    }
    public function update(){

        return	mysql_query("UPDATE stavke_otpremnice SET
		kolicina_otpremnice='$this->kolicina_otpremnice', 
		fk_artikla='$this->fk_artikla', 
		fk_otpremnice_st_otp='$this->fk_otpremnice_st_otp', 
		fk_korisnika_st_otp='$this->fk_korisnika_st_otp', 
		fk_poslovnice_st_otp='$this->fk_poslovnice_st_otp' 
		WHERE id_st_otp='$this->id_st_otp'");
    }
}
?>