<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    public function all($user_filter = false);

    public function active();

    public function disable();

    public function find($id);

    public function create(array $data);

    public function insert(array $data);

    public function insertIgnore(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function show($id);

    public function with($relations);

    public function findById($id);

    public function karakter_temizle($string);

    public function file_path($data, $type);

    public function save_file($type, $filesInfo, $fileName);

}
