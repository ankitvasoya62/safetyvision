$(document).ready(function () {
    var video = new Video();
    video.init();
    $('span.loading-span').hide();
    $('#upload').prop('disabled', false);
});

var Video = function () {
    var me = this;
    me.CLOCK = null;
    this.init = function () {
        $("#upload-file").bootstrapFileInput();
        me.upload();
        me.spot();
        $('#spot_start_hh').timepicker({ timeFormat: 'HH:mm',dropdown:true});
        $('#spot_stop_hh').timepicker({timeFormat: 'HH:mm',dropdown:true});
    };

    this.upload = function () {
        $("#upload").click(function () {
            if (me.checkType()) {
                $('span.loading-span').show();
                $('#upload').prop('disabled', true);
                $("#progress-wrap").css('display', 'block');
                $("#progress .progress_speed").css('width', '0%');
                $token = $("#token").val();
                $uuid = me.uuid();
                $("#uploadForm").attr('action', '/screen/spots/uploadVideo.html?X-Progress-ID=' + $uuid);
                
                $("#uploadForm").ajaxSubmit({
                    dataType: 'json',
                    timeout: 7200000,
                    debug: true,
                    beforeSubmit: function () {
                        $("#progress .progress_speed").css('width', '0%');
                        $("#progressText").html("");
                        me.CLOCK = setInterval(function () {
                            // $("#progress-wrap").css('display', 'block');
                            // $.ajax({
                            //     type: "GET",
                            //     url: "/progress",
                            //     dataType: "json",
                            //     headers: {
                            //         'X-Progress-ID': $uuid
                            //     },
                            //     success: function (data) {
                            //         if (data.state == 'done') {
                            //             window.clearInterval(me.CLOCK);
                            //         } else if (data.state == 'uploading') {
                            //             var percentage = Math.floor(100 * parseInt(data.received) / parseInt(data.size));
                            //             $("#progress .progress_speed").css('width', percentage + '%');
                            //             $("#progressText").html(percentage + '%&nbsp;' + me.formatSize(data.received) + '/' + me.formatSize(data.size));
                            //         } else {
                            //             $("#progressText").html(data.state);
                            //         }
                            //     }
                            // });
                        }, 1000);
                    },
                    success: function () {
                        $("#loading-status").html('<img src="/images/loading.gif" />').show();
                        me.convert($token);
                        me.submit();
                    }
                });
            }
        });
    };

    this.formatSize = function (bytes) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) {
            return 'n/a';
        }
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + sizes[i];
    };

    this.uuid = function () {
        var uuid = "";
        for (i = 0; i < 32; i++) {
            uuid += Math.floor(Math.random() * 16).toString(16);
        }
        return uuid;
    };
    this.convert = function (token) {
        var Convert_Clock_Status = setInterval(function () {
            $.post('/screen/spots/convert', {token: token}, function (data) {
                if (data.status) {
                    window.clearInterval(Convert_Clock_Status);
                    me.getConvertProgress(token);
                } else {
                    $("#error").html(data.msg);
                    $("#message").modal('toggle');
                }
            }, 'json');
        }, 1000);

    };

    this.getConvertProgress = function (token) {
        var Convert_Clock = setInterval(function () {
            $.post('/screen/spots/getConvertProgress', {token: token}, function (data) {
                if (data.status) {
                    window.clearInterval(Convert_Clock);
                    $("#loading-status").html('<img src="/images/loading.gif" />' + data.percent).hide();
                    $("#loaded-video video").attr("src", data.src).show();
                    $('span.loading-span').hide();
                    $('#upload').prop('disabled', false);
                    $("#submit-button").removeAttr("disabled");
                } else {
                    $("#loaded-video video").hide();
                    $("#loading-status").html('');
                    $("#loading-status").html('<img src="/images/loading.gif" />' + data.percent).show();
                }
            }, 'json');
        }, 2000);
    };

    this.checkType = function () {
        var uploadFile = $("#upload-file").val();
        uploadFile = uploadFile.replace('/', '\\');
        var pos = uploadFile.lastIndexOf('\\');
        if (pos > 0) {
            uploadFile = uploadFile.substr(pos + 1);
        }
        pos = uploadFile.lastIndexOf(".");
        var ext = pos > 0 ? uploadFile.substr(pos + 1).toLowerCase() : "";
        var exts = ["wmv", "asf", "asx", "rm", "rmvb", "mpg", "mpeg", "mpe", "3gp", "mov", "mp4", "m4v", "avi", "dat", "mkv", "flv", "vob", "mp3", "wma"];
        pos = -1;
        for (var i = 0, len = exts.length; i < len; i++) {
            if (exts[i] === ext) {
                pos = i;
                break;
            }
        }
        if (pos < 0) {
            $("#error").html("Please select the upload Video file !");
            $("#message").modal('toggle');
            return;
        } else {
            return true;
        }
    };

    this.submit = function () {
        $("#submit-button").removeAttr("disabled");
        $("#submit-button").click(function () {
            $token = $("#token").val();
            window.location.href = '/screen/spots/video/step/2/token/' + $token;
        });
    };

    this.spot = function () {
        me.setSelected();
        me.save();
    };

    this.setSelected = function () {
        $(".screens-all").click(function () {
            $(".screen-checked-right a").removeClass("checked_off").addClass("checked_on");
            me.setCount('All');
        });
        $(".screens-none").click(function () {
            $(".screen-checked-right a").removeClass("checked_on").addClass("checked_off");
            me.setCount('No');
        });
        $(".screen-checked-right a").click(function () {
            if ($(this).hasClass("checked_on")) {
                $(this).removeClass("checked_on").addClass("checked_off");
            } else {
                $(this).removeClass("checked_off").addClass("checked_on");
            }
            me.setCount(null);
        });
        $("#screen-control").click(function () {
            if ($(this).hasClass("spread")) {
                $("#screen-content").hide();
                $(this).removeClass("spread").addClass("unspread");
            } else {
                $("#screen-content").show();
                $(this).removeClass("unspread").addClass("spread");
            }
        });
        me.setDate();
    };
    this.setCount = function (num) {
        $("#screen_count").html($(".screen-checked-right a.checked_on").length);
        if (!num) {
            $("#screen-number").html($(".screen-checked-right a.checked_on").length);
        } else {
            $("#screen-number").html(num);
        }
    };

    this.setDate = function () {
        $("#spot-start-date").datepicker({
            showOn: "both",
            buttonText: "Date",
            buttonImage: "/images/calendar.png",
            buttonImageOnly: true,
            dateFormat: "D.dd.mm.yy",
            minDate: new Date(),
            onClose: function (selectedDate) {
                $("#spot-stop-date").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#spot-stop-date").datepicker({
            showOn: "both",
            buttonText: "Date",
            buttonImage: "/images/calendar.png",
            buttonImageOnly: true,
            dateFormat: "D.dd.mm.yy",
            minDate: new Date(),
            onClose: function (selectedDate) {
                $("#spot-start-date").datepicker("option", "maxDate", selectedDate);
            }
        });

        $("#update_start_date").datepicker({
            showOn: "both",
            buttonText: "Date",
            buttonImage: "/images/calendar.gif",
            buttonImageOnly: true,
            dateFormat: "D.dd.mm.yy",
            onClose: function (selectedDate) {
                $("#update_stop_date").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#update_stop_date").datepicker({
            showOn: "both",
            buttonText: "Date",
            buttonImage: "/images/calendar.gif",
            buttonImageOnly: true,
            dateFormat: "D.dd.mm.yy",
            minDate: $("#update_start_date").val(),
            onClose: function (selectedDate) {
                $("#update_start_date").datepicker("option", "maxDate", selectedDate);
            }
        });
    };
    this.save = function () {
        $("#spot-submit-button").click(function () {
            if (me.verifySpot()) {
                $screen_ids = [];
                $token = $("#spot_token").val();
                $owner = $.trim($("#spot-owner").val());
                $start_date = $("#spot-start-date").val();
                $stop_date = $("#spot-stop-date").val();
                $start_hh = $("#spot_start_hh").val();
                $stop_hh = $("#spot_stop_hh").val();
                $("#screen-panel a.checked_on").each(function () {
                    $screen_ids.push($(this).attr("data-screen-id"));
                });
                $.post('/screen/spots/save', {spot: {token: $token, owner: $owner, start_date: $start_date, stop_date: $stop_date, screen_id: $screen_ids, start_hh : $start_hh, stop_hh: $stop_hh}}, function (data) {
                    if (data.status) {
                        window.location.href = '/screen/screen/';
                    }
                }, 'json');

            }
        });
    };
    this.msg = function (info) {
        $("#error").html(info);
        $("#message").modal('toggle');
    };
    this.verifySpot = function () {
        var status = true;
        var msg = null;
        if (!$("#spot-start-date").val()) {
            status = false;
            msg = "Sorry, start date must be selected.";
        }
        if ($("#screen-panel a.checked_on").length <= 0) {
            status = false;
            msg = "Please, select the screen to publish this spot.";
        }
        if (!status) {
            me.msg(msg);
            return;
        } else {
            return true;
        }
    };
};