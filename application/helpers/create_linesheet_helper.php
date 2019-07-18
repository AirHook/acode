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

/* End of file Sate_country_helper.php */
/* Location: ./application/helpers/Sate_country_helper.php */