# SahibindenComBot
Sahibinden.com'da bulunan mağazanızın ilanlarını çekebileceğiniz bir bot uygulaması.

#Kurulum
Composer => <code>composer require aydinozturk/sahibinden-com-bot</code>

Git => <code>clone https://github.com/aydinozturk/SahibindenComBot.git</code>

Download => <code>https://github.com/aydinozturk/SahibindenComBot/archive/master.zip</code> <a href="https://github.com/aydinozturk/SahibindenComBot/archive/master.zip">Download</a> 
<br>

Uygulama için mysql veritabanı gerekmektedir. yükleyeceğiniz tablolar SQL içerisinde mevcuttur.

#Başlarken
<code>
ini_set('max_execution_time', 2400);<br>
<br>
require '../vendor/autoload.php'; // Diğer Eklenti Sınıflarımızı Yüklüyoruz.<br>
require '../src/SahibindenCom.php'; // SahibindenCom Sınıfını Yüklüyoruz.<br>
</code>

Sınıflarımızı Yükledikten Sonra Çağırma İşemine Geçiyoruz.

# Tanımlamalar

<code>
$MagazaAdi='SahibindenMagazaAdi'; // Bu alan sahibinden.com un vermiş olduğu subdomain  adıdır.
$MysqlServer='localhost'; // Mysql Server Adresiniz.<br>
$MysqlUser='root'; // Mysql Kullanıcı Adınız<br>
$MysqlPass='root'; // Mysql Kullanıcı Parolanız.<br>
$MysqlDB='sahibinden'; // Mysql Veritabanı Adınız.<br>
</code>

# Kullanım

<code>
$SahibindenCom=new SahibindenCom($MagazaAdi,$MysqlServer,$MysqlUser,$MysqlPass,$MysqlDB);<br>
foreach ($SahibindenCom->Pagination() as $Sayfa) /* Anasayfasındaki tüm ilan sayfalarını alıyoruz*/<br>
{<br>
    foreach ($SahibindenCom->Ilanlar($Sayfa)  as $Ilanlar) /* Geçerli Sayfadaki İlan listesini alıyoruz*/<br>
    { <br>
        $SahibindenCom->GetIlan($Ilanlar); // Ilandaki bilgileri veritabanımıza çekiyoruz.<br>
        sleep(5); <br>
    }<br>
}<br>
</code>


# Tüm Satırlar

<code>
ini_set('max_execution_time', 2400);<br>

require '../vendor/autoload.php'; // Diğer Eklenti Sınıflarımızı Yüklüyoruz.<br>
require '../src/SahibindenCom.php'; // SahibindenCom Sınıfını Yüklüyoruz.<br>
<br>
<br>
$MagazaAdi='SahibindenMagazaAdi'; // Bu alan sahibinden.com un vermiş olduğu subdomain  adıdır. örn:<br> SahibindenMagazaAdi.sahibinden.com<br>
$MysqlServer='localhost'; // Mysql Server Adresiniz.<br>
$MysqlUser='root'; // Mysql Kullanıcı Adınız<br>
$MysqlPass='root'; // Mysql Kullanıcı Parolanız.<br>
$MysqlDB='sahibinden'; // Mysql Veritabanı Adınız.<br>
<br>
$SahibindenCom=new SahibindenCom($MagazaAdi,$MysqlServer,$MysqlUser,$MysqlPass,$MysqlDB);<br>
foreach ($SahibindenCom->Pagination() as $Sayfa) // Anasayfasındaki tüm ilan sayfalarını alıyoruz<br>
{<br>
    foreach ($SahibindenCom->Ilanlar($Sayfa)  as $Ilanlar) // Geçerli Sayfadaki İlan listesini alıyoruz<br>
    { <br>
        $SahibindenCom->GetIlan($Ilanlar); // Ilandaki bilgileri veritabanımıza çekiyoruz.<br>
        sleep(5); <br>
    }<br>
}<br>

</code>
<br>
<i>Örnek İçin test klasörüne bakabilirsiniz.</i>

