<?php

abstract class Hewan
{
    public $nama, $darah = 50, $jumlahKaki, $keahlian;

    public function __construct($nama)
    {
        $this->nama = $nama;
    }

    public function atraksi()
    {
        $news = 'News : ' . $this->nama . ' sedang ' . $this->keahlian . '<br>' .
            '==============================<br>';
        echo $news;
    }
}

trait Fight
{
    public $attackPower, $defencePower;

    public function serang($hewan)
    {
        echo "News : $this->nama sedang menyerang $hewan->nama <br>";
        echo "=============================================== <br>";
        $this->diserang($this);
    }

    public function diserang($hewan)
    {
        echo "News : $this->nama sedang diserang $hewan->nama <br>";
        echo "=============================================== <br>";
        $darahBerkurang = $hewan->attackPower / $this->defencePower;
        $this->darah = $this->darah - ($darahBerkurang);
        echo "News : Darah $this->nama berkurang sejumlah $darahBerkurang <br>";
        echo "=============================================== <br>";
        echo "News : Darah $this->nama tersisa $this->darah <br>";
        echo "=============================================== <br><br>";
    }
}

class Elang extends Hewan
{
    use Fight;

    function __construct($nama)
    {
        parent::__construct($nama);
        $this->jumlahKaki = 2;
        $this->keahlian = 'Terbang Tinggi';
        $this->attackPower = 10;
        $this->defencePower = 5;
    }

    public function  getInfoHewan()
    {
        echo "======= ELANG ====== <br>" .
            "Nama : $this->nama <br>" .
            "Darah : $this->darah <br>" .
            "Jumlah Kaki : $this->jumlahKaki <br>" .
            "Keahlian : $this->keahlian <br>" .
            "Power Attack : $this->attackPower <br>" .
            "Defence Power : $this->defencePower <br>" .
            "====================== <br><br>";
    }
}

class Harimau extends Hewan
{
    use Fight;

    function __construct($nama)
    {
        parent::__construct($nama);
        $this->jumlahKaki = 4;
        $this->keahlian = 'Lari Cepat';
        $this->attackPower = 7;
        $this->defencePower = 8;
    }

    public function  getInfoHewan()
    {
        echo "======= HARIMAU ====== <br>" .
            "Nama : $this->nama <br>" .
            "Darah : $this->darah <br>" .
            "Jumlah Kaki : $this->jumlahKaki <br>" .
            "Keahlian : $this->keahlian <br>" .
            "Power Attack : $this->attackPower <br>" .
            "Defence Power : $this->defencePower <br>" .
            "====================== <br><br>";
    }
}

$elang = new Elang('Elang Kuat');
$harimau = new Harimau('Harimau Gokil');

echo $harimau->getInfoHewan();
echo $elang->getInfoHewan();

$harimau->atraksi();
$elang->atraksi();

$elang->serang($harimau);
echo $harimau->getInfoHewan();
echo $elang->getInfoHewan();

$harimau->serang($elang);
echo $harimau->getInfoHewan();
echo $elang->getInfoHewan();
