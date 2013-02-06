$f("player", "/flowplayer/flowplayer.commercial-3.2.7.swf",
    { key: '#$0edb3e437f0d8e5d780', 
 logo: {
        url: '/flowplayer/logo.png',
	fullscreenOnly: false,
	opacity: 0.3,
	pageUrl: "http://video"
    },

        clip: {
            autoPlay: false,
            autoBuffering: true,
            onMetaData: function(clip){
                var cuepointInterval = 5; // In seconds.
                var cuepoints = [];
                for (var i=1, t=Math.floor(clip.duration / cuepointInterval)+1; i<t; i++){
                    cuepoints.push(i * cuepointInterval * 1000);
                }

                clip.onCuepoint(cuepoints, function(clip, seconds){
                    // You cuepoint handling code.
                    var plug = $f().getPlugin('content');
                    plug.setHtml(this.id() + ": " + seconds + "-" + clip.duration + "----" + text() );
                    plug.show();
                });
            },
            ads: [{
                time: 1,                   // make the ad appear after 2 secs
                request: {
                    adType: "overlay",      // we want an overlay
                    contentId: "123"        // this is your internal video id
                }
            }]

        },
        plugins: {

            adsense: {
                url:'/flowplayer/flowplayer.adsense-1.6.2.swf',
                publisherId: "ca-video-pub-8316213049740061",	//publisher id
                channel: "4317708252"  //channel id

            },
            controls: {
                autoHide: 'never'
            },

            content: {
                url: '/flowplayer/flowplayer.content-3.2.0.swf',
                height: 80,
                width: 450,
                padding: 8,
                backgroundColor: '#112233',
                opacity: 0.7,
                closeButton: true,
                top: 15,
                backgroundGradient: [0.1, 0.1, 1.0],
                html: " ChristMedia",
                style: {p: {fontSize: 17}}
            },
            sharing: {
                url: '/flowplayer/flowplayer.sharing-3.2.1.swf'/*,
                embed: {
                    fallbackUrls: [ "Extremists.mov" ]
                }*/
            },
            dock: {
                right: 15,
                top: 110,
                horizontal: false,
                width: 50,
                autoHide: true
            }
        }
    });

function text()
{
    var html=[];
    html[0]="<a href='http://domshin.com.ua' target='_blank'>domshin.com.ua</a>"
    html[1]="<a href='http://iptech.ck.ua' target='_blank'>iptech.ck.ua</a>"
    html[2]="<a href='http://li-tour.com.ua' target='_blank'>li-tour.com.ua</a>"
    html[3]="<p>hi this is my content</p>"
    return html[Math.floor(Math.random()*html.length)];
}
