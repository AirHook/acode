		<!-- BEGIN GLOBAL MODALS -->
		<?php
		/**
		 * A way to show modal loading at start of page load
		 */
		if (@$show_loading)
		{ ?>
		<!-- LOADING -->
		<div class="loading-modal" id="loading-start" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-sm loading-fade">
				<div class="modal-content">
					<div class="modal-header">
						<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>-->
						<h4 class="modal-title">Loading...</h4>
					</div>
					<div class="modal-body text-center">
						<p class="modal-body-text"></p>
						<i class="fa fa-spinner fa-spin fa-3x text-danger" aria-hidden="true" style="margin:35px 0;"></i>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /modal -->
			<?php
		} ?>
		<!-- END GLOBAL MODALS -->
