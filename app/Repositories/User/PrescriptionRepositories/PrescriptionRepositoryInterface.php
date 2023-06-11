<?php

namespace App\Repositories\User\PrescriptionRepositories;

interface PrescriptionRepositoryInterface{

    public function detail($name, $user_id);
}
