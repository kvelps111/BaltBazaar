# BaltBazaar 

BaltBazaar ir studentu marketplace aplikācija, kas ļauj Baltijas studentiem droši pirkt un pārdot preces savā universitātes kopienā. Projekts izstrādāts kā gala darbs programmēšanas kursa eksāmenam.

---

##  Funkcionalitāte

-  Lietotāju reģistrācija un autorizācija
-  Sludinājumu pievienošana un dzēšana
-  Sludinājumu pārlūkošana ar filtriem (reģions, skola, kategorija)
-  Lietotāja profila pārvaldība
-  Mobilajām ierīcēm pielāgots dizains (responsive)
-  Premium UX elementi: moderns dizains, zaļie CTA, kartīšu izkārtojums

---

##  Izmantotās tehnoloģijas

- **Laravel 12.36.1** — backend framework
- **Blade** — šablonu dzinējs
- **Tailwind CSS** — moderns UI dizains
- **Sqlite** — datu bāze
- **Laravel Breeze** — autentifikācijas sistēma
- **Composer & NPM** — atkarību pārvaldība

---

##  Uzstādīšana

```bash
git clone https://github.com/tavs-lietotajvards/baltbazaar.git
cd baltbazaar

composer install
npm install && npm run dev

cp .env.example .env
php artisan key:generate

# Konfigurē datu bāzi .env failā
php artisan migrate

php artisan db:seed

php artisan serve
