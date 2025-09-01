<?php

namespace App\Http\Controllers;

use App\Http\Classes\DefinitonsClass;
use App\Http\Classes\StockClass;
use App\Http\Classes\UserClass;

class UserController
{

    public $class = null;
    public function __construct()
    {
        $this->class = new UserClass();
    }

    /*
        1-Rapor günlük olarak verilecek
        2-Dükkan ismi olacak
        3-Bazı ürünler dünden kullanılabilir. Düne ait ürünlerde gösterilebilir.
        4-Kurabiye 100 tane çıkarıldı 3 gün gitti. 3 gün sonra çöp uyarısı versin 100 Kurabıya girdik Bunlar 3 gün daha satılabilir ayın 3 ünde en geç çöpe atılabilir. 100 kurabiyeden 20 tanesi satıldı elde kalan 80 bu atık olarak eklenecek mi ertesi gün 80 dünden kalma vardı.
        5-3 kullanıcı oluşacak. şifremi hatırla olacak.

        Genel Yapılacaklar

        1-Maile alınan raporlar günlük olarak mail atılacak PDF de Örneğin tarih aralığı seçince o aralıkta 20 gün varsa günlük olarak rapor oluşacak sayfada her gün için bir sayfa olacak şekilde.
        2-PDF de ve Uygulama sayfasında ayarlarda olacak olan Dükkan ismi yazacak. Rapor da dükkan ismine ek olarak adres yazacak.
        3-Bazı ürünler ileriye dönük kullanılabilir. Bugün 30 kurabiye hazırladım. GÜn sonu işlemlerinde o ürünün üretim tarihi yazacak ve bugün 10 tane sattım denildiğinde ertesi gün gün sonuna geldiğinde dünden kaldığı yazacak. Oradan da 10 satıldı. kalan 10 kaldı mesela 3.gün girdiğinde 3 günlük ürün atık yapılsın mı diye seçenek belirtilecek. İşaretlerse atık olarak girecek o gün. Yoksa ertesi güne gidecek. 
        4-Kullanıcı sistemi kullanıcılardan ad soyad email ile oluşacak zorunlu değil alanlar. Sisteme giriş yapınca kullanıcı seçilecek direk o kullanıcıdan devam edilecek.
        5-Beni hatırla işlemleri olacak.
        6-Uygulama Re-Pair işlemleri olacak

    */

    public function addUser()
    {
        try {
           return response()->json($this->class->addUser());
        } catch (\Throwable $th) {
        }
    }

    public function getUsers()
    {
        try {
           return response()->json($this->class->getUsers());
        } catch (\Throwable $th) {
        }
    }

    public function getWaitData()
    {
        try {
           return response()->json($this->class->getWaitData());
        } catch (\Throwable $th) {
        }
    }

    public function approve()
    {
        try {
           return response()->json($this->class->approve());
        } catch (\Throwable $th) {
        }
    }

   

}
