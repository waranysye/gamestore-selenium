<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    // List categories
    public function index()
    {
        $data['categories'] = $this->categoryModel->findAll();
        return view('admin/categories/index', [
        'categories' => $data['categories'],
        'active'     => 'categories'
]);
    }

    // Form Add Category
    public function create()
    {
        return view('admin/categories/create'); // <- path diperbaiki
    }

    // Store new category
    public function store()
    {
        $name = $this->request->getPost('name');
        $slug = $this->request->getPost('slug');

        if (empty($slug)) {
            $slug = strtolower(str_replace(' ', '-', $name));
        }

        $this->categoryModel->save([
            'name' => $name,
            'slug' => $slug,
        ]);

        return redirect()->to('/categories');
    }

    // Form Edit Category
    public function edit($id = null)
    {
        $data['category'] = $this->categoryModel->find($id);
        if (!$data['category']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Category not found');
        }
        return view('admin/categories/edit', $data); // <- path diperbaiki
    }

    // Update category
    public function update($id = null)
    {
        $name = $this->request->getPost('name');
        $slug = $this->request->getPost('slug');

        if (empty($slug)) {
            $slug = strtolower(str_replace(' ', '-', $name));
        }

        $this->categoryModel->update($id, [
            'name' => $name,
            'slug' => $slug,
        ]);

        return redirect()->to('/categories');
    }

    // Delete category
    public function delete($id = null)
    {
        $this->categoryModel->delete($id);
        return redirect()->to('/categories');
    }
}