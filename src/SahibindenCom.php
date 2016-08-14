<?php
/**
 * Created by PhpStorm.
 * User: Aydin
 * Date: 19.3.2016
 * Time: 20:40
 */
class SahibindenCom{
    private $Curl,$MagazaAdi,$MysqlServer,$MysqlUser,$MysqlPass,$MysqlDb;

    public function __construct($MagazaAdi,$MysqlServer='localhost',$MysqlUser='root',$MysqlPass='root',$MysqlDb='sahibindenbot'){
        $this->MagazaAdi=$MagazaAdi;
        $this->MysqlServer=$MysqlServer;
        $this->MysqlUser=$MysqlUser;
        $this->MysqlPass=$MysqlPass;
        $this->MysqlDb=$MysqlDb;
        $this->Curl=new Curl();
        $db=mysql_connect($MysqlServer,$MysqlUser,$MysqlPass);
        mysql_select_db($MysqlDb,$db);
        mysql_query("SET NAMES utf8");
        mysql_query("SET CHARACTER SET utf8");
        mysql_query("SET COLLATION_CONNECTION = 'utf8_general_ci'");
    }

    public function LinkOlustur($slug)
    {
        setlocale(LC_ALL, "en_US.utf8");

        $slug = preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $slug));

        $slug = htmlentities($slug, ENT_QUOTES, 'UTF-8');

        $pattern = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $slug = preg_replace($pattern, '$1', $slug);

        $slug = html_entity_decode($slug, ENT_QUOTES, 'UTF-8');

        $pattern = '~[^0-9a-z]+~i';
        $slug = preg_replace($pattern, '-', $slug);

        return strtolower(trim($slug, '-'));
    }

    public function Pagination(){
       $Cikti=explode('<ul class="pageNaviButtons">',$this->Curl->get($this->MagazaAdi.'.sahibinden.com')->body);
        preg_match_all('@<a href="\/emlak(.*?)storeShowcase">(.*?)<\/a>@si',$Cikti[1],$Sonuc,PREG_PATTERN_ORDER);
        $ikinci[0]='/emlak?sorting=storeShowcase';
        $i=1;
        foreach ($Sonuc[1] as $Sonuclar ) {
            $ikinci[$i]='/emlak'.$Sonuclar.'storeShowcase';
            $i++;
        }
        return $ikinci;
    }

    public function Ilanlar($Sayfa='/emlak?sorting=storeShowcase'){
       $Cikti= $this->Curl->get($this->MagazaAdi.'.sahibinden.com'.$Sayfa);
        preg_match_all('@https:\/\/www.sahibinden.com/ilan/(.*?)"@si',$Cikti->body,$Sonuc);
        $i=1;
        foreach ($Sonuc[1] as $Linkler) {
            if($i%2<>0){
                $Link[]='https://www.sahibinden.com/ilan/'.$Linkler;
            }
            $i++;
        }

        return $Link;
    }

    public function GetIlan($SayfaURL){
        $Cikti= $this->Curl->get($SayfaURL)->body;
        $Ilan=array();
        preg_match_all('@<div class="classifiedBreadCrumb">(.*?)</div>@si',$Cikti,$Kategoriler);
        preg_match_all('@<img width="480" height="360" src="(.*?)" data-src="(.*?)"@si',$Cikti,$Resimler);
        preg_match_all('@data-lat="(.*?)" data-lon="(.*?)"@si',$Cikti,$Maps);
        preg_match_all('@<ul class="classifiedInfoList">(.*?)</ul>@si',$Cikti,$IlanBilgiler);
        preg_match_all('@<strong>(.*?)</strong>@si',$IlanBilgiler[1][0],$IlanBilgiBaslik);
        preg_match_all('@<span(.*?)>(.*?)</span>@si',$IlanBilgiler[1][0],$IlanBilgiIcerik);
        preg_match_all('@<div id="classifiedDescription" class="uiBoxContainer">(.*?)</div>@si',$Cikti,$Aciklama);
        preg_match_all('@<div class="uiBoxContainer classifiedDescription" id="classifiedProperties">(.*?)</div>@si',$Cikti,$Ozellikler);
        preg_match_all('@<h3>(.*?)</h3>@si',$Ozellikler[1][0],$OzellikBaslik);
        preg_match_all('@<ul>(.*?)</ul>@si',$Ozellikler[1][0],$OzellikKatman);

        $IlanOZellikler=array();
       for($i=0; $i<count($OzellikBaslik[1]);$i++){
           preg_match_all('@<li class="(.*?)">(.*?)</li>@si',$OzellikKatman[1][$i],$Ciktilarim);
           $IlanOZellikler[]=array('OzellikBaslik'=>$OzellikBaslik[1][$i],'Icerik'=>array('Bilgi'=>array_map('trim',$Ciktilarim[2]),'secim'=>$Ciktilarim[1]));
       }
        preg_match_all('@<a(.*?)>(.*?)</a>@si',$Kategoriler[1][0],$Kat);
        preg_match_all('@<h1>(.*?)</h1>@si',$Cikti,$H1Array);
        preg_match_all('@<h3>(.*?)</h3>@si',$Cikti,$H3Array);
        preg_match_all('@<h2>(.*?)</h2>@si',$Cikti,$H2Array);
        preg_match_all('@<h5>(.*?)</h5>@si',$Cikti,$H5Array);
        preg_match_all('@<a (.*?)>(.*?)</a>@si',$H2Array[1][0],$ILILCEMAH);

        $Ilan['Kategori']='Emlak';
        for($i=2; $i<count($Kat[2]);$i++){
            $Ilan['Kategori']=$Ilan['Kategori'].'>'.trim($Kat[2][$i]);
        }
        /* Ilan Array */
        $Ilan['Baslik']=$H1Array[1][0];
        $Ilan['Fiyat']=trim($H3Array[1][0]);
        $Ilan['Il']=trim($ILILCEMAH[2][0]);
        $Ilan['Ilce']=trim($ILILCEMAH[2][1]);
        $Ilan['Mah']=trim($ILILCEMAH[2][2]);
        $Ilan['IlanBilgiBaslik']=array_map('trim',$IlanBilgiBaslik[1]);
        $Ilan['IlanBilgiIcerik']=array_map('trim',$IlanBilgiIcerik[2]);
        $Ilan['IlanSahibi']=trim($H5Array[1][0]);
        $Ilan['Aciklama']=trim($Aciklama[1][0]);
        $Ilan['Maps']=$Maps[1][0].','.$Maps[2][0];
        $Ilan['Ozellikler']=$IlanOZellikler;
        $Ilan['Resimler']=$Resimler[2];

        $IlanAra=mysql_query("Select * from ilanlar Where Baslik='".$Ilan['Baslik']."' limit 1");
        if(!mysql_affected_rows()){
            mysql_query("INSERT INTO `ilanlar` (`Baslik`, `Fiyat`, `Il`, `Ilce`, `Mah`, `IlanSahibi`, `Aciklama`, `Maps`, `IlanLink`) VALUES
            ('".$Ilan['Baslik']."', '".$Ilan['Fiyat']."', '".$Ilan['Il']."', '".$Ilan['Ilce']."', '".$Ilan['Mah']."', '".$Ilan['IlanSahibi']."', '".$Ilan['Aciklama']."', '".$Ilan['Maps']."', '".$this->LinkOlustur($Ilan['Baslik'])."')");
            $SonID=mysql_fetch_assoc(mysql_query("Select * from ilanlar order by IlanID desc"))['IlanID'];
            foreach ($Ilan['Resimler'] as $Resim) {
                mysql_query("INSERT INTO `ilanresim` (`IlanID`, `Resim`) VALUES ('".$SonID."', '".$Resim."')");
            }
            for($i=0; $i<count($Ilan['IlanBilgiBaslik']);$i++){
                mysql_query("INSERT INTO `ilanbilgi` (`IlanID`, `Baslik`, `Icerik`) VALUES ('".$SonID."', '".$Ilan['IlanBilgiBaslik'][$i]."', '".$Ilan['IlanBilgiIcerik'][$i]."')");
            }
            for($i=0; $i<count($Ilan['Ozellikler']);$i++){
                for($j=0; $j<count($Ilan['Ozellikler'][$i]['Icerik']['Bilgi']);$j++){
                    mysql_query("INSERT INTO `ilanozellik` (`IlanID`, `OzellikBaslik`, `Bilgi`, `Secim`) VALUES ('".$SonID."', '".$Ilan['Ozellikler'][$i]['OzellikBaslik']."', '".$Ilan['Ozellikler'][$i]['Icerik']['Bilgi'][$j]."', '".$Ilan['Ozellikler'][$i]['Icerik']['secim'][$j]."')");
                }
            }
        }


        return $Ilan;
    }


}