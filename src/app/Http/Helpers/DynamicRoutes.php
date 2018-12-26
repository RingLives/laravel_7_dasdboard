<?php 

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\MxpMenuTemp as MxpDynamicMenu;

class DynamicRoutes
{

    public function getRoutes()
    {
        $routeList = Route::getRoutes();
        $all_routes = array();
        $excludes = array('uses','namespace','prefix','middleware','before','controller');
        $i = 0;
        foreach ($routeList as $value)
        {
            $statement = false;
            if(isset($value->action)){
                foreach ($value->action as $valueactionk => $valueaction) {
                    if(isset($valueaction) && !empty($valueaction) && !is_array($valueaction) && !in_array($valueactionk, $excludes)){
                        $all_routes[$i][$valueactionk] = $valueaction;
                        $statement = true;
                    }
                }
            }
            if($statement){
                $i++;
            }
        }
        return $all_routes;
    }
    // $dir = base_path().'\routes'
    public function folderModifyTime($dir = null)
    {
        if($dir == null){
            $dir = base_path().DIRECTORY_SEPARATOR.'routes';
        }
        $foldermtime = 0;

        $flags = \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::CURRENT_AS_FILEINFO;
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, $flags));

        while ($it->valid()) {
            if (($filemtime = $it->current()->getMTime()) > $foldermtime) {
                $foldermtime = $filemtime;
            }
            $it->next();
        }
        return $foldermtime;
    }
    public function createTimeFile($fileName = 'routesfolder.txt', $content = null)
    {
        if($content == null){
            $content = time();
        }
        Storage::put($fileName, $content);
    }
    // $dir = base_path().'\routes'
    public function isModifyFolder($dir = null, $timefile = 'routesfolder.txt')
    {
        if($dir == null){
            $dir = base_path().DIRECTORY_SEPARATOR.'routes';
        }
        $lastModifytime = (int)Storage::get($timefile);
        $recentModifytime = $this->folderModifyTime($dir);
        if($lastModifytime == 0){
            $lastModifytime = $recentModifytime;
        }
        if($recentModifytime > $lastModifytime){
            return true;
        }else if ($recentModifytime == $lastModifytime){
            return false;
        }else if ($recentModifytime < $lastModifytime){
            return false;
        }else{
            return false;
        }
    }
    // $dir = base_path().'\routes'
    public function updateFolderTime($dir = null, $fileName = 'routesfolder.txt')
    {
        if($dir == null){
            $dir = base_path().DIRECTORY_SEPARATOR.'routes';
        }
        $recentModifytime = $this->folderModifyTime($dir);
        $this->createTimeFile($fileName,$recentModifytime);
    }
    public function getAllRoutes()
    {
        $parents = array();
        $all_routes = $this->getRoutes();
        if(isset($all_routes) && !empty($all_routes)) {
            foreach ($all_routes as $key => $route) {
                if(!isset($route['parent'])) {
                    $parents[$route['as']] = $route;
                    unset($all_routes[$key]);
                }
            }
            if(isset($all_routes) && !empty($all_routes)) {
                foreach ($all_routes as $key => $route) {
                    if(isset($route['parent']) && isset($parents[$route['parent']])) {
                        $parents[$route['as']] = $route;
                        unset($all_routes[$key]);
                    }
                }
                if(isset($all_routes) && !empty($all_routes)) {
                    foreach ($all_routes as $key => $route) {
                        if(isset($route['parent']) && isset($parents[$route['parent']])) {
                            $parents[$route['as']] = $route;
                            unset($all_routes[$key]);
                        }
                    }
                    if(isset($all_routes) && !empty($all_routes)) {
                        foreach ($all_routes as $key => $route) {
                            if(isset($route['parent']) && isset($parents[$route['parent']])) {
                                $parents[$route['as']] = $route;
                                unset($all_routes[$key]);
                            }
                        }
                        if(isset($all_routes) && !empty($all_routes)) {
                            foreach ($all_routes as $key => $route) {
                                if(isset($route['parent']) && isset($parents[$route['parent']])) {
                                    $parents[$route['as']] = $route;
                                    unset($all_routes[$key]);
                                }
                            }
                            if(isset($all_routes) && !empty($all_routes)) {
                                foreach ($all_routes as $key => $route) {
                                    if(isset($route['parent']) && isset($parents[$route['parent']])) {
                                        $parents[$route['as']] = $route;
                                        unset($all_routes[$key]);
                                    }
                                }
                                if(isset($all_routes) && !empty($all_routes)) {
                                    foreach ($all_routes as $key => $route) {
                                        if(isset($route['parent']) && isset($parents[$route['parent']])) {
                                            $parents[$route['as']] = $route;
                                            unset($all_routes[$key]);
                                        }
                                    }
                                    if(isset($all_routes) && !empty($all_routes)) {
                                        foreach ($all_routes as $key => $route) {
                                            if(isset($route['parent']) && isset($parents[$route['parent']])) {
                                                $parents[$route['as']] = $route;
                                                unset($all_routes[$key]);
                                            }
                                        }
                                        if(isset($all_routes) && !empty($all_routes)) {
                                            foreach ($all_routes as $key => $route) {
                                                if(isset($route['parent']) && isset($parents[$route['parent']])) {
                                                    $parents[$route['as']] = $route;
                                                    unset($all_routes[$key]);
                                                }
                                            }
                                            if(isset($all_routes) && !empty($all_routes)) {
                                                foreach ($all_routes as $key => $route) {
                                                    if(isset($route['parent']) && isset($parents[$route['parent']])) {
                                                        $parents[$route['as']] = $route;
                                                        unset($all_routes[$key]);
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
            }
        }
        return $parents;
    }
    public function updateRoutes()
    {
        MxpDynamicMenu::truncate();
        $routeids = $routedata = [];
        $getAllRoutes = $this->getAllRoutes();
        if(isset($getAllRoutes) && !empty($getAllRoutes)){
            $i = 0;
            foreach ($getAllRoutes as $key => $getRoute) {
                if(isset($getRoute['as'])){
                    $MxpDynamicMenu = new MxpDynamicMenu();
                    $MxpDynamicMenu->route_name = $getRoute['as'];
                    if(isset($getRoute['icon'])){
                        $MxpDynamicMenu->icon = $getRoute['icon'];
                    }else{
                        $MxpDynamicMenu->icon = '';
                    }
                    if(isset($getRoute['Name'])){
                        $MxpDynamicMenu->Name = $getRoute['Name'];
                    }else{
                        $MxpDynamicMenu->Name = '';
                    }
                    if(isset($getRoute['description'])){
                        $MxpDynamicMenu->description = $getRoute['description'];
                    }else{
                        $MxpDynamicMenu->description = '';
                    }
                    if(isset($getRoute['is_active'])){
                        $MxpDynamicMenu->is_active = $getRoute['is_active'];
                    }else{
                        $MxpDynamicMenu->is_active = 1;
                    }
                    if(isset($getRoute['order_id'])){
                        $MxpDynamicMenu->order_id = $getRoute['order_id'];
                    }else{
                        $MxpDynamicMenu->order_id = 0;
                    }
                    if(isset($getRoute['parent'])){
                        if(isset($routeids[$getRoute['parent']])){
                            $MxpDynamicMenu->parent_id = $routeids[$getRoute['parent']];
                        }else{
                            $MxpDynamicMenu->parent_id = 0;
                        }
                    }else{
                        $MxpDynamicMenu->parent_id = 0;
                    }
                    if($MxpDynamicMenu->save()){
                        $routeids[$getRoute['as']] = $MxpDynamicMenu->id;
                    }
                $i++;
                }
            }
            $this->updateFolderTime();
        }
        return true;
    }
    public function refreshMenu()
    {

        if($this->isModifyFolder())
        {
            $this->updateRoutes();
        }
        return true;
    }
}