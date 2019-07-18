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

		<!-- WS LAPSE SESSION -->
		<?php if ($this->session->flashdata('popup_ws_lapse_dialog'))
		{ ?>
		<div class="loading-modal" id="modal-ws_lapse_dialog" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>-->
						<h4 class="modal-title">Notice!</h4>
					</div>
					<div class="modal-body">
						<p class="modal-body-text">
							You have been idle for quite a while.<br />
							Would you like to continue your session?
						</p>
					</div>
					<div class="modal-footer">
						<a href="<?php echo site_url('account/relapse'); ?>" class="btn dark btn-outline">Continue...</a>
						<a href="<?php echo site_url('account/logout'); ?>" class="btn dark">Logout</a>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
			<?php
		} ?>
		<!-- /modal -->
		<!-- END GLOBAL MODALS -->
