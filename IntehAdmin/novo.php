<?php

require 'core.php';
require 'connect.php';

if(loggedin()){
    echo'you are logged in. <a href="logout.php">Log out</a>';
    echo'dobrodosao skladistar';
    echo'<a href="primka_nova.php">PRIMKA</a>
		 <a href="otpremnica_nova.php">OTPREMNICA</a>';

//PRIMKA
    if(isset($_POST['naziv_artikla']) || isset($_POST['nabavna_cijena']) || isset($_POST['kolicina']) || isset($_POST['ime_dobavljaca']) || isset($_POST['datum'])){

        $naziv_artikla=$_POST['naziv_artikla'];
        $nabavna_cijena=$_POST['nabavna_cijena'];
        $kolicina=$_POST['kolicina'];
        $ime_dobavljaca=$_POST['ime_dobavljaca'];
        $datum=$_POST['datum'];

        $skladistar=mysql_query("SELECT idkorisnici FROM korisnici WHERE idkorisnici=1 OR idkorisnici=2");
        $sk=mysql_fetch_assoc($skladistar);
        $x=$sk['idkorisnici'];

        $id_dobavljaca=mysql_query("SELECT iddobavljaci FROM dobavljaci WHERE naziv_dobavljaca='$ime_dobavljaca'");
        $do=mysql_fetch_assoc($id_dobavljaca);
        $y=$do['iddobavljaci'];

//UZIMANJE NAZIVA I POSTOJECEG STANJA IZ BAZE
        $vrati_artikal=mysql_query("SELECT naziv_artikla FROM artikli WHERE naziv_artikla='$naziv_artikla'");
        $stanje=mysql_query("SELECT stanje FROM artikli WHERE naziv_artikla='$naziv_artikla'");
        $naziv_artikla_array=mysql_fetch_assoc($vrati_artikal);
        $stanje_artikala_array=mysql_fetch_assoc($stanje);

//UPDATE I INSERT ARTIKALA U BAZI
        if($naziv_artikla_array && $stanje_artikala_array>=0){
            $novo_stanje=$stanje_artikala_array['stanje']+$kolicina;
            mysql_query("UPDATE artikli SET stanje='$novo_stanje' WHERE naziv_artikla='$naziv_artikla'");
            //mysql_query("INSERT INTO dobavljaci (naziv_dobavljaca) VALUES ('".$ime_dobavljaca."')");
            mysql_query("INSERT INTO dokument(tip_dokumenta_idtip_dokumenta, dobavljaci_iddobavljaci, korisnici_idkorisnici, datum_vrijeme) VALUES (1, '$y', '$x', '$datum')");

        }
        else{
            mysql_query("INSERT INTO artikli (naziv_artikla, nabavna_cijena, stanje) VALUES ('".$naziv_artikla."', '".$nabavna_cijena."', '".$kolicina."')");
            //mysql_query("INSERT INTO dobavljaci (naziv_dobavljaca) VALUES ('".$ime_dobavljaca."')");
            mysql_query("INSERT INTO dokument(tip_dokumenta_idtip_dokumenta, dobavljaci_iddobavljaci, korisnici_idkorisnici, datum_vrijeme) VALUES (1, '$y', '$x', '$datum')");
        }

//ZAVRSAVA PRIMKA
    }

//OTPREMNICA
    if(isset($_POST['naziv_artikla_otpremnica']) || isset($_POST['kolicina_otpremnica']) || isset($_POST['datum_otpremnica'])  || isset($_POST['ime_dobavljaca_otpremnica'])){

        $naziv_artikla_otpremnica=$_POST['naziv_artikla_otpremnica'];
        $kolicina_otpremnica=$_POST['kolicina_otpremnica'];
        $datum_otpremnica=$_POST['datum_otpremnica'];
        $ime_dobavljaca_otpremnica=$_POST['ime_dobavljaca_otpremnica'];

        $skladistar=mysql_query("SELECT idkorisnici FROM korisnici WHERE idkorisnici=1 OR idkorisnici=2");
        $s=mysql_fetch_assoc($skladistar);
        $k=$s['idkorisnici'];

        $id_dobavljaca=mysql_query("SELECT iddobavljaci FROM dobavljaci WHERE naziv_dobavljaca='$ime_dobavljaca_otpremnica'");
        $d=mysql_fetch_assoc($id_dobavljaca);
        $z=$d['iddobavljaci'];

//PREGLED STANJA SKLADISTA
        $artikal=mysql_query("SELECT naziv_artikla FROM artikli WHERE naziv_artikla='$naziv_artikla_otpremnica'");
        $stanje=mysql_query("SELECT stanje FROM artikli WHERE naziv_artikla='$naziv_artikla_otpremnica'");


//ISPIS ARTIKLA I STANJA NA SKLADISTU
        if(!empty($artikal) && $stanje>=0){
            while($list1=mysql_fetch_assoc($artikal)){
                while($list=mysql_fetch_assoc($stanje))
                {
                    $ispis1=$list1['naziv_artikla'];
                    $ispis=$list['stanje'];
                    echo $ispis1;
                    echo$ispis;
                }
            }
        }
//----------------------------------------------
//RACUNANJE OTPREMNICE
        $artikal=mysql_query("SELECT naziv_artikla FROM artikli WHERE naziv_artikla='$naziv_artikla_otpremnica'");
        $stanje=mysql_query("SELECT stanje FROM artikli WHERE naziv_artikla='$naziv_artikla_otpremnica'");
        $artikal_array=mysql_fetch_assoc($artikal);
        $stanje_artikala_array=mysql_fetch_assoc($stanje);
        if(!empty($artikal_array) && $stanje_artikala_array>=0){

            $stanje=$stanje_artikala_array['stanje']-$kolicina_otpremnica;
            mysql_query("UPDATE artikli SET stanje='$stanje' WHERE naziv_artikla='$naziv_artikla_otpremnica'");
            mysql_query("INSERT INTO dokument(tip_dokumenta_idtip_dokumenta, dobavljaci_iddobavljaci, korisnici_idkorisnici, datum_vrijeme) VALUES (2, '$z', '$k', '$datum_otpremnica')");
        }else{
            echo'nemate dovoljno artikala na stanju';
        }
    }
}else{
    include 'loginform.php';
}
?>




