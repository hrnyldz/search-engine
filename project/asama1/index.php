
<!DOCTYPE HTML>
<html xmlns:color="http://www.w3.org/1999/xhtml">
<head>

    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>
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
<!1.asama >
<div class="main">
    <h1 style="color: aqua;">Anahtar kelime saydırma</h1>
    <form method="POST" action="#">
        <table>
            <tr>
                <td><strong><label style="color:chartreuse;"  >Anahtar Kelime Giriniz : </label></strong></td>

                <td><input value="" name="key"/></td>
            </tr>
            <tr>
                <td><strong><label style="color: orange ; ">Url Adresi Giriniz : </label></strong></td>
                <td><input value="" name="url"/></td>
            </tr>
            <tr>
                <td rowspan="1">
                    <button type="submit" value="Gönder">Ara</button>
                </td>
            </tr>
        </table>
    </form>
</div>
<br>
<br>

</body>
</html>

<?php
/**
türkçe karekter
array silme
sonucu alta alma
sayfalaraa dağıtma
 */
//Functions class yüklendi
require_once './functions.php';

//Sınıf içerisindeki fnksiyonları kullanabilmek için nesne oluşturduk
$functions = new functions();

//$url = "https://www.btk.gov.tr/tr-TR/Sayfalar/SG-SIBER-GUVENLIK-KURULU";
//$key = "güvenlik";
$sayilar = array();
if($_POST['key'] && $_POST['url']){

    //Veriler atanıyor
    $url = $_POST['url'];
    $key = $_POST['key'];

    //url adresi verilen sayfanın içeriğini aldık
    $content = $functions->getContent($url);

    //İçeriği ve anahtar kelimeyi gönderdiğimiz fonksiyon bize içerik içinde anahtar kelime kaç kez geçti söyleyecek.
    $count   = $functions->getCount($key, $content);
    $string=$url." Adresinde bulunan sayfa içeriğinde $key anahtar kelimesi <strong>".$count."</strong> adet bulunmaktadır.";
    //Sonuçları ekrana basıyoruz.
    echo '<br>'.'<br>'.'<br>';
    echo"<font face=$Verdana size=50 color=white>$string</font>";

}


else{
    echo '<br>'.'<br>'.'<br>';
    echo"<font face=$Verdana size=50 color=red>Lütfen Alanları Eksiksiz Doldurunuz.</font>";
}
?>
