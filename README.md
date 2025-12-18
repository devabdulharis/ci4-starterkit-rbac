# CodeIgniter 4 + DaisyUI RBAC Starter

Starter project ini adalah boilerplate modern untuk aplikasi berbasis **CodeIgniter 4** yang sudah terintegrasi dengan **Tailwind CSS + DaisyUI** serta sistem **Role-Based Access Control (RBAC)** yang lengkap.

Cocok untuk memulai project baru yang membutuhkan manajemen user, role, dan permission dengan tampilan UI yang cantik dan responsif.

## 🚀 Fitur Utama

-   **Authentication**: Login user dengan secure hashing.
-   **RBAC System**:
    -   Manajemen User, Role, dan Permission via UI.
    -   Route filtering berdasarkan permission (e.g. `users.view`, `roles.create`).
    -   Helper function `service('rbac')->hasPermission(...)` untuk logic di view/controller.
-   **Modern UI**:
    -   Menggunakan **Tailwind CSS** (via CDN untuk dev).
    -   Component library **DaisyUI** (Modal, Table, Alert, dll).
    -   **Dark/Light Mode** dengan persistence (disimpan otomatis).
    -   Layout responsif (Sidebar + Navbar).
-   **Functional**:
    -   Pagination & Search bawaan.
    -   User Profile management.
    -   Flash messages untuk notifikasi.

---

## 🛠️ Instalasi

1.  **Clone Repository **
    ```bash
    git clone https://github.com/devabdulharis/ci4-starterkit-rbac.git
    cd ci4-starterkit-rbac
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    ```

3.  **Setup Database**
    -   Buat database baru di MySQL (e.g., `ci4_rbac`).
    -   Copy file `.env.example` ke `.env` dan sesuaikan koneksi database:
        ```env
        database.default.hostname = localhost
        database.default.database = ci4_rbac
        database.default.username = root
        database.default.password = 
        database.default.DBDriver = MySQLi
        ```

4.  **Run Migrations & Seeds**
    Jalankan perintah ini untuk membuat tabel dan data awal (Admin user, Basic Roles):
    ```bash
    php spark migrate
    php spark db:seed PermissionSeeder
    ```
    *Note: Seeder akan membuat user `admin` dengan password `password`.*

5.  **Jalankan Server**
    ```bash
    php spark serve
    ```
    Buka `http://localhost:8080` di browser.

---

## 💻 Panduan Pengembangan (Dev Guide)

### 1. Membuat Modul Baru (Contoh: Produk)

Ingin menambahkan fitur "Manajemen Produk"? Ikuti langkah ini:

**A. Buat Controller & Model**
Gunakan `spark` untuk generate file dasar:
```bash
php spark make:model Product --suffix
php spark make:controller Product --suffix
```

**B. Definisikan Permission Baru**
Masuk ke menu **Permissions** di aplikasi (`/permissions`) dan tambahkan permission baru agar bisa diatur hak aksesnya:
-   `products.view`
-   `products.create`
-   `products.edit`
-   `products.delete`

**C. Atur Routing dengan Filter RBAC**
Buka `app/Config/Routes.php` dan tambahkan group route baru:
```php
$routes->group('products', function($routes) {
    $routes->get('', 'ProductController::index', ['filter' => 'rbac:products.view']);
    $routes->get('create', 'ProductController::create', ['filter' => 'rbac:products.create']);
    $routes->post('store', 'ProductController::store', ['filter' => 'rbac:products.create']);
    // ... dst
});
```

**D. Buat View dengan DaisyUI**
Copy struktur layout dari `app/Views/users/index.php` untuk konsistensi. Gunakan `layouts/main` sebagai template utama.
```php
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
    <h1>Product List</h1>
    <!-- Table content here -->
<?= $this->endSection() ?>
```

**E. Proteksi Tombol di View**
Sembunyikan tombol jika user tidak punya akses:
```php
<?php if (service('rbac')->hasPermission('products.create')): ?>
    <a href="/products/create" class="btn btn-primary">Add Product</a>
<?php endif; ?>
```

### 2. Mengubah Tampilan (UI)
-   **Theme**: Konfigurasi tema ada di `app/Views/layouts/main.php`. Default menggunakan `emerald` (light) dan `dim` (dark). Anda bisa menggantinya dengan tema DaisyUI lainnya.
-   **Components**: Cek dokumentasi [DaisyUI](https://daisyui.com/) untuk komponen siap pakai (Card, Modal, Button, dll).

### 3. Tips
-   **Password**: Default user admin adalah `admin@example.com` / `password`. Segera ganti setelah login.
-   **Icons**: Project ini menggunakan HeroIcons (via SVG inline).

---

## 🔒 Struktur Tabel (RBAC)
-   `users`: Data pengguna login.
-   `roles`: Grup pengguna (e.g. Admin, Editor).
-   `permissions`: Hak akses spesifik (e.g. `users.create`).
-   `files`: (Role <-> Permission) & (User <-> Role).

Happy Coding! 🚀
