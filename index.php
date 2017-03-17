<?php include ('item_add.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>test project</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="js/jquery-1.11.3.min.js"></script>
<!--        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
        <script src="js/jquery-ui.js"></script>
        <style>
            body {
                background-image: url("Grey-3D-Background.png");

            }
        </style>
    </head>
    <body> 
        <div class="wrapper">
            <div class="nav">
                <h1>Drag ANd Drop</h1>
            </div>
            <div class="container">
                <div id="cat_form">
                    <input type="text"  name="cname" class="form-control" id="Select" placeholder="Add New Category" maxlength="15" required>
                    <input type="hidden"  name="submit" class="form-control">
                    <input id="addC" name="" type="button" value="Add">
                    <br><span id="chars"></span> 
                    <div id="wait" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='ajax-loader.gif' width="64" height="64" /><br>Loading..</div>
                </div>  
                <div id="for_ajax">
                    <div class="reset">
                        <input id="reset"  type="submit" value="Reset All">
                    </div>
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
                                    <input type="text"  name="iname"  class="form-control" id="elections" placeholder="Add New Item"  maxlength="15"  required>

                                    <input type="hidden"  name="submitI" class="form-control">
                                    <input class="addI" name="" type="button" value="Add item">
                                    <div id="wait" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='ajax-loader.gif' width="64" height="64" /><br>Loading..</div>
                                </div>

                                <ul id="<?php echo $cat_id ?>" class="sortable connectedSortable" style="min-height: 25px;">
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
                    </div>
                </div> 
            </div>
            <div class="push"></div>
        </div>
        <footer class="site-footer"> © Copyright PureLogics. </footer>
        <script src="myjquery.js"></script>
    </body>
</html>

