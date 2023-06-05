<?php


function cek_user_permission($permission_name)
{
    if(auth()->user()->getPermissions($permission_name) || auth()->user()->getRoleNames()->first() === 'Admin'){
        return true;
    }else{
        return false;
    }
}
