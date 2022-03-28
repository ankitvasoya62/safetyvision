<?php
$init = array('menu.user' => 0, 'menu.user_access' => 0, 'menu.role' => 0, 'user.create' => 0);
$access = AuthManage::checkAccess($init);
?>
<div class="box" id="ctoolbar">
    <ul id="tools-menu">
        <?php if ($access['menu.user']) { ?>
            <li class="menu-users"><a href="/rbms/user/">Users</a></li>
        <?php } ?>
        <?php if ($access['menu.user_access']) { ?>
            <li class="menu-access"><a href="/rbms/roles/access">Users and Access</a></li>
        <?php } ?>
        <?php if ($access['menu.role']) { ?>
            <li class="menu-roles"><a href="/rbms/roles">Roles</a></li> 
        <?php } ?>
        <?php if ($access['user.create']) { ?>
            <li style="float:right;" class="menu-adduser"><a id="user_new" href="/rbms/user/create">New User</a></li>
        <?php } ?>
    </ul>
</div>