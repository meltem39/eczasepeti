<?php

namespace App\Repositories\User\PrescriptionRepositories;

use App\Models\Prescriptions;
use App\Repositories\EloquentBaseRepository;
use Carbon\Carbon;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class PrescriptionRepository.
 */
class PrescriptionRepository extends EloquentBaseRepository implements PrescriptionRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    protected $model;

    public function __construct(Prescriptions $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    public function detail($name, $user_id){
        date_default_timezone_set('Etc/GMT-3');
        $find = Prescriptions::where("code", $name)->where("user_id", $user_id)->first();
        $compare_date = Carbon::parse($find->expiry_date)->gt(Carbon::now());
        if ($compare_date)
            return $find;
        return false;
    }
}
