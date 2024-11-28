<?php

include "koneksi.php";

function tampil($sql)
{
    global $koneksi;
    $hasil = mysqli_query($koneksi, $sql);
    $tempat = [];
    while ($row = mysqli_fetch_assoc($hasil)) {
        $tempat[]= $row;
    }
    return $tempat;
}


?>