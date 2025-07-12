# 📘 Projet Laravel - Gestion Paiement & Relevés

Ce projet est une application Laravel conçue pour gérer les clients, les compteurs, les relevés de consommation d'eau, les factures, les paiements et l’exportation de fiches en PDF.

## ⚙️ Prérequis

Assurez-vous d'avoir les éléments suivants installés sur votre machine :
- PHP >= 8.1
- Composer
- MySQL ou MariaDB
- Node.js + NPM
- Serveur Web (Apache/Nginx)
- Git (optionnel)

## 🛠️ Étapes d'installation

### 1. Cloner le projet


### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Copier et configurer le fichier d'environnement

```bash
cp .env.example .env
```

Modifier les paramètres de connexion dans `.env` :

```env
APP_NAME="Laravel"
APP_ENV=local
APP_KEY=
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nom_de_la_base
DB_USERNAME=utilisateur
DB_PASSWORD=motdepasse
```

### 4. Générer la clé de l'application

```bash
php artisan key:generate
```

### 5. Lancer les migrations

```bash
php artisan migrate
```

### 6. Installer les dépendances front-end

```bash
npm install && npm run build
```

### 7. Donner les permissions nécessaires

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 8. Lancer le serveur local

```bash
php artisan serve
```

Accédez ensuite à : http://localhost:8000

## 🖨️ Génération de PDF

Ce projet utilise **Dompdf** via `barryvdh/laravel-dompdf` pour générer les factures et fiches de paiements.

### Configuration personnalisée utilisée :

```php
$pdf->setOptions([
    'isHtml5ParserEnabled' => true,
    'isPhpEnabled' => true,
    'defaultFont' => 'Arial',
    'dpi' => 150,
    'fontSubsetting' => true,
    'isRemoteEnabled' => false,
    'enable_font_subsetting' => true,
    'pdf_backend' => 'CPDF',
    'defaultPaperSize' => 'A4',
    'chroot' => public_path(),
]);
```

## 📁 Structure personnalisée

- `app/Models` → Modèles : `Client`, `Compteur`, `Payment`
- `resources/views/` → Vues Blade
- `routes/web.php` → Définition des routes
- `resources/views/payments/fiche_pdf.blade.php` → Vue PDF exportée
- `public/image/miharindrano.png` → Logo utilisé en fond

## ✅ Remarques finales

- L'application utilise un système de filtres dynamiques par mois/année.
- L’impression des fiches de paiement fonctionne directement en PDF.

---

🎉 Le projet est maintenant prêt à être utilisé !