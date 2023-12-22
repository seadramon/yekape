<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'ssh' => 'App\Models\Ssh'
        ]);
        View::composer('layout', function($view)
        {
            $menus = Menu::with(['childmenus' => function($sql){
                    $sql->whereHas('roles', function($sql){
                        $sql->where('roles.id', Auth::user()->role_id);
                    });
                    $sql->orderBy('seq', 'asc');
                    $sql->with(['childmenus' => function($sql){
                        $sql->whereHas('roles', function($sql){
                            $sql->where('roles.id', Auth::user()->role_id);
                        });
                        $sql->orderBy('seq', 'asc');
                    }]);
                }])
                ->whereHas('roles', function($sql){
                    $sql->where('roles.id', Auth::user()->role_id);
                })
                ->whereIn('level', [0, 1])
                ->orderBy('seq', 'asc')
                ->get();

            $generatedMenu = '';
            foreach ($menus as $menu) {
                if($menu->level == 0){
                    $generatedMenu .= $this->menu0($menu);
                }else{
                    $generatedMenu .= $this->generate($menu);
                }
            }
            $view->with('menus', $generatedMenu);
        });
    }

    private function menu0($menu)
    {
        return '<div class="menu-item">
            <a class="menu-link" href="' . route($menu->route_name) . '">
                <span class="menu-icon">
                    <i class="' . $menu->icon . '"></i>
                </span>
                <span class="menu-title">' . $menu->name . '</span>
            </a>
        </div>';
    }

    private function generate($menu)
    {
        if(in_array($menu->level, [1, 3])){
            $child = '';
            foreach ($menu->childmenus as $ch) {
                $child .= $this->generate($ch);
            }
            $parent = '<div data-kt-menu-trigger="{default: \'click\', lg: \'hover\'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention">
                <span class="menu-link">
                    <span class="menu-icon">
                        <i class="' . $menu->icon . '"></i>
                    </span>
                    <span class="menu-title">' . $menu->name . '</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-2 py-4 w-200px mh-75 overflow-auto">
                    <div class="menu-item">
                        ' . $child . '
                    </div>
                </div>
            </div>';
        }elseif (in_array($menu->level, [2, 4])) {
            // $parent = '<a class="menu-link" href="' . route($menu->route_name) . '">
            //     <span class="menu-bullet">
            //         <span class="bullet bullet-dot"></span>
            //     </span>
            //     <span class="menu-title">' . $menu->name . '</span>
            // </a>';
            $parent = '<a class="menu-link" href="' . route($menu->route_name) . '">
                <span class="menu-icon">
                    <i class="' . $menu->icon . '"></i>
                </span>
                <span class="menu-title">' . $menu->name . '</span>
            </a>';
        }
        return $parent;
    }
}
