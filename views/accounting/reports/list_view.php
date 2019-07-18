<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row overflow-hide">
        <div class="col-sm-12 overflow-hide">
            <div class="ibox overflow-hide">
                <div class="ibox-content">
                	<div class="row">
                		<div class="reports-grid">
	                		<?php
                            $controller =& get_instance();
	                		foreach ($reports as $key => $value) {
                                if($controller->has_access_of('view_report'))
	                			    echo '<a class="item" href="'.base_url().'admin/reports/'.$value['link'].'">'.$value['title'].'</a>';
                                else
                                    echo '<a class="item" href="#">'.$value['title'].'</a>';
	                		}
	                		?>
	                		<div class="clearfix"></div>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
</div>