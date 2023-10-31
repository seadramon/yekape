<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;
use App\Models\Customer;

use Intervention\Image\ImageManagerStatic as Image;
use Yajra\DataTables\Facades\DataTables;
use DB;
use File;
use Storage;

class CustomerController extends Controller
{

    public function index()
    {
        Cus
    	return view('master.customer.index');
    }

    public function loadData(Request $request)
    {
    	$query = Customer::select('*');

    	return DataTables::eloquent($query)
            ->addColumn('menu', function ($model) {
                $column = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-title="File KTP Suami" data-bs-image="'. asset($model->file_ktp_suami) .'">Show KTP Suami</a></li>
                            <li><a href="javascript:void(0)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-title="File KTP Istri" data-bs-image="'. asset($model->file_ktp_istri) .'">Show KTP Istri</a></li>
                            <li><a href="javascript:void(0)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-title="File KK" data-bs-image="'. asset($model->file_kk) .'">Show KK</a></li>
                            <li><a href="javascript:void(0)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-title="File NPWP" data-bs-image="'. asset($model->file_npwp) .'">Show NPWP</a></li>
                            <li><a href="javascript:void(0)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-title="File SK" data-bs-image="'. asset($model->file_sk) .'">Show SK</a></li>
                            <li><a class="dropdown-item" href="' . route('master.customer.create', ['id' => $model->id]) . '">Edit</a></li>
                            <li><a class="dropdown-item delete" href="javascript:void(0)" data-id="' .$model->id. '" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>
                        </ul>
                        </div>';

                return $column;
            })
            ->rawColumns(['menu'])
            ->toJson();
    }

    public function create($id = null)
    {
        $data = null;

        if ($id) {
            $data = Customer::find($id);
        }

    	$agama = [
    		"" => "-Pilih Agama-",
    		"ISLAM" => "Islam",
    		"KRISTEN" => "Kristen",
    		"HINDU" => "Hindu",
    		"BUDHA" => "Budha"
    	];
    	$jk = [
    		"" => "-Pilih Jenis Kelamin-",
    		'L' => 'Laki-laki',
    		'P' => 'Perempuan'
    	];
    	return view('master.customer.create', compact('agama', 'jk', 'data'));
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();

            if ($request->id) {
            	$data = Customer::find($request->id);
            } else {
            	$data = new Customer;
            }

			$data->no_ktp = $request->no_ktp;
	        $data->nama = $request->nama;
	        $data->telp_1 = $request->telp_1;
	        $data->telp_2 = $request->telp_2;
	        $data->tempat_lahir = $request->tempat_lahir;
	        $data->tanggal_lahir = date('Y-m-d', strtotime($request->tanggal_lahir));
	        $data->agama = $request->agama;
	        $data->jenis_kelamin = $request->jenis_kelamin;
	        $data->alamat = $request->alamat;
	        $data->kelurahan = $request->kelurahan;
	        $data->kecamatan = $request->kecamatan;
	        $data->kota = $request->kota;
	        $data->pekerjaan = $request->pekerjaan;
	        $data->nama_usaha = $request->nama_usaha;
	        $data->telp_usaha = $request->telp_usaha;
	        $data->alamat_usaha = $request->alamat_usaha;
	        $data->no_kk = $request->no_kk;
	        $data->no_npwp = $request->no_npwp;
	        $data->email = $request->email;
	        $data->nama_pajak = $request->nama_pajak;
	        $data->alamat_pajak = $request->alamat_pajak;
	        $data->kota_pajak = $request->kota_pajak;
	        $data->doc = date('Y-m-d H:i:s');
	        $data->save();

	        $id = $data->id;

            DB::commit();

            // Store FIle Upload
	        $files = [
	        	'file_ktp_suami',
	        	'file_ktp_istri',
	        	'file_kk',
	        	'file_npwp',
	        	'file_sk'
	        ];

            $customerFile = Customer::find($id);
            $countFile = 0;

	        foreach ($files as $postFile) {
		        if ($request->hasFile($postFile)) {
		        	$save_path = storage_path('app/public/customers/'. $id);
		        	if (!file_exists($save_path)) {
			            mkdir($save_path, 775, true);
			        }

		            $extension = $request->file($postFile)->getClientOriginalExtension();
		            $file = Image::make($request->file($postFile));
		            $file->resize(300, null, function ($constraint) {
		                $constraint->aspectRatio();
		            });
                    $filename = $postFile.'.'. $extension;
		            $file->save(storage_path('app/public/customers/'. $id .'/'.$filename));

                    $customerFile->$postFile = 'storage/customers/' . $id . '/' . $filename;

                    $countFile++;
		        }
	        }

            if ($countFile > 0) {
                $customerFile->save();
                DB::commit();
            }

            $flasher->addSuccess('Data has been saved successfully!');
            return redirect()->route('master.customer.index');
        } catch(Exception $e) {
            DB::rollback();

            $flasher->addError($e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Customer::find($request->id);
            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }
}
