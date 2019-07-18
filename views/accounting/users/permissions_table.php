<?php $controller = &get_instance(); ?>
<style type="text/css">
    .user-permissions {
        overflow-y: scroll;
        overflow-x: auto;
        /*width: 989px;*/
    }
    table th, table td {
        width: 80px;
        text-align: center;
        font-size: 11px;
    }
    table th:nth-of-type(1), table td:nth-of-type(1) {
        width: 130px;
        text-align: left;
    }
    table {
        margin-bottom: 0px !important;
    }
</style>
<div class="user-permissions" >
<table class="table table-bordered">
    <thead>
        <tr>
            <td></td>
            <?php
            if(isset($permisions) && !empty($permisions)) {
                foreach ($permisions as $key => $value) {
                    echo '<td>'.$value.'</td>';
                }
            }
            ?>
        </tr>
    </thead>
</table>
</div>
<div class="user-permissions" style="height: 400px;">
    <table class="table table-bordered ">
        <tbody>
            <?php
            if(!empty($modules)) {
                foreach ($modules as $module) {
                    ?>
                    <tr>
                        <td><?php echo $module->name; ?></td>
                        <?php
                        if(isset($permisions) && !empty($permisions)) {
                            $index = 1;
                            foreach ($permisions as $key => $value) {
                                echo '<td>';
                                if(isset($module->roles[$index])) {
                                    $role_id = $module->roles[$index]->id;
                                    if(in_array($role_id, $user_roles))
                                        echo '<input name="roles['.$role_id.']" data-switchery="true" checked type="checkbox" class="js-switch1">';
                                    else
                                        echo '<input name="roles['.$role_id.']"  type="checkbox" class="js-switch1">';
                                }
                                echo '</td>';
                                $index++;
                            }
                        }
                        ?>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>

                               