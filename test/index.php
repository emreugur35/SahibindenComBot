<?php

ini_set('max_execution_time', 2400);
error_reporting(-1);

require '../vendor/autoload.php'; // Diğer Eklenti Sınıflarımızı Yüklüyoruz.
require '../src/SahibindenCom.php'; // SahibindenCom Sınıfını Yüklüyoruz.


$MagazaAdi='SahibindenMagazaAdi'; // Bu alan sahibinden.com un vermiş olduğu subdomain  adıdır. örn: SahibindenMagazaAdi.sahibinden.com
$SahibindenCom=new SahibindenCom($MagazaAdi);
foreach ($SahibindenCom->Pagination() as $Sayfa) /* Anasayfasındaki tüm ilan sayfalarını alıyoruz*/
{
    foreach ($SahibindenCom->Ilanlar($Sayfa)  as $Ilanlar) /* Geçerli Sayfadaki İlan listesini alıyoruz*/
    { 
        $SahibindenCom->GetIlan($Ilanlar); // Ilandaki bilgileri veritabanımıza çekiyoruz.
        sleep(5); 
    }
}


?>