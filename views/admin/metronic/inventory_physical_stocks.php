                                                <div class="table-scrollable" style="margin-top:0px!important;">
                                                    <table id="table-inventory-physical" class="table table-bordered table-striped table-hover table-condensed inventory-physical">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Prod NO</th>
                                                                <th>Color Name</th>

                                                                <?php if ($size_mode == '1')
                                                                { ?>

                                                                <th class="size">Size 0</th>
                                                                <th class="size">Size 2</th>
                                                                <th class="size">Size 4</th>
                                                                <th class="size">Size 6</th>
                                                                <th class="size">Size 8</th>
                                                                <th class="size">Size 10</th>
                                                                <th class="size">Size 12</th>
                                                                <th class="size">Size 14</th>
                                                                <th class="size">Size 16</th>
                                                                <th class="size">Size 18</th>
                                                                <th class="size">Size 20</th>
                                                                <th class="size">Size 22</th>

                                                                    <?php
                                                                } ?>

                                                                <?php if ($size_mode == '0')
                                                                { ?>

                                                                <th class="size">Size S</th>
                                                                <th class="size">Size M</th>
                                                                <th class="size">Size L</th>
                                                                <th class="size">Size XL</th>
                                                                <th class="size">Size XXL</th>

                                                                    <?php
                                                                } ?>

                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            if ($products)
                                                            {
                                                                foreach ($products as $product)
                                                                { ?>

                                                            <tr>
                                                                <td><?php echo $product->st_id; ?></td>
                                                                <td><?php echo $product->prod_no; ?></td>
                                                                <td><?php echo $product->color_name; ?></td>

                                                                    <?php if ($size_mode == '1')
                                                                    { ?>

                                                                <td><?php echo $product->physical_0; ?></td>
                                                                <td><?php echo $product->physical_2; ?></td>
                                                                <td><?php echo $product->physical_4; ?></td>
                                                                <td><?php echo $product->physical_6; ?></td>
                                                                <td><?php echo $product->physical_8; ?></td>
                                                                <td><?php echo $product->physical_10; ?></td>
                                                                <td><?php echo $product->physical_12; ?></td>
                                                                <td><?php echo $product->physical_14; ?></td>
                                                                <td><?php echo $product->physical_16; ?></td>
                                                                <td><?php echo $product->physical_18; ?></td>
                                                                <td><?php echo $product->physical_20; ?></td>
                                                                <td><?php echo $product->physical_22; ?></td>

                                                                        <?php
                                                                    } ?>

                                                                    <?php if ($size_mode == '0')
                                                                    { ?>

                                                                <td><?php echo $product->physical_ss; ?></td>
                                                                <td><?php echo $product->physical_sm; ?></td>
                                                                <td><?php echo $product->physical_sl; ?></td>
                                                                <td><?php echo $product->physical_sxl; ?></td>
                                                                <td><?php echo $product->physical_sxxl; ?></td>

                                                                        <?php
                                                                    } ?>

                                                            </tr>

                                                                    <?php
                                                                }
                                                            }
                                                            else
                                                            { ?>

                                                            <tr>
                                                                <td colspan="14">
                                                                    There are no products returned.
                                                                </td>
                                                            </tr>

                                                                <?php
                                                            } ?>

                                                        </tbody>
                                                    </table>
                                                </div>
