														<?php if (@$step != 'receipt')
														{ ?>

														<div class="col-sm-6">

															<h5> Billing Address <span class="small"> &nbsp; <a href="<?php echo site_url('checkout/address'); ?>" style="color:black;">Edit</a></span></h5>

															<p>
															<?php
															if ($this->session->user_role == 'wholesale')
															{
																echo $this->wholesale_user_details->store_name.'<br />';
															}
															else
															{
																echo $this->session->b_firstname.' '.$this->session->b_lastname.'<br />';
															}
															echo $this->session->b_address1 ? $this->session->b_address1.'<br />' : '';
															echo $this->session->b_address2 ? $this->session->b_address2.'<br />' : '';
															echo $this->session->b_city.($this->session->b_state != 'Other' ? ', '.$this->session->b_state.' ' : ' ').$this->session->b_zip.'<br />';
															echo $this->session->b_country.'<br />';
															echo $this->session->b_phone.'<br />';
															if ($this->session->user_role == 'wholesale')
															{
																echo 'ATTN: '.$this->session->b_firstname.' '.$this->session->b_lastname.'<br />';
															}
															?>
															</p>

														</div>
														<div class="col-sm-6">

															<h5> Shipping Address <span class="small"> &nbsp; <a href="<?php echo site_url('checkout/address'); ?>" style="color:black;">Edit</a></span></h5>

															<p>
															<?php
															if ($this->session->user_role == 'wholesale')
															{
																echo $this->wholesale_user_details->store_name.'<br />';
															}
															else
															{
																echo $this->session->sh_firstname.' '.$this->session->sh_lastname.'<br />';
															}
															echo $this->session->sh_address1 ? $this->session->sh_address1.'<br />' : '';
															echo $this->session->sh_address2 ? $this->session->sh_address2.'<br />' : '';
															echo $this->session->sh_city.($this->session->sh_state != 'Other' ? ', '.$this->session->sh_state.' ' : ' ').$this->session->sh_zip.'<br />';
															echo $this->session->sh_country.'<br />';
															echo $this->session->sh_phone.'<br />';
															if ($this->session->user_role == 'wholesale')
															{
																echo 'ATTN: '.$this->session->sh_firstname.' '.$this->session->sh_lastname.'<br />';
															}
															?>
															</p>

														</div>

															<?php
														}
														else
														{ ?>

														<div class="col-sm-4">

															<h5> Billing Address </h5>

															<p>
															<?php
															if ($this->session->user_role == 'wholesale')
															{
																echo $this->wholesale_user_details->store_name.'<br />';
															}
															else
															{
																echo $this->order_details->firstname.' '.$this->order_details->lastname.'<br />';
															}
															echo @$user->address1;
															echo @$user->address2 ? '<br />'.$user->address2.'<br />' : '<br />';
															echo @$user->city.(@$user->state != 'Other' ? ', '.@$user->state.' ' : ' ').@$user->zipcode.'<br />';
															echo @$user->country.'<br />';
															echo @$user->telephone.'<br />';
															if ($this->session->user_role == 'wholesale')
															{
																echo 'ATTN: '.$this->order_details->firstname.' '.$this->order_details->lastname.'<br />';
															}
															?>
															</p>

														</div>
														<div class="col-sm-4">

															<h5> Shipping Address </h5>

															<p>
															<?php
															if ($this->session->user_role == 'wholesale')
															{
																echo $this->wholesale_user_details->store_name.'<br />';
															}
															else
															{
																echo @$this->order_details->firstname.' '.$this->order_details->lastname.'<br />';
															}
															echo @$this->order_details->ship_address1;
															echo @$this->order_details->ship_address2 ? '<br />'.@$this->order_details->sh_address2.'<br />' : '<br />';
															echo @$this->order_details->ship_city.(@$this->order_details->ship_state != 'Other' ? ', '.$this->order_details->ship_state.' ' : ' ').@$this->order_details->ship_zipcode.'<br />';
															echo @$this->order_details->ship_country.'<br />';
															echo @$this->order_details->telephone.'<br />';
															if ($this->session->user_role == 'wholesale')
															{
																echo 'ATTN: '.$this->order_details->firstname.' '.$this->order_details->lastname.'<br />';
															}
															?>
															</p>

														</div>
														<div class="col-sm-4">

															<h5> Shipping Method </h5>

															<p>
															<?php
															echo $this->order_details->courier;
															?>
															</p>

														</div>

														<?php } ?>
