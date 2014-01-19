<?php
include 'model/artikli.php';
if($akcija=='izmjeni'){

    $art=new artikli();
    $art = request2db($art);
    $art->update();

}elseif($akcija=='prikazi'){

    $art=new artikli();
    $art->select($_REQUEST['id_artikli']);

}elseif($akcija=='izbrisi'){

    $art=new artikli();
    $art = request2db($art);
    $art->delete();

}elseif($akcija=='dodaj'){

    $art=new artikli();
    $art = request2db($art);
    $art->insert();
}
$query=mysql_query("SELECT * FROM artikli");
?>
<form action="index.php?stranica=pregled_stanje" method="POST">

    <table>
        <tr>
            <td>Naziv artikla</td>
            <td><input type="text" name="naziv_artikla" value="<?php echo $art->naziv_artikla; ?>">
                <input type="hidden" name="id_artikli" value="<?php echo $art->id_artikli; ?>"></td>
        </tr>
        <tr>
            <td>prodajna cijena</td>
            <td><input type="text" name="prodajna_cijena" value="<?php echo $art->prodajna_cijena; ?>"></td>
        </tr>
        <tr>
            <td>nabavna</td>
            <td><input type="text" name="nabavna_cijena" value="<?php echo $art->nabavna_cijena; ?>"></td>
        </tr>
        <tr>
            <td>stanje</td>
            <td><input type="text" name="stanje" value="<?php echo $art->stanje; ?>"></td>
        </tr>
    </table>
    <input type="submit" name="akcija" value="izmjeni">
    <input type="submit" name="akcija" value="dodaj">

</form>
<table>
    <tr>
        <td>Id Artikla</td>
        <td>Naziv Artikla</td>
        <td>Prodajna cijena</td>
        <td>Nabavna Cijena</td>
        <td>Stanje</td>
    </tr>
    <?php
    while($row=mysql_fetch_assoc($query)){
        ?>
        <tr>
            <td><?php echo $row['id_artikli'];?></td>
            <td><?php echo $row['naziv_artikla'];?></td>
            <td><?php echo $row['prodajna_cijena'];?></td>
            <td><?php echo $row['nabavna_cijena'];?></td>
            <td><?php echo $row['stanje'];?></td>
            <td><a href="index.php?stranica=pregled_stanje&akcija=prikazi&id_artikli=<?php echo $row['id_artikli']; ?>">Prikazi</a></td>
            <td><a href="index.php?stranica=pregled_stanje&akcija=izbrisi&id_artikli=<?php echo $row['id_artikli']; ?>">Izbrisi</a></td>
        </tr>
    <?php } ?>
</table>