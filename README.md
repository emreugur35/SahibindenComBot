# SahibindenComBot
Sahibinden.com'da bulunan mağazanızın ilanlarını çekebileceğiniz bir bot uygulaması.

#Kurulum
Composer => <code>composer require aydinozturk/sahibinden-com-bot</code>

Git => <code>https://github.com/aydinozturk/SahibindenComBot.git</code>

Download => <code>https://github.com/aydinozturk/SahibindenComBot/archive/master.zip</code> <a href="https://github.com/aydinozturk/SahibindenComBot/archive/master.zip">Download</a> 


Uygulama için mysql veritabanı gerekmektedir. yükleyeceğiniz tablolar SQL içerisinde mevcuttur.

#Başlarken
<code>
ini_set('max_execution_time', 2400);

require '../vendor/autoload.php'; // Diğer Eklenti Sınıflarımızı Yüklüyoruz.
require '../src/SahibindenCom.php'; // SahibindenCom Sınıfını Yüklüyoruz.
</code>

Sınıflarımızı Yükledikten Sonra Çağırma İşemine Geçiyoruz.

# Tanımlamalar

<code>
$MagazaAdi='SahibindenMagazaAdi'; // Bu alan sahibinden.com un vermiş olduğu subdomain  adıdır. örn: SahibindenMagazaAdi.sahibinden.com
$MysqlServer='localhost'; // Mysql Server Adresiniz.
$MysqlUser='root'; // Mysql Kullanıcı Adınız
$MysqlPass='root'; // Mysql Kullanıcı Parolanız.
$MysqlDB='sahibinden'; // Mysql Veritabanı Adınız.
</code>

# Kullanım

<code>
$SahibindenCom=new SahibindenCom($MagazaAdi,$MysqlServer,$MysqlUser,$MysqlPass,$MysqlDB);
foreach ($SahibindenCom->Pagination() as $Sayfa) /* Anasayfasındaki tüm ilan sayfalarını alıyoruz*/
{
    foreach ($SahibindenCom->Ilanlar($Sayfa)  as $Ilanlar) /* Geçerli Sayfadaki İlan listesini alıyoruz*/
    { 
        $SahibindenCom->GetIlan($Ilanlar); // Ilandaki bilgileri veritabanımıza çekiyoruz.
        sleep(5); 
    }
}</code>


# Tüm Satırlar

<code>
ini_set('max_execution_time', 2400);

require '../vendor/autoload.php'; // Diğer Eklenti Sınıflarımızı Yüklüyoruz.
require '../src/SahibindenCom.php'; // SahibindenCom Sınıfını Yüklüyoruz.


$MagazaAdi='SahibindenMagazaAdi'; // Bu alan sahibinden.com un vermiş olduğu subdomain  adıdır. örn: SahibindenMagazaAdi.sahibinden.com
$MysqlServer='localhost'; // Mysql Server Adresiniz.
$MysqlUser='root'; // Mysql Kullanıcı Adınız
$MysqlPass='root'; // Mysql Kullanıcı Parolanız.
$MysqlDB='sahibinden'; // Mysql Veritabanı Adınız.

$SahibindenCom=new SahibindenCom($MagazaAdi,$MysqlServer,$MysqlUser,$MysqlPass,$MysqlDB);
foreach ($SahibindenCom->Pagination() as $Sayfa) /* Anasayfasındaki tüm ilan sayfalarını alıyoruz*/
{
    foreach ($SahibindenCom->Ilanlar($Sayfa)  as $Ilanlar) /* Geçerli Sayfadaki İlan listesini alıyoruz*/
    { 
        $SahibindenCom->GetIlan($Ilanlar); // Ilandaki bilgileri veritabanımıza çekiyoruz.
        sleep(5); 
    }
}

<i>Örnek İçin test klasörüne bakabilirsiniz.</i>
</code>
