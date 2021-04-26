<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Create Linesheet
 *
 * @package		CodeIgniter
 * @subpackage	Custom Helpers
 * @category	Images, Linesheet
 * @author		WebGuy
 * @link
 */

// ------------------------------------------------------------------------

/**
 * Create Linesheet
 *
 * Create Linesheet for the product item
 *
 * Parameters:
 *			$img_info -> @GetImageSize of the image in concner
 *			$prod_no -> product number
 *			$img_path -> relative path to image
 *						 'product_assets/'.$prod['c_folder'].'/'.$prod['d_folder'].'/'.$prod['sc_folder'].'/';
 *			$img_name -> filename portion of the image file
 *			$des_logo -> respective designer logo (with relative path) - MUST be PNG
 *
 * @access	public
 * @param	strings
 * @return	boolean
 */
	if ( ! function_exists('create_linesheet'))
	{
		function create_linesheet(
			$img_info = '',
			$prod_no = '',
			$img_path = '',
			$img_name = '',
			$des_logo = '',
			$wholesale_price = '',
			$color_name = ''
		)
		{
			if (
				! $img_info
				OR ! $prod_no
				OR ! $img_path
				OR ! $img_name
				OR ! $des_logo
				OR ! $wholesale_price
				OR ! $color_name
			)
			{
				// nothing more to help with...
				return FALSE;
			}

			// add directory where necessary
			if ( ! file_exists($img_path.'product_linesheet'))
			{
				$old = umask(0);
				if ( ! mkdir($img_path.'product_linesheet', 0777, TRUE)) die('Unable to create "'.$img_path.'product_linesheet'.'" folder. (L867)');
				umask($old);
			}

			// -----------------------------------------
			// ---> Step 1 - BACKDROP
				// resample image
				// Create image instances
				$src = imagecreatefrompng($des_logo); // --> logo size is 292 x 47
				$dest = imagecreatetruecolor(1240, 680); // --> backdrop size (with default black background)

				// making $dest a white backdrop image
				$bg = imagecolorallocate ( $dest, 255, 255, 255 );
				imagefilledrectangle( $dest, 0, 0, 1240, 680, $bg);

				// Copy logo at top left portion of image backdrop
				imagecopy($dest, $src, 10, 12, 0, 0, 292, 47);

				// save image linesheet (1st temp)
				imagejpeg($dest, $img_path.'product_linesheet/z_temp_0001.jpg', 100);

				// free up memmory
				imagedestroy($dest);
				imagedestroy($src);

			// -----------------------------------------
			// ---> Step 2
				// resample front,back, and side and save in temp files
				// FIRST image
				$w = $img_info[0];
				$h = $img_info[1];
				$src = imagecreatefromjpeg($img_path.'product_front/'.$img_name.'.jpg');
				$dest = imagecreatetruecolor(400, 600);
				imagecopyresampled($dest, $src, 0, 0, 0, 0, 400, 600, $w, $h);
				imagejpeg($dest, $img_path.'product_linesheet/z_temp_front.jpg', 100);
				imagedestroy($dest);
				imagedestroy($src);

				// SECOND image
				// if no side image, use back, else use front again
				if (file_exists($img_path.'product_side/'.$img_name.'.jpg')) $img = $img_path.'product_side/'.$img_name.'.jpg';
				elseif (file_exists($img_path.'product_back/'.$img_name.'.jpg')) $img = $img_path.'product_back/'.$img_name.'.jpg';
				else $img = $img_path.'product_front/'.$img_name.'.jpg';
				$img_info_2 = GetImageSize($img);
				$w = $img_info_2[0];
				$h = $img_info_2[1];
				$src = imagecreatefromjpeg($img);
				$dest = imagecreatetruecolor(400, 600);
				imagecopyresampled($dest, $src, 0, 0, 0, 0, 400, 600, $w, $h);
				imagejpeg($dest, $img_path.'product_linesheet/z_temp_side.jpg', 100);
				imagedestroy($dest);
				imagedestroy($src);

				// THIRD image
				// if no back image, use side, else use front again
				if (file_exists($img_path.'product_back/'.$img_name.'.jpg')) $img = $img_path.'product_back/'.$img_name.'.jpg';
				elseif (file_exists($img_path.'product_side/'.$img_name.'.jpg')) $img = $img_path.'product_side/'.$img_name.'.jpg';
				else $img = $img_path.'product_front/'.$img_name.'.jpg';
				$img_info_2 = GetImageSize($img);
				$w = $img_info_2[0];
				$h = $img_info_2[1];
				$src = imagecreatefromjpeg($img);
				$dest = imagecreatetruecolor(400, 600);
				imagecopyresampled($dest, $src, 0, 0, 0, 0, 400, 600, $w, $h);
				imagejpeg($dest, $img_path.'product_linesheet/z_temp_back.jpg', 100);
				imagedestroy($dest);
				imagedestroy($src);

			// -----------------------------------------
			// ---> Step 3
				// paste FRONT image on linesheet image (left side)
				$src = imagecreatefromjpeg($img_path.'product_linesheet/z_temp_front.jpg'); // --> front image
				$dest = imagecreatefromjpeg($img_path.'product_linesheet/z_temp_0001.jpg'); // --> backdrop from step 1
				imagecopy($dest, $src, 10, 70, 0, 0, 400, 600);
				imagejpeg($dest, $img_path.'product_linesheet/z_temp_0002.jpg', 100);
				imagedestroy($dest);
				imagedestroy($src);

			// -----------------------------------------
			// ---> Step 4
				// paste SECOND image on linesheet image (middle)
				$src = imagecreatefromjpeg($img_path.'product_linesheet/z_temp_side.jpg'); // --> back/side/front image
				$dest = imagecreatefromjpeg($img_path.'product_linesheet/z_temp_0002.jpg'); // --> backdrop from step 3
				imagecopy($dest, $src, 420, 70, 0, 0, 400, 600);
				imagejpeg($dest, $img_path.'product_linesheet/z_temp_0003.jpg', 100);
				imagedestroy($dest);
				imagedestroy($src);

			// -----------------------------------------
			// ---> Step 5
				// paste THIRD image on linesheet image (right side)
				$src = imagecreatefromjpeg($img_path.'product_linesheet/z_temp_back.jpg'); // --> back/side/front image
				$dest = imagecreatefromjpeg($img_path.'product_linesheet/z_temp_0003.jpg'); // --> backdrop from step 3
				imagecopy($dest, $src, 830, 70, 0, 0, 400, 600);
				imagejpeg($dest, $img_path.'product_linesheet/z_temp_0004.jpg', 100);
				imagedestroy($dest);
				imagedestroy($src);

			// -----------------------------------------
			// ---> Step 6
				// add product number at top right of final linesheet image
				$dest = imagecreatefromjpeg($img_path.'product_linesheet/z_temp_0004.jpg');
				$text_color = imagecolorallocate($dest, 255, 255, 255); // white
				imagestring($dest, 5, 970, 30, $prod_no, $text_color);
				//imagejpeg($dest, $img_path.'product_linesheet/'.$img_name.'.jpg', 100);
				imagejpeg($dest, $img_path.'product_linesheet/z_temp_0005.jpg', 100);
				imagedestroy($dest);

			// -----------------------------------------
			// ---> Step 7
				// add color name at top right of final linesheet image
				$dest = imagecreatefromjpeg($img_path.'product_linesheet/z_temp_0005.jpg');
				$text_color = imagecolorallocate($dest, 255, 255, 255); // white
				imagestring($dest, 5, 1050, 30, $color_name, $text_color);
				//imagejpeg($dest, $img_path.'product_linesheet/'.$img_name.'.jpg', 100);
				imagejpeg($dest, $img_path.'product_linesheet/z_temp_0006.jpg', 100);
				imagedestroy($dest);

			// -----------------------------------------
			// ---> Step 8
				// add price at top right of FINAL linesheet image
				$dest = imagecreatefromjpeg($img_path.'product_linesheet/z_temp_0006.jpg');
				$text_color = imagecolorallocate($dest, 255, 0, 0); // red
				imagestring($dest, 5, 1180, 30, $wholesale_price, $text_color);
				imagejpeg($dest, $img_path.'product_linesheet/'.$img_name.'.jpg', 100);

			return TRUE;
		}
	}

