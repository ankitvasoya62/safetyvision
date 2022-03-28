<?php $this->renderPartial('../tools'); ?>
<?php
$init = array('user.edit' => 0, 'user.delete' => 0);
$access = AuthManage::checkAccess($init);
?>
<div id="cmain" class="box">
    <div id="cheader" class="title">
        <span>Users</span>
    </div>
    <div id="ccontent">
        <table class="table table-bordered  table-striped table-user">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Expiry Date</th>
                    <th>User Expired</th>
                    <th>Last login</th>
                    <th>Customer</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($users)) {
                    foreach ($users as $row) {
                        $out = $row['expires'] && $row['expires'] < time();
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><a href="/rbms/user/profile/id/<?php echo $row['id']; ?>"><?php echo $row['email']; ?></a></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo VSCommon::formateDateTime($row['expires']); ?></td>
                            <td class="isout <?php
                            if ($out) {
                                echo 'yes';
                            } else {
                                echo 'no';
                            }
                            ?>"></td>
                            <td><?php echo Sessions::model()->getLastLogin($row['id']); ?></td>
                            <td><?php echo Customer::model()->getNameById($row['customer_id']); ?></td>
                            <td style="text-align: center;">
                                <?php if($access['user.edit']){ ?>
                                <a href="/rbms/user/profile/id/<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                <?php } ?>
                                <?php if($access['user.delete']){ ?>
                                <a href="/rbms/user/delete/<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7">
                            None items
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="pages">
            <?php $this->widget('CLinkPager', array('pages' => $pages, 'header' => '', 'firstPageLabel' => '<<', 'lastPageLabel' => '>>', 'nextPageLabel' => '→', 'prevPageLabel' => '←', 'htmlOptions' => array('class' => 'pagination'))); ?>
        </div>
        <h4>Active sessions</h4>
        <table class="table table-bordered  table-striped table-user">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Login Time</th>
                    <th>Customer</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($sessions)) {
                    foreach ($sessions as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row['user']['name']; ?></td>
                            <td><?php echo date("d.m.Y H:i:s", $row['last_login']); ?></td>
                            <td><?php echo Customer::model()->getNameById($row['user']['customer_id']); ?></td>
                            <td><?php echo $row['ip']; ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4">
                            None items
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>