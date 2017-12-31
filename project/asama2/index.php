<!DOCTYPE HTML>
<html xmlns:color="http://www.w3.org/1999/xhtml">
<head>
    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>
    <title>Arama Motoru</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="main.css"/>

    <style>

        body{width: 100%;}
        .main{width: 50%;margin: 0 auto;}
        form , table{float: left;width: 100%;}
        form input , textarea{width: 100%;}
        label{text-align: right;}

    </style>
</head>

<body>

<!2.asama>
<div class="main">
    <h1 style="color:chartreuse;">Sayfa (URL) Sıralama</h1>
    <h2 style="color:deeppink;">Anahtar Kelime ve Url Adreleri aralarında virgül koyarak girniz</h2>
    <form method="POST" action="#">
        <table>
            <tr>
                <td><label style="color:coral;" >Anahtar Kelime Girniz : </label></td>
                <td><input value="" name="keys"/></td>
            </tr>
            <tr>
                <td><label style="color:antiquewhite;">Url Adresi Giriniz : </label></td>
                <td><textarea rows="4" name="urls"/></textarea></td>
            </tr>
            <tr>
                <td rowspan="1">
                    <button type="submit" value="Gönder">Ara</button>
                </td>
            </tr>
        </table>
    </form>
</div>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script>
    var arr = [10,12,15,21];
    for(var i=0;i<arr.length-1;i++){
        setTimeout(function(j){
            console.log('Index : ' + i + " element : " + arr[j]);
        },3000,i);
    }

    jQuery.each([10,12,15,21], function(index, value ) {
        setTimeout(function(){
            console.log( index + ": " + value );
        },3000);
    });
</script>
</body>
</html>

<?php
//Functions class yüklendi
require_once './functions.php';

//Sınıf içerisindeki fnksiyonları kullanabilmek için nesne oluşturduk
$functions = new functions();
echo"<br />";
echo"<br />";
echo"<br />";
echo"<br />";
echo"<br />";
//$url = "https://www.btk.gov.tr/tr-TR/Sayfalar/SG-SIBER-GUVENLIK-KURULU";
//$key = "güvenlik";
if($_POST['keys'] && $_POST['urls']){
    //Anahtar kelimeler array içerisine atılıyor
    $keys = explode(",",$_POST['keys']);
    //Url adresleri array içerisine alınıyor
    $urls = explode(",",$_POST['urls']);
    $i=0;$j=0;
    foreach ($keys as $key){
        foreach ($urls as $url) {
            //İçeriği ve anahtar kelimeyi gönderdiğimiz fonksiyon bize içerik içinde anahtar kelime kaç kez geçti söyleyecek.
            $content = $functions->getContent($url);
            //İçeriği ve anahtar kelimeyi gönderdiğimiz fonksiyon bize içerik içinde anahtar kelime kaç kez geçti söyleyecek.
            $count   = $functions->getCount($key, $content);

            #################### Yeni eklendi ############################
            //Url Bazlı Kelime Puanları Alınıyor
            $hit[$url][$key] = ($count)?$count:1;
            ##############################################################

            //Sonuçlar alınıyor
            if(!$sonuc[$url."-".$key]['aciklama']){
                $sonuc[$url."-".$key]['aciklama'] = "";
            }
            $sonuc[$url."-".$key]['aciklama'] .= "$key Anahtar Kelimesi $url adresinde <strong>$count</strong> adet geçmektedir.<br>";
            if(!$sonuc[$url."-".$key]['puan']){
                $sonuc[$url."-".$key]['puan'] = 0;
            }
            $sonuc[$url."-".$key]['puan'] = $sonuc[$url."-".$key]['puan'] + $count;

        }
    }

    //Url bazlı puan hesaplanıyor
    foreach ($hit as $url=>$key) {
        //Eğer puan ilk defa hesaplanıyorsa 1 olarak atanıyor.
        if(!$urlHit[$url]){
            $urlHit[$url] = 1;
        }
        //Url içerisinde geçen her anahtar kelime için puen hesaplanıyor
        foreach ($key as $value) {
            $urlHit[$url] = $urlHit[$url]*$value;
        }

    }
    #################### Yeni eklendi ############################
    //Hesaplanan puanlar ekrana basılıyor
    //PUANLAR BÜYÜKTEN KÜÇÜĞE LİSTELENİYOR
    arsort($urlHit);
    echo'<br>'.'<br>'.'<br>';
    foreach ($sonuc as $key=>$value) {
        $string="Açıklama : ".$sonuc[$key]['aciklama'] ." Puan : ".$value['puan'].'<br>';
        echo"<font face=$Verdana size=50 color=aqua>$string</font>";    }
    //Verileri ekrana yazıyorum

    echo '<br>'.'<br>'.'<br>';
    foreach ($urlHit as $url=>$puan) {
        $string=$url." adresinin skoru ".'<br>'.$puan.'<br>';
        echo"<font face=$Verdana size=50 color=#bdb76b>$string</font>";
    }

    ###############################################################
    //Yukarıda skor puanlarını yazdık

    //Sonuçlar Toplam Puana uygun olarak sort ediliyor
    foreach ($sonuc as $key => $row) {
        $puan[$key]  = $row['puan'];
        $aciklama[$key] = $row['aciklama'];
    }

    array_multisort($puan, SORT_DESC, $aciklama, SORT_ASC, $sonuc);


} else{
    echo"<br />";
    echo"<br />";
    echo"<br />";
    echo"<br />";
    echo"<br />";
    echo"<font face=$Verdana size=50 color=red>Lütfen Alanları Eksiksiz Doldurunuz.</font>";
}
?>