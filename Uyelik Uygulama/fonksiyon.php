<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
?>
<?php
try{
$baglan= new PDO("mysql:host=localhost; dbname=veritabaniadi; charset=utf8","kullaniciadi","şifre");
$baglan->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    die($e->getMessage());
}


class uye{
    function ekle($baglan){
        @$buton=$_POST["buton"];
    
        
        if(@$buton){
            $ad=htmlspecialchars($_POST["ad"]);
            $soyad=htmlspecialchars($_POST["soyad"]);
            $yas=htmlspecialchars($_POST["yas"]);
            $aidat=htmlspecialchars($_POST["aidat"]);

            if(empty($ad) || empty($soyad) || empty($yas) || empty($aidat)){
                echo "Alanların tamamını doldurunuzz!!!";

            }
            else{
                $ekleme=$baglan->prepare("insert into uyeler (ad,soyad,yas,aidat) VALUES('$ad','$soyad','$yas',$aidat)");
                $ekleme->execute();
                echo'<h2 class="text-success">Üye eklenmiştir...</h2>';
            }
        }
        
        echo '   <table class="table table-bordered table-striped text-center bg-white">
        <thead>
        <tr>
        <th colspan="6">ÜYE EKLEME</th>                  
        </tr>
        </thead>
        <tbody>
        <tr>
       
    <td colspan="6">
    <form action="uyelikler.php?hareket=ekle" method="post">
    <input type="text" name="ad" class="form-control mx-auto col-md-3 mt-2" placeholder="Ad yaz" />
    <input type="text" name="soyad" class="form-control mx-auto col-md-3 mt-2" placeholder="Soyad yaz"/>
    <input type="text" name="yas" class="form-control mx-auto col-md-3 mt-2" placeholder="Yaş yaz"/>
    <input type="text" name="aidat" class="form-control mx-auto col-md-3 mt-2" placeholder="Aidat yaz"/>
    <input type="submit" name="buton" class="btn btn-success mt-2" value="EKLE" />
    </form>
    </td>
    <tr>
    </tbody>
    </table>
    <a href="uyelikler.php" class="link-primary">Ana Sayfa</a>';
    
		
    }
    function listele($baglan,$sirala){
        if($sirala==0){
            $sorgu=$baglan->prepare("select * from uyeler");

        }
        elseif($sirala==1){
            $sorgu=$baglan->prepare("select * from uyeler order by yas desc");
        }
        elseif($sirala==2){
            $sorgu=$baglan->prepare("select * from uyeler order by yas asc");
            
        }
        elseif($sirala==3){
            $sorgu=$baglan->prepare("select * from uyeler order by aidat desc");
        }
        elseif($sirala==4){
            $sorgu=$baglan->prepare("select * from uyeler order by aidat asc");

        }
        $sorgu->execute();
        
        if(@$sorgu->rowCount()== 0 ){
            echo'<tr>
            <td colspan="6">KAYITLI ÜYE YOK</td></tr>';
        }
        else{
        //işlmeler
        while($cikti=$sorgu->fetch(PDO::FETCH_ASSOC)){
            echo'<tr>
            <td>'.$cikti["ad"].'</td>
            <td>'.$cikti["soyad"].'</td>
            <td>'.$cikti["yas"].'</td>
            <td>'.$cikti["aidat"].'</td>
            <td><a href="uyelikler.php?hareket=uyeguncelle&id='.$cikti["id"].'" class="btn btn-warning">Güncelle</a></td>
            <td><a href="uyelikler.php?hareket=uyesil&id='.$cikti["id"].'" class="btn btn-danger">Sil</a></td>
            </tr>';

        }
        }

    }

    function sil($baglan){
        $uyeid=$_GET["id"];
        if(empty($uyeid)){
            echo "HATA VAR";
        }
        else{
            $sil=$baglan->prepare("DELETE from uyeler where id=$uyeid");
            $sil->execute();
            echo'<h2 class="text-warning">Üye Silinmiştir...<br>Ana sayfaya yönlendiriliyorsunuz.....</h2>';
            header("refresh:3;url=uyelikler.php");
            
        }

    }

    function guncelle($baglan){
        @$uyeid=$_GET["id"];
		
		@$buton= $_POST["butonguncelle"];
        if(@$buton){
            $id=htmlspecialchars($_POST["id"]);
            $ad=htmlspecialchars($_POST["ad"]);
            $soyad=htmlspecialchars($_POST["soyad"]);
            $yas=htmlspecialchars($_POST["yas"]);
            $aidat=htmlspecialchars($_POST["aidat"]);

            if(empty($ad) || empty($soyad) || empty($yas) || empty($aidat)){
                echo "Alanların tamamını doldurunuzz!!!";

            }
            else{
                $guncelle=$baglan->prepare("UPDATE uyeler SET ad='$ad',soyad='$soyad',yas='$yas',aidat='$aidat' where id=$id");
                $guncelle->execute();
                echo'<h2 class="text-success">Üye Güncellenmiştir<br>Ana Sayfaya Yönlendiriliyorsunuz...</h2>';
                header("refresh:3;url=uyelikler.php");
            }
        }
        else{
            echo '   <table class="table table-bordered table-striped text-center bg-white">
        	<thead>
            <tr>
            <th colspan="6">ÜYE GÜNCELLEME</th>                  
            </tr>
            </thead>
        	<tbody>
            <tr>
           
        <td colspan="6">
        <form action="uyelikler.php?hareket=uyeguncelle" method="post">';
		
		$sorgum=$baglan->prepare("select * from uyeler where id=$uyeid");
		$sorgum->execute();
		
		$sorguson=$sorgum->fetch();
		
		
		
		
       echo ' <input type="text" name="ad" class="form-control mx-auto col-md-3 mt-2" value="'.$sorguson["ad"].'" />
        <input type="text" name="soyad" class="form-control mx-auto col-md-3 mt-2" value="'.$sorguson["soyad"].'"/>
        <input type="text" name="yas" class="form-control mx-auto col-md-3 mt-2" value="'.$sorguson["yas"].'"/>
        <input type="text" name="aidat" class="form-control mx-auto col-md-3 mt-2" value="'.$sorguson["aidat"].'"/>
		 <input type="hidden" name="id" class="form-control mx-auto col-md-3 mt-2" value="'.$sorguson["id"].'"/>
        <input type="submit" name="butonguncelle" class="btn btn-success mt-2" value="GÜNCELLE" />
        </form>
        </td>
        <tr>
        </tbody>
        </table>';

        }
    }
}
?>

