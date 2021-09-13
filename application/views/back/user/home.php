<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Dashboard</h1>      
</div>

<div class="row">

    <div class="col-lg-8">

        <div class="row">
            <div class="col-md-12">

                <div id="url-shorten-alert">
                    
                </div>

                <div class="card border-light marbot20 ">
                   <div class="card-header">Shorten Url</div>
                   <div class="card-body" style="padding: 1.25rem 14px 1px;">
                       <form action="" method="POST" enctype="multipart/form-data" id="shorten_url_form">
                            <div class="row" style="border-bottom:1px solid #ececec;padding-bottom:20px">

                                 <div class="col-lg-10">
                                     <div class="input-group">
                                       <div class="input-group-prepend">
                                         <div class="input-group-text"><i class="fas fa-link"></i></div>
                                       </div>
                                       <input type="text" autocomplete="off" required="" class="form-control" name="url" placeholder="Paste a Long Url..."/>
                                     </div>
                                 </div>
                                <div class="col-lg-2">
                                    <a href="#" class="btn btn-primary btn-lg btn-submit">Shorten</a>
                                    <input type="submit" style="display:none"/>
                                </div>
                            </div>

                           <a style="margin:14px 0px;" href="#" id="advanced-options-url-shorten-link" class="btn btn-light btn-sm">Advanced Options</a>

                           <div class="advanced-options-url-shorten">

                               <div class="row">

                                   <div class="col-lg-3 col-md-6 col-sm-6 marbot20">
                                       <label for="s_alias">Custom Alias</label>
                                       <p style="min-height:42px">If you want customized shorten name on link</p>
                                       <input type="text" name="alias" id="s_alias" class="form-control shorten-input" placeholder="Custom Alias"/>
                                   </div>

                                   <div class="col-lg-3 col-md-6 col-sm-6 marbot20">
                                       <label for="s_description">Description</label>
                                       <p style="min-height:42px">Description for identifying on panel</p>
                                       <input type="text" name="description" id="s_description" class="form-control shorten-input" placeholder="Description"/>
                                   </div>

                                   <div class="col-lg-3 col-md-6 col-sm-6 marbot20">
                                       <label for="s_expire_date">Expire Date</label>
                                       <p style="min-height:42px">After expire date url is not going to be usable</p>
                                       <input type="text" name="expire_date" id="s_expire_date" class="form-control shorten-input" placeholder="Expire Date"/>
                                   </div>

                                   <div class="col-lg-3 col-md-6 col-sm-6 marbot20">
                                       <label for="s_password">Password Protect</label>
                                       <p style="min-height:42px">Password on redirect to protect content</p>
                                       <input type="text" name="password" id="s_password" class="form-control shorten-input" placeholder="Password"/>
                                   </div>

                               </div>
                               
                               <hr>
                               
                               <div class="row marbot10">
                                   <div class="col-lg-12">
                                       <div class="left"><label style="margin:0px;">Location Targeting</label></div>
                                       <div class="right"><a href="#" class="btn btn-sm btn-dark" id="add_more_locations" style="line-height: 1">Add more locations</a></div>
                                   </div>
                                   <div class="col-lg-12">
                                       <p>Redirect users to different urls based on their location.</p>
                                   </div>
                               </div>
                               
                               <div id="locs">
                                    <div class="row shorten-row">
                                         <div class="col-lg-6">
                                            <select class="form-control shorten-input" name="location[]"> <option selected value="0">Select one</option><option value="AF">Afghanistan</option><option value="AX">Aland Islands</option><option value="AL">Albania</option><option value="DZ">Algeria</option><option value="AS">American Samoa</option><option value="AD">Andorra</option><option value="AO">Angola</option><option value="AI">Anguilla</option><option value="AQ">Antarctica</option><option value="AG">Antigua and Barbuda</option><option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AW">Aruba</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="AZ">Azerbaijan</option><option value="BS">Bahamas</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="BY">Belarus</option><option value="BE">Belgium</option><option value="BZ">Belize</option><option value="BJ">Benin</option><option value="BM">Bermuda</option><option value="BT">Bhutan</option><option value="BO">Bolivia</option><option value="BQ">Bonaire, Saint Eustatius and Saba </option><option value="BA">Bosnia and Herzegovina</option><option value="BW">Botswana</option><option value="BV">Bouvet Island</option><option value="BR">Brazil</option><option value="IO">British Indian Ocean Territory</option><option value="VG">British Virgin Islands</option><option value="BN">Brunei</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="KH">Cambodia</option><option value="CM">Cameroon</option><option value="CA">Canada</option><option value="CV">Cape Verde</option><option value="KY">Cayman Islands</option><option value="CF">Central African Republic</option><option value="TD">Chad</option><option value="CL">Chile</option><option value="CN">China</option><option value="CX">Christmas Island</option><option value="CC">Cocos Islands</option><option value="CO">Colombia</option><option value="KM">Comoros</option><option value="CK">Cook Islands</option><option value="CR">Costa Rica</option><option value="HR">Croatia</option><option value="CU">Cuba</option><option value="CW">Curacao</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="CD">Democratic Republic of the Congo</option><option value="DK">Denmark</option><option value="DJ">Djibouti</option><option value="DM">Dominica</option><option value="DO">Dominican Republic</option><option value="TL">East Timor</option><option value="EC">Ecuador</option><option value="EG">Egypt</option><option value="SV">El Salvador</option><option value="GQ">Equatorial Guinea</option><option value="ER">Eritrea</option><option value="EE">Estonia</option><option value="ET">Ethiopia</option><option value="FK">Falkland Islands</option><option value="FO">Faroe Islands</option><option value="FJ">Fiji</option><option value="FI">Finland</option><option value="FR">France</option><option value="GF">French Guiana</option><option value="PF">French Polynesia</option><option value="TF">French Southern Territories</option><option value="GA">Gabon</option><option value="GM">Gambia</option><option value="GE">Georgia</option><option value="DE">Germany</option><option value="GH">Ghana</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GP">Guadeloupe</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GG">Guernsey</option><option value="GN">Guinea</option><option value="GW">Guinea-Bissau</option><option value="GY">Guyana</option><option value="HT">Haiti</option><option value="HM">Heard Island and McDonald Islands</option><option value="HN">Honduras</option><option value="HK">Hong Kong</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Iran</option><option value="IQ">Iraq</option><option value="IE">Ireland</option><option value="IM">Isle of Man</option><option value="IL">Israel</option><option value="IT">Italy</option><option value="CI">Ivory Coast</option><option value="JM">Jamaica</option><option value="JP">Japan</option><option value="JE">Jersey</option><option value="JO">Jordan</option><option value="KZ">Kazakhstan</option><option value="KE">Kenya</option><option value="KI">Kiribati</option><option value="XK">Kosovo</option><option value="KW">Kuwait</option><option value="KG">Kyrgyzstan</option><option value="LA">Laos</option><option value="LV">Latvia</option><option value="LB">Lebanon</option><option value="LS">Lesotho</option><option value="LR">Liberia</option><option value="LY">Libya</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MO">Macao</option><option value="MK">Macedonia</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="ML">Mali</option><option value="MT">Malta</option><option value="MH">Marshall Islands</option><option value="MQ">Martinique</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="YT">Mayotte</option><option value="MX">Mexico</option><option value="FM">Micronesia</option><option value="MD">Moldova</option><option value="MC">Monaco</option><option value="MN">Mongolia</option><option value="ME">Montenegro</option><option value="MS">Montserrat</option><option value="MA">Morocco</option><option value="MZ">Mozambique</option><option value="MM">Myanmar</option><option value="NA">Namibia</option><option value="NR">Nauru</option><option value="NP">Nepal</option><option value="NL">Netherlands</option><option value="NC">New Caledonia</option><option value="NZ">New Zealand</option><option value="NI">Nicaragua</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="NU">Niue</option><option value="NF">Norfolk Island</option><option value="KP">North Korea</option><option value="MP">Northern Mariana Islands</option><option value="NO">Norway</option><option value="OM">Oman</option><option value="PK">Pakistan</option><option value="PW">Palau</option><option value="PS">Palestinian Territory</option><option value="PA">Panama</option><option value="PG">Papua New Guinea</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="PH">Philippines</option><option value="PN">Pitcairn</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="CG">Republic of the Congo</option><option value="RE">Reunion</option><option value="RO">Romania</option><option value="RU">Russia</option><option value="RW">Rwanda</option><option value="BL">Saint Barthelemy</option><option value="SH">Saint Helena</option><option value="KN">Saint Kitts and Nevis</option><option value="LC">Saint Lucia</option><option value="MF">Saint Martin</option><option value="PM">Saint Pierre and Miquelon</option><option value="VC">Saint Vincent and the Grenadines</option><option value="WS">Samoa</option><option value="SM">San Marino</option><option value="ST">Sao Tome and Principe</option><option value="SA">Saudi Arabia</option><option value="SN">Senegal</option><option value="RS">Serbia</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SG">Singapore</option><option value="SX">Sint Maarten</option><option value="SK">Slovakia</option><option value="SI">Slovenia</option><option value="SB">Solomon Islands</option><option value="SO">Somalia</option><option value="ZA">South Africa</option><option value="GS">South Georgia and the South Sandwich Islands</option><option value="KR">South Korea</option><option value="SS">South Sudan</option><option value="ES">Spain</option><option value="LK">Sri Lanka</option><option value="SD">Sudan</option><option value="SR">Suriname</option><option value="SJ">Svalbard and Jan Mayen</option><option value="SZ">Swaziland</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="SY">Syria</option><option value="TW">Taiwan</option><option value="TJ">Tajikistan</option><option value="TZ">Tanzania</option><option value="TH">Thailand</option><option value="TG">Togo</option><option value="TK">Tokelau</option><option value="TO">Tonga</option><option value="TT">Trinidad and Tobago</option><option value="TN">Tunisia</option><option value="TR">Turkey</option><option value="TM">Turkmenistan</option><option value="TC">Turks and Caicos Islands</option><option value="TV">Tuvalu</option><option value="VI">U.S. Virgin Islands</option><option value="UG">Uganda</option><option value="UA">Ukraine</option><option value="AE">United Arab Emirates</option><option value="GB">United Kingdom</option><option value="US">United States</option><option value="UM">United States Minor Outlying Islands</option><option value="UY">Uruguay</option><option value="UZ">Uzbekistan</option><option value="VU">Vanuatu</option><option value="VA">Vatican</option><option value="VE">Venezuela</option><option value="VN">Vietnam</option><option value="WF">Wallis and Futuna</option><option value="EH">Western Sahara</option><option value="YE">Yemen</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option></select>
                                         </div>

                                         <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-sm-10">
                                                    <input type="text" name="location_url[]" class="form-control shorten-input" placeholder="Url"/>
                                                </div>
                                                <div class="col-sm-2">
                                                    <a href="#" class="delete-row-btn btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
                                                </div>
                                            </div>
                                         </div>
                                    </div>
                               </div>
                               
                               <hr>
                               
                               <div class="row marbot10">
                                   <div class="col-lg-12">
                                       <div class="left"><label style="margin:0px;">Device Targeting</label></div>
                                       <div class="right"><a href="#" class="btn btn-sm btn-dark" id="add_more_devices" style="line-height: 1">Add more devices</a></div>
                                   </div>
                                   <div class="col-lg-12">
                                       <p>Redirect users to different urls based on their device.</p>
                                   </div>
                               </div>
                               
                               <div id="devices">
                                    <div class="row shorten-row">
                                         <div class="col-lg-6">
                                             <select class="form-control shorten-input" name="device[]">
                                                 <option selected value="0">Select one</option>
                                                 <option value="mobile">Mobile</option>
                                                 <option value="tablet">Tablet</option>
                                                 <option value="desktop">Desktop</option>
                                             </select>
                                         </div>

                                         <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-sm-10">
                                                    <input type="text" name="device_url[]" class="form-control shorten-input" placeholder="Url"/>
                                                </div>
                                                <div class="col-sm-2">
                                                    <a href="#" class="delete-row-btn btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
                                                </div>
                                            </div>
                                         </div>
                                    </div>
                               </div>

                           </div>
                        </form>
                   </div>
                </div>
            </div>

            <!--chart-->
            <div class="col-md-12">

                <div class="card border-light ">
                   <div class="card-header">Url Click Data</div>
                   <div class="card-body" style="height:400px">
                        <canvas id="home-page-chart"></canvas>
                        <div class="no_data" style="padding-top:173px">NO DATA AVAILABLE</div>
                   </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="row">
            <!-- map -->
            <div class="col-md-12 marbot20" id="location_data_map_col">
                <div id="home-page-map"></div>
            </div>

            <div class="col-md-12">
                <div class="card border-light ">
                   <div class="card-header">Top Clicked URLs</div>
                   <div class="card-body">
                      <ul>
                        <?php

                          if ($top_clicked_urls !== "no_data")
                          {
                            foreach ($top_clicked_urls as $tcurl)
                            {
                              echo '<li><a href="'.base_url().$tcurl["name"].'">'.base_url().$tcurl["name"].'</a> - '.$tcurl["views"].' Clicks</li>';
                            }
                          }
                          else
                            echo 'No clicks at all';

                        ?>
                      </ul>
                   </div>
                </div>
            </div>
        </div>
    </div>

