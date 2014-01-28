<?php
include 'model/otpremnica_model.php';
include 'model/stavke_otp_model.php';
include 'model/artikli.php';
$otpremnica_id=0;

$otpremnica=new otpremnica();

if($akcija=='kreiraj'){
    $otpremnica->fk_korisnika_otp=$_SESSION['user_id'];
    $datum=new DateTime('now');
    $otpremnica->datum_vrijeme = $datum->format('Y-m-d h:i:s');
    $otpremnica->fk_poslovnice=$_REQUEST['fk_poslovnice'];
    $otpremnica->insert();
    $otpremnica_id=$otpremnica->id_otpremnica;
}
elseif($akcija=='dodaj'){
    $stavke_otpremnice=new stavke_otpremnice();
    $stavke_otpremnice=request2db($stavke_otpremnice);
    $stavke_otpremnice->insert();
    $otpremnica_id=$_REQUEST['fk_otpremnice_st_otp'];
    $otpremnica->select($otpremnica_id);

}
elseif($akcija=='izbrisi_stavku_otpremnice'){
    $stavke_otpremnice=new stavke_otpremnice();
    $stavke_otpremnice = request2db($stavke_otpremnice);
    $stavke_otpremnice->delete($_REQUEST['id_st_otp']);
    $otpremnica_id=$_REQUEST['otpremnica_id'];
    $otpremnica->select($otpremnica_id);
}elseif($akcija=='uradi_otpremnicu'){

    $otpremnica_id=$_REQUEST['fk_otpremnice_st_otp'];
    $otpremnica->select($otpremnica_id);

    $query=mysql_query("SELECT *
		FROM `stavke_otpremnice` s
		WHERE fk_otpremnice_st_otp='$otpremnica_id'");

    while($row=mysql_fetch_assoc($query)){
        $artikal=new artikli();
        $artikal->select($row['fk_artikla']);
        $artikal->stanje=$artikal->stanje-$row['kolicina_otpremnice'];
        $artikal->update();
    }

}
?>

<form method="POST" action="index.php">
    <table>
        <tr><p>Morate odabrati poslovnicu da bi kreirali novu primku</p></tr>
        <tr>
            <td>Ime poslovnice</td><td>

                <select name="fk_poslovnice" >
                    <option value="0">--Select--</option>
                    <?php
                    $getNazivPoslovnice = mysql_query("SELECT * FROM poslovnice");
                    while($viewAllPoslovnice=mysql_fetch_array($getNazivPoslovnice)){

                        ?>
                        <option value="<?php echo $viewAllPoslovnice['id_poslovnice']; ?>"><?php echo $viewAllPoslovnice['naziv_poslovnice']; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Korisnik kreirao</td>
            <td><?php echo $_SESSION['user_id']; ?></td>
        </tr>
        <tr>
            <td>Datum i vrijeme:</td>
            <td><?php echo $otpremnica->datum_vrijeme; ?></td>
        </tr>
        <tr>
            <td></td>
            <td><?php if($otpremnica_id==0){?><input type="submit" value="kreiraj" name="akcija"><?php }?></td>
        </tr>
    </table>
</form>

<form method="POST" action="index.php">
    <table>
        <tr>
            <p>OVDJE UNESITE STAVKE otpremnice</p>
        </tr>
        <tr>
            <td>Kolicina</td><td>
                <input type="text" name="kolicina_otpremnice">
            </td>

        </tr>
        <tr>
            <td>Artikal <input type="hidden" name="fk_otpremnice_st_otp" value="<?php echo $otpremnica_id; ?>"></td>
            <td>
                <select name="fk_artikla" >
                    <option value="0">--Select--</option>
                    <?php
                    $getNazivArtikla = mysql_query("SELECT * FROM artikli");
                    while($viewAllArtikli=mysql_fetch_array($getNazivArtikla)){

                        ?>
                        <option value="<?php echo $viewAllArtikli['id_artikli']; ?>"><?php echo $viewAllArtikli['naziv_artikla']; ?></option>
                    <?php } ?>

                </select>
            </td>

        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="dodaj" name="akcija"></td>
        </tr>
    </table>
</form>

<form action="index.php" method="POST">
    <table>
        <tr>
            <td>Id Stavke primke</td>
            <td>Id Artikla</td>
            <td>Naziv Artikla</td>
            <td>Kolicina</td>
            <td>Nabavna Cijena</td>
        </tr>
        <?php
        $query=mysql_query("SELECT *
FROM `stavke_otpremnice` s,artikli a
WHERE s.fk_artikla = a.id_artikli AND fk_otpremnice_st_otp='$otpremnica_id'");

        while($row=mysql_fetch_assoc($query)){
            ?>
            <tr>
                <td><?php echo $row['id_st_otp'];?></td>
                <td><?php echo $row['fk_artikla'];?></td>
                <td><?php echo $row['naziv_artikla'];?></td>
                <td><?php echo $row['kolicina_otpremnice'];?></td>
                <td><a href="index.php?stranica=otpremnica&akcija=izbrisi_stavku_otpremnice&id_st_otp=<?php echo $row['id_st_otp']; ?>&otpremnica_id=<?php echo $otpremnica_id; ?>">Izbrisi</a></td>
            </tr>
        <?php } ?>
    </table>

    <input type="hidden" name="fk_otpremnice_st_otp" value="<?php echo $otpremnica_id; ?>">

    <input type="submit" name="akcija" value="uradi_otpremnicu">
</form>