// ------------------------------------------------------------------------

	if ( ! function_exists('create_linesheet_2'))
	{
		function create_linesheet_2(
			$img_info = '',
			$prod_no = '',
			$linesheet_temp_dir = '',
			$img_path = '',
			$img_name = '',
			$des_logo = '',
			$wholesale_price = '',
			$color_name = ''
		)
		{
			if (
				! $img_info
				OR ! $prod_no
				OR ! $linesheet_temp_dir
				OR ! $img_path
				OR ! $img_name
				OR ! $des_logo
				OR ! $color_name
			)
			{
				// nothing more to help with...
				return FALSE;
			}

			// in this new linesheet creation, the directory is already
			// checked and created as deem necessary
			/*// add directory where necessary
			if ( ! file_exists($img_path.'product_linesheet'))
			{
				$old = umask(0);
				if ( ! mkdir($img_path.'product_linesheet', 0777, TRUE)) die('Unable to create "'.$img_path.'product_linesheet'.'" folder. (L867)');
				umask($old);
			}
			*/

			// -----------------------------------------
			// ---> Step 1 - BACKDROP
				// resample image
				// Create image instances
				$src = imagecreatefrompng($des_logo); // --> logo size is 292 x 47
				$dest = imagecreatetruecolor(1240, 680); // --> backdrop size

				// Copy logo at top left portion of image backdrop
				imagecopy($dest, $src, 10, 12, 0, 0, 292, 47);

				// save image linesheet (1st temp)
				imagejpeg($dest, $linesheet_temp_dir.'z_temp_0001.jpg', 100);

				// free up memmory
				imagedestroy($dest);
				imagedestroy($src);

			// -----------------------------------------
			// ---> Step 2
				// resample front,back, and side and save in temp files
				// FIRST image
				$w = $img_info[0];
				$h = $img_info[1];
				$src = imagecreatefromjpeg($img_path.$img_name.'_f.jpg');
				$dest = imagecreatetruecolor(400, 600);
				imagecopyresampled($dest, $src, 0, 0, 0, 0, 400, 600, $w, $h);
				imagejpeg($dest, $linesheet_temp_dir.'z_temp_front.jpg', 100);
				imagedestroy($dest);
				imagedestroy($src);

				// SECOND image
				// if no side image, use back, else use front again
				if (file_exists($img_path.$img_name.'_s.jpg')) $img = $img_path.$img_name.'_s.jpg';
				elseif (file_exists($img_path.$img_name.'_b.jpg')) $img = $img_path.$img_name.'_b.jpg';
				else $img = $img_path.$img_name.'_f.jpg';
				$img_info_2 = GetImageSize($img);
				$w = $img_info_2[0];
				$h = $img_info_2[1];
				$src = imagecreatefromjpeg($img);
				$dest = imagecreatetruecolor(400, 600);
				imagecopyresampled($dest, $src, 0, 0, 0, 0, 400, 600, $w, $h);
				imagejpeg($dest, $linesheet_temp_dir.'z_temp_side.jpg', 100);
				imagedestroy($dest);
				imagedestroy($src);

				// THIRD image
				// if no back image, use side, else use front again
				if (file_exists($img_path.$img_name.'_b.jpg')) $img = $img_path.$img_name.'_b.jpg';
				elseif (file_exists($img_path.$img_name.'_s.jpg')) $img = $img_path.$img_name.'_s.jpg';
				else $img = $img_path.$img_name.'_f.jpg';
				$img_info_2 = GetImageSize($img);
				$w = $img_info_2[0];
				$h = $img_info_2[1];
				$src = imagecreatefromjpeg($img);
				$dest = imagecreatetruecolor(400, 600);
				imagecopyresampled($dest, $src, 0, 0, 0, 0, 400, 600, $w, $h);
				imagejpeg($dest, $linesheet_temp_dir.'z_temp_back.jpg', 100);
				imagedestroy($dest);
				imagedestroy($src);

			// -----------------------------------------
			// ---> Step 3
				// paste FRONT image on linesheet image (left side)
				$src = imagecreatefromjpeg($linesheet_temp_dir.'z_temp_front.jpg'); // --> front image
				$dest = imagecreatefromjpeg($linesheet_temp_dir.'z_temp_0001.jpg'); // --> backdrop from step 1
				imagecopy($dest, $src, 10, 70, 0, 0, 400, 600);
				imagejpeg($dest, $linesheet_temp_dir.'z_temp_0002.jpg', 100);
				imagedestroy($dest);
				imagedestroy($src);

			// -----------------------------------------
			// ---> Step 4
				// paste SECOND image on linesheet image (middle)
				$src = imagecreatefromjpeg($linesheet_temp_dir.'z_temp_side.jpg'); // --> back/side/front image
				$dest = imagecreatefromjpeg($linesheet_temp_dir.'z_temp_0002.jpg'); // --> backdrop from step 3
				imagecopy($dest, $src, 420, 70, 0, 0, 400, 600);
				imagejpeg($dest, $linesheet_temp_dir.'z_temp_0003.jpg', 100);
				imagedestroy($dest);
				imagedestroy($src);

			// -----------------------------------------
			// ---> Step 5
				// paste THIRD image on linesheet image (right side)
				$src = imagecreatefromjpeg($linesheet_temp_dir.'z_temp_back.jpg'); // --> back/side/front image
				$dest = imagecreatefromjpeg($linesheet_temp_dir.'z_temp_0003.jpg'); // --> backdrop from step 3
				imagecopy($dest, $src, 830, 70, 0, 0, 400, 600);
				imagejpeg($dest, $linesheet_temp_dir.'z_temp_0004.jpg', 100);
				imagedestroy($dest);
				imagedestroy($src);

			// -----------------------------------------
			// ---> Step 6
				// add product number at top right of final linesheet image
				$dest = imagecreatefromjpeg($linesheet_temp_dir.'z_temp_0004.jpg');
				$text_color = imagecolorallocate($dest, 255, 255, 255); // white
				imagestring($dest, 5, 970, 30, $prod_no, $text_color);
				//imagejpeg($dest, $img_path.'product_linesheet/'.$img_name.'.jpg', 100);
				imagejpeg($dest, $linesheet_temp_dir.'z_temp_0005.jpg', 100);
				imagedestroy($dest);

			// -----------------------------------------
			// ---> Step 7
				// add color name at top right of final linesheet image
				$dest = imagecreatefromjpeg($linesheet_temp_dir.'z_temp_0005.jpg');
				$text_color = imagecolorallocate($dest, 255, 255, 255); // white
				imagestring($dest, 5, 1050, 30, $color_name, $text_color);
				//imagejpeg($dest, $img_path.'product_linesheet/'.$img_name.'.jpg', 100);
				imagejpeg($dest, $linesheet_temp_dir.'z_temp_0006.jpg', 100);
				imagedestroy($dest);

			// -----------------------------------------
			// ---> Step 8
				// add price at top right of FINAL linesheet image
				$dest = imagecreatefromjpeg($linesheet_temp_dir.'z_temp_0006.jpg');
				$text_color = imagecolorallocate($dest, 255, 0, 0); // red
				imagestring($dest, 5, 1180, 30, $wholesale_price, $text_color);
				imagejpeg($dest, $img_path.$img_name.'_linesheet.jpg', 100);

			return TRUE;
		}
	}

