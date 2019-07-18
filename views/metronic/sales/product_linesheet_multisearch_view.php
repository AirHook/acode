<h3>SEARCH MULTIPLE ITEMS</h3>

<?php
/***********
 * Noification area
 */
?>
<div class="margin-top-20">
	<?php if (validation_errors()) { ?>
	<div class="alert alert-danger">
		<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
	</div>
	<?php } ?>
</div>

<div style="position:relative;">
	Please enter one STYLE NUMBER per box for as many as 40 items only. <span style="color:red;font-style:italic;">(Sylte Numbers only please.)</span>
	<br /><br />

	<!--bof form==========================================================================-->
	<?php echo form_open(
		'sales/purchase_orders/search_multiple',
		array(
			'class' => 'sa-multi-search-form'
		)
	); ?>

		<div class="m-grid m-grid-responsive-sm">
            <div class="m-grid-row">
                <div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 1. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 2. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 3. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 4. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
            </div>
			<div class="m-grid-row">
                <div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 5. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 6. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 7. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 8. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
            </div>
			<div class="m-grid-row">
                <div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 9. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 10. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 11. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 12. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
            </div>
			<div class="m-grid-row">
                <div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 13. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 14. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 15. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 16. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
            </div>
			<div class="m-grid-row">
                <div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 17. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 18. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 19. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 20. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
            </div>
			<div class="m-grid-row">
                <div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 21. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 22. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 23. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 24. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
            </div>
			<div class="m-grid-row">
                <div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 25. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 26. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 27. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 28. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
            </div>
			<div class="m-grid-row">
                <div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 29. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 30. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 31. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 32. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
            </div>
			<div class="m-grid-row">
                <div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 33. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 34. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 35. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 36. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
            </div>
			<div class="m-grid-row">
                <div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 37. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 38. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 39. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
				<div class="m-grid-col m-grid-col-middle">
					<span class="multi-search-item-no"> 40. </span>
					<input class="multi-search-form-control search_by_style" type="text" name="style_ary[]" />
				</div>
            </div>
		</div>

		<br />
		<div class="row">
			<div class="col-md-3">
				<button type="submit" class="btn dark btn-block"> SEARCH ITEMS </button>
			</div>
		</div>

	<?php echo form_close(); ?>
	<!--eof form==========================================================================-->

</div>
