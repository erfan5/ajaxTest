<?php
include ('item_add.php');
?> 
<div class="category">
    <?php
    foreach ($selects as $selected) {
        $cat_name = $selected['name'];
        $cat_id = $selected['id'];
        ?>
        <div class="ababab">
            <div id="heading">
                <h3><?php echo $cat_name; ?></h3>
            </div>
            <div id="itemss">
                <input type="hidden" id ="cate_id" value="<?php echo $cat_id; ?>"  class="form-control"  name="cat_id">
                  <br><span id="charss"></span> 
                <input type="text"  name="iname"  class="form-control" id="elections" placeholder="Add New Item"  maxlength="15" required>
                <input type="hidden"  name="submitI" class="form-control">
                <input class="addI" name="" type="button" value="Add item">
                <div id="wait" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='ajax-loader.gif' width="64" height="64" /><br>Loading..</div>
            </div>

            <ul id="<?php echo $cat_id ?>" class="sortable connectedSortable" style="min-height: 50px;">
                <?php
                foreach ($selects_item as $selected_item) {
                    $item_name = $selected_item['name'];
                    $item_id = $selected_item['id'];
                    ?>
                    <?php if ($cat_id == $selected_item['category_id']) { ?>
                        <li class="item-list" id="<?php echo $item_id; ?>" order="<?php echo $selected_item['list_order']; ?>"><?php echo $item_name; ?></li>
                        <?php } ?>  
                    <?php } ?>  
            </ul>
        </div>
    <?php } ?> 
</div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
<script>
    $(document).ready(function () {
        $('input').keypress(function (e) {
            if (e.which === 32)
                return false;
        });
        
        $(document).ajaxSuccess(function () {
             var maxLength = 15;
               
                $('#cat_form').children('input').keyup(function () {
                    var length = $(this).val().length;
                    var length = maxLength - length;
                     var textt = 'characters left';
                    $('#chars').text(length+ " " +textt);
                  
                });
                var maxLength = 15;
                $('.ababab input').keyup(function () {
                    var length = $(this).val().length;
                    var length = maxLength - length;
                    var textt = 'characters left';
                    $(this).prev('span').text(length+ " " +textt);
                });
             
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
                            //  confirm('Are you sure you want to delete this?');
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
                        //console.warn(data);


                    }, "json");
                }
            });
        });
    });
</script>