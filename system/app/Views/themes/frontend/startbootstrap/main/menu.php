<?php
$menus = [];
if(file_exists(APPPATH . "Views/menus/Frontend.json")){
    $menus = file_get_contents(APPPATH . "Views/menus/Frontend.json");
    $menus = @json_decode($menus);
}
?>
<style>
.logo{
    filter: brightness(100);
}
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-5">
        <a class="navbar-brand" href="/"><img class="logo mt-2" src="<?=site_url('themes/focus2/images/logo-full.png')?>" alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php
                $count = 0;
                foreach ($menus as $menu) {
                    $submenu = '';

                    foreach ($menu->children as $children) {
                        if ($children->external) {
                            $submenu .= '<li><a class="dropdown-item" target="_blank" href="' . site_url($children->url) . '">' . lang($children->title) . '</a></li>';
                        } else {
                            $submenu .= '<li><a class="dropdown-item" href="' . site_url($children->url) . '">' . lang($children->title) . '</a></li>';
                        }
                    }
                    $submenu = count($menu->children) > 0 ? '<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown'.$count.'">' . $submenu . '</ul>' : '';
                    if (empty($submenu)) {
                        if ($menu->external) {
                            echo '<li class="nav-item"><a target="_blank" class="nav-link" href="' . site_url($menu->url) . '"><i class="' . $menu->icon . '"></i>' . lang($menu->title) . '</a></li>';
                        } else {
                            echo '<li class="nav-item"><a class="nav-link" href="' . site_url($menu->url) . '"><i class="' . $menu->icon . '"></i>' . lang($menu->title) . '</a></li>';
                        }
                    } else {
                        echo '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" id="navbarDropdown'.$count.'" href="Javascript:void()" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="' . $menu->icon . '"></i>' . lang($menu->title) . '</a>' . $submenu . '</li>';
                    }
                    $count++;
                }
                ?>
                <li class="nav-item">
                    <?php
                        if(empty(session()->get('token'))){
                            echo '<a class="btn btn-outline-light" href="login">'.lang("App.site_menu_btn_login").'</a>';
                        }else{
                            echo '<a class="btn btn-outline-light" href="dashboard">'.lang("App.site_menu_btn_dashboard").'</a>';
                        }
                    ?>
                </li>
            </ul>
        </div>
    </div>
</nav>