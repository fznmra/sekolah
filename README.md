# sekolah
uas web kelompok 6 Miftahul Fauzan dan Khairunnisa SISTEM AKADEMIK DAN MONITORING KEHADIRAN SISWA BERBASIS WEB

Panduan penggunaan projek  

1.download project ini  
git clone https://github.com/fznmra/sekolah.git  

2.akan muncul folder sekolah, buka foldernya  
cd sekolah  

3.lalu instal composernya  
composer install  

4.Salin file .env.example menjadi .env:  
cp .env.example .env  

5.Setelah itu, buka file .env dan sesuaikan bagian database:  
atur sesuai nama database yg sudah kalian buat di phpmyadmin  

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_kamu
DB_USERNAME=root
DB_PASSWORD=  

6.Generate App Key:
php artisan key:generate  

7.Migrasi dan Seeding Data  
Karena projek ini menggunakan Seed, jalankan perintah berikut untuk membuat tabel sekaligus mengisi data awal:  

php artisan migrate --seed  

8.Jalankan Server  
Terakhir, jalankan server lokal Laravel:  

php artisan serve  

sistem ini mempunyai 3 aktor: admin, guru dan orang tua.  

akun admin:  
username: admin  
password: admin123  

untuk akun orang tua adalah  
username: ortu_nisn (contoh: ortu_1234567890)  
password bawaan adalah : 123456  

terimakasih telah membaca  