<?
	/**
	* Image Handler Class
	*
	* @link http://somnetics.in/
	* @copyright 2010-2011 Somnetics Pvt. Ltd.
	* @author Susanta Das <susanta.das@somnet.co.in>	
	* @version 1.0.50
	*/
	class Image {
		/**
		* Generate Thumbnail
		*
		* Function thumbnail
		* @param $source_path as string
		* @param $destination_path as string
		* @param $image_width as number
		* @param $image_height as number
		* @returns image file
		* @author Susanta Das
		*/
		static function thumbnail($source_path, $destination_path, $image_width=null, $image_height=null, $center_image=true){
			//get file extension
			$get_extension = strtolower(substr(strrchr($source_path, '.'), 1));
			
			if($get_extension=='jpg' || $get_extension=='jpeg')
				$source_img = @imagecreatefromjpeg($source_path);
			elseif($get_extension=='png')
				$source_img = @imagecreatefrompng($source_path);
			elseif($get_extension=='gif')
				$source_img = @imagecreatefromgif($source_path);
							
			if($source_img){
				//echo "could not create image handle";
				//exit(0);			
				
				$orig_w = imagesx($source_img);
				$orig_h = imagesy($source_img);

				if(empty($image_width) && !empty($image_height))
				{
					$new_ratio = $image_height / $orig_h * 100;
					
					$image_width = round($orig_w * $new_ratio / 100);
				}
								
				if(!empty($image_width) && empty($image_height))
				{
					$new_ratio = $image_width / $orig_w * 100;
					
					$image_height = round($orig_h * $new_ratio / 100);
				}				
							
				$new_w = $image_width;
				$new_h = $image_height;
					
				$w_ratio = ($new_w / $orig_w);
				$h_ratio = ($new_h / $orig_h);
					
				if($orig_h > $new_h || $orig_w > $new_w)
				{			
					if ($orig_w > $orig_h) {//landscape
						if($orig_h > $new_h)
							$crop_h = $new_h;
						else
						{
							$crop_h = $orig_h;						
							$h_ratio = 1;
						}
						
						$crop_w = round($orig_w * $h_ratio);	

						if($center_image)
							$xStart = ($orig_w - $orig_h) / 2;
						else
							$xStart = 0;
							
						$yStart = 0;
					} elseif ($orig_w < $orig_h) {//portrait
						if($orig_w > $new_w)
							$crop_w = $new_w;
						else
						{
							$crop_w = $orig_w;						
							$w_ratio = 1;
						}
						
						$crop_h = round($orig_h * $w_ratio);					
						
						$xStart = 0;
						
						if($center_image)
							$yStart = ($orig_h - $orig_w) / 2;
						else
							$yStart = 0;							
					} else {//square
						$crop_w = $new_w;
						$crop_h = $new_h;	
						
						$xStart = 0;
						$yStart = 0;
					}						

					$dest_img = @imagecreatetruecolor($new_w, $new_h);	
													
					if($get_extension=='jpg' || $get_extension=='jpeg')
					{
						imagecopyresampled($dest_img, $source_img, 0, 0, $xStart, $yStart, $crop_w, $crop_h, $orig_w, $orig_h);					
						
						if(imagejpeg($dest_img, $destination_path, 100)) {
							imagedestroy($dest_img);
							imagedestroy($source_img);
						} else {
							//return "could not make thumbnail image";
							//exit(0);
						}
					}
					elseif($get_extension=='png')
					{	
						//for transparent
						@imagecolortransparent($dest_img, @imagecolorallocate($dest_img, 0, 0, 0));
						@imagealphablending($dest_img, false);
						@imagesavealpha($dest_img, true);
						
						imagecopyresampled($dest_img, $source_img, 0, 0, $xStart, $yStart, $crop_w, $crop_h, $orig_w, $orig_h);
						
						if(imagepng($dest_img, $destination_path, 8)) {
							imagedestroy($dest_img);
							imagedestroy($source_img);
						} else {
							//return "could not make thumbnail image";
							//exit(0);
						}				
					}
					elseif($get_extension=='gif')
					{
						//for transparent
						@imagecolortransparent($dest_img, @imagecolorallocate($dest_img, 0, 0, 0));
						@imagealphablending($dest_img, false);
						@imagesavealpha($dest_img, true);
						
						imagecopyresampled($dest_img, $source_img, 0, 0, $xStart, $yStart, $crop_w, $crop_h, $orig_w, $orig_h);
						
						if(imagegif($dest_img, $destination_path, null)) {
							imagedestroy($dest_img);
							imagedestroy($source_img);
						} else {
							//return "could not make thumbnail image";
							//exit(0);
						}			
					}
				}
				else
				{ 								
					copy($source_path, $destination_path);
				}
			}
		}
	}
?>