<div id="ctoolbar" class="box"></div>
<div id="cmain" class="box">
    <div id="cheader" class="title" style="padding:0 0;">
        <span><?php echo Yii::t('lang', 'Create new spots'); ?> </span>
    </div>
    <div id="ccontent" style="background: #ffffff;min-width: 1000px;">
        <div class="spot-type">
            <?php
            $types = Yii::app()->params->spotType;
            foreach ($types as $key => $val) {
                ?>
                <div data-type="<?php echo $key; ?>"><div><?php echo $val; ?></div><img src="/images/spot/<?php echo $key; ?>.png"></div>
            <?php } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var type = new Type();
        type.init();
    });
    var Type = function() {
        var me = this;
        this.init = function() {
            me.redirectTo();
        }
        this.redirectTo = function() {
            $(".spot-type div").click(function() {
                if ($(this).attr('data-type') != "") {
                    window.location.href = '/screen/spots/create/type/' + $(this).attr('data-type');
                }
            });
        }
    };
</script>