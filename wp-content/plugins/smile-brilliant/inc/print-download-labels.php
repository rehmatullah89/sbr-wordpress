<?php

/**
 * Print a receipt using the lpr command.
 *
 * This function prints a receipt using the lpr command in a Unix-like environment.
 * It checks the WP_ENV constant to determine whether the code is running in a production environment.
 * If in production, it verifies the shipment by cropping the image and then sends it to the ZEBRAZT410 printer.
 *
 * @param string $file_path The path to the receipt file.
 * @param string $type      The type of receipt (e.g., '6x4').
 *
 * @return void
 */

 function mbt_printer_receipt($file_path, $type)
{
     //echo $file_path;
    // echo $type;
    // die();
  // echo  $file_path = 'https://stable.smilebrilliant.com/downloads/labels/9400136109361638577964.png';
  
    if (extension_loaded('gd') && function_exists('gd_info') && strpos($file_path, ".png") !== false && strpos($file_path, "downloads/labels") !== false) {
        //echo "GD library is installed and enabled.";
         $file_path = rotate_image_180_deg($file_path,180,0);
    } else {
        //echo "GD library is not installed or enabled.";
    }
   
    $orientation_add = '';
    if(strpos($file_path, ".pdf") !== false && strpos($file_path, "downloads/packages") !== false){
        $orientation_add = '-o orientation-requested=4';
    }
   //echo 'printed path'.$file_path;
    
    if (WP_ENV == 'production') {
        $printerSelected = 'ZEBRAZT410';
    }
    else{
        $printerSelected = 'HPMBT';
    }
        $verifyShipment = crop_image_mbt($file_path);
        if (is_array($verifyShipment) && count($verifyShipment) > 0) {
            foreach ($verifyShipment as $page_path) {
                $orientation_add = '';
                if(strpos($file_path, ".pdf") !== false && strpos($file_path, "downloads/packages") !== false){
                    $orientation_add = 'orientation-requested=4';
                }
                 $ptint_req =  'nohup lpr -P '.$printerSelected.' -o media=Custom.4x6in -o landscape -o fit-to-page '.$orientation_add.' ' . $page_path . ' 2>&1 &';
                
                shell_exec($ptint_req);
            }
        } else {
            if ($type == '6x4') {
                 $ptint_req = 'nohup lpr -P '.$printerSelected.' -o media=Custom.4x6in -o landscape -o fit-to-page '.$orientation_add.' ' . $file_path . ' 2>&1 &';
                //echo '==>';
                shell_exec($ptint_req);
            } else {
                 $ptint_req = 'nohup lpr -P '.$printerSelected.' -o media=Custom.4x6in -o fit-to-page '.$orientation_add.' ' . $file_path . ' 2>&1 &';
                //echo '__>';
                shell_exec($ptint_req);
            }
        }
    
}
function mbt_printer_receipt_back($file_path, $type)
{
    if (WP_ENV == 'production') {
        $verifyShipment = crop_image_mbt($file_path);
        if (is_array($verifyShipment) && count($verifyShipment) > 0) {
            foreach ($verifyShipment as $page_path) {
                //shell_exec('nohup lpr -P ZEBRAZT410 -o media=Custom.4x6in -o landscape -o fit-to-page ' . $page_path . ' 2>&1 &');
                shell_exec('nohup lpr -P HPMBT -o media=Custom.4x6in -o landscape -o fit-to-page -o orientation-requested=4 ' . $page_path . ' 2>&1 &');
            }
        } else {
            if ($type == '6x4') {
               // shell_exec('nohup lpr -P ZEBRAZT410 -o media=Custom.4x6in -o landscape -o fit-to-page ' . $file_path . ' 2>&1 &');
                shell_exec('nohup lpr -P HPMBT -o media=Custom.4x6in -o landscape -o fit-to-page -o orientation-requested=4 ' . $file_path . ' 2>&1 &');
            } else {
               /// shell_exec('nohup lpr -P ZEBRAZT410 -o media=Custom.4x6in -o fit-to-page ' . $file_path . ' 2>&1 &');
                shell_exec('nohup lpr -P HPMBT -o media=Custom.4x6in -o fit-to-page  -o orientation-requested=3 ' . $file_path . ' 2>&1 &');
            }
        }
    }
}

function rotate_image_180_deg($path, $to, $from) {
    
    $originalImage = imagecreatefrompng($path);
    if ($originalImage !== false) {
        // Get the width and height of the original image
        $width = imagesx($originalImage);
        $height = imagesy($originalImage);
    
        // Create a new image with the same width and height
        $newImage = imagecreatetruecolor($width, $height);
   
        // Rotate the original image by 180 degrees
        imagecopyresampled($newImage, $originalImage, 0, 0, 0, 0, $width, $height, $width, $height);
        $newImage = imagerotate($newImage, 180, 0);
       
        //$newImagePath = '/home/nginx/domains/stable.smilebrilliant.com/public/downloads/labels/9400136109361638577964-new3.png';
        
         $newImagePath2 = str_replace('.png','-print-rotate-mbt.png' , $path);

        // Output the rotated image
       // header('Content-type: image/png');
        imagepng($newImage,$newImagePath2);
        return $newImagePath2;
        // Free up memory
        //imagedestroy($originalImage);
        //imagedestroy($newImage);
    } else {
        // Image loading failed
        return $path;
    } 
}