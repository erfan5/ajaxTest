$(document).ready(function () {
    function sortdel() {
        var oldList, newList, item;
        $(".sortable").sortable({
            connectWith: ".connectedSortable",
            revert: true,
            refreshPositions: true,
            helper: 'clone',
            cursor: "move",
            dropOnEmpty: true,
            delay: 1,
            tolerance: 'pointer',
            revert: 50,
                    over: function (event, ui) {
                        outside = false;
                    },
            out: function (event, ui) {
                outside = true;
            },
            beforeStop: function (event, ui) {

                if (outside) {
                    if (confirm('Are you sure you want to delete this?')) {
                        ui.item.remove();
                        var remove_item = item.attr('id');
                        console.log("removed_item_id " + remove_item);
                        $.post("list_updated.php", {item_delete: true, item_id: remove_item}, function (data) {
                            console.log(data);
                        }, "json");
                    }
                }
            },
            start: function (event, ui) {
                item = ui.item;
                newList = oldList = ui.item.parent();
            },
            stop: function (event, ui) {



            },
            change: function (event, ui) {
                if (ui.sender) {
                    newList = ui.placeholder.parent();
                }
            },
            update: function (event, ui) {
                console.log("Moved " + item.text() + " ID " + item.attr('id') + " from " + oldList.attr('id') + " to " + newList.attr('id'));
                var itemid = item.attr('id');
                var category_to = newList.attr('id');
                var category_from = oldList.attr('id')
                var list_sortable = $(this).sortable('toArray').toString();
                console.log(list_sortable);
                console.log("item: " + itemid);
                $.post("list_updated.php", {update_order: true, list_order: list_sortable, 'category_to': category_to, 'category_from': category_from, item_id: itemid}, function (data) {
                }, "json");
            }
        });
    }
    sortdel();

    var maxLength = 15;
    $('#cat_form').children('input').keyup(function () {
        var length = $(this).val().length;
        var length = maxLength - length;
        var textt = 'characters left';
        $('#chars').text(length + " " + textt);

    });
    function validate() {
        var maxLength = 15;
        $('.ababab input').keyup(function () {
            var length = $(this).val().length;
            var length = maxLength - length;
            var textt = 'characters left';
            $(this).prev('span').text(length + " " + textt);
        });
    }
    validate();
    $(document).on("keypress", "#Select", function (e) {
        var val = $(this).val();
        var length = val.length;
        val = jQuery.trim(val);

        if (e.which === 13) {
            if (/^\s*[a-zA-Z0-9,\s]+\s*$/.test(val) == false || length == 0) {
                alert('Your string is null or contains illegal characters.');
                return false;
            }
            ajaxer(e);
        }
    });

    $(document).on('click', '#addC', function (e) {
        var val = $(this).siblings('#Select').val();
        var length = val.length;
        val = jQuery.trim(val);
        if (/^\s*[a-zA-Z0-9,\s]+\s*$/.test(val) == false || length == 0) {
            alert('Your string is null or contains illegal characters.');
            return false;
        }
        ajaxer(e);


    }
    );


    function ajaxer(e) {
        $(document).ajaxStart(function () {
            $("#wait").css("display", "block");
        });
        e.preventDefault();


        var name = $("#Select").val();
        var submit = 'submit';
        var dataString = 'cname=' + name + '&submit=' + submit;
        // AJAX Code To Submit Form.
        $.post("item_add.php", {add_cate: true, cname: name, submit: submit}, function (data) {
            var cat_id = data.cate_id;
            $('.category').append('<div class="ababab"><div id="heading"><h3>' + name + '</h3></div><div id="itemss"><input type="hidden" id="cate_id" value=' + cat_id + ' class="form-control" name="cat_id"><br><span id="charss"></span><input type="text" name="iname" class="form-control" id="elections" placeholder="Add New Item" maxlength="15" required=""><input type="hidden" name="submitI" class="form-control"><input class="addI" name="" type="button" value="Add item"></div><ul id=' + cat_id + ' class="sortable connectedSortable ui-sortable" style="min-height: 25px;"></ul></div>');

            validate();
            sortdel();
        }, "json");

        $(document).ajaxComplete(function () {
            $("#wait").css("display", "none");
        });
    }
    $(document).on("keypress", "#for_ajax input", function (e) {
        if (e.which === 13) {

            var val = $(this).val();
            var cat_id = $(this).siblings('#cate_id').val();
            var length = val.length;
            val = jQuery.trim(val);
            if (/^\s*[a-zA-Z0-9,\s]+\s*$/.test(val) == false || length == 0) {
                alert('Your string is null or contains illegal characters.');
                return false;
            }
            ajaxerI(val, cat_id);
        }
    });

    $(document).on('click', ".addI", function (e) {
        var val = $(this).closest('div').children('#elections').val();
        var cat_id = $(this).siblings('#cate_id').val();
        ajaxerI(val, cat_id);

    });

    function ajaxerI(val, cat_id) {
        $(document).ajaxStart(function () {
            $("#wait").css("display", "block");
        });
        var length = val.length;
        val = jQuery.trim(val);
        if (/^\s*[a-zA-Z0-9,\s]+\s*$/.test(val) == false || length == 0) {
            alert('Your string is null or contains illegal characters.');
            return false;
        } else {

            // AJAX Code To Submit Form.

            var catid = parseInt(cat_id);
            var name = val;
            var lastorder = $('ul#' + catid + '>li:last-child').attr('order');

            if (lastorder) {
                var order = parseInt(lastorder) + 1;

            } else {

                var order = '0';
            }
            var submit = 'submitI';
            var dataString = 'iname=' + name + '&submitI=' + submit + '&cat_id=' + catid;
            $.post("item_add.php", {add_item: true, iname: name, submitI: submit, cat_id: catid}, function (data) {
                var last_id = data.last_id;

                var mytest = '<li class="item-list ui-sortable-handle" id="' + last_id + '"  order=' + order + '>' + name + '</li>';
                $('ul#' + catid).append(mytest);
                sortdel();
            }, "json");
            $(document).ajaxComplete(function () {
                $("#wait").css("display", "none");
            });
        }
    }
    $(document).on('click', '#reset', function (e) {
        $.post("list_updated.php", {update_orignal: true}, function (data) {
            window.location.reload();

        }, "json");

    });

});



