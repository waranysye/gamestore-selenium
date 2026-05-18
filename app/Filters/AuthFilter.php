<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    // app/Filters/AuthFilter.php

public function before(RequestInterface $request, $arguments = null)
{
    // Jika sedang testing, kita bisa melonggarkan filter atau pastikan session terbaca
    if (ENVIRONMENT === 'testing') {
        // Opsional: Logika tambahan jika diperlukan
    }

    if (!session()->get('user_id')) {
        return redirect()->to('/login');
    }

    return null;
}

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tidak dipakai
    }
}