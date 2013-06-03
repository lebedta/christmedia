<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ss
 * Date: 9/22/11
 * Time: 10:20 AM
 * To change this template use File | Settings | File Templates.
 */
 
class ProfileForm extends BasesfGuardUserAdminForm
{
    private $width = 400;
    private $height = 300;
    public function setup()
    {
        parent::setup();

        unset(
          $this['is_active'],
          $this['is_super_admin'],
          $this['groups_list'],
          $this['permissions_list']
        );

        $form = new UserProfileForm($this->getObject()->getProfile());
        $this->embedForm('sfGuardUser', $form);
    }

    public function doSave($con = null)
    {
        parent::doSave($con);
        //resample image
        if(!is_null($this->getObject()->getProfile()->getAvatar()))
        {


            $image = "uploads/avatar/".$this->getObject()->getProfile()->getAvatar();
            $image_file_name = $this->getObject()->getProfile()->getAvatar();

            $image_file_name_parts = explode(".", $image_file_name);

            $image_type = exif_imagetype($image);

            switch($image_type)
            {
                case IMAGETYPE_GIF:
                    $image_old = imagecreatefromgif($image);
                    break;
                case IMAGETYPE_JP2:
                case IMAGETYPE_JPEG:
                case IMAGETYPE_JPEG2000:
                    $image_old = imagecreatefromjpeg($image);
                    break;
                case IMAGETYPE_PNG:
                    $image_old = imagecreatefrompng($image);
                    break;
            }
            $old_w = imagesx($image_old);
            $old_h = imagesy($image_old);

            $x_ratio = $old_w/$this->width;
            $y_ratio = $old_h/$this->height;
            $ratio = max($x_ratio, $y_ratio);


            $new_w = round($old_w/$ratio);
            $new_h = round($old_h/$ratio);

            $params = array( 32, 64 ,100);
            foreach($params as $width)
            {

                $new_w = $new_h = $width;
                $image_logo = imagecreatetruecolor($new_w, $new_h);
                imagecopyresampled($image_logo, $image_old, 0, 0, 0, 0, $new_w, $new_h, $old_w, $old_h);
                imagepng($image_logo, "uploads/avatar/".$image_file_name_parts[0]."_".$width.".png");
            }

            $image_new = imagecreatetruecolor($new_w, $new_h);
            imagecopyresampled($image_new, $image_old, 0, 0, 0, 0, $new_w, $new_h, $old_w, $old_h);

            imagepng($image_new, "uploads/avatar/".$image_file_name_parts[0].".png");


            $this->getObject()->getProfile()->setAvatar($image_file_name_parts[0].".png");
        }
        $this->getObject()->getProfile()->save();
    }
}