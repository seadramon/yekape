<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bagian;
use App\Models\Kontraktor;
use App\Models\Serapan;
use App\Models\Spk;
use Exception;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SpkController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('spk.index');
    }

    public function data(Request $request)
    {
        $query = Spk::with('kontraktor', 'serapan')->select('*');

        return (new DataTables)->eloquent($query)
            ->addColumn('menu', function ($model) {
                $action = json_decode(session('ACTION_MENU_' . Auth::user()->id));
                $list = '';
                $list .= '<li><a class="dropdown-item" href="' . route('spk.edit', ['spk' => $model->id]) . '">Edit</a></li>';
                if (in_array('edit', $action)) {
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
        return view('spk.create', $this->prepareData() + [
            'data' => $data
        ]);
    }

    public function edit($id)
    {
        $data = Spk::find($id);

        return view('spk.create', $this->prepareData() + [
            'data' => $data
        ]);
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'nomor' => 'required',
                'jenis' => 'required',
                'serapan' => 'required',
                'kontraktor' => 'required',
            ])->validate();

            $data = new Spk;

            $data->nomor = $request->nomor;
            $data->jenis = $request->jenis;
            $data->tanggal = date('Y-m-d', strtotime($request->tanggal));
            $data->serapan_id = $request->serapan;
            $data->kontraktor_id = $request->kontraktor;
            $data->uraian = $request->uraian;
            $data->nilai = str_replace(',', '.', str_replace('.', '', $request->nilai));
            $data->ppn_nilai = str_replace(',', '.', str_replace('.', '', $request->ppn_nilai));
            $data->ppn = $request->ppn;
            $data->pic_jabatan = $request->pic_jabatan;
            $data->pic_ktp = $request->pic_ktp;
            $data->npwp = $request->npwp;
            $data->keterangan = $request->keterangan;
            $data->bagian_id = $request->bagian;
            $data->created_id = Auth::user()->id;
            $data->save();

            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $dir = "spk/" . $data->id;
                $filename = 'file' . '.' . $file->getClientOriginalExtension();
                $path = $dir . '/' . $filename;
                Storage::put($path, File::get($file));
                $data->path_file = $path;
                $data->save();
            }

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('spk.index');
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
                'nomor' => 'required',
                'jenis' => 'required',
                'serapan' => 'required',
                'kontraktor' => 'required',
            ])->validate();

            $data = Spk::find($request->spk);

            $data->nomor = $request->nomor;
            $data->jenis = $request->jenis;
            $data->tanggal = date('Y-m-d', strtotime($request->tanggal));
            $data->serapan_id = $request->serapan;
            $data->kontraktor_id = $request->kontraktor;
            $data->uraian = $request->uraian;
            $data->nilai = str_replace(',', '.', str_replace('.', '', $request->nilai));
            $data->ppn_nilai = str_replace(',', '.', str_replace('.', '', $request->ppn_nilai));
            $data->ppn = $request->ppn;
            $data->pic_jabatan = $request->pic_jabatan;
            $data->pic_ktp = $request->pic_ktp;
            $data->npwp = $request->npwp;
            $data->keterangan = $request->keterangan;
            $data->bagian_id = $request->bagian;
            $data->created_id = Auth::user()->id;
            $data->save();

            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $dir = "spk/" . $data->id;
                $filename = 'file' . '.' . $file->getClientOriginalExtension();
                $path = $dir . '/' . $filename;
                Storage::put($path, File::get($file));
                $data->path_file = $path;
                $data->save();
            }

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('spk.index');
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
            $data = Spk::find($request->id);
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
        $serapan = Serapan::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->kode . ' | ' . $item->nama];
        })->all();
        $serapan = ["" => "---Pilih PP---"] + $serapan;
        $kontraktor = Kontraktor::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->jenis . ' | ' . $item->nama];
        })->all();
        $kontraktor = ["" => "---Pilih PP---"] + $kontraktor;

        $jenis = [
            '' => '---Pilih Jenis---',
            'konstruksi' => 'Konstruksi',
            'nonkonstruksi' => 'Non Konstruksi',
        ];
        $ppn = [
            '0' => 'Tanpa PPN',
            '10' => 'PPN 10%',
            '11' => 'PPN 11%',
        ];
        return [
            'serapan'         => $serapan,
            'jenis'        => $jenis,
            'kontraktor'        => $kontraktor,
            'ppn'        => $ppn,
        ];
    }
}
