<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Religion;
use App\Models\Teacher;
use Carbon\Carbon;
use Exception;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class KaryawanController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('karyawan.index');
    }

    public function data(Request $request)
    {
        $query = Karyawan::with('jabatan.bagian')->select('*');

        return (new DataTables)->eloquent($query)
            ->addColumn('menu', function ($model) {
                $column = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="'.route('karyawan.edit', ['karyawan' => $model->id]).'">Edit</a></li>
                            <li><a class="dropdown-item delete" href="javascript:void(0)" data-id="'.$model->id.'" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>
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

        $jabatans = Jabatan::get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->nama];
            })
            ->all();
        $jabatans = ['' => 'Pilih Jabatan'] + $jabatans;

        $genders = ['L' => 'Laki-Laki', 'P' => 'Perempuan'];

        return view('karyawan.create', [
            'jabatans' => $jabatans,
            'genders' => $genders,
            'data' => $data,
        ]);
    }

    public function edit($id)
    {
        $data = null;

        $religions = Religion::get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->religion];
            })
            ->all();
        $religions = ['' => 'Choose Religion'] + $religions;

        $genders = ['L' => 'Male', 'P' => 'Female'];

        if ($id) {
            $data = Teacher::find($id);
        }

        return view('master.teacher.edit', [
            'religions' => $religions,
            'genders' => $genders,
            'data' => $data,
            'id' => $id,
        ]);
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'nama' => 'required',
                'jabatan_id' => 'required',
            ])->validate();

            $karyawan = new Karyawan;

            $karyawan->nik = $request->nik;
            $karyawan->nama = $request->nama;
            $karyawan->alamat_ktp = $request->alamat_ktp;
            $karyawan->alamat_domisili = $request->alamat_domisili;
            $karyawan->tempat_lahir = $request->tempat_lahir;
            $karyawan->tgl_lahir = $request->tgl_lahir;
            $karyawan->jabatan_id = $request->jabatan_id;
            $karyawan->jenis_kelamin = $request->jenis_kelamin;
            $karyawan->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('karyawan.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data Teacher '.$e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
        }
    }

    public function update($id, Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'name' => 'required',
                'religion_id' => 'required',
            ])->validate();

            $teacher = Teacher::find($request->id);

            $teacher->name = $request->name;
            $teacher->phone_number = $request->phone_number;
            $teacher->religion_id = $request->religion_id;
            $teacher->gender = $request->gender;
            $teacher->pob = $request->pob;
            $teacher->dob = Carbon::createFromFormat('d/m/Y', $request->dob)->format('Y-m-d');
            $teacher->address = $request->address;

            $teacher->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('master.teacher.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data Teacher '.$e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Teacher::find($request->id);
            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }
}
