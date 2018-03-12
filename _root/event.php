<?php

class event extends LucidPage{

    function pageHeader() {
        $header .= '';
        return $header;
    }

    public function pageView() {
        $this->setView('frame', 'page');
    }

    function pageCode() {
        $content .= '   <div class="container">

            <div class="left-column">
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
                <div class="twocolumn-container">
                    <div class="event-column">
                        <div id="eventinfo">
                            <h1>Clinical Advances in Treating Psoriatic Disease</h1>
                            <p>A satellite symposium held in conjunction with APhA2018.</p>
                        </div>
                        <div class="event-information">
                            <table>
                                <tr>
                                    <td><b>Date:</b></td>
                                    <td>Sunday</td>
                                </tr>
                                <tr>
                                    <td><b>Location:</b></td>
                                    <td>Omni Nashville Hotel | Broadway Ballroom E | Nashville, Tennessee</td>
                                </tr>
                                <tr>
                                    <td><b>Time:</b></td>
                                    <td>6:00 am - 6:30 am (Registration & Breakfast)<br>
                                    6:30 am - 8:00 am (Main Session)<br>
                                    *Central time	</td>
                                </tr>
                            </table>
                        </div>
                        <div class="event-details right display-flex">
                            <div>
                            <h2><i class="fas fa-users"></i> Target Audiences:</h2>
                            <p>Retail Pharmacists will benefit in this event.
                            Retail Pharmacists will benefit in this event.</p>
                            <h2><i class="fas fa-clipboard"></i> Type of Activity:</h2>
                            <p>The Type of Activity is an Application. The Type of Activity is an Application.</p>
                            <h2><i class="far fa-credit-card"></i> Fee:</h2>
                            <p>There is no fee for this activity. This event is funded through the grant of somewhere</p>
                            </div>
                            <div>
                            <h2><i class="fas fa-male"></i> Faculty Presenters: <i class="fas fa-female"></i></h2>
                            <p><b>April Jones, PharmD, CSP</b><br>
                            Clinical Specialty Pharmacist<br>
                            Vanderbilt University Medical Center<br>
                            Nashville, Tennessee<br>
                            </p>
                            <p><b>Jashin J. Wu, MD</b><br>
                            Director of Dermatology Research<br>
                            Department of Dermatology<br>
                            Kaiser Permanente Los Angeles Medical Center<br>
                            Los Angeles, California</p>
                            </div>
                        </div>
                        <div class="event-details left">
                            <h4>Program Overview:</h4>
                            <p>
                                Early and accurate diagnosis of psoriasis and psoriatic arthritis is essential for effective disease management to prevent further complications and disease progression. Pharmacists need to recognize the significance of early diagnosis and be familiar with the pharmacologic options to effectively treat these conditions. In this session, an expert dermatologist and a specialty pharmacist will discuss the expanding landscape of novel and biosimilar therapies for psoriatic disease, identify the benefits of treatment intensification, and review the safety and efficacy of various treatment options.
                            </p>
                        </div>
                        <div class="event-details right">
                            <h4>Educational Objectives:</h4>
                            <p>At the completion of this activity, the participant will be able to:</p>
                            <ul>
                                <li>Determine the benefits of treatment intensification for psoriatic disease</li>
                                <li>Explain the clinical efficacy and safety of treatment options for psoriasis and psoriatic arthritis</li>
                                <li>Examine methods to improve early diagnosis of psoriatic arthritis and minimize complications</li>
                            </ul>
                        </div>
                        <div class="event-details left">
                            <h4>Accreditation:</h4>
                            <img src="http://ptce.s3.amazonaws.com/_media/_image/acpe.png" alt="">
                            <p>
                                Pharmacy Times Continuing Education™ is accredited by the Accreditation Council for Pharmacy Education (ACPE) as a provider of continuing pharmacy education. <b>This activity is approved for 1.5 contact hours (0.15 CEUs) under the ACPE universal activity number 0290-0000-18-028-L01-P. The activity is available for CE credit through March 18, 2018.</b>

                            </p>
                        </div>
                        <div class="event-details right">
                            <h4>Obtaining Credit:</h4>
                            <p>
                                All participants who attended the live symposium need to log onto their Pharmacy Times Continuing Education™ account on www.pharmacytimes.org to complete an online evaluation form and request their credit.
                            </p>
                        </div>
                        <div class="event-details left">
                            <h2>Disclosures</h2>
                            <h4>Faculty</h4>
                            <p><b>Jashin J. Wu, MD</b> has the following relevant financial relationships with commercial interests to disclose:</p>
                            <ul class="indent-only">
                                <li>Grant/Research Support: AbbVie, Amgen, Eli Lilly, Janssen, Novartis, and Regeneron</li>
                            </ul>
                            <p>The following contributors have no relevant financial relationships with commercial interests to disclose.</p>
                            <p><b>April Jones, PharmD, CSP</b></p>
                            <p>An anonymous peer reviewer is used as part of content validation and conflict resolution. The peer reviewer has no relevant financial relationships with commercial interests to disclose.</p>
                            <p><b>Pharmacy Times Continuing Education™</b><br>
                            Planning Staff - David Heckard; Maryjo Dixon, RPh; Jyoti Arya, PharmD, RPh; Olivia Mastrodonato; and Susan Pordon. </p>
                            <p>An anonymous peer reviewer is used as part of content validation and conflict resolution. The peer reviewer has no relevant financial relationships with commercial interests to disclose. </p>
                        </div>
                        <div class="event-details right">
                            <h4>Activity Disclaimer:</h4>
                            <p>
                                Pharmacy Times Continuing Education™ (PTCE) strives to provide the highest level of service. However, unforeseen circumstances may necessitate the rescheduling or cancellation of live events, including, but not limited to, webinars hosted by PTCE. PTCE reserves the right to cancel an event without notice. PTCE will not be responsible for any expenditure incurred due to the cancellation.
                            </p>
                        </div>
                        <div class="event-details left">
                            <h4>Americans with Disabilities Act:</h4>
                            <p>
                                Pharmacy Times Continuing Education™ (PTCE™) fully complies with the legal requirements of the ADA and the rules and regulations thereof. If any participant in this educational activity is in need of accommodations, please notify us in order to receive service. Please call 609- 378-3701.
                            </p>
                        </div>
                        <div class="event-details right">
                            <h4>Educational Disclaimer</h4>
                            <p>
                                Continuing professional education (CPE) activities are offered solely for educational purposes and do not constitute any form of professional advice or referral. Discussions concerning drugs, dosages, and procedures may reflect the clinical experience of the author(s) or they may be derived from the professional literature or other sources and may suggest uses that are investigational in nature and not approved labeling or indications. Participants are encouraged to refer to primary references or full prescribing information resources.
                            </p>
                        </div>
                        <div class="event-details left">
                            <p>Privacy Policy and Terms of Use Information:<br>
                            <a href="www.pharmacytimes.com/terms-condition">www.pharmacytimes.com/terms-condition</a></p>
                        </div>		
                    </div>
            </div>
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