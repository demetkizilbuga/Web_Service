<?php
session_start();
ob_start();
header('Access-Control-Allow-Origin: *');
ini_set('error_reporting', E_ALL^E_NOTICE);
require_once 'plussistem/config.php';
header("Content-type:application/json");


// fonksiyon tanımlama END


$tarih = date ("Y-m-d H:i:s");
$json = Array();

$basarili["durum"]["kod"] = 1 ;
$basarili["durum"]["mesaj"] =  "Başarılı";

$hatali["durum"]["kod"] = 0 ;
$hatali["durum"]["mesaj"] =  "Erişim Tanımsız";

$enum["basarili"] = $basarili;
$enum["hatali"] = $hatali;


$json = $hatali;


if (empty($_GET["q"])  ) {
// echo '<a href=index.php> Giriş Sayfasına Gitmek için Tıklayın..</a>';
// echo '<script>alert("Lütfen Giriş Alanlarını Boş Bırakmayınız.") </script>';
} else { 



    $json = $basarili;
    $json["durum"]["mesaj"] =  "Kullanıcı girişi başarılı";


    if( $_GET["q"] == "HaberlerTumu"  ) {

        $query = $db->prepare("SELECT `Id`, `Baslik`, `Gorsel`, ( select Baslik from haberTurleri WHERE haberler.TurId = haberTurleri.Id ) as HaberTuru , `Icerik`, `Goruntuleme`, `Begenme`, `Begenmeme`, `Tarih` FROM `haberler` ");

        $query->execute(array(   ));

        if( $query->rowCount() ){
            foreach( $query as $val ){

                $gecisArray[  ] = Array(
                    'Id' => $val["Id"],
                    'Baslik' => $val["Baslik"],
                    'Gorsel' => $val["Gorsel"],
                    'HaberTuru' => $val["HaberTuru"],
                    // 'Icerik' => $val["Icerik"],
                    'Goruntuleme' => $val["Goruntuleme"],
                    'Begenme' => $val["Begenme"],
                    'Begenmeme' => $val["Begenmeme"],
                    'Tarih' => $val["Tarih"]
                );

            }

            $json["count"]["total"] = $query->rowCount()  ;



        }else{

            $json["count"]["total"] = 0  ;

            $gecisArray[  ] = Array(
                'Id' => "0",
                'Baslik' => "",
                'Gorsel' => " ",
                'HaberTuru' => " ",
                // 'Icerik' => $val["Icerik"],
                'Goruntuleme' => " ",
                'Begenme' => " ",
                'Begenmeme' =>  "",
                'Tarih' => " "
            );
        }


        $json["data"] = $gecisArray;

    }else if( $_GET["q"] == "KategorilerTumu"  ) {

        $query = $db->prepare("SELECT * FROM `haberTurleri`");

        $query->execute(array(   ));

        if( $query->rowCount() ){
            foreach( $query as $val ){

                $gecisArray[  ] = Array(
                    'Id' => $val["Id"],
                    'Baslik' => $val["Baslik"]
                );

            }

            $json["count"]["total"] = $query->rowCount()  ;



        }else{

            $json["count"]["total"] = 0  ;

            $gecisArray[  ] = Array(
                'id' => "0",
                'baslik' => "", 
            );

        }


        $json["data"] = $gecisArray;

    }else if( !empty($_GET["IdTur"] ) AND  $_GET["q"] == "HaberlerKategori"  ) {

        $query = $db->prepare("SELECT `Id`, `Baslik`, `Gorsel`, ( select Baslik from haberTurleri WHERE haberler.TurId = haberTurleri.Id ) as HaberTuru , `Icerik`, `Goruntuleme`, `Begenme`, `Begenmeme`, `Tarih` FROM `haberler` where TurId = ? ");

        $query->execute(array( $_GET["IdTur"]  ));

        if( $query->rowCount() ){
            foreach( $query as $val ){

                $gecisArray[  ] = Array(
                    'Id' => $val["Id"],
                    'Baslik' => $val["Baslik"],
                    'Gorsel' => $val["Gorsel"],
                    'HaberTuru' => $val["HaberTuru"],
                    // 'Icerik' => $val["Icerik"],
                    'Goruntuleme' => $val["Goruntuleme"],
                    'Begenme' => $val["Begenme"],
                    'Begenmeme' => $val["Begenmeme"],
                    'Tarih' => $val["Tarih"]
                );

            }

            $json["count"]["total"] = $query->rowCount()  ;



        }else{

            $json["count"]["total"] = 0  ;

            $gecisArray[  ] = Array(
                'Id' => "0",
                'Baslik' => "",
                'Gorsel' => " ",
                'HaberTuru' => " ",
                // 'Icerik' => $val["Icerik"],
                'Goruntuleme' => " ",
                'Begenme' => " ",
                'Begenmeme' =>  "",
                'Tarih' => " "
            );

        }


        $json["data"] = $gecisArray;

    }else if( !empty($_GET["HaberId"] ) AND  $_GET["q"] == "Haber"  ) {


        $ud_query = $db->prepare("UPDATE haberler SET Goruntuleme = Goruntuleme+1 WHERE Id = ?");
        $update = $ud_query->execute(array($_GET["HaberId"]));


        $query = $db->prepare("SELECT `Id`, `Baslik`, `Gorsel`, ( select Baslik from haberTurleri WHERE haberler.TurId = haberTurleri.Id ) as HaberTuru , `Icerik`, `Goruntuleme`, `Begenme`, `Begenmeme`, `Tarih` FROM `haberler` where Id = ? ");

        $query->execute(array( $_GET["HaberId"]  ));

        if( $query->rowCount() ){
            foreach( $query as $val ){

                $gecisArray[  ] = Array(
                    'Id' => $val["Id"],
                    'Baslik' => $val["Baslik"],
                    'Gorsel' => $val["Gorsel"],
                    'HaberTuru' => $val["HaberTuru"],
                    'Icerik' => $val["Icerik"],
                    'Goruntuleme' => $val["Goruntuleme"],
                    'Begenme' => $val["Begenme"],
                    'Begenmeme' => $val["Begenmeme"],
                    'Tarih' => $val["Tarih"]
                );

            }

            $json["count"]["total"] = $query->rowCount()  ;



        }else{

            $json["count"]["total"] = 0  ;

            $gecisArray[  ] = Array(
                'Id' => "0",
                'Baslik' => "",
                'Gorsel' => " ",
                'HaberTuru' => " ",
                'Icerik' => " ",
                'Goruntuleme' => " ",
                'Begenme' => " ",
                'Begenmeme' =>  "",
                'Tarih' => " "
            );

        }


        $json["data"] = $gecisArray;

    }else if( !empty($_GET["HaberId"] ) AND  $_GET["q"] == "HaberBegenme"  ) {


        $ud_query = $db->prepare("UPDATE haberler SET Begenme = Begenme+1 WHERE Id = ?");
        $update = $ud_query->execute(array($_GET["HaberId"]));


        $query = $db->prepare("SELECT `Id`, `Baslik`, `Gorsel`, ( select Baslik from haberTurleri WHERE haberler.TurId = haberTurleri.Id ) as HaberTuru , `Icerik`, `Goruntuleme`, `Begenme`, `Begenmeme`, `Tarih` FROM `haberler` where Id = ? ");

        $query->execute(array( $_GET["HaberId"]  ));

        if( $query->rowCount() ){
            foreach( $query as $val ){ 
                $gecisArray[  ] = Array(
                    'Id' => $val["Id"], 
                    'Goruntuleme' => $val["Goruntuleme"],
                    'Begenme' => $val["Begenme"],
                    'Begenmeme' => $val["Begenmeme"] 
                );

            }

            $json["count"]["total"] = $query->rowCount()  ;



        }else{

            $json["count"]["total"] = 0  ;

            $gecisArray[  ] = Array(
                'id' => 0,
                'Goruntuleme' => " ",
                'Begenme' => " ",
                'Begenmeme' => " "
            );

        }


        $json["data"] = $gecisArray;

    }else if( !empty($_GET["HaberId"] ) AND  $_GET["q"] == "HaberBegenmeme"  ) {


        $ud_query = $db->prepare("UPDATE haberler SET Begenmeme = Begenmeme+1 WHERE Id = ?");
        $update = $ud_query->execute(array($_GET["HaberId"]));


        $query = $db->prepare("SELECT `Id`, `Baslik`, `Gorsel`, ( select Baslik from haberTurleri WHERE haberler.TurId = haberTurleri.Id ) as HaberTuru , `Icerik`, `Goruntuleme`, `Begenme`, `Begenmeme`, `Tarih` FROM `haberler` where Id = ? ");

        $query->execute(array( $_GET["HaberId"]  ));

        if( $query->rowCount() ){
            foreach( $query as $val ){ 
                $gecisArray[  ] = Array(
                    'Id' => $val["Id"], 
                    'Goruntuleme' => $val["Goruntuleme"],
                    'Begenme' => $val["Begenme"],
                    'Begenmeme' => $val["Begenmeme"] 
                );

            }

            $json["count"]["total"] = $query->rowCount()  ;



        }else{

            $json["count"]["total"] = 0  ;

            $gecisArray[  ] = Array(
                'id' => 0,
                'Goruntuleme' => " ",
                'Begenme' => " ",
                'Begenmeme' => " "
            );

        }


        $json["data"] = $gecisArray;

    }   

 

}


echo json_encode($json);
  
die("");
 

?>

