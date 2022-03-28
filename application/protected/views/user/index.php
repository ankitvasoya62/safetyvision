<div class="box" id="ctoolbar">
    <ul id="tools-menu">
        <li class="menu-users"><a href="/user/">Users</a></li>
        <li class="menu-access"><a href="">Users and Access</a></li>
        <li class="menu-roles"><a href="">Roles</a></li> 
        <li style="float:right;" class="menu-adduser"><a id="user_new" href="/user/create">New User</a></li>
    </ul>
</div>

<div id="cmain" class="box">
    <div id="cheader" class="title">
        <span>Users</span>
    </div>
    <div id="ccontent">
        <table class="table table-bordered  table-striped table-user">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>UserName</th>
                    <th>Email</th>
                    <th>Customer</th>
                    <th>Create Time</th>
                    <th>Update Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($users)) {
                    foreach ($users as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo Customer::model()->getNameById($row['customer_id']); ?></td>
                            <td><?php echo VSCommon::formateDateTime($row['create_time']); ?></td>
                            <td><?php echo VSCommon::formateDateTime($row['update_time']); ?></td>
                            <td style="text-align: center;">
                                <a href="/user/update/<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                <a href="/user/delete/<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7">
                            None Data
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="pages">
            <?php $this->widget('CLinkPager', array('pages' => $pages, 'header' => '', 'firstPageLabel' => '<<', 'lastPageLabel' => '>>', 'nextPageLabel' => '→', 'prevPageLabel' => '←', 'htmlOptions' => array('class' => 'pagination'))); ?>
        </div>
    </div>
</div>