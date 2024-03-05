<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Bagian;
use App\Models\Kontraktor;
use Exception;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class KontraktorController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('master.kontraktor.index');
    }

    public function data(Request $request)
    {
        $query = Kontraktor::with('bagian')->select('*');

        return (new DataTables)->eloquent($query)
            ->addColumn('menu', function ($model) {
                $action = json_decode(session('ACTION_MENU_' . Auth::user()->id));
                $list = '';
                if (in_array('edit', $action)) {
                    $list .= '<li><a class="dropdown-item" href="' . route('master.kontraktor.edit', ['kontraktor' => $model->id]) . '">Edit</a></li>';
                }
                if (in_array('delete', $action)) {
                    $list .= '<li><a class="dropdown-item delete" href="javascript:void(0)" data-id="' . $model->id . '" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>';
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

    public function create()
    {
        $data = null;
        return view('master.kontraktor.create', $this->prepareData() + [
            'data' => $data
        ]);
    }

    public function edit($id)
    {
        $data = Kontraktor::find($id);

        return view('master.kontraktor.create', $this->prepareData() + [
            'data' => $data
        ]);
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'nama' => 'required',
                'jenis' => 'required',
                'bagian' => 'required',
            ])->validate();

            $data = new Kontraktor;

            $data->jenis = $request->jenis;
            $data->nama = $request->nama;
            $data->alamat = $request->alamat;
            $data->kota = $request->kota;
            $data->hp = $request->hp;
            $data->pic_nama = $request->pic_nama;
            $data->pic_jabatan = $request->pic_jabatan;
            $data->pic_ktp = $request->pic_ktp;
            $data->npwp = $request->npwp;
            $data->keterangan = $request->keterangan;
            $data->bagian_id = $request->bagian;
            $data->created_id = Auth::user()->id;
            $data->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('master.kontraktor.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data ' . $e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
        }
    }

    public function update($id, Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'nama' => 'required',
                'jenis' => 'required',
                'bagian' => 'required',
            ])->validate();

            $data = Kontraktor::find($request->kontraktor);

            $data->jenis = $request->jenis;
            $data->nama = $request->nama;
            $data->alamat = $request->alamat;
            $data->kota = $request->kota;
            $data->hp = $request->hp;
            $data->pic_nama = $request->pic_nama;
            $data->pic_jabatan = $request->pic_jabatan;
            $data->pic_ktp = $request->pic_ktp;
            $data->npwp = $request->npwp;
            $data->keterangan = $request->keterangan;
            $data->bagian_id = $request->bagian;
            $data->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('master.kontraktor.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data ' . $e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Kontraktor::find($request->id);
            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }

    private function prepareData()
    {
        $bagian = Bagian::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->nama];
        })->all();
        $bagian = ["" => "---Pilih Bagian---"] + $bagian;

        $jenis = [
            'PT' => 'PT',
            'CV' => 'CV',
            'PERSONAL' => 'PERSONAL',
        ];
        $kota = [
            '' => '---Pilih Kota---',
            'surabaya' => 'Surabaya',
            'sidoarjo' => 'Sidoarjo',
            'gresik' => 'Gresik',
        ];
        return [
            'bagian'         => $bagian,
            'jenis'        => $jenis,
            'kota'        => $kota,
        ];
    }
}
