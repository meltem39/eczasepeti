<?php

namespace App\Repositories;

use App\Models\AccountDocument;
use App\Models\AccountImage;
use App\Models\BranchModule;
use App\Models\CurrencyFormula;
use App\Models\NonMedicine;
use App\Models\StockImage;
use App\Models\UserImage;
use Carbon\Carbon;
use App\Models\Company;
use App\Models\CompanyBranch;
use App\Models\Customer;
use App\Models\ExchangeExtreme;
use App\Models\ExchangePreference;
use App\Models\PaymentInfo;
use App\Models\ProgramModule;
use App\Models\User;
use Cassandra\Custom;
use Faker\Core\File;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Filesystem\Filesystem;

class EloquentBaseRepository implements BaseRepositoryInterface
{

    protected $model;
    public function __construct(Model $model){
        $this->model = $model;
    }

    public function all($user_filter = false){
        if($user_filter && !Auth::user()->isAdmin())
            return $this->model::orderBy("id", "desc")->whereUserId(Auth::user()->id)->get();

        return $this->model->all();
    }

    public function active(){
        return $this->model->whereStatus(1)->get();
    }

    public function disable(){
        return $this->model->whereStatus(0)->get();
    }

    public function find($id) {
        return $this->model->whereId(strtoupper($id))->first();
    }

    public function create(array $data){
        return $this->model->create($data);
    }

    public function insert(array $data){
        return $this->model->insert($data);
    }

    public function insertIgnore(array $data){
        $result = null;
        try{
            $result = $this->model->insert($data);
        }catch (\Exception $exception){
            Log::error("Record duplicated.");
        }
        return $result;
    }

    public function update(array $data, $id){
        $record = $this->find($id);
        return $record->update($data);
    }

    public function delete($id){
        return $this->model->destroy($id);
    }

    public function show($id){
        return $this->model->findOrFail($id);
    }

    public function with($relations){
        return $this->model->with($relations);
    }

    public function findById($id) {
        if(Auth::user()->isAdmin())
            return $this->model->findOrFail($id);
        $result = $this->model->whereId($id);
        if(!Auth::user()->isAdmin())
            $result = $result->whereUserId(Auth::user()->id);
        $result = $result->first();
        if($result) return $result;
        abort(404);
    }

    public function karakter_temizle($string)
    {
        $find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
        $replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
        $string = strtolower(str_replace($find, $replace, $string));
        $string = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $string);
        $string = trim(preg_replace('/\s+/', ' ', $string));
        $string = str_replace(' ', '-', $string);
        return $string;
    }

    public function file_path($request, $type){
        $validator = Validator::make($request->all(), [
            'data' => 'mimes:jpg,png,mp4,mov,mkv,avi,jpeg|max:10485760'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        if ($files = $request->file('data')){
            $file_info = array();
            $filesInfo = pathinfo($request->file("data")->getClientOriginalName());
            $fileName = $this->karakter_temizle($filesInfo["filename"]) . "-" . time() . "." . $request->file("data")->getClientOriginalExtension();
            $path_detail = $this->path_create($request->id, $type);
            if($path_detail["delete"]){
                $FileSystem = new Filesystem();
                if($FileSystem->exists(public_path($path_detail["path"]))){
                    $files = $FileSystem->files(public_path($path_detail["path"]));
                    if (!empty($files)) {
                        $FileSystem->deleteDirectory(public_path($path_detail["path"]));
                    }
                }
            }
            $file = $request->file("data")->move(public_path($path_detail["path"]), $fileName);
            $create = $this->save_file($type, $request, $filesInfo, $fileName);
            return $create;
        } else return false;
    }

    public function file_paths($request, $type, $id){
        $create = array();
        $path_detail = $this->path_create($id, $type);
        if($path_detail["delete"]){
            $FileSystem = new Filesystem();
            if($FileSystem->exists(public_path($path_detail["path"]))){
                $files = $FileSystem->files(public_path($path_detail["path"]));
                if (!empty($files)) {
                    $FileSystem->deleteDirectory(public_path($path_detail["path"]));
                }
            }
            $delete_table_data = StockImage::where("stock_id", $id)->delete();
        }
        for($i=0; $i<count($request->file("data")); $i++){
            if($files = $request->file("data")[$i]){
                $file_info = array();
                $filesInfo = pathinfo($request->file("data")[$i]->getClientOriginalName());
                $fileName = $this->karakter_temizle($filesInfo["filename"]) . "-" . time() . "-" . $i ."." . $request->file("data")[$i]->getClientOriginalExtension();
                $path_detail = $this->path_create($id, $type);

                $file = $request->file("data")[$i]->move(public_path($path_detail["path"]), $fileName);
                $save = $this->save_file($type, $request, $filesInfo, $fileName);
                $save->save();
                $create[$i] = $save;
            }
        }
        return $create;
    }

    public function save_file($type, $filesInfo, $fileName){
        switch ($type){
            case "non_medical":
                $document = new NonMedicine();
                $document->name = $filesInfo["basename"];
                $document->type = $filesInfo["extension"];
                $document->data = $fileName;
                return $document;

        }
    }

    public function path_create($id, $path_detail){
        switch ($path_detail){
            case "non_medical":
                return ["path" => "../../public_html/files/pharmacy/".$id."/non_medical_image"];

        }
    }


}
