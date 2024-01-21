<?php

namespace App\Http\Controllers\ManajemenUser;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleMenu;
use App\Models\Ssh;
use App\Models\User;
use Exception;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('manajemen_user.user.index');
    }

    public function data(Request $request)
    {
        $query = User::with('karyawan')
            ->has('karyawan')
            ->select('*');

        return (new DataTables)->eloquent($query)
            ->addColumn('menu', function ($model) {
            // <li><a class="dropdown-item delete" href="javascript:void(0)" data-id="' .$model->id. '" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>
                $column = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="' . route('manajemen-user.user.ganti-password', $model->id) . '">Ganti Password</a></li>
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


        return view('manajemen_user.user.create', ['data' => $data] + $this->prepareData());
    }


    public function store(Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'name' => 'required',
            ])->validate();

            $temp = new Role;

            $temp->name = $request->name;
            $temp->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('manajemen-user.role.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data SSH '.$e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
        }
    }

    public function edit($ssh)
    {
        $data = Role::find($ssh);


        return view('manajemen_user.user.create', ['data' => $data] + $this->prepareData());
    }

    public function update(Request $request, FlasherInterface $flasher, $ssh)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'name' => 'required'
            ])->validate();

            $temp = Role::find($ssh);

            $temp->name = $request->name;
            $temp->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('manajemen-user.role.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data Role '.$e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Role::find($request->id);
            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }

    public function gantiPasswordLink($id)
    {   
        $data = User::find($id);

        return view('manajemen_user.user.ganti-password', ['data' => $data] + $this->prepareData());
    }

    public function gantiPasswordStore(Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'password' => 'required',
                're_password' => 'required|same:password',
            ])->validate();

            $temp = User::find($request->id);

            $temp->password = Hash::make($request->password);
            $temp->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('manajemen-user.user.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data User '.$e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
        }
    }

    protected function prepareData(){
        
        return [
            
        ];
    }
}
