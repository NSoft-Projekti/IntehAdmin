<?php
include 'model/primka_model.php';
include 'model/stavke_primke_model.php';

if($akcija=='kreiraj'){
    $primka=new primka();
    $primka->fk_korisnika_primka=$_SESSION['user_id'];
    $datum=new DateTime('now');
    $primka->datum_vrijeme = $datum->format('Y-m-d h:i:s');
    $primka->fk_dobavljaci=$_REQUEST['fk_dobavljaci'];
    $primka->insert();
    $primka_id=$primka->id_primka;
}
elseif($akcija=='dodaj'){
    $stavke_primke=new stavke_primke();
    $stavke_primke=request2db($stavke_primke);
    $stavke_primke->insert();
    $primka_id=$_REQUEST['fk_primke'];
}
elseif($akcija=='izbrisi_stavku_primke'){
    $stavke_primke=new stavke_primke();
    $stavke_primke = request2db($stavke_primke);
    $stavke_primke->delete($_REQUEST['id_stavke_primke']);
}
?>

<form type="POST" action="index.php">
    <table>

        <tr>
            <td>Ime dobavljaca</td><td>

                <select name="fk_dobavljaci" >
                    <option value="0">--Select--</option>
                    <?php
                    $getNazivDobavljaca = mysql_query("SELECT * FROM dobavljaci");
                    while($viewAllDobavljaci=mysql_fetch_array($getNazivDobavljaca)){

                        ?>
                        <option value="<?php echo $viewAllDobavljaci['id_dobavljaci']; ?>"><?php echo $viewAllDobavljaci['ime_dobavljaca']; ?></option>
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
            <td><?php echo $primka->datum_vrijeme; ?></td>

        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="kreiraj" name="akcija"></td>

        </tr>
        <tr>
            <td></td>
            <td></td>

        </tr>


    </table>
</form>

<form type="POST" action="index.php">
    <table>

        <tr>
            <td>Kolicina</td><td>
                <input type="text" name="kolicina_primke">
            </td>

        </tr>
        <tr>
            <td>Artikal <input type="hidden" name="fk_primke" value="<?php echo $primka_id; ?>"></td>
            <td>
                <select name="fk_artikla_st_pr" >
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
            <td>Datum i vrijeme</td>
            <td></td>

        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="dodaj" name="akcija"></td>

        </tr>
        <tr>
            <td></td>
            <td></td>

        </tr>


    </table>
</form>


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
FROM `stavke_primke` s,artikli a
WHERE s.fk_artikla_st_pr = a.id_artikli AND fk_primke='$primka_id'");

    while($row=mysql_fetch_assoc($query)){
        ?>
        <tr>
            <td><?php echo $row['id_stavke_primke'];?></td>
            <td><?php echo $row['fk_artikla_st_pr'];?></td>
            <td><?php echo $row['naziv_artikla'];?></td>
            <td><?php echo $row['kolicina_primke'];?></td>
            <td><?php echo $row['nabavna_cijena'];?></td>
            <td><a href="index.php?stranica=primka&akcija=izbrisi_stavku_primke&id_stavke_primke=<?php echo $row['id_stavke_primke']; ?>">Izbrisi</a></td>
        </tr>
    <?php } ?>
</table>