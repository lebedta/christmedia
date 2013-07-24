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
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'ChristMedia', 'frontend'),
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

  private function call_log($message)
  {
      $path = sfConfig::get('sf_log_dir') . '/convertvideo.log';

      $iteration = date('Y-m-d H:i:s') . ":  " . $message . "\n";
      file_put_contents($path, $iteration, FILE_APPEND);
      echo "\n\n $iteration \n\n";
  }

  protected function execute($arguments = array(), $options = array())
  {
      // initialize the database connection
      $databaseManager = new sfDatabaseManager($this->configuration);
      $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

      // add your code here
      $videos = VideoTable::getConvertVideo();

      self::call_log('Cron task was successfully started.');

      foreach($videos as $video)
      {
          $old_name = $video['file'];
          $video->setIsEdit(true);
          $video_name = substr($video['file'], strrpos($video['file'], '/') +1);
          $temp = explode('.', $video_name);
          if($temp[1] != 'glv')
          {
              $new_name = $temp[0].".mp4";
              $path = sfConfig::get('sf_upload_dir').'/video/';

              /*For mp4 (H.264 / ACC):*/
              $command="ffmpeg -i ".$path.$video['file']." -ar 22050 -f mp4 -s 624x260 ".$path.$new_name;
              exec($command . ' 2>&1', $output);
              echo $command;

              /*For webm (VP8 / Vorbis):*/
              $command="ffmpeg -i ".$path.$video['file']." -ar 22050 -f webm -s 624x260 ".$path.$temp[0].".webm";
              exec($command . ' 2>&1', $output);
              echo $command;

              /*For ogv (Theora / Vorbis):*/
//              ffmpeg -i "INPUTFILE" -b 1500k -vcodec libtheora -acodec libvorbis -ab 160000 -g 30 "OUTPUTFILE.ogv"
              $command="ffmpeg -i ".$path.$video['file']." -ar 22050 -vcodec libtheora -acodec libvorbis -ab 160000 -s 624x260 ".$path.$temp[0].".ogv";
              exec($command . ' 2>&1', $output);
              echo $command;

              $video->setFile($new_name);
              $video->setIsConverted(false);
              $video->setStatus('complete');
              $video->setIsEdit(false);
              $video->setIsActive(true);
              $video->save();
              //unlink($path.$old_name);
          }
      }
      self::call_log('Cron task was successfully finished.');
  }

}