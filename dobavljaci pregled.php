<?php
include 'model/dobavljaci.php';
if($akcija=='izmjeni'){

    $dob=new dobavljaci();
    $dob = request2db($dob);
    $dob->update();

}elseif($akcija=='prikazi'){

    $dob=new dobavljaci();
    $dob->select($_REQUEST['id_dobavljaci']);

}elseif($akcija=='izbrisi'){

    $dob=new dobavljaci();
    $dob = request2db($dob);
    $dob->delete($_REQUEST['id_dobavljaci']);

}elseif($akcija=='dodaj'){

    $dob=new dobavljaci();
    $dob = request2db($dob);
    $dob->insert();
}
?>
<form action="index.php?stranica=pregled_dobavljaca" method="POST">

    <table>
        <tr>
            <td>Naziv artikla</td>
            <td><input type="text" name="ime_dobavljaca" value="<?php echo $dob->ime_dobavljaca; ?>">
                <input type="hidden" name="id_dobavljaci" value="<?php echo $dob->id_dobavljaci; ?>"></td>
        </tr>
    </table>
    <input type="submit" name="akcija" value="izmjeni">
    <input type="submit" name="akcija" value="dodaj">

</form>
<table>
    <tr>
        <td>Id Dobavljaca</td>
        <td>Ime Dobavljaca</td>
    </tr>
    <?php
    $query=mysql_query("SELECT * FROM dobavljaci");
    while($row=mysql_fetch_assoc($query)){
        ?>
        <tr>
            <td><?php echo $row['id_dobavljaci'];?></td>
            <td><?php echo $row['ime_dobavljaca'];?></td>
            <td><a href="index.php?stranica=pregled_dobavljaca&akcija=prikazi&id_dobavljaci=<?php echo $row['id_dobavljaci']; ?>">Prikazi</a></td>
            <td><a href="index.php?stranica=pregled_dobavljaca&akcija=izbrisi&id_dobavljaci=<?php echo $row['id_dobavljaci']; ?>">Izbrisi</a></td>
        </tr>
    <?php } ?>
</table>