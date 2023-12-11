<?php

namespace App\Http\Controllers\ManajemenUser;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleMenu;
use App\Models\Ssh;
use Exception;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('manajemen_user.role.index');
    }

    public function data(Request $request)
    {
        $query = Role::with(['menus' => function($sql){
                $sql->orderBy('seq','ASC');
            }])
            ->select('*');

        return (new DataTables)->eloquent($query)
            ->addColumn('menu_list',function ($item){
                $temp = '';
                foreach($item->menus as $row){
                    if($row->level == 1){
                        $temp .= '<b>#'.$row->name.'</b><br>';
                    }else{
                        $temp .= '--'.$row->name.'<br>';
                    }
                }
                return $temp;
                
            })
            ->addColumn('menu', function ($model) {
            // <li><a class="dropdown-item delete" href="javascript:void(0)" data-id="' .$model->id. '" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>
                $column = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="' . route('manajemen-user.role.edit', $model->id) . '">Edit</a></li>
                            <li><a class="dropdown-item" href="' . route('manajemen-user.role.setting-menu', $model->id) . '">Setting Menu</a></li>
                        </ul>
                        </div>';

                return $column;
            })
            ->rawColumns(['menu', 'menu_list'])
            ->toJson();
    }

    public function create()
    {
        $data = null;


        return view('manajemen_user.role.create', ['data' => $data] + $this->prepareData());
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


        return view('manajemen_user.role.create', ['data' => $data] + $this->prepareData());
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

    public function settingMenu($id)
    {   
        $role = Role::find($id);
        $data = Menu::with(['in_role' => function($sql) use ($id){
                    $sql->where('role_id', $id);
                }])->orderBy('seq','ASC')
                ->get();
        
        return view('manajemen_user.role.setting_menu', [
            'id' => $id,
            'role' => $role,
        ]);
    }

    public function settingMenuTreeData(Request $request){
        $data = Menu::with(['in_role' => function($sql) use ($request){
                $sql->where('role_id',$request->id);
            }])->orderBy('seq','ASC')
            ->get();

        $json = [];
        foreach($data as $row){
            $icon = 'fa fa-link';
            if(in_array($row->level, [1, 3])){
                $icon = 'fa fa-folder';
            }else if($row->level == 2 || $row->level == 4 ){
                $icon = 'fa fa-file';
            }
            $json[] = [
                'id' => $row->id,
                'parent' => in_array($row->level, [2, 3, 4]) ? $row->parent_id : '#',
                'text' => $row->name,
                'icon' => $icon,
                'li_attr' => ['val_id'=>$row->id],
                'state' => [
                    'selected' => ($row->in_role == null) || in_array($row->level, [1, 3]) || (count($row->action) > 0)  ? false : true,
                    'opened' => true
                ]
            ];
            foreach ($row->action as $action) {
                $json[] = [
                    'id' => $row->id . "|" . $action, 
                    'parent' => $row->id,
                    'text' => Str::camel($action),
                    'icon' => 'fa-solid fa-location-crosshairs',
                    'li_attr' => ['val_id' => $row->id . "|" . $action],
                    'state' => [
                        'selected' => in_array($action, $row->in_role->action_menu ?? []) ? true : false,
                        'opened' => true
                    ]
                ];
            }
        }
        return response()->json(['data' => $json]);
    }

    public function settingMenuUpdate(Request $request)
    {
        $id = $request->role_id;
        $data = collect($request->data)->filter(function($item){ return !str_contains($item, '|'); });
        $actions = collect($request->data)->filter(function($item){ return str_contains($item, '|'); })->groupBy(function($item){ return explode('|', $item)[0]; });
        
        $clearing = RoleMenu::where('role_id',$id)->delete();
        
        foreach($data as $row){
            if($row != null){
                if(str_contains($row, 'mobile')){
                    // $menuid = str_replace('mobile', '', $row);
                    // $rmm = new RoleMenuMobile;
                    // $rmm->role_id = $id;
                    // $rmm->menu_id =$menuid;
                    // $rmm->save();
                }else{
                    $roleName = Role::find($id);
                    $cc = Menu::where('id',$row)->first(); 
    
                    if($cc->level == 0){
                        $input = new RoleMenu();
                        $input->role_id = $id;
                        $input->menu_id = $cc->id;
                        $input->save();
                    }else if($cc->level == 2){
                        $input = new RoleMenu();
                        $input->role_id = $id;
                        $input->menu_id = $row;
                        $input->save();
    
                        $aa = Menu::find($row);
                        $ch = RoleMenu::where('role_id',$id)->where('menu_id',$aa->parent_id)->first();
                        if($aa != null && $ch == null){
                            $input = new RoleMenu();
                            $input->role_id = $id;
                            $input->menu_id = $aa->parent_id;
                            $input->save();
                        }
                    }else if($cc->level == 4){
                        $input = new RoleMenu();
                        $input->role_id = $id;
                        $input->menu_id = $row;
                        $input->save();
    
                        $aa = Menu::find($row);
                        $ch = RoleMenu::where('role_id',$id)->where('menu_id',$aa->parent_id)->first();
                        if($aa != null && $ch == null){
                            $input = new RoleMenu();
                            $input->role_id = $id;
                            $input->menu_id = $aa->parent_id;
                            $input->save();
                        }
    
                        $aa1 = Menu::find($aa->parent_id);
                        $ch1 = RoleMenu::where('role_id',$id)->where('menu_id',$aa1->parent_id)->first();
                        if($aa1 != null && $ch1 == null){
                            $input = new RoleMenu();
                            $input->role_id = $id;
                            $input->menu_id = $aa1->parent_id;
                            $input->save();
                        }
                    }
                }
            }
        }
        foreach ($actions as $key => $rows) {
            $action_menu = collect($rows)->map(function($item){ return explode("|", $item)[1]; });
            $input = RoleMenu::firstOrNew([
                'role_id' => $id,
                'menu_id'  => $key
            ]);
            $input->action_menu = $action_menu->all();
            $input->save();
        }                       
        return 'success';
    }

    public function settingMenuDelete($id, FlasherInterface $flasher)
    {
        $checking = RoleMenu::where('role_id',$id)->delete();
        $flasher->addSuccess('Data berhasil dihapus!');
        return redirect()->route('manajemen-user.role.setting-menu', ['id' => $id]);
    }

    protected function prepareData(){
        
        return [
            
        ];
    }
}
