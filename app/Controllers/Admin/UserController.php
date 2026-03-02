<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // =========================
    // LIST USERS
    // =========================
    public function index()
{
    $data['users'] = $this->userModel->findAll();
    return view('admin/users/index', [
    'users'  => $data['users'],
    'active' => 'users'
]);
}

    // =========================
    // SHOW CREATE FORM
    // =========================
    public function create()
    {
        return view('admin/users/create');
    }

    // =========================
    // STORE USER
    // =========================
    public function store()
    {
        $this->userModel->save([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
        ]);

        return redirect()->to('/admin/users')->with('success', 'User created successfully');
    }

    // =========================
    // SHOW EDIT FORM
    // =========================
    public function edit($id)
    {
        $data['user'] = $this->userModel->find($id);

        if (!$data['user']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/users/edit', $data);
    }

    // =========================
    // UPDATE USER
    // =========================
    public function update($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $updateData = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'role'  => $this->request->getPost('role'),
        ];

        // Update password only if filled
        if ($this->request->getPost('password')) {
            $updateData['password'] = password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            );
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to('/admin/users')->with('success', 'User updated successfully');
    }

    // =========================
    // DELETE USER
    // =========================
    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->userModel->delete($id);

        return redirect()->to('/admin/users')->with('success', 'User deleted successfully');
    }
}