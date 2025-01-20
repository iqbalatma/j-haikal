<?php

namespace App\View\Components\Layouts\Dashboard;

use App\Models\Menu;
use App\Repositories\MenuRepository;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public Collection $_menus;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        if (!($allMenu = Cache::get(config("cache.keys.all_menus")))) {
            $allMenu = MenuRepository::getAllTopLevelMenuWithChildren();
            $allMenu = $allMenu->map(function (Menu $item) {
                $item->children_routes = $item->children->pluck("route_name_group");
                return $item;
            });
            Cache::put(config("cache.keys.all_menus"), $allMenu);
        }

        $allMenu->map(function (Menu $item) {
            $item->is_child_active_exist = false;
            foreach ($item->children_routes as $children_route) {
                if (request()->routeIs($children_route . "*")) {
                    $item->is_child_active_exist = true;
                }
            }

            return $item;
        });

        $this->_menus = $allMenu;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.dashboard.sidebar');
    }
}
