<?php $this->renderPartial('../tools'); ?>

<div id="cmain" class="box">
    <div id="cheader" class="title">
        <span>Users</span>
    </div>
    <div id="ccontent">
        <table class="table table-bordered  table-striped table-user">
            <thead>
                <tr>
                    <th>E-mail</th>
                    <th>Name</th>
                    <th>Customer</th>
                    <th>Expiry Date</th>
                    <th>User Expired</th>
                    <th>Role Type</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Is Current</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($access)) {
                    foreach ($access as $row) {
                        $out = $row['user']['expires'] && $row['user']['expires'] < time();
                        $isCurrent = ($row['stime'] == 0 || $row['stime'] <= time()) && ($row['etime'] == 0 || $row['etime'] > time());
                        ?>
                        <tr>
                            <td><?php echo $row['user']['email']; ?></td>
                            <td><a href="/rbms/user/profile/id/<?php echo $row['user']['id']; ?>"><?php echo $row['user']['name']; ?></a></td>
                            <td><?php echo Customer::model()->getNameById($row['user']['customer_id']); ?></td>
                            <th><?php echo VSCommon::formateDateTime($row['user']['expires']); ?></th>
                            <th class="isout <?php
                            if ($out) {
                                echo 'yes';
                            } else {
                                echo 'no';
                            }
                            ?>"></th>
                            <th><?php echo $row['role']['name']; ?></th>
                            <td><?php echo VSCommon::formateDateTime($row['stime']); ?></td>
                            <td><?php echo VSCommon::formateDateTime($row['etime']); ?></td>
                             <td class="isout <?php
                            if ($isCurrent) {
                                echo 'yes';
                            } else {
                                echo 'no';
                            }
                            ?>"></td>
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