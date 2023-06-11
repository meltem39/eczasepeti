<?php

namespace App\Repositories\Pharmacy\NonMedicineRepositories;

use App\Models\NonMedicine;
use App\Repositories\EloquentBaseRepository;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class NonMedicineRepository.
 */
class NonMedicineRepository extends EloquentBaseRepository implements NonMedicineRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    protected $model;

    public function __construct(NonMedicine $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    public function add($id, $detail){
        if(isset($detail["data"])){
            $file_info = array();
            $filesInfo = pathinfo($detail["data"]->getClientOriginalName());
            $fileName = $this->karakter_temizle($filesInfo["filename"]). "-" . time() . "." . $detail["data"]->getClientOriginalExtension();
            $path_detail = $this->path_create($id, "non_medical");
            $file = $detail["data"]->move(public_path($path_detail["path"]), $fileName);
            $create = $this->save_file("non_medical", $filesInfo, $fileName);
            $detail["name"] = $filesInfo["basename"];
            $detail["type"] = $filesInfo["extension"];
            $detail["data"] = $fileName;
        }
        $detail["pharmacy_id"] = $id;
        $insert = $this->model->create($detail);
        return $insert;
    }
}
