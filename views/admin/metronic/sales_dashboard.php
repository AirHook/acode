<?php
// let's set the role for sales user my account
$pre_link =
    @$role == 'sales'
    ? 'my_account/sales'
    : 'admin'
;
?>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="dashboard-stat2 bordered">
            <div class="display">
                <div class="number">
                    <h3 class="font-blue-sharp">
                        <span data-counter="counterup" data-value="567"></span>
                    </h3>
                    <small>NEW ORDERS</small>
                </div>
                <div class="icon">
                    <i class="icon-basket"></i>
                </div>
            </div>
            <div class="progress-info hide">
                <div class="progress">
                    <span style="width: 45%;" class="progress-bar progress-bar-success blue-sharp">
                        <span class="sr-only">45% grow</span>
                    </span>
                </div>
                <div class="status">
                    <div class="status-title"> grow </div>
                    <div class="status-number"> 45% </div>
                </div>
            </div>
            <div class="list">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width:110px;"> Order # </th>
                            <th> Date </th>
                            <th> Items </th>
                            <th> Customer </th>
                            <th style="width:75px;text-align:right;"> Amount </th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if ($orders)
                        {
                            $i = 1;
                            foreach ($orders as $order)
                            {
                                // edit link
                                $edit_link = site_url($pre_link.'/orders/details/index/'.$order->order_id);

                                // order options
                                $order_options = json_decode($order->order_options, TRUE);

                                // for wholesale only site like tempoparis, show only wholesale orders
                                // for now, we use this condition to remove consuemr orders
                                //if ($order->store_name)
                                //{
                                ?>

                        <tr class="odd gradeX ">
                            <!-- Order# -->
                            <td>
                                <a href="<?php echo $edit_link; ?>">
                                    <?php echo $order->order_id.'-'.strtoupper(substr(($order->designer_group == 'Mixed Designers' ? 'SHO' : $order->designer_group),0,3)); ?> <?php echo @$order_options['sales_order'] ? '| SO' : ''; ?>
                                </a>
                            </td>
                            <!-- Date -->
                            <td>
                                <?php
                                // using order_date timestamp
                                echo date('Y-m-d',$order->order_date);
                                ?>
                            </td>
                            <!-- Items -->
                            <td>
                                <?php
                                echo $order->prod_no;
                                if ($order->number_of_orders > 1) echo ' <i class="fa fa-plus text-success tooltips" data-original-title="...more items"></i>';
                                ?>
                            </td>
                            <!-- Customer Info -->
                            <td>
                                <?php
                                if ($order->store_name)
                                {
                                    echo $order->store_name;
                                    echo '<br /><small><cite>('.ucwords(strtolower($order->firstname.' '.$order->lastname)).')</cite></small>';
                                }
                                else echo ucwords(strtolower($order->firstname.' '.$order->lastname));
                                ?>
                            </td>
                            <!-- Purchase Amount -->
                            <td class="text-right"> <?php echo '$ '.number_format($order->amount, 2); ?> </td>
                        </tr>

                                    <?php
                                    $i++;
                                //}
                            }
                        }
                        else
                        { ?>

                        <tr><td colspan="4">No records found.</td></tr>

                            <?php
                        } ?>

                    </tbody>
                </table>
                <a href="<?php echo site_url($pre_link.'/orders/new_orders'); ?>">
                    <cite class="small">more orders...</cite>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="dashboard-stat2 bordered">
            <div class="display">
                <div class="number">
                    <h3 class="font-purple-soft">
                        <span data-counter="counterup" data-value="276"></span>
                    </h3>
                    <small>RECENT ACTIVE WHOLESALE USERS</small>
                </div>
                <div class="icon">
                    <i class="icon-user"></i>
                </div>
            </div>
            <div class="progress-info hide">
                <div class="progress">
                    <span style="width: 57%;" class="progress-bar progress-bar-success purple-soft">
                        <span class="sr-only">56% change</span>
                    </span>
                </div>
                <div class="status">
                    <div class="status-title"> change </div>
                    <div class="status-number"> 57% </div>
                </div>
            </div>
            <div class="list">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th> Store Name </th>
                            <th> Contact Email </th>
                            <th> Last Login </th>
                            <th> Visits </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($users)
                        {
                            $i = @$page ? ($limit * $page) - ($limit - 1) : 1;
                            foreach ($users as $user)
                            {
                                $edit_link = site_url($pre_link.'/users/wholesale/edit/index/'.$user->user_id);
                                ?>

                        <tr class="odd gradeX ">
                            <?php
                            /***********
                             * Store Name
                             */
                            ?>
                            <td> <?php echo $user->store_name; ?> </td>
                            <?php
                            /***********
                             * Email
                             */
                            ?>
                            <td>
                                <a href="<?php echo $edit_link; ?>"><?php echo $user->email; ?></a>
                            </td>
                            <?php
                            /***********
                             * Last Login
                             */
                            ?>
                            <td class="hidden-xs hidden-sm"> <?php echo $user->xdate; ?> </td>
                            <?php
                            /***********
                             * # of visits
                             */
                            ?>
                            <td class="hidden-xs hidden-sm"> <?php echo $user->visits_after_activation; ?> </td>
                        </tr>

                                <?php
                                $i++;
                            }
                        }
                        else
                        { ?>

                        <tr><td colspan="12" align="center">No records found.</td></tr>

                            <?php
                        } ?>
                    </tbody>
                </table>
                <a href="<?php echo site_url($pre_link.'/users/wholesale'); ?>">
                    <cite class="small">more users...</cite>
                </a>
            </div>
        </div>
    </div>
</div>
