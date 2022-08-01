<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
?>
<?php
include("fonksiyon.php"); 
$uye= new uye();  
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dosya/style.css" >
    <title>Uyelik İşlemleri</title>
</head>
<body>
<div class="container-fluid">
	<div class="row">
    
    	<div class="col-md-6 mx-auto mt-4" >
            <?php
             @$hareket=$_GET["hareket"];
            switch($hareket){
               
                case "ekle":
                $uye->ekle($baglan);
                break;
                case "uyeguncelle":
                    $uye->guncelle($baglan);
                break;
                case "uyesil":
                    $uye->sil($baglan);
                
                break;
                default:
            
            ?>
        	<table class="table table-bordered table-striped text-center bg-white">
            	<thead>
            <tr>
            <th colspan="6"><a href="uyelikler.php?hareket=ekle" class="btn btn-success">ÜYE EKLE</a></th>
                       
            </tr>
            </thead>
        	<thead>
            <tr>
            <th class="font-weight-bold">AD</th>
            <th class="font-weight-bold">SOYAD</th>
            <th class="font-weight-bold"><a href="uyelikler.php?sec=buyuk">+</a> YAŞ <a href="uyelikler.php?sec=kucuk">-</a></th>
            <th class="font-weight-bold"><a href="uyelikler.php?sec=buyuk2">+</a> AİDAT <a href="uyelikler.php?sec=kucuk2">-</a></th>
            <th class="font-weight-bold">GÜNCELLE</th>
            <th class="font-weight-bold">SİL</th>            
            </tr>
            </thead>
            <tbody>
                <?php

                @$siralama=$_GET["sec"];
                switch($siralama){
                    case "buyuk":
                        $uye->listele($baglan,1);
                    break;
                    case "kucuk":
                        $uye->listele($baglan,2);
                    break;
                    case "buyuk2":
                        $uye->listele($baglan,3);
                    break;
                    case "kucuk":
                        $uye->listele($baglan,4);
                    break;

                    default :
                    $uye->listele($baglan,0);
                }
                
                   
                ?>

            </tbody>
        	
            </table>
            <?php
            }
            ?>
            
  
        
        </div>
    
    
    </div>

	

</div>


</body>
</html>