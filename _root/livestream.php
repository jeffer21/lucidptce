<?php

class livestream extends LucidPage{

    function pageHeader() {
        $header .= '';
        return $header;
    }

    public function pageView() {
        $this->setView('frame', 'page');
    }

    function pageCode() {
        $content .= '    <div class="left-column">
        <div id="login" class="section-box">
            <div class="left-column-title">Login/Sign Up</div>
            <form>
                <input class ="input-username" type="text" name="username" placeholder="Username"><br>
                <input class ="input-password" type="text" name="password" placeholder="Password"><br>
                <div class="forgot-pw"><a href="#">forgot password?</a></div> <br>

                <input class="sign-in btn" type="submit" value="Sign In">
                <button class="sign-up btn">Sign Up</button>
            </form>
        </div><br>

        <div id="quicklinks" class="section-box quicklinks">
            <div class="left-column-title">Quick Links</div>
            <ul>
                <li><a href="#">Videos</a></li>
                <li><a href="#">Clinical Resources</a></li>
                <li><a href="#">Conference Coverage</a></li>
                <li><a href="#">Contributors</a></li>
            </ul>
        </div><br>

        <div id="topics" class="section-box quicklinks">
            <div class="left-column-title">Topic</div>
            <ul>
                <li><a href="#">Allergies</a></li>
                <li><a href="#">Anaphylaxis</a></li>
                <li><a href="#">Asthma</a></li>
                <li><a href="#">Blood Disorders</a></li>
                <li><a href="#">Cardiology</a></li>
                <li><a href="#">Cold and Flu</a></li>
                <li><a href="#">COPD</a></li>
                <li><a href="#">Dermatology</a></li>
                <li><a href="#">Diabetes</a></li>
                <li><a href="#">Depression</a></li>
            </ul>
        </div>

        </div>
        <div class="main-content-2col">
            <div id="liveStream-info">
                <div style="text-align: center">Live Stream Title</div>
            </div><br>

            <div id="live-stream" style="text-align: center">
                <iframe src="https://player.twitch.tv/?channel=genesisnexus" frameborder="0" allowfullscreen="true" scrolling="no" height="378" width="620"></iframe>
                <p style="text-align: center">Date: Tuesday, April 24, 2018<br>
                    Time: 6:30 am - 8:00 am EST
                </p>
            </div>

        </div>';

        $this->setVar('content', $content);
    }

    function pageMeta() {
        $seoMeta["title"] = 'PTCE Beta';
        $seoMeta["keyword"] = '';
        $seoMeta["description"] = '';
        return $seoMeta;
    }

    function pageModule() {
    }

    public function pageAd(){
        /*
        $arr['url'] = 'HOME';
        $arr['unit'][] = 'AD728x90L';
        $arr['unit'][] = 'AD728x90B';
        $arr['unit'][] = 'AD300x100';
        $arr['unit'][] = 'AD320x50L';
        $arr['unit'][] = 'AD300x250';
        $arr['unit'][] = 'AD300x250A';
        */
        return $arr;
    }

}

?>