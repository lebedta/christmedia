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
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
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
          $video_id = substr(substr($video['link_youtube'], strpos($video['link_youtube'], 'v=')+2),0,11);

          if( $curl = curl_init() )
          {
              // Задаем ссылку
              curl_setopt($curl,CURLOPT_URL,"http://www.youtube.com/get_video_info?video_id=".$video_id);
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
              $p = explode("url=http://o",$out);
              $link1=null;
              $link2=null;
              $link3=null;
              for($i=0; $i <= count($p)-1; $i++)
              {
                  $itag=substr($p[$i], strpos($p[$i], "&itag="), 8);
                  if($itag == "&itag=35")
                  {
                      $link1=$i;
                      $p[$i]="http://o".substr($p[$i],0,strripos($p[$i], "&itag="))."&".$title;
                  }
                  elseif($itag == "&itag=34")
                  {
                      $link2=$i;
                      $p[$i]="http://o".substr($p[$i],0,strripos($p[$i], "&itag="))."&".$title;
                  }
                  elseif($itag == "&itag=5&" || $itag == "&itag=5,")
                  {
                      $link3=$i;
                      $p[$i]="http://o".substr($p[$i],0,strripos($p[$i], "&itag="))."&".$title;
                  }
              }

              if($link1!='')
              {
                  $link_download =  $p[$link1];
              }
              elseif($link2!='')
              {
                  $link_download =  $p[$link2];
              }
              elseif($link3!='')
              {
                  $link_download =  $p[$link3];
              }
              else
              {
                  echo "format flv not found";
              }

              set_time_limit(0);
              $filename= sha1($video["title"].rand(11111, 99999)).'.flv';
              $fullpath= sfConfig::get('sf_upload_dir').'/video/'.$filename;
              $data = file_get_contents($link_download);
              if(file_put_contents($fullpath, $data))
              {

                  $show_videos = new Video();
                  $show_videos->setTitle($video["title"]);
                  $show_videos->setDescription($video["description"]);
                  $show_videos->setFile($filename);
                  $show_videos->setScrinshot($video["scrinshot"]);
                  $show_videos->setIsActive(false);
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
