<?php

class createScrinshotTask extends sfBaseTask
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
        $this->name             = 'createScrinshot';
        $this->briefDescription = '';
        $this->detailedDescription = <<<EOF
The [convertVideo|INFO] task does things.
Call it with:

  [php symfony createScrinshot|INFO]
EOF;
    }

    private function call_log($message)
    {
        $path = sfConfig::get('sf_log_dir') . '/createscrinshot.log';

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
        $videos = VideoTable::getVideosNeadScrinshot();
        $path = sfConfig::get('sf_upload_dir').'/scrinshot/';
        $video_path = sfConfig::get('sf_upload_dir').'/video/';
        $temp = false;
        /* set default count scrinshot */
        $count_scrinshot = 5;

        self::call_log('Cron task was successfully started.');

        foreach($videos as $video)
        {
            $filename= sha1($video->getTitle().rand(11111, 99999));
            if($video->getDuration()> 0 )
            {
                $count = (int)($video->getDuration()/$count_scrinshot);

                $duration_L = 0;
                if($count>0)
                {
                    for($i=1; $i<=$count_scrinshot; $i++)
                    {
                        $duration_L = $duration_L + $count;
                        $filename= sha1($video->getTitle().rand(11111, 99999));
                        //scrinshot
                        $command="ffmpeg -i ".$video_path.$video->getFile()." -s 120x90 -ss ".$duration_L." -vframes 1 ".$path.$filename.$i.".png";
                        exec($command . ' 2>&1', $output);
                        echo $command;
                        self::call_log($command);
                        $scrrinshot = new Scrinshot();
                        $scrrinshot->setFile($filename.$i.".png");
                        $scrrinshot->setVideoId($video->getId());
                        $scrrinshot->save();
                        $temp = true;
                    }
                }
                else
                {
                    //scrinshot
                    $command="ffmpeg -i ".$video_path.$video->getFile()." -s 120x90  -ss 0 -vframes 1 ".$path.$filename.".png";
                    exec($command . ' 2>&1', $output);
                    echo $command;
                    self::call_log($command);
                    $scrrinshot = new Scrinshot();

                    $scrrinshot->setFile($filename.".png");
                    $scrrinshot->setVideoId($video->getId());
                    $scrrinshot->save();
                    $temp = true;
                }
            }



            if($temp == true)
            {
                $video->setIsScrinshot(true);
                $video->save();
            }
        }
        self::call_log('Cron task was successfully finished.');
    }
}