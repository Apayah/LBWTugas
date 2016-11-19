# LBWTugas
Tugas Besar Mata Kuliah LBW

Notes:
Untuk bisa menjalankan file copy file cacert.pem dan php.ini dari folder XAMPP\php\ ke folder instalasi XAMPP\php
Kalau tidak inging meng-overwrite php.ini, tambahkan line:

[curl]
; A default value for the CURLOPT_CAINFO option. This is required to be an
; absolute path.
curl.cainfo="D:\Utilities\Xampp\php\cacert.pem"
openssl.cafile="D:\Utilities\Xampp\php\cacert.pem"

ke php.ini

Di file index.php di line 
$loginUrl = $helper->getLoginUrl('http://localhost:81/LBWTugas/main.php', $permissions);
ganti http://localhost:81 ke port yang dipakai
