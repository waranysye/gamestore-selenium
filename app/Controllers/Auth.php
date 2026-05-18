<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    protected UserModel $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session   = session();
    }

    // ======================
    // LOGIN VIEW
    // ======================
    public function login()
    {
        return view('SignIn');
    }

    // ======================
    // PROCESS LOGIN
    // ======================
    public function attemptLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email and password are required.');
        }

        $user = $this->userModel
            ->where('email', $this->request->getPost('email'))
            ->first();

        if (
    !$user ||
    $this->request->getPost('password') !== $user['password']
    ) {
    return redirect()->back()
        ->withInput()
        ->with('error', 'Invalid email or password.');
    }

        if (ENVIRONMENT !== 'testing') {
    $this->session->regenerate(true);
    }

        $this->session->set([
            'user_id'    => $user['id'],
            'name'       => $user['name'],
            'role'       => $user['role'],
            'isLoggedIn' => true
        ]);

        return $user['role'] === 'admin'
    ? redirect()->to('/admin/users')
    : redirect()->to('/');
    }

    // ======================
    // SIGN UP VIEW
    // ======================
    public function signup()
    {
        return view('SignUp');
    }

    // ======================
    // PROCESS SIGN UP
    // ======================
    public function attemptSignup()
    {
        // ⛔ WAJIB SETUJU DULU
        if (!$this->request->getPost('agree')) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'You must agree to the Terms and Privacy Policy.');
        }

        $rules = [
            'name'     => 'required|alpha_space|min_length[3]|max_length[50]', // Ditambah alpha_space
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]'
        ];

        $errors = [
            'name' => [
                'alpha_space' => 'Name can only contain letters and spaces (no numbers or symbols).',
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        // ✅ SIMPAN USER
        $this->userModel->insert([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role' => 'user'
        ]);

        // ✅ SETELAH BERHASIL → KE SIGN IN
        return redirect()->to('/login')
            ->with('success', 'Account successfully created. Please sign in.');
    }

    // ======================
    // AJAX REAL-TIME CHECK
    // ======================
    public function checkAvailability()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        if ($this->request->getPost('email')) {
            if ($this->userModel->where(
                'email',
                $this->request->getPost('email')
            )->first()) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Email already registered'
                ]);
            }
        }

        if (
            $this->request->getPost('password') &&
            strlen($this->request->getPost('password')) < 6
        ) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Password must be at least 6 characters'
            ]);
        }

        return $this->response->setJSON(['status' => 'ok']);
    }

    // ======================
    // LOGOUT
    // ======================
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }
}