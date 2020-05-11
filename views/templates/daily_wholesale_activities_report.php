<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Activation HTML Email</title>

	<?php
	/***********
	 * For editing purposes, css are placed here initially
	 * Transfer all styles inline because some clients, such as Gmail,
	 * will ignore or strip out your <style> tag contents, or ignore them.
	 */
	?>
	<style type="text/css">
	<?php
	/***********
	 * On mobile, it's ideal if the whole button is a link, not just the text,
	 * because it's much harder to target a tiny text link with your finger.
	 */
	?>
	@media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
		body[yahoo] .buttonwrapper {background-color: transparent!important;}
		body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important; display: block!important;}

		/* Unsubscribe footer button only on mobile devices */
		body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
		body[yahoo] .hide {display: none!important;}
	}

	<?php
	/***********
	 * A Fix for Apple Mail
	 * Weirdly, Apple Mail (normally a very progressive email client)
	 * doesn't support the max-width property either.
	 * It does support media queries though, so we can add one that tells
	 * it to set a width on our 'content' class table, as long as the viewport
	 * can display the whole 600px.
	 */
	?>
	@media only screen and (min-device-width: 801px) {
		.content {width: 800px !important;}
		.col380 {width: 400px !important;}
	}
	</style>

</head>

<?php
/***********
 * Hiding Mobile Styles From Yahoo!
 *
 * You will notice that the body tag has an extra attribute.
 * Yahoo Mail loves to interpret your media queries as gospel,
 * so to prevent this, you need to use attribute selectors.
 * The easiest way to do this (as suggested by Email on Acid)
 * is to simply add an arbitrary attribute to the body tag.
 *
 * You can then target specific classes by using the attribute selector for your body tag in the CSS.
 * body[yahoo] .class {}
 *
 * bgcolor="#f6f8f1" -> removed
 */
?>
<body yahoo style="margin: 0;padding: 0; min-width: 100% !important; font-family: verdana; font-size: 12px;">

	<br />
	<br />

	<p> <strong>WHOLESALE STORE ACTIVITIES </strong> - [ <?php echo $sales_user; ?> ] </p>

	<p>
	The following wholesale users logged in yesterday (<?php echo @$date; ?>):
	</p>

	<?php if ($loggedin_users) { ?>

	<br />
	<table style="font-size:12px;padding:0 0 20px 30px;">

		<?php
		$user = array();
		$i = 1;
		foreach ($loggedin_users as $wholesale_user)
		{
			// check if user has been listed
			if ( ! in_array($wholesale_user->email, $user))
			{
				// decode $logindata
				//$logindata = json_decode($wholesale_user->logindata, TRUE);
				$json_str = str_replace('},{', '}|{', $wholesale_user->logindata);
				$json_arys = explode('|', $json_str);
				$logindata = array();
				foreach ($json_arys as $json)
				{
					$temp_ary = json_decode($json, TRUE);
					//$logindata = array_merge_recursive($logindata, $temp_ary);
					$logindata = is_array($temp_ary) ? array_merge_recursive($logindata, $temp_ary) : array_merge_recursive($logindata);
				}
				?>

		<tr>
			<td style="padding:0 0 0 0;">
				Visitor <?php echo @$i; ?>
			</td>
		</tr>
		<tr>
			<td style="padding:0 0 20px 30px;">
				<br />
				Store Name: <strong><?php echo $wholesale_user->store_name; ?></strong><br />
				Contact Name: <?php echo $wholesale_user->firstname.' '.$wholesale_user->lastname; ?><br />
				Telephone: <?php echo $wholesale_user->telephone; ?><br />
				Email: <?php echo $wholesale_user->email; ?><br />
				City: <?php echo $wholesale_user->city; ?><br />
				Country: <?php echo $wholesale_user->country; ?><br />
				<br />
				Create Date: <?php echo $wholesale_user->create_date; ?><br />
				Activation Date: <?php echo $wholesale_user->active_date; ?><br />
				Last Login: <?php echo $wholesale_user->xdate.' '.$wholesale_user->xtime; ?><br />
				Today's Visits: ( <?php echo $wholesale_user->today_visits; ?> )<br />
				<strong>Total Visits: ( <?php echo $wholesale_user->total_visits; ?> )</strong>
				<br />
			</td>
		</tr>
		<tr>
			<td style="padding:0 0 20px 60px;">
				Product Clicks:

				<?php
				if ( ! empty(@$logindata['product_clicks']))
				{
					foreach ($logindata['product_clicks'] as $key => $val)
					{
						if ( ! is_int($key))
						{
							echo '<br />';
							echo '&nbsp; &nbsp; &nbsp; '.$key.' ('.(is_array($val) ? array_sum($val) : $val).')';
						}
						else{
							echo '<br />';
							echo '&nbsp; &nbsp; &nbsp; '.$val;
						}
					}
				}
				else echo '<br />&nbsp; &nbsp; &nbsp; No product clicks.';
				?>

				<br />
			</td>
		</tr>

				<?php if ( ! empty(@$logindata['product_clicks']))
				{ ?>

		<tr>
			<td style="padding:0 0 20px 30px;">
				<br />
					Click <a href="<?php echo site_url('admin/campaigns/sales_pacakge/create/by_product_clicks_report'); ?>?date=<?php echo $wholesale_user->xdate; ?>&user=<?php echo $wholesale_user->email; ?>">HERE</a> to send user package offer of items clicked.
			</td>
		</tr>

					<?php
				} ?>

				<?php
				// let's make an array of the wholesale user possibly having more than one visit a day
				array_push($user, $wholesale_user->email);

				$i++;
			}
		}
		?>

	</table>

	<?php } else { ?>

	<p style="padding:30px 0 20px 30px;">
		No wholesale user activities yesterday.
	</p>

	<?php } ?>

	<br /><br />

	End...

	<br /><br />
	<br /><br />
	<br /><br />

</body>
</html>
