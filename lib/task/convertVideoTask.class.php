<?php

class convertVideoTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'convertVideo';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [convertVideo|INFO] task does things.
Call it with:

  [php symfony convertVideo|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
      // initialize the database connection
      $databaseManager = new sfDatabaseManager($this->configuration);
      $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

      // add your code here
      $videos = VideoTable::getConvertVideo();

      foreach($videos as $video)
      {
          $old_name = $video['file'];
          $video->setIsEdit(true);
          $video_name = substr($video['file'], strrpos($video['file'], '/') +1);
          $temp = explode('.', $video_name);
          if($temp[1] != 'flv')
          {
              $new_name = $temp[0].".flv";
              $path = sfConfig::get('sf_upload_dir').'/video';
              $command="ffmpeg -i ".$path.$video['file']." -ar 22050 -f flv -s 640x480 ".$path.$new_name;
              exec($command . ' 2>&1', $output);
              echo $command;

              $video->setFile($new_name);
              $video->setIsConverted(false);
              $video->setStatus('complete');
              $video->setIsEdit(false);
              $video->save();
              unlink($path.$old_name);
          }
      }
  }

}