// ------------------------------------------------------------------------

	if ( ! function_exists('create_lookbook'))
	{
		function create_lookbook(
			$prod_no = '',
			$color_name = '',
			$price = '',
			$lookbook_temp_dir = '',
			$img_path = '',
			$img_name = '',
			$des_logo = '',
			$category = '',
			$page_count = ''
		)
		{
			if (
				! $prod_no
				OR ! $color_name
				//OR ! $price
				OR ! $lookbook_temp_dir
				OR ! $img_path
				OR ! $img_name
				OR ! $des_logo
				OR ! $category
			)
			{
				// nothing more to help with...
				return FALSE;
			}

			$CI =& get_instance();
			$CI->load->library('image_lib');

			// -----------------------------------------
			// ---> Step 1 - BACKDROP
				// resample image
				// Create image instances
				$dest = imagecreatetruecolor(1240, 900); // --> backdrop size to (600 + 40 + 600) x 900
				// get color for background
				$bg_white = imagecolorallocate($dest, 255, 255, 255); // white
				// fill the rectangle
				imagefilledrectangle($dest, 0, 0, 1239, 899, $bg_white);
				// save image linesheet (1st temp)
				imagejpeg($dest, $lookbook_temp_dir.'zz_temp_0001.jpg', 90);
				// free up memmory
				imagedestroy($dest);
				//imagedestroy($src);

			// -----------------------------------------
			// ---> Step 2
				// paste FRONT image on lookbook image (left side)
				// download image via curl
				if ($CI->webspace_details->slug != 'instylenewyork')
				{
					$ch = curl_init();
				    curl_setopt($ch, CURLOPT_URL, PROD_IMG_URL.$img_path.$img_name.'_f.jpg');
				    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // good edit, thanks!
				    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1); // also, this seems wise considering output is image.
					curl_setopt($ch, CURLOPT_FAILONERROR, 1);
				    $data = curl_exec($ch);
					if (curl_errno($ch)) {
						// NOTE: front image is always present thus making this catch error remote
					    $error_msg_f = curl_error($ch); // The requested URL returned error: 404 Not Foundwith error
					}
				    curl_close($ch);
				    $image = imagecreatefromstring($data);
					imagejpeg($image, $lookbook_temp_dir.'lbf.jpg', 90);
					$src_front_image = $lookbook_temp_dir.'lbf.jpg';
				}
				else
				{
					$src_front_image = $img_path.$img_name.'_f.jpg';
				}
				// resize image
				$config['image_library']	= 'gd2';
				$config['quality']			= '80%';
				$config['source_image'] 	= $src_front_image;
				$config['new_image'] 		= $lookbook_temp_dir.'lbf_'.$page_count.'.jpg';
				$config['maintain_ratio'] 	= TRUE;
				$config['width']         	= 600; // from 800
				$config['height']       	= 900; // from 1200
				$CI->image_lib->initialize($config);
				$CI->image_lib->resize(); // to debug error: if ( ! $CI->image_lib->resize())
				$CI->image_lib->clear();
				// generate temp image
				$src = imagecreatefromjpeg($lookbook_temp_dir.'lbf_'.$page_count.'.jpg'); // --> front image
				$dest = imagecreatefromjpeg($lookbook_temp_dir.'zz_temp_0001.jpg'); // --> backdrop from step 1
				imagecopy($dest, $src, 0, 0, 0, 0, 600, 900);
				imagejpeg($dest, $lookbook_temp_dir.'zz_temp_0002.jpg', 90);
				imagedestroy($dest);
				imagedestroy($src);
				imagedestroy($image);

			// -----------------------------------------
			// ---> Step 3
				// paste SECOND image on lookbook image (right side - back, or side, or front)
				// download image via curl
				if ($CI->webspace_details->slug != 'instylenewyork')
				{
					$img_front = FALSE;

					// get back image
					$img_back = TRUE;
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, PROD_IMG_URL.$img_path.$img_name.'_b.jpg');
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // good edit, thanks!
					curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1); // also, this seems wise considering output is image.
					curl_setopt($ch, CURLOPT_FAILONERROR, 1);
					$data = curl_exec($ch);
					if (curl_errno($ch)) {
						$error_msg_b = curl_error($ch); // The requested URL returned error: 404 Not Foundwith error
						$img_back = FALSE;
					}
					curl_close($ch);

					// if no back image
					if ( ! $img_back)
					{
						// get side image
						$img_side = TRUE;
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, PROD_IMG_URL.$img_path.$img_name.'_s.jpg');
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // good edit, thanks!
						curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1); // also, this seems wise considering output is image.
						curl_setopt($ch, CURLOPT_FAILONERROR, 1);
						$data = curl_exec($ch);
						if (curl_errno($ch)) {
							$error_msg_s = curl_error($ch); // The requested URL returned error: 404 Not Foundwith error
							$img_side = FALSE;
						}
						curl_close($ch);

						// if no side image
						if ( ! $img_side)
						{
							// default to front image
							$img_front = TRUE;
						}
					}

					if ($img_front)
					{
						$src_back_image = $lookbook_temp_dir.'lbf.jpg';
					}
					else
					{
						$image = imagecreatefromstring($data);
						imagejpeg($image, $lookbook_temp_dir.'lbb.jpg', 90);
						$src_back_image = $lookbook_temp_dir.'lbb.jpg';
					}
				}
				else
				{
					if (file_exists($img_path.$img_name.'_b.jpg')) $src_back_image = $img_path.$img_name.'_b.jpg';
					elseif (file_exists($img_path.$img_name.'_s.jpg')) $src_back_image = $img_path.$img_name.'_s.jpg';
					else $src_back_image = $img_path.$img_name.'_f.jpg';
				}
				//$img_info_2 = GetImageSize($img);
				//$w = $img_info_2[0];
				//$h = $img_info_2[1];
				// resize image
				$config['image_library']	= 'gd2';
				$config['quality']			= '80%';
				$config['source_image'] 	= $src_back_image;
				$config['new_image'] 		= $lookbook_temp_dir.'lbb_'.$page_count.'.jpg';
				$config['maintain_ratio'] 	= TRUE;
				$config['width']         	= 600; // from 800
				$config['height']       	= 900; // from 1200
				$CI->image_lib->initialize($config);
				$CI->image_lib->resize(); // to debug error: if ( ! $CI->image_lib->resize())
				$CI->image_lib->clear();
				// generate temp image
				$src = imagecreatefromjpeg($lookbook_temp_dir.'lbb_'.$page_count.'.jpg');
				$dest = imagecreatefromjpeg($lookbook_temp_dir.'zz_temp_0002.jpg'); // --> backdrop from step 2
				imagecopy($dest, $src, 640, 0, 0, 0, 600, 900);
				imagejpeg($dest, $lookbook_temp_dir.'zz_temp_0003.jpg', 90);
				imagedestroy($dest);
				imagedestroy($src);
				imagedestroy($image);

			// -----------------------------------------
			// ---> Step 4
				// add logo and reduce size
				$src_temp = imagecreatefrompng($des_logo); // --> logo size is 292 x 47
				$src = imagescale($src_temp, 180, -1); // scale down logo
				// crop auto excess transparent background
				$cropped = imagecropauto($src, IMG_CROP_DEFAULT);
				if ($cropped !== false) { // in case a new image resource was returned
				    imagedestroy($src);    // we destroy the original image
				    $src = $cropped;       // and assign the cropped image to $im
				}
				// get new logo dimensions
				$src_w = imagesx($src);
				$src_h = imagesy($src);
				// get destination image as background
				$dest = imagecreatefromjpeg($lookbook_temp_dir.'zz_temp_0003.jpg'); // --> backdrop from step 3
				// creating a cut resource
				$cut = imagecreatetruecolor($src_w, $src_h);
				// copying relevant section from background to the cut resource
				imagecopy($cut, $dest, 0, 0, 20, 20, $src_w, $src_h);
				// copying relevant section from watermark logo to the cut resource
				imagecopy($cut, $src, 0, 0, 0, 0, $src_w, $src_h);
				// insert cut resource to destination image
				imagecopymerge($dest, $cut, 20, 20, 0, 0, $src_w, $src_h, 90);
				// save file
				imagejpeg($dest, $lookbook_temp_dir.'zz_temp_0004.jpg', 90);
				imagedestroy($dest);
				imagedestroy($src);
				imagedestroy($src_temp);
				imagedestroy($cropped);
				imagedestroy($cut);

			// -----------------------------------------
			// ---> Step 5
				// add category
				$dest = imagecreatefromjpeg($lookbook_temp_dir.'zz_temp_0004.jpg'); // --> backdrop from step 4
				$text_color = imagecolorallocate($dest, 255, 255, 255); // white
				$font = 'ArialCE.ttf'; // font
				imagettftext($dest, 18, 90, 40, 825, $text_color, $font, strtoupper($category));
				imagejpeg($dest, $lookbook_temp_dir.'zz_temp_0005.jpg', 90);
				imagedestroy($dest);
				imagedestroy($text_color);

			// -----------------------------------------
			// ---> Step 6
				// add product number, color name, price, & page count
				$dest = imagecreatefromjpeg($lookbook_temp_dir.'zz_temp_0005.jpg'); // --> backdrop from step 5
				$text_color = imagecolorallocate($dest, 255, 255, 255); // white
				$font = 'ArialCE.ttf'; // font
				$string = $prod_no.'    '.$color_name.'    '.$price;
				imagettftext($dest, 10, 0, 20, 880, $text_color, $font, $string);
				imagettftext($dest, 10, 0, 1215, 880, $text_color, $font, $page_count);
				imagejpeg($dest, $lookbook_temp_dir.'lbimg_'.$page_count.'.jpg', 90);
				imagedestroy($dest);
				imagedestroy($text_color);

			// -----------------------------------------
			// ---> Remove residual images
				unlink($lookbook_temp_dir.'lbf_'.$page_count.'.jpg');
				unlink($lookbook_temp_dir.'lbb_'.$page_count.'.jpg');

			return $lookbook_temp_dir.'lbimg_'.$page_count.'.jpg';
		}
	}

// ------------------------------------------------------------------------

/* End of file Sate_country_helper.php */
/* Location: ./application/helpers/Sate_country_helper.php */
