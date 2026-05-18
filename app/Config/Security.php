<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Security extends BaseConfig
{
    // Gunakan session untuk keamanan lebih baik
    public string $csrfProtection = 'session'; 

    // Aktifkan untuk mencegah eksploitasi token statis
    public bool $tokenRandomize = true;

    // Nama token yang muncul di input hidden (bebas diubah)
    public string $tokenName = 'csrf_gamestore_token';
    
    public string $headerName = 'X-CSRF-TOKEN';

    public string $cookieName = 'csrf_cookie_name';

    public int $expires = 7200;

    // Biarkan true agar setiap submit form menghasilkan token baru
    public bool $regenerate = true;

    // Biarkan false di development/testing agar muncul error 403 yang jelas
    public bool $redirect = (ENVIRONMENT === 'production');
}

