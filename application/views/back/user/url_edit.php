<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<form action="<?=base_url()."user/urls/".$url_data->id."/update"?>" method="POST" id="url-edit-form">
    <input type="text" class="form-control shorten-input" name="url" value="<?=$url_data->url?>"/>
    
    <a href="#" style="margin-top:14px" id="edit-advanced" class="btn btn-light btn-sm">Advanced Options</a>
    
    <div class="advanced-options-url-edit" style="display:none;margin-top:14px;">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 marbot20">
                <label for="s_alias">Custom Alias</label>
                <p>If you want customized shorten name on link</p>
                <input type="text" name="alias" id="s_alias" class="form-control shorten-input" value="<?=$url_data->name?>" placeholder="Custom Alias"/>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 marbot20">
                <label for="s_description">Description</label>
                <p>Description for identifying on panel</p>
                <input type="text" name="description" id="s_description" class="form-control shorten-input" value="<?=$url_data->description?>" placeholder="Description"/>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 marbot20">
                <label for="s_expire_date">Expire Date</label>
                <p>After expire date url is not going to be usable</p>
                <input type="text" name="expire_date" id="s_expire_date" class="form-control shorten-input" placeholder="Expire Date"/>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 marbot20">
                <label for="s_password">Password Protect</label>
                <p>Password on redirect to protect content</p>
                <input type="text" name="password" id="s_password" class="form-control shorten-input" value="<?=$url_data->password?>" placeholder="Password"/>
            </div>

        </div>

        <hr>
        <div class="row marbot10">
            <div class="col-lg-12">
                <div class="left"><label style="margin:0px;">Location Targeting</label></div>
                <div class="right">
                    <a href="#" class="btn btn-sm btn-dark" id="add_more_locations" style="line-height: 1">Add more locations</a>
                </div>
            </div>
            <div class="col-lg-12">
               <p>Redirect users to different urls based on their location.</p>
            </div>
        </div>

        <div id="locs">

            <?php

                

                $locsselect = "";
                $locsselect .= '<div class="row shorten-row">';
                $locsselect .= '<div class="col-sm-12">';
                $locsselect .= '<select class="form-control shorten-input" name="location[]">';
                $locsselect .= '<option selected="" value="0">Select one</option>';
                foreach (json_decode($this->chart_model->country_names, true) as $key => $value)
                {                    
                    $locsselect .= '<option value="'.$key.'"';
                    $locsselect .= '>'.$value.'</option>';
                    
                }
                $locsselect .= '</select>';
                $locsselect .= '</div>';
                $locsselect .= '<div class="col-sm-12">';
                $locsselect .= '
                <div class="row">
                <div class="col-sm-10">
                <input type="text" name="location_url[]" class="form-control shorten-input" placeholder="Url" />
                </div>
                <div class="col-sm-2">
                <a href="#" class="delete-row-btn btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
                </div>
                </div>
                ';
                $locsselect .= '</div>';
                $locsselect .= '</div>';

                if ($url_data->locations !== null)
                {
                    $locs = json_decode($url_data->locations, true);
                    if ($locs !== null)
                    {
                        
                        $i = 1;
                        foreach ($locs as $row)
                        {
                            echo '<div class="row shorten-row">';
                                echo '<div class="col-sm-12">';
                                    echo '<select class="form-control shorten-input" name="location[]">';
                                        echo '<option value="0">Select one</option>';
                                        foreach (json_decode($this->chart_model->country_names, true) as $key => $value)
                                        {
                                            echo '<option value="'.$key.'"';
                                            if ($key == $row["location"])
                                                echo ' selected="" ';
                                            echo '>'.$value.'</option>';
                                        }
                                    echo '</select>';
                                echo '</div>';

                                echo '<div class="col-sm-12">';
                                    echo '
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <input type="text" name="location_url[]" class="form-control shorten-input" placeholder="Url" value="'.$row["url"].'"/>
                                            </div>
                                            <div class="col-sm-2">
                                                <a href="#" class="delete-row-btn btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
                                            </div>
                                        </div>
                                    ';
                                echo '</div>';

                            echo '</div>';

                            if ($i !== count($locs))
                            echo '<hr>';

                            $i++;
                        }
                    }
                    else
                    {
                        echo $locsselect;
                    }
                }
                else
                {
                    echo $locsselect;
                }

        ?>
        </div>
        
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

            <?php

                    $devicesselect = '
                    <div class="row shorten-row">
                         <div class="col-sm-12">
                             <select class="form-control shorten-input" name="device[]">
                                 <option selected value="0">Select one</option>
                                 <option value="mobile">Mobile</option>
                                 <option value="tablet">Tablet</option>
                                 <option value="desktop">Desktop</option>
                             </select>
                         </div>

                         <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-10">
                                    <input type="text" name="device_url[]" class="form-control shorten-input" placeholder="Url"/>
                                </div>
                                <div class="col-sm-2">
                                    <a href="#" class="delete-row-btn btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                         </div>
                    </div>';

                    if ($url_data->devices !== null)
                    {
                        $devices = json_decode($url_data->devices, true);
                        if ($devices !== null)
                        {
                            
                            $i = 1;
                            foreach ($devices as $row)
                            {

                                echo '<div class="row shorten-row">
                                     <div class="col-sm-12">
                                         <select class="form-control shorten-input" name="device[]">
                                             <option value="0">Select one</option>';

                                             echo '<option ';
                                             if ($row["device"] == "mobile")
                                                echo ' selected="" ';
                                             echo 'value="mobile">Mobile</option>';

                                             echo '<option ';
                                             if ($row["device"] == "tablet")
                                                echo ' selected="" ';
                                             echo 'value="tablet">Tablet</option>';

                                             echo '<option';
                                             if ($row["device"] == "desktop")
                                                echo ' selected="" ';
                                             echo 'value="desktop">Desktop</option>';

                                         echo '</select>
                                     </div>

                                     <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <input type="text" name="device_url[]" class="form-control shorten-input" value="'.$row["url"].'" placeholder="Url"/>
                                            </div>
                                            <div class="col-sm-2">
                                                <a href="#" class="delete-row-btn btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
                                            </div>
                                        </div>
                                     </div>
                                </div>';

                                if ($i !== count($locs))
                                    echo '<hr>';

                                    $i++;

                            }
                        }
                        else
                        {
                            echo $devicesselect;
                        }
                    }
                    else
                    {
                        echo $devicesselect;
                    }
                ?>

        </div>

    </div>
