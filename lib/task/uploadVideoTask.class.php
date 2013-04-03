<?php

class uploadVideoTask extends sfBaseTask
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
    $this->name             = 'uploadVideo';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [uploadVideo|INFO] task does things.
Call it with:

  [php symfony uploadVideo|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // add your code here

      $videos = YoutubeTable::getUploadFile();

      foreach($videos as $video)
      {
          $parse=parse_url($video->getLinkYoutube());
          $video_id = str_replace('v=', 'video_id=', $parse['query']);

          $link = "http://www.youtube.com/get_video_info?".$video_id;

          if( $curl = curl_init() )
          {

              curl_setopt($curl,CURLOPT_URL, $link);
              // Скачанные данные не выводить поток
              curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
              // Скачиваем
              $out = curl_exec($curl);
              $out = urldecode($out);
              $out = urldecode($out);

              if($title= strstr($out, "title="))
              {
                  $title2=strpos($title, "&");
                  $title=substr($title, 0, $title2);
              }

              $title_mas = explode(" ", $title);
              $title=$title_mas[0];

              $p = explode("url=",$out);

              $link1=null;
              $link2=null;
              $link3=null;
              $link_download=null;
              for($i=0; $i <= count($p)-1; $i++)
              {
                  $itag=substr($p[$i], strpos($p[$i], "&itag="), 8);

                  if($itag == "&itag=35")
                  {
                      $link1=$i;
                      $link_download = str_replace('&sig=', '&signature=', $p[$i]);
                      $p[$i]="http://o".substr($p[$i],0,strripos($p[$i], "&itag="))."&".$title;
                  }
                  elseif($itag == "&itag=34")
                  {
                      $link2=$i;
                      $link_download = str_replace('&sig=', '&signature=', $p[$i]);
                      $p[$i]="http://o".substr($p[$i],0,strripos($p[$i], "&itag="))."&".$title;
                  }
                  elseif($itag == "&itag=5&" || $itag == "&itag=5,")
                  {
                      $link3=$i;
                      $link_download = str_replace('&sig=', '&signature=', $p[$i]);
                      $p[$i]="http://o".substr($p[$i],0,strripos($p[$i], "&itag="))."&".$title;
                  }
              }

              set_time_limit(0);
              $filename= sha1($video["title"].rand(11111, 99999)).'.flv';
              $fullpath= sfConfig::get('sf_upload_dir').'/video/'.$filename;
              echo $link_download;
              $data = @file_get_contents($link_download);
              if(file_put_contents($fullpath, $data))
              {
                  $cmd = "ffmpeg -i " . $fullpath . " 2>&1";
                  exec($cmd);
                  if (preg_match('/Duration: ((\d+):(\d+):(\d+))/s', `$cmd`, $time)) {
                      $total = ($time[2] * 3600) + ($time[3] * 60) + $time[4];
                  }

                  $show_videos = new Video();
                  $show_videos->setTitle($video["title"]);
                  $show_videos->setDescription($video["description"]);
                  $show_videos->setFile($filename);
                  $show_videos->setDuration($total);
                  $show_videos->setIsActive(true);
                  $show_videos->setIsConverted(false);
                  $show_videos->setIsEdit(false);
                  $show_videos->setStatus("complete");
                  $show_videos->save();

                  $video->setDownload(false);
                  $video->setIsEdit(false);
                  $video->setVideoId($show_videos->getId());
                  $video->save();

                  echo "video downloaded";
              }
              else
              {
                  echo 'Something error';
              }
          }
      }
  }
}
