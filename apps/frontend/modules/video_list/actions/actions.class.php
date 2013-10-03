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
        $this->order = $request->getUrlParameter('order');
        $this->category = $request->getUrlParameter('category', null);

        $videos = VideoTable::getVideos($this->order, $this->category);
        $this->videos = $videos->limit(6)->execute();

    }

    public function executeViewVideo(sfWebRequest $request)
    {
        $video_slug = $request->getUrlParameter('video_slug');
        $this->video = Doctrine_Core::getTable('Video')->findOneBy('slug', $video_slug);
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

    public function executeAjaxLoad(sfWebRequest $request)
    {
        if($request->isMethod('post')){
            $count = $request->getParameter('count');
            $order = $request->getParameter('order');
            $category = $request->getParameter('category');
            $videos = VideoTable::getVideos($order, $category);
            $this->videos = $videos->limit(3)->offset($count)->execute();

            $this->renderPartial('list_video', array('videos'=>$this->videos));
            return sfView::NONE;
        }
    }
}