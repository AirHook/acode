					<?php
					/**********
					 * CONTENT
					 */
					?>
					<div id="content" class="content clearfix">
					
						<?php
						/**********
						 * For index page - 
						 * This DIV holds a height that helps in ensuring a space for the sesarch input
						 * on mobile devices....
						 */
						?>
						<div class="hidden-on-desktop" style="height:35px;">&nbsp;</div>
						
						<div id="main" class="content-grid  clearfix" role="main">
						
							<div class="ct ct-body clearfix">
								<!-- mod: 04-12-2016 -->
								
								<div class="homepage">
									<div class="roden-creative">
									
										<?php
										/**********
										 * First image container
										 */
										?>
										<?php 
										if (
											! isset($this->webspace_details->theme_options['section_1'])
											OR (
												isset($this->webspace_details->theme_options['section_1'])
												&& ! $this->webspace_details->theme_options['section_1']
											)
										)
										{
											$this->load->view($this->webspace_details->options['theme'].'/index_section_1'); 
										}
										?>
										<!-- .container-one -->
										
										<?php
										/**********
										 * Second image container
										 * of three images (two rows)
										 */
										?>
										<div class="container-two">
											<div class="inner">
											
												<?php
												/**********
												 * Top Row (section)
												 */
												?>
												<?php 
												if (
													! isset($this->webspace_details->theme_options['section_2a'])
													OR (
														isset($this->webspace_details->theme_options['section_2a'])
														&& ! $this->webspace_details->theme_options['section_2a']
													)
												)
												{
													$this->load->view($this->webspace_details->options['theme'].'/index_section_2a'); 
												}
												?>

												<?php
												/**********
												 * Bottom Row (section)
												 */
												?>
												<?php 
												if (
													! isset($this->webspace_details->theme_options['section_2b'])
													OR (
														isset($this->webspace_details->theme_options['section_2b'])
														&& ! $this->webspace_details->theme_options['section_2b']
													)
												)
												{
													$this->load->view($this->webspace_details->options['theme'].'/index_section_2b'); 
												}
												?>
												
											</div>
										</div>
										<!-- .container-two -->
		
										<?php
										/**********
										 * Third image container
										 * about Full width section
										 */
										?>
										<?php 
										if (
											! isset($this->webspace_details->theme_options['section_3'])
											OR (
												isset($this->webspace_details->theme_options['section_3'])
												&& ! $this->webspace_details->theme_options['section_3']
											)
										)
										{
											$this->load->view($this->webspace_details->options['theme'].'/index_section_3'); 
										}
										?>
										<!-- .container-three -->
		
										<?php
										/**********
										 * Fourth image container
										 */
										?>
										<?php 
										if (
											! isset($this->webspace_details->theme_options['section_4'])
											OR (
												isset($this->webspace_details->theme_options['section_4'])
												&& ! $this->webspace_details->theme_options['section_4']
											)
										)
										{
											$this->load->view($this->webspace_details->options['theme'].'/index_section_4'); 
										}
										?>
										<!-- .container-four -->
		
										<?php
										/**********
										 * Fifth image container
										 * Boxed grid single image
										 */
										?>
										<?php 
										if (
											! isset($this->webspace_details->theme_options['section_5'])
											OR (
												isset($this->webspace_details->theme_options['section_5'])
												&& ! $this->webspace_details->theme_options['section_5']
											)
										)
										{
											$this->load->view($this->webspace_details->options['theme'].'/index_section_5'); 
										}
										?>
										<!-- .container-four -->
										
									</div>
									
								</div><!-- .homepage -->

								<div style="max-width:1020px;margin:50px auto 10px;padding:0 10px;">
								
									<?php
									/**********
									 * HOME Page Footer Text
									 * editable at admin
									 * sames as home page image boxes edits
									 */
									?>
									<div class='readmore is-active'>
									
										<?php echo @$homepage_options['six']['footer_text']; ?>
										
									</div>
									
								</div>
								
							</div><!-- end CT BODY -->
						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div><!-- end #content -->
                
