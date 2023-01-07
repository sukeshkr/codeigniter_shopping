<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image {

       protected $CI;

    function __construct() {

        if (!is_dir('uploads')) {

            mkdir('uploads', 0755, TRUE);
        }

        $this->CI =& get_instance();
    }

    function generalCropAdd()
    {

        $ci_name=strtolower($this->CI->router->fetch_class());

        if (!is_dir('uploads/'.$ci_name))
        {
            mkdir('uploads/'.$ci_name, 0755, TRUE);
        }
     
        if($ci_name=='combo_offer')
        {
        $iWidth = 380;
        $iHeight = 212; // desired image result dimensions
        }
        if($ci_name=='cart_banner')
        {
        $iWidth = 650;
        $iHeight = 325; // desired image result dimensions
        }

        $iJpgQuality = 90;
        if ($_FILES) {
        // if no errors and size less than 250kb
        if (!$_FILES['image_file']['error'] && $_FILES['image_file']['size'] < 1024 * 1024) {
        if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {
        // new unique filename
        $sTempFileName = 'uploads/'.$ci_name.'/' . md5(time() . rand());
        // move uploaded file into cache folder
        move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);
        // change file permission to 644
        @chmod($sTempFileName, 0644);
        if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {
        $aSize = getimagesize($sTempFileName); // try to obtain image info
        if (!$aSize) {
        @unlink($sTempFileName);
        return;
        }
        // check for image type
        switch ($aSize[2]) {
        case IMAGETYPE_JPEG:
        $sExt = '.jpg';
        // create a new image from file 
        $vImg = @imagecreatefromjpeg($sTempFileName);
        break;
        /* case IMAGETYPE_GIF:
        $sExt = '.gif';
        // create a new image from file
        $vImg = @imagecreatefromgif($sTempFileName);
        break; */
        case IMAGETYPE_PNG:
        $sExt = '.png';
        // create a new image from file 
        $vImg = @imagecreatefrompng($sTempFileName);
        break;
        default:
        @unlink($sTempFileName);
        return;
        }
        // create a new true color image
        $vDstImg = @imagecreatetruecolor($iWidth, $iHeight);
        // copy and resize part of an image with resampling
        imagecopyresampled($vDstImg, $vImg, 0, 0, (int) $_POST['x1'], (int) $_POST['y1'], $iWidth, $iHeight, (int) $_POST['w'], (int) $_POST['h']);
        // define a result image filename
        $sResultFileName = $sTempFileName . $sExt;
        // output image to file
        $crop_image = explode("/", $sResultFileName);
        $this->image_name = $crop_image[2];
        imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
        @unlink($sTempFileName);
        }
        }
        }
        }

        return; 
    }

    function imageCropAdd()
    {

    $ci_name=strtolower($this->CI->router->fetch_class());

     if (!is_dir('uploads/'.$ci_name))
     {
        mkdir('uploads/'.$ci_name, 0755, TRUE);
        mkdir('uploads/'.$ci_name.'/crop', 0755, TRUE);
     }
     
    

        $config['upload_path'] = 'uploads/'.$ci_name.'/';
        $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
        $config['file_name'] = $_FILES['image_file']['name'];
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['min_width'] = '0';
        $config['min_height'] = '0';
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;
        $this->CI->upload->initialize($config);
        $upload = $this->CI->upload->do_upload('image_file');
        $data = $this->CI->upload->data();
        $this->image_name = $data['file_name'];
     
        if($ci_name=='cart_banner')
        {
        $iWidth = 1400;
        $iHeight = 800; // desired image result dimensions
        }

        if($ci_name=='category')
        {
        $iWidth = 592;
        $iHeight = 458; // desired image result dimensions
        }
        
        
        if($ci_name=='store')
        {
        $iWidth = 356;
        $iHeight = 400; // desired image result dimensions
        }

        $iJpgQuality = 90;
        if ($_FILES) {
        // if no errors and size less than 250kb
        if (!$_FILES['image_file']['error'] && $_FILES['image_file']['size'] < 1024 * 1024) {
        if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {
        // new unique filename
        $sTempFileName = 'uploads/'.$ci_name.'/crop/' . md5(time() . rand());
        // move uploaded file into cache folder
        move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);
        // change file permission to 644
        @chmod($sTempFileName, 0644);
        if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {
        $aSize = getimagesize($sTempFileName); // try to obtain image info
        if (!$aSize) {
        @unlink($sTempFileName);
        return;
        }
        // check for image type
        switch ($aSize[2]) {
        case IMAGETYPE_JPEG:
        $sExt = '.jpg';
        // create a new image from file 
        $vImg = @imagecreatefromjpeg($sTempFileName);
        break;
        /* case IMAGETYPE_GIF:
        $sExt = '.gif';
        // create a new image from file
        $vImg = @imagecreatefromgif($sTempFileName);
        break; */
        case IMAGETYPE_PNG:
        $sExt = '.png';
        // create a new image from file 
        $vImg = @imagecreatefrompng($sTempFileName);
        break;
        default:
        @unlink($sTempFileName);
        return;
        }
        // create a new true color image
        $vDstImg = @imagecreatetruecolor($iWidth, $iHeight);
        // copy and resize part of an image with resampling
        imagecopyresampled($vDstImg, $vImg, 0, 0, (int) $_POST['x1'], (int) $_POST['y1'], $iWidth, $iHeight, (int) $_POST['w'], (int) $_POST['h']);
        // define a result image filename
        $sResultFileName = $sTempFileName . $sExt;
        // output image to file
        $crop_image = explode("/", $sResultFileName);
        $this->crop_image_name = $crop_image[3];
        imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
        @unlink($sTempFileName);
        }
        }
        }
        }

        return; 
    }

    function imageProductAdd()
    {
        $ci_name=strtolower($this->CI->router->fetch_class());

        if (!is_dir('uploads/'.$ci_name))
        {
            mkdir('uploads/'.$ci_name.'/large', 0755, TRUE);
            mkdir('uploads/'.$ci_name.'/small', 0755, TRUE);
        }
       
        $upload = $this->CI->upload->do_upload('image_file');
        $data = $this->CI->upload->data();
        $this->image_name = $data['file_name'];

        if($ci_name=='products')
        {
            $iWidth = 300; 
            $iHeight =300;// desired image result dimensions
            $iWidth2 =600;
            $iHeight2 = 600;
            $iJpgQuality = 72; // desired image result dimensions
        }
            
        $iJpgQuality = 90;

        if ($_FILES) {

            // if no errors and size less than 250kb
            if (! $_FILES['image_file']['error'] && $_FILES['image_file']['size'] < 1600 * 1600) {

                if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {
                       
                    // new unique filename
                    $sTempFileName = 'uploads/'.$ci_name.'/small/' . md5(time() . rand());
                    $sTempFileName2= 'uploads/'.$ci_name.'/large/' . md5(time() . rand());
                    // move uploaded file into cache folder
                    move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);
                    move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName2);

                    // change file permission to 644
                    @chmod($sTempFileName, 0644);
                    @chmod($sTempFileName2, 0644);
           
                    if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) 
                    {
                        $aSize = getimagesize($sTempFileName); // try to obtain image info
                        if (!$aSize) 
                        {
                            @unlink($sTempFileName);
                            return;
                        }

                            // check for image type
                            switch($aSize[2]) 
                            {
                                case IMAGETYPE_JPEG:
                                    $sExt = '.jpg';

                                    // create a new image from file 
                                    $vImg = @imagecreatefromjpeg($sTempFileName);
                                    break;
                                
                                case IMAGETYPE_PNG:
                                    $sExt = '.png';

                                    // create a new image from file 
                                    $vImg = @imagecreatefrompng($sTempFileName);
                                    break;
                                default:
                                    @unlink($sTempFileName);
                                    return;
                            }

                             // create a new true color image
                            $vDstImg = @imagecreatetruecolor( $iWidth, $iHeight );
                            $vDstImg2 = @imagecreatetruecolor( $iWidth2, $iHeight2 );
                            // copy and resize part of an image with resampling
                            imagecopyresampled($vDstImg, $vImg, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'], $iWidth, $iHeight, (int)$_POST['w'], (int)$_POST['h']);
                            imagecopyresampled($vDstImg2, $vImg, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'], $iWidth2, $iHeight2, (int)$_POST['w'], (int)$_POST['h']);

                            // define a result image filename
                            $sResultFileName = $sTempFileName . $sExt;
                            $sResultFileName2 = $sTempFileName2 . $sExt;
                          
                            // output image to file
                            $crop_image = explode("/", $sResultFileName);
                             $crop_image1 = explode("/", $sResultFileName2);
                            $this->crop_image_name = $crop_image[3];
                            $this->crp_large=$crop_image1[3];
                            // output image to file
                            imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
                            imagejpeg($vDstImg2, $sResultFileName2, $iJpgQuality);
                            @unlink($sTempFileName);
                            @unlink($sTempFileName2);

                        }
                    }
                }
            }
       
    }

    function imagePortfolioAdd()
    {
        $ci_name=strtolower($this->CI->router->fetch_class());

        if (!is_dir('uploads/'.$ci_name))
        {
            mkdir('uploads/'.$ci_name.'/large', 0755, TRUE);
            mkdir('uploads/'.$ci_name.'/small', 0755, TRUE);
        }
       
        $upload = $this->CI->upload->do_upload('image_file');
        $data = $this->CI->upload->data();
        $this->image_name = $data['file_name'];

        if($ci_name=='gallery')
        {
            $iWidth = 800; 
            $iHeight =1200;// desired image result dimensions
            $iWidth2 =350;
            $iHeight2 = 525;
            $iJpgQuality = 72; // desired image result dimensions
        }
            
        $iJpgQuality = 90;

        if ($_FILES) {

            // if no errors and size less than 250kb
            if (! $_FILES['image_file']['error'] && $_FILES['image_file']['size'] < 1600 * 1600) {

                if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {
                       
                    // new unique filename
                    $sTempFileName = 'uploads/'.$ci_name.'/small/' . md5(time() . rand());
                    $sTempFileName2= 'uploads/'.$ci_name.'/large/' . md5(time() . rand());
                    // move uploaded file into cache folder
                    move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);
                    move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName2);

                    // change file permission to 644
                    @chmod($sTempFileName, 0644);
                    @chmod($sTempFileName2, 0644);
           
                    if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) 
                    {
                        $aSize = getimagesize($sTempFileName); // try to obtain image info
                        if (!$aSize) 
                        {
                            @unlink($sTempFileName);
                            return;
                        }

                            // check for image type
                            switch($aSize[2]) 
                            {
                                case IMAGETYPE_JPEG:
                                    $sExt = '.jpg';

                                    // create a new image from file 
                                    $vImg = @imagecreatefromjpeg($sTempFileName);
                                    break;
                                
                                case IMAGETYPE_PNG:
                                    $sExt = '.png';

                                    // create a new image from file 
                                    $vImg = @imagecreatefrompng($sTempFileName);
                                    break;
                                default:
                                    @unlink($sTempFileName);
                                    return;
                            }

                             // create a new true color image
                            $vDstImg = @imagecreatetruecolor( $iWidth, $iHeight );
                            $vDstImg2 = @imagecreatetruecolor( $iWidth2, $iHeight2 );
                            // copy and resize part of an image with resampling
                            imagecopyresampled($vDstImg, $vImg, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'], $iWidth, $iHeight, (int)$_POST['w'], (int)$_POST['h']);
                            imagecopyresampled($vDstImg2, $vImg, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'], $iWidth2, $iHeight2, (int)$_POST['w'], (int)$_POST['h']);

                            // define a result image filename
                            $sResultFileName = $sTempFileName . $sExt;
                            $sResultFileName2 = $sTempFileName2 . $sExt;
                          
                            // output image to file
                            $crop_image = explode("/", $sResultFileName);
                             $crop_image1 = explode("/", $sResultFileName2);
                            $this->crop_image_name = $crop_image[3];
                            $this->crp_large=$crop_image1[3];
                            // output image to file
                            imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
                            imagejpeg($vDstImg2, $sResultFileName2, $iJpgQuality);
                            @unlink($sTempFileName);
                            @unlink($sTempFileName2);

                        }
                    }
                }
            }
       
    }



    function imageNotificationCropAdd()
    {

    $ci_name=notification;

     if (!is_dir('uploads/'.$ci_name))
     {
        mkdir('uploads/'.$ci_name, 0755, TRUE);
        mkdir('uploads/'.$ci_name.'/crop', 0755, TRUE);
     }
     
    

        $config['upload_path'] = 'uploads/'.$ci_name.'/';
        $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
        $config['file_name'] = $_FILES['image_file']['name'];
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['min_width'] = '0';
        $config['min_height'] = '0';
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;
        $this->CI->upload->initialize($config);
        $upload = $this->CI->upload->do_upload('image_file');
        $data = $this->CI->upload->data();
        $this->image_name = $data['file_name'];
     
        if($ci_name=='cart_banner')
        {
        $iWidth = 1400;
        $iHeight = 800; // desired image result dimensions
        }

        if($ci_name=='category')
        {
        $iWidth = 296;
        $iHeight = 229; // desired image result dimensions
        }
        
        
        if($ci_name=='notification')
        {
        $iWidth = 356;
        $iHeight = 400; // desired image result dimensions
        }

        $iJpgQuality = 90;
        if ($_FILES) {
        // if no errors and size less than 250kb
        if (!$_FILES['image_file']['error'] && $_FILES['image_file']['size'] < 1024 * 1024) {
        if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {
        // new unique filename
        $sTempFileName = 'uploads/'.$ci_name.'/crop/' . md5(time() . rand());
        // move uploaded file into cache folder
        move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);
        // change file permission to 644
        @chmod($sTempFileName, 0644);
        if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {
        $aSize = getimagesize($sTempFileName); // try to obtain image info
        if (!$aSize) {
        @unlink($sTempFileName);
        return;
        }
        // check for image type
        switch ($aSize[2]) {
        case IMAGETYPE_JPEG:
        $sExt = '.jpg';
        // create a new image from file 
        $vImg = @imagecreatefromjpeg($sTempFileName);
        break;
        /* case IMAGETYPE_GIF:
        $sExt = '.gif';
        // create a new image from file
        $vImg = @imagecreatefromgif($sTempFileName);
        break; */
        case IMAGETYPE_PNG:
        $sExt = '.png';
        // create a new image from file 
        $vImg = @imagecreatefrompng($sTempFileName);
        break;
        default:
        @unlink($sTempFileName);
        return;
        }
        // create a new true color image
        $vDstImg = @imagecreatetruecolor($iWidth, $iHeight);
        // copy and resize part of an image with resampling
        imagecopyresampled($vDstImg, $vImg, 0, 0, (int) $_POST['x1'], (int) $_POST['y1'], $iWidth, $iHeight, (int) $_POST['w'], (int) $_POST['h']);
        // define a result image filename
        $sResultFileName = $sTempFileName . $sExt;
        // output image to file
        $crop_image = explode("/", $sResultFileName);
        $this->crop_image_name = $crop_image[3];
        imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
        @unlink($sTempFileName);
        }
        }
        }
        }

        return; 
    }



}