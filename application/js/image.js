$(document).ready(function() {
    var image = new ImageCrop();
    image.init();
});

var ImageCrop = function() {
    var me = this;
    me.verify = {title: false, image: false};
    me.x = 160;
    me.y = 90;
    me.x2 = 640;
    me.y2 = 450;
    me.jcrop_api = null;
    me.newSelect = [];
    me.boundx = null;
    me.boundy = null;
    me.xsize = $('#preview-pane .preview-container').width();
    me.ysize = $('#preview-pane .preview-container').height();
    this.init = function() {
        me.upload();
        me.submit();
        $("#upload-file").bootstrapFileInput();
        me.watchTitle();
    };

    this.crop = function() {
        $('#target').Jcrop({
            boxWidth: 640,
            boxHeight: 360,
            onChange: me.update,
            onSelect: me.update,
            aspectRatio: me.xsize / me.ysize,
            setSelect: [160, 90, 640, 450]
        }, function() {
            var bounds = this.getBounds();
            me.boundx = bounds[0];
            me.boundy = bounds[1];
            me.jcrop_api = this;

            var width = me.jcrop_api.ui.holder.width();
            var height = me.jcrop_api.ui.holder.height();
            var left = 0;
            var top = 0;
            if (width <= 640) {
                left = parseInt((640 - width) * 0.5);
            }
            if (height <= 360) {
                top = parseInt((360 - height) * 0.5);
            }
            me.jcrop_api.ui.holder.css({left: left, top: top});
            $('#preview-pane').appendTo(me.jcrop_api.ui.holder);
        });
        me.watch();
    };
    this.update = function(c) {
        if (parseInt(c.w) > 0)
        {
            var rx = me.xsize / c.w;
            var ry = me.ysize / c.h;
            var x = Math.round(c.x);
            var y = Math.round(c.y);
            var width = Math.round(c.x2 - c.x);
            var height = Math.round(c.y2 - c.y);
            $("#x").val(x);
            $("#y").val(y);
            $("#width").val(width);
            $("#height").val(height);
            $('#preview-pane .preview-container img').css({
                width: Math.round(rx * me.boundx) + 'px',
                height: Math.round(ry * me.boundy) + 'px',
                marginLeft: '-' + Math.round(rx * c.x) + 'px',
                marginTop: '-' + Math.round(ry * c.y) + 'px'
            });
            me.setParam(c);
            me.verify.image = true;
            me.approved();
        }
    };
    this.watch = function() {
        $("#x").change(function() {
            me.x = parseInt($(this).val());
            me.newSelect = [me.x, me.y, me.x2, me.y2];
            me.jcrop_api.setSelect(me.newSelect);
        });
        $("#y").change(function() {
            me.y = parseInt($(this).val());
            me.newSelect = [me.x, me.y, me.x2, me.y2];
            me.jcrop_api.setSelect(me.newSelect);
        });
        $("#width").change(function() {
            me.x2 = parseInt($(this).val()) + me.x;
            me.newSelect = [me.x, me.y, me.x2, me.y2];
            me.jcrop_api.setSelect(me.newSelect);
        });
        $("#height").change(function() {
            me.y2 = parseInt($(this).val()) + me.y;
            me.newSelect = [me.x, me.y, me.x2, me.y2];
            me.jcrop_api.setSelect(me.newSelect);
        });
        $("#spot-title").change(function() {
            $title = $.trim($("#spot-title").val());
            if ($title.length !== 0) {
                me.verify.title = true;
            } else {
                me.verify.title = false;
            }
            me.approved();
        });
    };
    this.watchTitle = function() {
        $("#spot-title").change(function() {
            $title = $.trim($("#spot-title").val());
            if ($title.length !== 0) {
                me.verify.title = true;
            } else {
                me.verify.title = false;
            }
            me.approved();
        });
    };

    this.approved = function() {
        if (me.verify.title && me.verify.image) {
            $("#submit-button").removeAttr("disabled");
        } else {
            $("#submit-button").attr("disabled", "disabled");
        }
    };

    this.upload = function() {
        $("#upload").click(function() {
            if (me.checkType()) {
                $("#uploadForm").ajaxSubmit({
                    dataType: 'json',
                    timeout: 600000,
                    debug: true,
                    beforeSubmit: function() {
                        $("#crop-pane").html('<img src="/images/loading.gif" />');
                    },
                    success: function(data) {
                        var img = new Image();
                        img.src = data.src;
                        img.onload = function() {
                            $("#crop-pane").html('');
                            $("#preview-pane").css("display", "block");
                            $("#crop-pane").html('<img src="' + data.src + '" id="target" />');
                            $(".preview-container").html('<img src="' + data.src + '" id="preview" />');
                            me.crop();
                        };
                    }
                });
            }
        });
    };
    this.checkType = function() {
        var uploadFile = $("#upload-file").val();
        uploadFile = uploadFile.replace('/', '\\');
        var pos = uploadFile.lastIndexOf('\\');
        if (pos > 0) {
            uploadFile = uploadFile.substr(pos + 1);
        }
        pos = uploadFile.lastIndexOf(".");
        var ext = pos > 0 ? uploadFile.substr(pos + 1).toLowerCase() : "";
        var exts = ["jpg", "png", "gif", "jpeg"];
        pos = -1;
        for (var i = 0, len = exts.length; i < len; i++) {
            if (exts[i] === ext) {
                pos = i;
                break;
            }
        }
        if (pos < 0) {
            $("#error").html("Please select the allowed JGP/PNG/GIF/JPEG file!");
            $("#message").modal('toggle');
            return;
        } else {
            return true;
        }
    };
    this.setParam = function(c) {
        var width = Math.round(c.x2 - c.x);
        var height = Math.round(c.y2 - c.y);
        $("#crop_Y").val(Math.round(c.y));
        $("#crop_X").val(Math.round(c.x));
        $("#crop_Width").val(width);
        $("#crop_Height").val(height);
    };
    this.submit = function() {
        $("#submit-button").click(function() {
            $token = $("#crop_token").val();
            $title = $.trim($("#spot-title").val());
            $y = $("#crop_Y").val();
            $x = $("#crop_X").val();
            $width = $("#crop_Width").val();
            $height = $("#crop_Height").val();
            $.post("/screen/spots/handleImage", $.param({image: {token: $token, x: $x, y: $y, width: $width, height: $height}, title: $title}), function(data) {
                if (data.status) {
                    window.location.href = '/screen/spots/video/step/1/token/' + data.token;
                }
            }, "json");
        });
    };
};