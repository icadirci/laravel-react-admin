# About Laravel React Admin - Task Module

Bu proje, jovertical/laravel-react-admin reposundan çatallanarak (fork) alınmış ve admin paneline Task Modülü eklenerek geliştirilmiştir.
Kurulum

## Depoyu Klonlama

Projeyi yerel bilgisayarınıza indirmek için:

``` 
git clone https://github.com/icadirci/laravel-react-admin 

cd laravel-react-admin
```

## Bağımlıkları Kurma

Backend (Laravel)
```
composer install
```
Frontend (React ve Tailwind)
```
yarn install
```
## Ortam Değişkenlerini Ayarlama
```
cp .env.example .env
php artisan key:generate
```
.env dosyanızı açın ve veritabanı bilgilerinizi güncelleyin:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_admin
DB_USERNAME=root
DB_PASSWORD=
```
Veritabanı Migrasyonları ve Seed'leri Çalıştırma
```
php artisan migrate --seed
```
Uygulamayı Çalıştırma

Backend (Laravel API)
```
php artisan serve
```
Frontend (React)
```
yarn watch | yarn dev
```
Proje http://localhost:3000 adresinde çalışıyor olmalıdır.

## Task Modülü

Task modülü, admin paneline görev yönetimi ekler. Kullanıcılar görev oluşturabilir, düzenleyebilir ve silebilir. Kanban dashboard ve api üzerinden değişiklikler yapılabilir


## API Endpoint'leri

GET /api/v1/tasks → Tüm görevleri getirir.

POST /api/v1/tasks → Yeni bir görev ekler.

PUT /api/v1/tasks/{id} → Belirtilen görevi günceller.

DELETE /api/v1/tasks/{id} → Görevi siler.

GET /api/v1/kanban-data → Kanban dashboard'ı için gruplanmış verileri getirir



"Tasks" menüsüne tıklayarak yeni eklenen sayfaya erişebilirsiniz.

## Varsayılan admin hesabı:

Username: icadirci

Şifre: password



