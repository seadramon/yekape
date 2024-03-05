<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;
use App\Models\Customer;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{

    public function index()
    {
    	return view('master.customer.index');
    }

    public function loadData(Request $request)
    {
    	$query = Customer::select('*');

    	return DataTables::eloquent($query)
            ->addColumn('menu', function ($model) {
                $action = json_decode(session('ACTION_MENU_' . Auth::user()->id));
                $list = '';
                if(in_array('show_ktp_suami', $action)){
                    $list .= '<li><a href="' . route('api.gambar', ['kode' => str_replace('/', '&', ($model->file_ktp_suami ?? "notfound.jpg"))]) . '" target="_blank" class="dropdown-item">Show KTP Suami</a></li>';
                }
                if(in_array('show_ktp_istri', $action)){
                    $list .= '<li><a href="' . route('api.gambar', ['kode' => str_replace('/', '&', ($model->file_ktp_istri ?? "notfound.jpg"))]) . '" target="_blank" class="dropdown-item">Show KTP Istri</a></li>';
                }
                if(in_array('show_kk', $action)){
                    $list .= '<li><a href="' . route('api.gambar', ['kode' => str_replace('/', '&', ($model->file_kk ?? "notfound.jpg"))]) . '" target="_blank" class="dropdown-item">Show KK</a></li>';
                }
                if(in_array('show_npwp', $action)){
                    $list .= '<li><a href="' . route('api.gambar', ['kode' => str_replace('/', '&', ($model->file_npwp ?? "notfound.jpg"))]) . '" target="_blank" class="dropdown-item">Show NPWP</a></li>';
                }
                if(in_array('show_sk', $action)){
                    $list .= '<li><a href="' . route('api.gambar', ['kode' => str_replace('/', '&', ($model->file_sk ?? "notfound.jpg"))]) . '" target="_blank" class="dropdown-item">Show SK</a></li>';
                }
                if(in_array('edit', $action)){
                    $list .= '<li><a class="dropdown-item" href="' . route('master.customer.create', ['id' => $model->id]) . '">Edit</a></li>';
                }
                if(in_array('delete', $action)){
                    $list .= '<li><a class="dropdown-item delete" href="javascript:void(0)" data-id="' .$model->id. '" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>';
                }
                $column = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu">
                            ' . $list . '
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

            $countFile = 0;

	        foreach ($files as $postFile) {
		        if ($request->hasFile($postFile)) {
                    $file = $request->file($postFile);
        
                    $dir = "customer/" . $id;
                    $filename = $postFile . '.' . $file->getClientOriginalExtension();
                    $path = $dir . '/' . $filename;
                    Storage::put($path, File::get($file));
                    $data->$postFile = $path;
                    $countFile++;
		        }
	        }

            if ($countFile > 0) {
                $data->save();
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

    public function searchCustomer(Request $request)
    {
        $search = $request->search;
        $result = null;

        $data = Customer::select('id', 'nama');

        if ($search) {
            $data->where(DB::raw("LOWER(nama)"), 'LIKE', '%'. strtolower($search) . '%');
        }

        $result = $data->orderBy('nama', 'asc')->get();

        return $result;
    }
}