</div>




<script type="text/javascript">
    
    var btn_submit_status = "submit";

    var locationsdiv = '<div class="row shorten-row"> <div class="col-lg-6"> <select class="form-control shorten-input" name="location[]"> <option selected value="0">Select one</option><option value="AF">Afghanistan</option><option value="AX">Aland Islands</option><option value="AL">Albania</option><option value="DZ">Algeria</option><option value="AS">American Samoa</option><option value="AD">Andorra</option><option value="AO">Angola</option><option value="AI">Anguilla</option><option value="AQ">Antarctica</option><option value="AG">Antigua and Barbuda</option><option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AW">Aruba</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="AZ">Azerbaijan</option><option value="BS">Bahamas</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="BY">Belarus</option><option value="BE">Belgium</option><option value="BZ">Belize</option><option value="BJ">Benin</option><option value="BM">Bermuda</option><option value="BT">Bhutan</option><option value="BO">Bolivia</option><option value="BQ">Bonaire, Saint Eustatius and Saba </option><option value="BA">Bosnia and Herzegovina</option><option value="BW">Botswana</option><option value="BV">Bouvet Island</option><option value="BR">Brazil</option><option value="IO">British Indian Ocean Territory</option><option value="VG">British Virgin Islands</option><option value="BN">Brunei</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="KH">Cambodia</option><option value="CM">Cameroon</option><option value="CA">Canada</option><option value="CV">Cape Verde</option><option value="KY">Cayman Islands</option><option value="CF">Central African Republic</option><option value="TD">Chad</option><option value="CL">Chile</option><option value="CN">China</option><option value="CX">Christmas Island</option><option value="CC">Cocos Islands</option><option value="CO">Colombia</option><option value="KM">Comoros</option><option value="CK">Cook Islands</option><option value="CR">Costa Rica</option><option value="HR">Croatia</option><option value="CU">Cuba</option><option value="CW">Curacao</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="CD">Democratic Republic of the Congo</option><option value="DK">Denmark</option><option value="DJ">Djibouti</option><option value="DM">Dominica</option><option value="DO">Dominican Republic</option><option value="TL">East Timor</option><option value="EC">Ecuador</option><option value="EG">Egypt</option><option value="SV">El Salvador</option><option value="GQ">Equatorial Guinea</option><option value="ER">Eritrea</option><option value="EE">Estonia</option><option value="ET">Ethiopia</option><option value="FK">Falkland Islands</option><option value="FO">Faroe Islands</option><option value="FJ">Fiji</option><option value="FI">Finland</option><option value="FR">France</option><option value="GF">French Guiana</option><option value="PF">French Polynesia</option><option value="TF">French Southern Territories</option><option value="GA">Gabon</option><option value="GM">Gambia</option><option value="GE">Georgia</option><option value="DE">Germany</option><option value="GH">Ghana</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GP">Guadeloupe</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GG">Guernsey</option><option value="GN">Guinea</option><option value="GW">Guinea-Bissau</option><option value="GY">Guyana</option><option value="HT">Haiti</option><option value="HM">Heard Island and McDonald Islands</option><option value="HN">Honduras</option><option value="HK">Hong Kong</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Iran</option><option value="IQ">Iraq</option><option value="IE">Ireland</option><option value="IM">Isle of Man</option><option value="IL">Israel</option><option value="IT">Italy</option><option value="CI">Ivory Coast</option><option value="JM">Jamaica</option><option value="JP">Japan</option><option value="JE">Jersey</option><option value="JO">Jordan</option><option value="KZ">Kazakhstan</option><option value="KE">Kenya</option><option value="KI">Kiribati</option><option value="XK">Kosovo</option><option value="KW">Kuwait</option><option value="KG">Kyrgyzstan</option><option value="LA">Laos</option><option value="LV">Latvia</option><option value="LB">Lebanon</option><option value="LS">Lesotho</option><option value="LR">Liberia</option><option value="LY">Libya</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MO">Macao</option><option value="MK">Macedonia</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="ML">Mali</option><option value="MT">Malta</option><option value="MH">Marshall Islands</option><option value="MQ">Martinique</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="YT">Mayotte</option><option value="MX">Mexico</option><option value="FM">Micronesia</option><option value="MD">Moldova</option><option value="MC">Monaco</option><option value="MN">Mongolia</option><option value="ME">Montenegro</option><option value="MS">Montserrat</option><option value="MA">Morocco</option><option value="MZ">Mozambique</option><option value="MM">Myanmar</option><option value="NA">Namibia</option><option value="NR">Nauru</option><option value="NP">Nepal</option><option value="NL">Netherlands</option><option value="NC">New Caledonia</option><option value="NZ">New Zealand</option><option value="NI">Nicaragua</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="NU">Niue</option><option value="NF">Norfolk Island</option><option value="KP">North Korea</option><option value="MP">Northern Mariana Islands</option><option value="NO">Norway</option><option value="OM">Oman</option><option value="PK">Pakistan</option><option value="PW">Palau</option><option value="PS">Palestinian Territory</option><option value="PA">Panama</option><option value="PG">Papua New Guinea</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="PH">Philippines</option><option value="PN">Pitcairn</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="CG">Republic of the Congo</option><option value="RE">Reunion</option><option value="RO">Romania</option><option value="RU">Russia</option><option value="RW">Rwanda</option><option value="BL">Saint Barthelemy</option><option value="SH">Saint Helena</option><option value="KN">Saint Kitts and Nevis</option><option value="LC">Saint Lucia</option><option value="MF">Saint Martin</option><option value="PM">Saint Pierre and Miquelon</option><option value="VC">Saint Vincent and the Grenadines</option><option value="WS">Samoa</option><option value="SM">San Marino</option><option value="ST">Sao Tome and Principe</option><option value="SA">Saudi Arabia</option><option value="SN">Senegal</option><option value="RS">Serbia</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SG">Singapore</option><option value="SX">Sint Maarten</option><option value="SK">Slovakia</option><option value="SI">Slovenia</option><option value="SB">Solomon Islands</option><option value="SO">Somalia</option><option value="ZA">South Africa</option><option value="GS">South Georgia and the South Sandwich Islands</option><option value="KR">South Korea</option><option value="SS">South Sudan</option><option value="ES">Spain</option><option value="LK">Sri Lanka</option><option value="SD">Sudan</option><option value="SR">Suriname</option><option value="SJ">Svalbard and Jan Mayen</option><option value="SZ">Swaziland</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="SY">Syria</option><option value="TW">Taiwan</option><option value="TJ">Tajikistan</option><option value="TZ">Tanzania</option><option value="TH">Thailand</option><option value="TG">Togo</option><option value="TK">Tokelau</option><option value="TO">Tonga</option><option value="TT">Trinidad and Tobago</option><option value="TN">Tunisia</option><option value="TR">Turkey</option><option value="TM">Turkmenistan</option><option value="TC">Turks and Caicos Islands</option><option value="TV">Tuvalu</option><option value="VI">U.S. Virgin Islands</option><option value="UG">Uganda</option><option value="UA">Ukraine</option><option value="AE">United Arab Emirates</option><option value="GB">United Kingdom</option><option value="US">United States</option><option value="UM">United States Minor Outlying Islands</option><option value="UY">Uruguay</option><option value="UZ">Uzbekistan</option><option value="VU">Vanuatu</option><option value="VA">Vatican</option><option value="VE">Venezuela</option><option value="VN">Vietnam</option><option value="WF">Wallis and Futuna</option><option value="EH">Western Sahara</option><option value="YE">Yemen</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option></select> </div> <div class="col-lg-6"> <div class="row"> <div class="col-sm-10"> <input type="text" name="location_url[]" class="form-control shorten-input" placeholder="Url"/> </div> <div class="col-sm-2"> <a href="#" class="delete-row-btn btn btn-sm btn-danger"><i class="fas fa-times"></i></a> </div> </div> </div> </div>';
    
    var devicesdiv = '<div class="row shorten-row"> <div class="col-lg-6"> <select class="form-control shorten-input" name="device[]"> <option selected value="0">Select one</option> <option value="mobile">Mobile</option> <option value="tablet">Tablet</option> <option value="desktop">Desktop</option> </select> </div><div class="col-lg-6"> <div class="row"> <div class="col-sm-10"> <input type="text" name="device_url[]" class="form-control shorten-input" placeholder="Url"/> </div><div class="col-sm-2"> <a href="#" class="delete-row-btn btn btn-sm btn-danger"><i class="fas fa-times"></i></a> </div></div></div></div>';

    var homepagechart;
    var homepagemap;

    $(document).ready(function(){
        $("#advanced-options-url-shorten-link").click(function(e){

            e.preventDefault();
            $(".advanced-options-url-shorten").slideToggle("fast");

        });


        var allowedDate =new Date(new Date().getTime() + 24 * 60 * 60 * 1000);

        $( "#s_expire_date" ).datepicker({
              showButtonPanel: true,
              minDate: allowedDate
          });
        
        
        $("#add_more_locations").click(function(e){
            e.preventDefault();
            $("#locs").append(locationsdiv);
        });
        
        $("#add_more_devices").click(function(e){
            e.preventDefault();
            $("#devices").append(devicesdiv);
        });
        
        $(".advanced-options-url-shorten").on("click", ".delete-row-btn", function(e){
            e.preventDefault();
            $(this).parents(".shorten-row").remove();
        });

        gmap = [];
        gmap.push(homepagemap);
        
        gchart = [];
        gchart.push(homepagechart);

        $.ajax({
            url: '<?=base_url()?>user/get_chart_data/all/',
            contentType: false,
            processData: false,
            success: function( data){

              loadchart(data);
              load_location_data(data);

            },
            error: function( e ){
                console.log( e );
            }
        });

        

        $(".btn-submit").click(function(e){
            e.preventDefault();
            if (btn_submit_status == "submit")
                $("#shorten_url_form").submit();
            else
            {
                $("#shorten_url_form").find("input[name='url']").select();
                $("#shorten_url_form").find("input[name='url']")[0].setSelectionRange(0, 99999);
                document.execCommand("copy");
                $.notify("Copied to clipboard", "success");
                $("#shorten_url_form").find("input[name='url']").val("");
                $(".btn-submit").text("Shorten");
                btn_submit_status = "submit";
                clear_shorten_form();

            }
        });

        $("#shorten_url_form").find("input[name='url']").change(function(){
            if (btn_submit_status == "copy")
            {
                $(".btn-submit").text("Shorten");
                btn_submit_status = "submit";
                clear_shorten_form();
            }
        });

        $("#shorten_url_form").submit(function(e){
            e.preventDefault();

            var url = ($("#shorten_url_form").find("input[name='url']").val()).trim();

            if (url == "")
            {
                $.notify("Please fill the url input", "error");
                return;
            }

            var form_data = new FormData($(this)[0]);

            $.ajax({
                url: '<?=base_url()?>user/shorten_url',
                type: 'post',
                data: form_data,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".btn-submit").text("Loading...");
                    $(".btn-submit").attr("disabled", "");
                    $("#url-shorten-alert").html("");
                },
                success: function( data){
                    $(".btn-submit").removeAttr("disabled");
                    process_output_data_shorten(data);
                    console.log(data);
                },
                error: function( e ){
                    $(".btn-submit").text("Shorten");
                    $(".btn-submit").removeAttr("disabled");
                    console.log( e );
                }
            });
        });
    });

    function clear_shorten_form()
    {
        $("#shorten_url_form").find("input[name='alias']").val("");
        $("#shorten_url_form").find("input[name='description']").val("");
        $("#shorten_url_form").find("input[name='expire_date']").val("");
        $("#shorten_url_form").find("input[name='password']").val("");

        $("#locs").html("");
        $("#devices").html("");

        $("#locs").append(locationsdiv);
        $("#devices").append(devicesdiv);
    }

    function process_output_data_shorten(data)
    {
        if (data.substr(0, 7) == "success"){
            $.notify("Url successfully shortened", "success");
            $("#url-shorten-alert").html('<div class="alert alert-success"><strong>Success!</strong> your url has been shortened! <a href="'+ data.substr(7) + '">' + data.substr(7) + '</a>');
            $("#shorten_url_form").find("input[name='url']").val(data.substr(7)).select();
            $(".btn-submit").text("Copy");
            btn_submit_status = "copy";
            
        }else if (data == "error" || data == "no_data"){
            $.notify("Unknown error happened", "error");
            $(".btn-submit").text("Shorten");
        }else if (data == "name_exists"){
            $.notify("This alias is already used by another link please use different one", "error");
            $(".btn-submit").text("Shorten");
        }else if (data == "bad_url" || data == "no_url"){
            $.notify("Please enter a correct url", "error");
            $(".btn-submit").text("Shorten");
        }else if (data == "bad_alias"){
            $.notify("You have invalid characters in your custom alias!", "error");
            $(".btn-submit").text("Shorten");
        }else if (data == "bad_url_loc"){
            $.notify("Please enter a correct url on location targeting", "error");
            $(".btn-submit").text("Shorten");
        }else if (data == "bad_url_device"){
            $.notify("Please enter a correct url on device targeting", "error");
            $(".btn-submit").text("Shorten");
        }else{
            $.notify("Unknown error happened", "error");
            $(".btn-submit").text("Shorten");
        }
    }

    function loadchart(data)
    {
      try{
          homepagechart.destroy();
      }catch(err){}

      if (data == "no_data")
      {
          $("#home-page-chart").hide();
          $("#home-page-chart").parent().find(".no_data").show();
          return;
      }

      data = JSON.parse(data);

      var labels = [];
      var cdata = [];

      if (data.click_chart !== "no_data")
      {
          for (var i = 0; i < data.click_chart.length; i++)
          {
              labels.push(data.click_chart[i][1]);
              cdata.push(data.click_chart[i][0]);
          }

          $("#home-page-chart").show();
          $("#home-page-chart").parent().find(".no_data").hide();

          homepagechart = new Chart(document.getElementById('home-page-chart'), {
              "type": "line",
              "data": {
                  "labels": labels,
                  "datasets": [{
                      "data": cdata,
                      "fill": true,
                      "borderColor": "#007bff",
                      "backgroundColor": "#82beff",
                      "lineTension": 0,
                  }]
              },
              "options": {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                  yAxes: [{
                      gridLines: {
                          color: "rgba(0, 0, 0, 0)",
                      },
                      ticks: {
                          stepSize: 1
                      } 
                  }]
              }
              }
          });
      }else{
          $("#home-page-chart").hide();
          $("#home-page-chart").parent().find(".no_data").show();
      }    
    }

    function load_location_data(datas)
    {
        try{
            location_data.remove();
        }catch(err){}

        $("#location_data_map_col").html('<div id="location-data-map"></div>');

        if (datas == "no_data")
        {
            homepagemap = $('#location-data-map').vectorMap({map: 'world_mill',zoomStep: 1.5,zoomOnScroll: false,});
            return;
        }
        
        datas = JSON.parse(datas);

        if (datas.location != "no_data")
        {
            var locs = {};

            for (var i = 0; i < datas.location.length; i++)
            {
                locs[datas.location[i][1]] = datas.location[i][0];
            }

            homepagemap = $('#location-data-map').vectorMap({
                map: 'world_mill',
                zoomStep: 1.5,
                zoomOnScroll: false,
                series: {
                    markers: [{
                      attribute: 'fill',
                      scale: ['#FEE5D9', '#A50F15'],
                      values: locs,
                    },{
                      attribute: 'r',
                      scale: [1, 20],
                      values: locs,
                    }],
                    regions: [{
                      scale: ['#DEEBF7', '#08519C'],
                      attribute: 'fill',
                      values: locs
                    }]
                }
            });
        }
        else
        {
          homepagemap = $('#location-data-map').vectorMap({map: 'world_mill',zoomStep: 1.5,zoomOnScroll: false,});
        }

    }

</script>