<?php
$permission = getMenuControl();
$menus = [];
if(file_exists(APPPATH . "Views/menus/Backend.json")){
    $menus = file_get_contents(APPPATH . "Views/menus/Backend.json");
    $menus = @json_decode($menus);
}
?>
<!--Sidebar-->
<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <?php
            //Generation of menus
                $module_menu = file_exists(APPPATH . "Modules/Modules.json");
                if (($menus && is_array($menus) && count($menus))) {
                    foreach ($menus as $menu) {
                        if(isset($menu->divider)){
                            if($menu->divider == "App.menu_modules"){
                                //Generation of modules
                                if($module_menu) {
                                    $mods = file_get_contents(APPPATH . "Modules/Modules.json");
                                    $mods = @json_decode($mods);
                                    $enable_module = false;
                                    $permission_module = false;
                                    foreach ($mods as $item) {
                                        if ($item->status) {
                                            $enable_module = true;
                                        }
                                        foreach ($item->rules as $rules){
                                            if($rules == session()->get('group')){
                                                $permission_module = true;
                                            }
                                        }
                                    }
                                    if ($enable_module && $permission_module) {
                                        if (($mods && is_array($mods) && count($mods))) {
                                            echo '<li class="nav-label">' . lang($menu->divider) . '</li>';
                                            foreach ($mods as $item) {
                                                if ($item->status) {
                                                    if (file_exists(APPPATH . "Modules/" . $item->directory . '/app.json')) {
                                                        $app = file_get_contents(APPPATH . "Modules/" . $item->directory . '/app.json');
                                                        $app = @json_decode($app);
                                                        if ($app && $app->type == 'module') {
                                                            if (($app && is_array($app->menu) && count($app->menu))) {
                                                                foreach ($app->menu as $menu) {
                                                                    $submenu = '';
                                                                    foreach ($menu->children as $children) {
                                                                        if ($children->external) {
                                                                            $submenu .= '<li><a target="_blank" href="' . $children->url . '">' . lang($children->title) . '</a></li>';
                                                                        } else {
                                                                            $submenu .= '<li><a href="' . site_url($children->url) . '">' . lang($children->title) . '</a></li>';
                                                                        }
                                                                    }
                                                                    $submenu = count($menu->children) > 0 ? '<ul aria-expanded="false">' . $submenu . '</ul>' : '';
                                                                    if (empty($submenu)) {
                                                                        if ($menu->external) {
                                                                            echo '<li><a target="_blank" href="' . $menu->url . '" aria-expanded="false"><i class="' . $menu->icon . '"></i><span class="nav-text">' . lang($menu->title) . '</span></a></li>';
                                                                        } else {
                                                                            echo '<li><a href="' . site_url($menu->url) . '" aria-expanded="false"><i class="' . $menu->icon . '"></i><span class="nav-text">' . lang($menu->title) . '</span></a></li>';
                                                                        }
                                                                    } else {
                                                                        echo '<li><a class="has-arrow" href="Javascript:void()" aria-expanded="false"><i class="' . $menu->icon . '"></i><span class="nav-text">' . lang($menu->title) . '</span></a>' . $submenu . '</li>';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }else{
                                if(session()->get('group') == "115b5ad39b853084209caf6824224f6b")
                                echo '<li class="nav-label">'.lang($menu->divider).'</li>';
                            }
                        }else{
                            if($menu->permission_controller == "" || count(getArrayItem($permission,'name',$menu->permission_controller)) > 0)
                            {
                                $submenu = '';
                                foreach ($menu->children as $children) {
                                    if($children->external){
                                        $submenu .= '<li><a target="_blank" href="'.$children->url.'">'.lang($children->title).'</a></li>';
                                    }else{
                                        $submenu .=  '<li><a href="'.site_url($children->url).'">'.lang($children->title).'</a></li>';
                                    }
                                }
                                $submenu = count($menu->children) > 0 ? '<ul aria-expanded="false">'.$submenu.'</ul>' : '';
                                if(empty($submenu)){
                                    if($menu->external){
                                        echo '<li><a target="_blank" href="'.$menu->url.'" aria-expanded="false"><i class="'.$menu->icon.'"></i><span class="nav-text">'.lang($menu->title).'</span></a></li>';
                                    }else{
                                        if($menu->url == "settings/module"){
                                            if($module_menu){
                                                echo '<li><a href="'.site_url($menu->url).'" aria-expanded="false"><i class="'.$menu->icon.'"></i><span class="nav-text">'.lang($menu->title).'</span></a></li>';
                                            }
                                        }else{
                                            echo '<li><a href="'.site_url($menu->url).'" aria-expanded="false"><i class="'.$menu->icon.'"></i><span class="nav-text">'.lang($menu->title).'</span></a></li>';
                                        }
                                    }
                                }else{
                                    echo '<li><a class="has-arrow" href="Javascript:void()" aria-expanded="false"><i class="'.$menu->icon.'"></i><span class="nav-text">'.lang($menu->title).'</span></a>'.$submenu.'</li>';
                                }
                            }
                        }
                    }
                }
            ?>
        </ul>
    </div>
</div>