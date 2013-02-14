<?php

    /**
     * video actions.
     *
     * @package    blueprint
     * @subpackage video
     * @author     Your name here
     * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
     */
class video_listActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */

    public function executeIndex(sfWebRequest $request)
    {
        $this->videos = VideoTable::getVideos();
    }

    public function executeViewVideo(sfWebRequest $request)
    {
        $video_id = $request->getUrlParameter('video_id');
        $this->video = Doctrine_Core::getTable('Video')->find($video_id);
        $this->forward404Unless($this->video, "Video not exist");

        if(isset($_COOKIE['myCookie']))
        {
            if(!VideoWatchingTable::isWatching($this->video, $_COOKIE['myCookie']))
            {
                VideoWatchingTable::setWatching($this->video, $_COOKIE['myCookie']);
            }
        }
        else
        {
            $unique = uniqid();
            $this->getResponse()->setCookie('myCookie', $unique ,time()+60*60*24*30);
            VideoWatchingTable::setWatching($this->video, $unique);
        }
    }

    public function executeVoteVideo(sfWebRequest $request)
    {
        $result = array("content" => null,
                        "status" => "false");

        if ($request->isMethod("post"))
        {
            $video_id = $request->getUrlParameter('video_id');
            $video = Doctrine_Core::getTable('Video')->find($video_id);

            $rating = $request->getPostParameter('rat');

            $videoRating = new VideoRating();
            $videoRating->setRating($rating);
            $videoRating->setVideo($video);
            $videoRating->setUserCookieId($_COOKIE['myCookie']);
            $videoRating->save();

            $result = array(
                "content" => $video->getVideoRating(),
                "status" => "Ok",
            );
        }
        $this->renderText(json_encode($result));
        return sfView::NONE;
    }
}