</form>

<script type="text/javascript">

    var locationsdiv = '<div class="row shorten-row"> <div class="col-sm-12"> <select class="form-control shorten-input" name="location[]"> <option selected value="0">Select one</option><option value="AF">Afghanistan</option><option value="AX">Aland Islands</option><option value="AL">Albania</option><option value="DZ">Algeria</option><option value="AS">American Samoa</option><option value="AD">Andorra</option><option value="AO">Angola</option><option value="AI">Anguilla</option><option value="AQ">Antarctica</option><option value="AG">Antigua and Barbuda</option><option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AW">Aruba</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="AZ">Azerbaijan</option><option value="BS">Bahamas</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="BY">Belarus</option><option value="BE">Belgium</option><option value="BZ">Belize</option><option value="BJ">Benin</option><option value="BM">Bermuda</option><option value="BT">Bhutan</option><option value="BO">Bolivia</option><option value="BQ">Bonaire, Saint Eustatius and Saba </option><option value="BA">Bosnia and Herzegovina</option><option value="BW">Botswana</option><option value="BV">Bouvet Island</option><option value="BR">Brazil</option><option value="IO">British Indian Ocean Territory</option><option value="VG">British Virgin Islands</option><option value="BN">Brunei</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="KH">Cambodia</option><option value="CM">Cameroon</option><option value="CA">Canada</option><option value="CV">Cape Verde</option><option value="KY">Cayman Islands</option><option value="CF">Central African Republic</option><option value="TD">Chad</option><option value="CL">Chile</option><option value="CN">China</option><option value="CX">Christmas Island</option><option value="CC">Cocos Islands</option><option value="CO">Colombia</option><option value="KM">Comoros</option><option value="CK">Cook Islands</option><option value="CR">Costa Rica</option><option value="HR">Croatia</option><option value="CU">Cuba</option><option value="CW">Curacao</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="CD">Democratic Republic of the Congo</option><option value="DK">Denmark</option><option value="DJ">Djibouti</option><option value="DM">Dominica</option><option value="DO">Dominican Republic</option><option value="TL">East Timor</option><option value="EC">Ecuador</option><option value="EG">Egypt</option><option value="SV">El Salvador</option><option value="GQ">Equatorial Guinea</option><option value="ER">Eritrea</option><option value="EE">Estonia</option><option value="ET">Ethiopia</option><option value="FK">Falkland Islands</option><option value="FO">Faroe Islands</option><option value="FJ">Fiji</option><option value="FI">Finland</option><option value="FR">France</option><option value="GF">French Guiana</option><option value="PF">French Polynesia</option><option value="TF">French Southern Territories</option><option value="GA">Gabon</option><option value="GM">Gambia</option><option value="GE">Georgia</option><option value="DE">Germany</option><option value="GH">Ghana</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GP">Guadeloupe</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GG">Guernsey</option><option value="GN">Guinea</option><option value="GW">Guinea-Bissau</option><option value="GY">Guyana</option><option value="HT">Haiti</option><option value="HM">Heard Island and McDonald Islands</option><option value="HN">Honduras</option><option value="HK">Hong Kong</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Iran</option><option value="IQ">Iraq</option><option value="IE">Ireland</option><option value="IM">Isle of Man</option><option value="IL">Israel</option><option value="IT">Italy</option><option value="CI">Ivory Coast</option><option value="JM">Jamaica</option><option value="JP">Japan</option><option value="JE">Jersey</option><option value="JO">Jordan</option><option value="KZ">Kazakhstan</option><option value="KE">Kenya</option><option value="KI">Kiribati</option><option value="XK">Kosovo</option><option value="KW">Kuwait</option><option value="KG">Kyrgyzstan</option><option value="LA">Laos</option><option value="LV">Latvia</option><option value="LB">Lebanon</option><option value="LS">Lesotho</option><option value="LR">Liberia</option><option value="LY">Libya</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MO">Macao</option><option value="MK">Macedonia</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="ML">Mali</option><option value="MT">Malta</option><option value="MH">Marshall Islands</option><option value="MQ">Martinique</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="YT">Mayotte</option><option value="MX">Mexico</option><option value="FM">Micronesia</option><option value="MD">Moldova</option><option value="MC">Monaco</option><option value="MN">Mongolia</option><option value="ME">Montenegro</option><option value="MS">Montserrat</option><option value="MA">Morocco</option><option value="MZ">Mozambique</option><option value="MM">Myanmar</option><option value="NA">Namibia</option><option value="NR">Nauru</option><option value="NP">Nepal</option><option value="NL">Netherlands</option><option value="NC">New Caledonia</option><option value="NZ">New Zealand</option><option value="NI">Nicaragua</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="NU">Niue</option><option value="NF">Norfolk Island</option><option value="KP">North Korea</option><option value="MP">Northern Mariana Islands</option><option value="NO">Norway</option><option value="OM">Oman</option><option value="PK">Pakistan</option><option value="PW">Palau</option><option value="PS">Palestinian Territory</option><option value="PA">Panama</option><option value="PG">Papua New Guinea</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="PH">Philippines</option><option value="PN">Pitcairn</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="CG">Republic of the Congo</option><option value="RE">Reunion</option><option value="RO">Romania</option><option value="RU">Russia</option><option value="RW">Rwanda</option><option value="BL">Saint Barthelemy</option><option value="SH">Saint Helena</option><option value="KN">Saint Kitts and Nevis</option><option value="LC">Saint Lucia</option><option value="MF">Saint Martin</option><option value="PM">Saint Pierre and Miquelon</option><option value="VC">Saint Vincent and the Grenadines</option><option value="WS">Samoa</option><option value="SM">San Marino</option><option value="ST">Sao Tome and Principe</option><option value="SA">Saudi Arabia</option><option value="SN">Senegal</option><option value="RS">Serbia</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SG">Singapore</option><option value="SX">Sint Maarten</option><option value="SK">Slovakia</option><option value="SI">Slovenia</option><option value="SB">Solomon Islands</option><option value="SO">Somalia</option><option value="ZA">South Africa</option><option value="GS">South Georgia and the South Sandwich Islands</option><option value="KR">South Korea</option><option value="SS">South Sudan</option><option value="ES">Spain</option><option value="LK">Sri Lanka</option><option value="SD">Sudan</option><option value="SR">Suriname</option><option value="SJ">Svalbard and Jan Mayen</option><option value="SZ">Swaziland</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="SY">Syria</option><option value="TW">Taiwan</option><option value="TJ">Tajikistan</option><option value="TZ">Tanzania</option><option value="TH">Thailand</option><option value="TG">Togo</option><option value="TK">Tokelau</option><option value="TO">Tonga</option><option value="TT">Trinidad and Tobago</option><option value="TN">Tunisia</option><option value="TR">Turkey</option><option value="TM">Turkmenistan</option><option value="TC">Turks and Caicos Islands</option><option value="TV">Tuvalu</option><option value="VI">U.S. Virgin Islands</option><option value="UG">Uganda</option><option value="UA">Ukraine</option><option value="AE">United Arab Emirates</option><option value="GB">United Kingdom</option><option value="US">United States</option><option value="UM">United States Minor Outlying Islands</option><option value="UY">Uruguay</option><option value="UZ">Uzbekistan</option><option value="VU">Vanuatu</option><option value="VA">Vatican</option><option value="VE">Venezuela</option><option value="VN">Vietnam</option><option value="WF">Wallis and Futuna</option><option value="EH">Western Sahara</option><option value="YE">Yemen</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option></select> </div> <div class="col-sm-12"> <div class="row"> <div class="col-sm-10"> <input type="text" name="location_url[]" class="form-control shorten-input" placeholder="Url"/> </div> <div class="col-sm-2"> <a href="#" class="delete-row-btn btn btn-sm btn-danger"><i class="fas fa-times"></i></a> </div> </div> </div> </div>';
    
    var devicesdiv = '<div class="row shorten-row"> <div class="col-sm-12"> <select class="form-control shorten-input" name="device[]"> <option selected value="0">Select one</option> <option value="mobile">Mobile</option> <option value="tablet">Tablet</option> <option value="desktop">Desktop</option> </select> </div><div class="col-sm-12"> <div class="row"> <div class="col-sm-10"> <input type="text" name="device_url[]" class="form-control shorten-input" placeholder="Url"/> </div><div class="col-sm-2"> <a href="#" class="delete-row-btn btn btn-sm btn-danger"><i class="fas fa-times"></i></a> </div></div></div></div>';


    //var allowedDate =new Date(new Date().getTime() + 24 * 60 * 60 * 1000);

    $(document).ready(function(){
        $( "#s_expire_date" ).datepicker({
              showButtonPanel: true,
        });

        <?php

            if (!empty($url_data->expire_date))
            {
                ?>
                var orgdate = '<?=$url_data->expire_date?>';
                $("#s_expire_date").datepicker("setDate", new Date(orgdate));
                <?php
            }

        ?>

        $("#add_more_locations").click(function(e){
            e.preventDefault();
            $("#locs").append(locationsdiv);
        });
        
        $("#add_more_devices").click(function(e){
            e.preventDefault();
            $("#devices").append(devicesdiv);
        });

        $(".advanced-options-url-edit").on("click", ".delete-row-btn", function(e){
            e.preventDefault();
            $(this).parents(".shorten-row").remove();
        });
    });
</script>

<style>
    #url-edit-form hr{margin-top:0px;}
</style>