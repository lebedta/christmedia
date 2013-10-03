<?php include_partial("video_list/subMenu"); ?>
<aside>
    <?php include_partial("video_list/menuTree"); ?>
</aside>
<div class="content">
    <ul class="video-prewiev">
        <?php foreach($videos as $video): ?>
            <li style="float: left; " class="mouse_move">
                <span>
                    <a href="<?php echo url_for('@view_video?video_slug='.$video->getSlug()); ?>">
                        <div id="sl_<?php echo $video->getId(); ?>" style="" class="slider_JS">

                            <?php foreach($video->getScrinshots() as $scrinshot): ?>
                            <?php echo image_tag('/uploads/scrinshot/'.$scrinshot->getFile(), array('width'=>'200', 'height'=>'117')); ?>
                            <?php endforeach; ?>

                        </div>
                        <span class="video_title"> <?php echo $video->getTitle(); ?> </span>
                    </a>

                </span>
                <div id="star_<?php echo $video->getId(); ?>" class="star" data-star="<?php echo $video->getVideoRating(); ?>"></div>
                <span>
                    Просмотров: <?php echo $video->getVideoWatching()->count(); ?>
                </span>
            </li>
        <?php endforeach ?>
    </ul>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        var lim = true;
        base();

        <!--load contend-->

        var scrollInAction = false;
        jQuery(window).scroll(function(){

            if(($(document).height()-$(window).height()-$(document).scrollTop()) < 600){
                //console.log(1);

                if (scrollInAction){
                    return false;
                }else{
                    scrollInAction = true;
                    load_content();


                }
            }
        });
        function load_content()
        {
            if(lim){
                var url = '<?php echo url_for('@load_video') ?>';
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {"count" : jQuery(".video-prewiev li").length, "order" : <?php echo $order ? "'".$order."'" : '' ?> <?php echo $category ? ',category: '."'".$category."'" : '' ?>},
                    success:function (data) {
                        jQuery('.video-prewiev').append(data);
                        base();
                        scrollInAction = false;
                        if(data== ''){
                            lim = false;
                        }
                    }
                });
            }


        }

        <!--edn script-->
        function base ()
        {
            jQuery(".slider_JS").slidesjs({
                pagination: false,
                play : {
                    active: true,
                    auto: false,
                    interval: 700,
                    swap: true,
                    effect: {
                        slide: {
                            // Slide effect settings.
                            speed: 200
                            // [number] Speed in milliseconds of the slide animation.
                        },
                        fade: {
                            speed: 200,
                            // [number] Speed in milliseconds of the fade animation.
                            crossfade: true
                            // [boolean] Cross-fade the transition.
                        }
                    }
                }
            });
            jQuery(".slidesjs-navigation").hide();

            jQuery(".slider_JS").mouseover(function(){

                jQuery(this).find(".slidesjs-play").click();
                return false;
            })

            jQuery(".slider_JS").mouseout(function(){

                jQuery(this).find(".slidesjs-stop").click();

            })

            jQuery('.star').each(function(){
                jQuery(this).raty({
                    path: "/rating",
                    score: jQuery(this).data('star'),
                    readOnly: true
                });
            })

        }

   });
</script>