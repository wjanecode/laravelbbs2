<?php
/**
 *
 * @author woojuan
 * @email woojuan163@163.com
 * @copyright GPL
 * @version
 */
/**
 * 返回当前路由名称,改为-连接,方便前端类名使用
 * @return mixed
 */
function route_class(){

    return str_replace('.','-',\Illuminate\Support\Facades\Route::currentRouteName());
}
