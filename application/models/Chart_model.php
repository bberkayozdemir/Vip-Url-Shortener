<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public $country_names = '{"AF":"Afghanistan","AX":"Aland Islands","AL":"Albania","DZ":"Algeria","AS":"American Samoa","AD":"Andorra","AO":"Angola","AI":"Anguilla","AQ":"Antarctica","AG":"Antigua and Barbuda","AR":"Argentina","AM":"Armenia","AW":"Aruba","AU":"Australia","AT":"Austria","AZ":"Azerbaijan","BS":"Bahamas","BH":"Bahrain","BD":"Bangladesh","BB":"Barbados","BY":"Belarus","BE":"Belgium","BZ":"Belize","BJ":"Benin","BM":"Bermuda","BT":"Bhutan","BO":"Bolivia","BQ":"Bonaire, Saint Eustatius and Saba ","BA":"Bosnia and Herzegovina","BW":"Botswana","BV":"Bouvet Island","BR":"Brazil","IO":"British Indian Ocean Territory","VG":"British Virgin Islands","BN":"Brunei","BG":"Bulgaria","BF":"Burkina Faso","BI":"Burundi","KH":"Cambodia","CM":"Cameroon","CA":"Canada","CV":"Cape Verde","KY":"Cayman Islands","CF":"Central African Republic","TD":"Chad","CL":"Chile","CN":"China","CX":"Christmas Island","CC":"Cocos Islands","CO":"Colombia","KM":"Comoros","CK":"Cook Islands","CR":"Costa Rica","HR":"Croatia","CU":"Cuba","CW":"Curacao","CY":"Cyprus","CZ":"Czech Republic","CD":"Democratic Republic of the Congo","DK":"Denmark","DJ":"Djibouti","DM":"Dominica","DO":"Dominican Republic","TL":"East Timor","EC":"Ecuador","EG":"Egypt","SV":"El Salvador","GQ":"Equatorial Guinea","ER":"Eritrea","EE":"Estonia","ET":"Ethiopia","FK":"Falkland Islands","FO":"Faroe Islands","FJ":"Fiji","FI":"Finland","FR":"France","GF":"French Guiana","PF":"French Polynesia","TF":"French Southern Territories","GA":"Gabon","GM":"Gambia","GE":"Georgia","DE":"Germany","GH":"Ghana","GI":"Gibraltar","GR":"Greece","GL":"Greenland","GD":"Grenada","GP":"Guadeloupe","GU":"Guam","GT":"Guatemala","GG":"Guernsey","GN":"Guinea","GW":"Guinea-Bissau","GY":"Guyana","HT":"Haiti","HM":"Heard Island and McDonald Islands","HN":"Honduras","HK":"Hong Kong","HU":"Hungary","IS":"Iceland","IN":"India","ID":"Indonesia","IR":"Iran","IQ":"Iraq","IE":"Ireland","IM":"Isle of Man","IL":"Israel","IT":"Italy","CI":"Ivory Coast","JM":"Jamaica","JP":"Japan","JE":"Jersey","JO":"Jordan","KZ":"Kazakhstan","KE":"Kenya","KI":"Kiribati","XK":"Kosovo","KW":"Kuwait","KG":"Kyrgyzstan","LA":"Laos","LV":"Latvia","LB":"Lebanon","LS":"Lesotho","LR":"Liberia","LY":"Libya","LI":"Liechtenstein","LT":"Lithuania","LU":"Luxembourg","MO":"Macao","MK":"Macedonia","MG":"Madagascar","MW":"Malawi","MY":"Malaysia","MV":"Maldives","ML":"Mali","MT":"Malta","MH":"Marshall Islands","MQ":"Martinique","MR":"Mauritania","MU":"Mauritius","YT":"Mayotte","MX":"Mexico","FM":"Micronesia","MD":"Moldova","MC":"Monaco","MN":"Mongolia","ME":"Montenegro","MS":"Montserrat","MA":"Morocco","MZ":"Mozambique","MM":"Myanmar","NA":"Namibia","NR":"Nauru","NP":"Nepal","NL":"Netherlands","NC":"New Caledonia","NZ":"New Zealand","NI":"Nicaragua","NE":"Niger","NG":"Nigeria","NU":"Niue","NF":"Norfolk Island","KP":"North Korea","MP":"Northern Mariana Islands","NO":"Norway","OM":"Oman","PK":"Pakistan","PW":"Palau","PS":"Palestinian Territory","PA":"Panama","PG":"Papua New Guinea","PY":"Paraguay","PE":"Peru","PH":"Philippines","PN":"Pitcairn","PL":"Poland","PT":"Portugal","PR":"Puerto Rico","QA":"Qatar","CG":"Republic of the Congo","RE":"Reunion","RO":"Romania","RU":"Russia","RW":"Rwanda","BL":"Saint Barthelemy","SH":"Saint Helena","KN":"Saint Kitts and Nevis","LC":"Saint Lucia","MF":"Saint Martin","PM":"Saint Pierre and Miquelon","VC":"Saint Vincent and the Grenadines","WS":"Samoa","SM":"San Marino","ST":"Sao Tome and Principe","SA":"Saudi Arabia","SN":"Senegal","RS":"Serbia","SC":"Seychelles","SL":"Sierra Leone","SG":"Singapore","SX":"Sint Maarten","SK":"Slovakia","SI":"Slovenia","SB":"Solomon Islands","SO":"Somalia","ZA":"South Africa","GS":"South Georgia and the South Sandwich Islands","KR":"South Korea","SS":"South Sudan","ES":"Spain","LK":"Sri Lanka","SD":"Sudan","SR":"Suriname","SJ":"Svalbard and Jan Mayen","SZ":"Swaziland","SE":"Sweden","CH":"Switzerland","SY":"Syria","TW":"Taiwan","TJ":"Tajikistan","TZ":"Tanzania","TH":"Thailand","TG":"Togo","TK":"Tokelau","TO":"Tonga","TT":"Trinidad and Tobago","TN":"Tunisia","TR":"Turkey","TM":"Turkmenistan","TC":"Turks and Caicos Islands","TV":"Tuvalu","VI":"U.S. Virgin Islands","UG":"Uganda","UA":"Ukraine","AE":"United Arab Emirates","GB":"United Kingdom","US":"United States","UM":"United States Minor Outlying Islands","UY":"Uruguay","UZ":"Uzbekistan","VU":"Vanuatu","VA":"Vatican","VE":"Venezuela","VN":"Vietnam","WF":"Wallis and Futuna","EH":"Western Sahara","YE":"Yemen","ZM":"Zambia","ZW":"Zimbabwe"}';

    function click_chart($time, $id = null, $user = null, $free_view = false)
    {
        if ($id !== null && $user == null)
            $this->db->where("url", $id);

        if ($user == null) {
            if ($free_view == false) {
                $this->db->where("user", $this->session->userdata('user_id'));
            }
        }else
            $this->db->where("user", $id);

        switch ($time) {

            case "weekly":

                $this->db->where("YEARWEEK(`date`, 1) = YEARWEEK(CURDATE(), 1)");

                $query = $this->db->get("log");
                if ($query !== false && $query->num_rows() > 0)
                {

                    $result = $query->result_array();
                    $data = array(
                        "0"=>array(0,"Monday"),
                        "1"=>array(0,"Tuesday"),
                        "2"=>array(0,"Wednesday"),
                        "3"=>array(0,"Thursday"),
                        "4"=>array(0,"Friday"),
                        "5"=>array(0,"Saturday"),
                        "6"=>array(0,"Sunday")
                    );

                    foreach ($result as $q)
                    {
                        $date = strtotime($q["date"]);
                        $day = strtolower(date("l",$date));
                        switch ($day)
                        {
                            case "monday":
                                $data["0"]["0"]++;
                            break;
                            case "tuesday":
                                $data["1"]["0"]++;
                            break;
                            case "wednesday":
                                $data["2"]["0"]++;
                            break;
                            case "thursday":
                                $data["3"]["0"]++;
                            break;
                            case "friday":
                                $data["4"]["0"]++;
                            break;
                            case "saturday":
                                $data["5"]["0"]++;
                            break;
                            case "sunday":
                                $data["6"]["0"]++;
                            break;
                        }
                    }

                    return $data;
                }
                else
                    return "no_data";

                break;

            case "monthly":
                $this->db->where("YEAR(date)='".date("Y")."'AND MONTH(date)='".date("m")."'");

                $query = $this->db->get("log");
                if ($query !== false && $query->num_rows() > 0)
                {

                    $result = $query->result_array();
                    $data = array();
                    $year = date("Y");
                    $month = date("m");

                    for ($d = 1; $d <= 31; $d++)
                    {
                        $time=mktime(12, 0, 0, $month, $d, $year);
                        if (date('m', $time)==$month)
                            $data[]= array(0, date('d', $time));
                    }

                    foreach ($result as $q)
                    {
                        $date = strtotime($q["date"]);
                        $day = strtolower(date("d",$date));
                        $data[$day - 1]["0"]++;
                    }

                    return $data;
                }
                else
                    return "no_data";

                break;

            case 'yearly':

                $this->db->where("DATE(date) > (NOW() - INTERVAL 12 MONTH)");
                $query = $this->db->get("log");
                if ($query !== false && $query->num_rows() > 0)
                {

                    $result = $query->result_array();
                    $data = array (
                        "0"=>array(0,"January"),
                        "1"=>array(0,"February"),
                        "2"=>array(0,"March"),
                        "3"=>array(0,"April"),
                        "4"=>array(0,"May"),
                        "5"=>array(0,"June"),
                        "6"=>array(0,"July"),
                        "7"=>array(0,"August"),
                        "8"=>array(0,"Septemper"),
                        "9"=>array(0,"October"),
                        "10"=>array(0,"November"),
                        "11"=>array(0,"December"),
                    );

                    foreach ($result as $q)
                    {
                        $date = strtotime($q["date"]);
                        $month = strtolower(date("F",$date));
                        switch ($month)
                        {
                            case "january":
                                $data["0"]["0"]++;
                            break;
                            case "february":
                                $data["1"]["0"]++;
                            break;
                            case "march":
                                $data["2"]["0"]++;
                            break;
                            case "april":
                                $data["3"]["0"]++;
                            break;
                            case "may":
                                $data["4"]["0"]++;
                            break;
                            case "june":
                                $data["5"]["0"]++;
                            break;
                            case "july":
                                $data["6"]["0"]++;
                            break;
                            case "august":
                                $data["7"]["0"]++;
                            break;
                            case "september":
                                $data["8"]["0"]++;
                            break;
                            case "october":
                                $data["9"]["0"]++;
                            break;
                            case "november":
                                $data["10"]["0"]++;
                            break;
                            case "december":
                                $data["11"]["0"]++;
                            break;
                        }
                    }

                    $hits = array();
                    switch (strtolower(date("F")))
                    {
                        case "january":
                            $hits[0] = $data[1];
                            $hits[1] = $data[2];
                            $hits[2] = $data[3];
                            $hits[3] = $data[4];
                            $hits[4] = $data[5];
                            $hits[5] = $data[6];
                            $hits[6] = $data[7];
                            $hits[7] = $data[8];
                            $hits[8] = $data[9];
                            $hits[9] = $data[10];
                            $hits[10] = $data[11];
                            $hits[11] = $data[0];
                        break;

                        case "february":
                            $hits[0] = $data[2];
                            $hits[1] = $data[3];
                            $hits[2] = $data[4];
                            $hits[3] = $data[5];
                            $hits[4] = $data[6];
                            $hits[5] = $data[7];
                            $hits[6] = $data[8];
                            $hits[7] = $data[9];
                            $hits[8] = $data[10];
                            $hits[9] = $data[11];
                            $hits[10] = $data[0];
                            $hits[11] = $data[1];
                        break;

                        case "march":
                            $hits[0] = $data[3];
                            $hits[1] = $data[4];
                            $hits[2] = $data[5];
                            $hits[3] = $data[6];
                            $hits[4] = $data[7];
                            $hits[5] = $data[8];
                            $hits[6] = $data[9];
                            $hits[7] = $data[10];
                            $hits[8] = $data[11];
                            $hits[9] = $data[0];
                            $hits[10] = $data[1];
                            $hits[11] = $data[2];
                        break;

                        case "april":
                            $hits[0] = $data[4];
                            $hits[1] = $data[5];
                            $hits[2] = $data[6];
                            $hits[3] = $data[7];
                            $hits[4] = $data[8];
                            $hits[5] = $data[9];
                            $hits[6] = $data[10];
                            $hits[7] = $data[11];
                            $hits[8] = $data[0];
                            $hits[9] = $data[1];
                            $hits[10] = $data[2];
                            $hits[11] = $data[3];
                        break;

                        case "may":
                            $hits[0] = $data[5];
                            $hits[1] = $data[6];
                            $hits[2] = $data[7];
                            $hits[3] = $data[8];
                            $hits[4] = $data[9];
                            $hits[5] = $data[10];
                            $hits[6] = $data[11];
                            $hits[7] = $data[0];
                            $hits[8] = $data[1];
                            $hits[9] = $data[2];
                            $hits[10] = $data[3];
                            $hits[11] = $data[4];
                        break;

                        case "june":
                            $hits[0] = $data[6];
                            $hits[1] = $data[7];
                            $hits[2] = $data[8];
                            $hits[3] = $data[9];
                            $hits[4] = $data[10];
                            $hits[5] = $data[11];
                            $hits[6] = $data[0];
                            $hits[7] = $data[1];
                            $hits[8] = $data[2];
                            $hits[9] = $data[3];
                            $hits[10] = $data[4];
                            $hits[11] = $data[5];
                        break;

                        case "july":
                            $hits[0] = $data[7];
                            $hits[1] = $data[8];
                            $hits[2] = $data[9];
                            $hits[3] = $data[10];
                            $hits[4] = $data[11];
                            $hits[5] = $data[0];
                            $hits[6] = $data[1];
                            $hits[7] = $data[2];
                            $hits[8] = $data[3];
                            $hits[9] = $data[4];
                            $hits[10] = $data[5];
                            $hits[11] = $data[6];
                        break;

                        case "august":
                            $hits[0] = $data[8];
                            $hits[1] = $data[9];
                            $hits[2] = $data[10];
                            $hits[3] = $data[11];
                            $hits[4] = $data[0];
                            $hits[5] = $data[1];
                            $hits[6] = $data[2];
                            $hits[7] = $data[3];
                            $hits[8] = $data[4];
                            $hits[9] = $data[5];
                            $hits[10] = $data[6];
                            $hits[11] = $data[7];
                        break;

                        case "september":
                            $hits[0] = $data[9];
                            $hits[1] = $data[10];
                            $hits[2] = $data[11];
                            $hits[3] = $data[0];
                            $hits[4] = $data[1];
                            $hits[5] = $data[2];
                            $hits[6] = $data[3];
                            $hits[7] = $data[4];
                            $hits[8] = $data[5];
                            $hits[9] = $data[6];
                            $hits[10] = $data[7];
                            $hits[11] = $data[8];
                        break;

                        case "october":
                            $hits[0] = $data[10];
                            $hits[1] = $data[11];
                            $hits[2] = $data[0];
                            $hits[3] = $data[1];
                            $hits[4] = $data[2];
                            $hits[5] = $data[3];
                            $hits[6] = $data[4];
                            $hits[7] = $data[5];
                            $hits[8] = $data[6];
                            $hits[9] = $data[7];
                            $hits[10] = $data[8];
                            $hits[11] = $data[9];
                        break;

                        case "november":
                            $hits[0] = $data[11];
                            $hits[1] = $data[0];
                            $hits[2] = $data[1];
                            $hits[3] = $data[2];
                            $hits[4] = $data[3];
                            $hits[5] = $data[4];
                            $hits[6] = $data[5];
                            $hits[7] = $data[6];
                            $hits[8] = $data[7];
                            $hits[9] = $data[8];
                            $hits[10] = $data[9];
                            $hits[11] = $data[10];
                        break;

                        case "december":
                            $hits[0] = $data[0];
                            $hits[1] = $data[1];
                            $hits[2] = $data[2];
                            $hits[3] = $data[3];
                            $hits[4] = $data[4];
                            $hits[5] = $data[5];
                            $hits[6] = $data[6];
                            $hits[7] = $data[7];
                            $hits[8] = $data[8];
                            $hits[9] = $data[9];
                            $hits[10] = $data[10];
                            $hits[11] = $data[11];
                        break;
                    }
                    return $hits;

                }
                else
                    return "no_data";

                break;

            default:
                    return "no_data";
                break;
        }

        
    }

    function clicks($time, $id = null, $user = null, $free_view = false)
    {
        if ($id !== null && $user == null)
            $this->db->where("url", $id);

        if ($user == null) {
            if ($free_view == false) {
                $this->db->where("user", $this->session->userdata('user_id'));
            }
        }else
            $this->db->where("user", $id);

        switch ($time) {
            case 'today':
                $this->db->where("YEAR(date)='".date("Y")."'AND MONTH(date)='".date("m")."' AND DAY(date)='".date("d")."'");
                break;
            case 'all':
                break;
            case 'weekly':
                $this->db->where("YEARWEEK(`date`, 1) = YEARWEEK(CURDATE(), 1)");
                break;
            case 'monthly':
                $this->db->where("YEAR(date)='".date("Y")."'AND MONTH(date)='".date("m")."'");
                break;
            case 'yearly':
                $this->db->where("DATE(date) > (NOW() - INTERVAL 12 MONTH)");
                break;
            default:
                    return 0;
                break;
        }

        $query = $this->db->get("log");
        if ($query !== false && $query->num_rows() > 0)
        {
            return $query->num_rows();
        }
        else
            return 0;
    }

    function pie($type, $time, $id = null, $user = null, $free_view = false)
    {
        if ($id !== null && $user == null)
            $this->db->where("url", $id);

        if ($user == null) {
            if ($free_view == false) {
                $this->db->where("user", $this->session->userdata('user_id'));
            }
        }else
            $this->db->where("user", $id);

        switch ($time) 
        {
            case 'all':
                break;
            case 'weekly':
                $this->db->where("YEARWEEK(`date`, 1) = YEARWEEK(CURDATE(), 1)");
                break;
            case 'monthly':
                $this->db->where("YEAR(date)='".date("Y")."'AND MONTH(date)='".date("m")."'");
                break;
            case 'yearly':
                $this->db->where("DATE(date) > (NOW() - INTERVAL 12 MONTH)");
                break;
            default:
                    return "no_data";
                break;
        }

        $query = $this->db->get("log");
        if ($query !== false && $query->num_rows() > 0)
        {
            $data = array();
            $result = $query->result_array();
            foreach ($result as $row)
            {
                if ($row[$type] == null)
                    continue;
                if (!isset($data[$row[$type]]))
                    $data[$row[$type]] = 0;

                $data[$row[$type]]++;
            }

            $newdata = array();

            foreach ($data as $key => $value) {
                array_push($newdata, array(0 => $value, 1 => $key));
            }

            if (count($newdata) == 0)
                return "no_data";

            return $newdata;
        }
        else
            return "no_data";
    }

    function location($time, $id = null, $user = null, $free_view = false)
    {
        if ($id !== null && $user == null)
            $this->db->where("url", $id);

        if ($user == null) {
            if ($free_view == false) {
                $this->db->where("user", $this->session->userdata('user_id'));
            }
        }else
            $this->db->where("user", $id);

        switch ($time) 
        {
            case 'all':
                break;
            case 'weekly':
                $this->db->where("YEARWEEK(`date`, 1) = YEARWEEK(CURDATE(), 1)");
                break;
            case 'monthly':
                $this->db->where("YEAR(date)='".date("Y")."'AND MONTH(date)='".date("m")."'");
                break;
            case 'yearly':
                $this->db->where("DATE(date) > (NOW() - INTERVAL 12 MONTH)");
                break;
            default:
                    return "no_data";
                break;
        }

        $query = $this->db->get("log");
        if ($query !== false && $query->num_rows() > 0)
        {
            $data = array();
            $result = $query->result_array();
            foreach ($result as $row)
            {
                if ($row["location"] == null)
                    continue;
                if (!isset($data[$row["location"]]))
                    $data[$row["location"]] = 0;

                $data[$row["location"]]++;
            }

            arsort($data);

            $locarray = json_decode($this->country_names, true);
            $newdata = array();

            foreach ($data as $key => $value) {
                array_push($newdata, array(0 => $value, 1 => $key, 2 => $locarray[$key]));
            }

            if (count($newdata) == 0)
                return "no_data";

            return $newdata;
        }
        else
            return "no_data";
        
    }

    function top_clicked_urls()
    {
        $query = $this->db->order_by("views", "DESC")->limit("10")->where("views > 0")->get("shorten_urls");

        if ($query !== false && $query->num_rows() > 0)
        {
            return $query->result_array();
        }else
            return "no_data";
    }

    function registered_users_chart($time)
    {
        switch ($time) {

            case "weekly":

                $this->db->where("YEARWEEK(`register_date`, 1) = YEARWEEK(CURDATE(), 1)");

                $query = $this->db->get("users");
                if ($query !== false && $query->num_rows() > 0)
                {

                    $result = $query->result_array();
                    $data = array(
                        "0"=>array(0,"Monday"),
                        "1"=>array(0,"Tuesday"),
                        "2"=>array(0,"Wednesday"),
                        "3"=>array(0,"Thursday"),
                        "4"=>array(0,"Friday"),
                        "5"=>array(0,"Saturday"),
                        "6"=>array(0,"Sunday")
                    );

                    foreach ($result as $q)
                    {
                        $date = strtotime($q["register_date"]);
                        $day = strtolower(date("l",$date));
                        switch ($day)
                        {
                            case "monday":
                                $data["0"]["0"]++;
                                break;
                            case "tuesday":
                                $data["1"]["0"]++;
                                break;
                            case "wednesday":
                                $data["2"]["0"]++;
                                break;
                            case "thursday":
                                $data["3"]["0"]++;
                                break;
                            case "friday":
                                $data["4"]["0"]++;
                                break;
                            case "saturday":
                                $data["5"]["0"]++;
                                break;
                            case "sunday":
                                $data["6"]["0"]++;
                                break;
                        }
                    }

                    return $data;
                }
                else
                    return "no_data";

                break;

            case "monthly":
                $this->db->where("YEAR(register_date)='".date("Y")."'AND MONTH(register_date)='".date("m")."'");

                $query = $this->db->get("users");
                if ($query !== false && $query->num_rows() > 0)
                {

                    $result = $query->result_array();
                    $data = array();
                    $year = date("Y");
                    $month = date("m");

                    for ($d = 1; $d <= 31; $d++)
                    {
                        $time=mktime(12, 0, 0, $month, $d, $year);
                        if (date('m', $time)==$month)
                            $data[]= array(0, date('d', $time));
                    }

                    foreach ($result as $q)
                    {
                        $date = strtotime($q["register_date"]);
                        $day = strtolower(date("d",$date));
                        $data[$day - 1]["0"]++;
                    }

                    return $data;
                }
                else
                    return "no_data";

                break;

            case 'yearly':

                $this->db->where("DATE(register_date) > (NOW() - INTERVAL 12 MONTH)");
                $query = $this->db->get("users");
                if ($query !== false && $query->num_rows() > 0)
                {

                    $result = $query->result_array();
                    $data = array (
                        "0"=>array(0,"January"),
                        "1"=>array(0,"February"),
                        "2"=>array(0,"March"),
                        "3"=>array(0,"April"),
                        "4"=>array(0,"May"),
                        "5"=>array(0,"June"),
                        "6"=>array(0,"July"),
                        "7"=>array(0,"August"),
                        "8"=>array(0,"Septemper"),
                        "9"=>array(0,"October"),
                        "10"=>array(0,"November"),
                        "11"=>array(0,"December"),
                    );

                    foreach ($result as $q)
                    {
                        $date = strtotime($q["register_date"]);
                        $month = strtolower(date("F",$date));
                        switch ($month)
                        {
                            case "january":
                                $data["0"]["0"]++;
                                break;
                            case "february":
                                $data["1"]["0"]++;
                                break;
                            case "march":
                                $data["2"]["0"]++;
                                break;
                            case "april":
                                $data["3"]["0"]++;
                                break;
                            case "may":
                                $data["4"]["0"]++;
                                break;
                            case "june":
                                $data["5"]["0"]++;
                                break;
                            case "july":
                                $data["6"]["0"]++;
                                break;
                            case "august":
                                $data["7"]["0"]++;
                                break;
                            case "september":
                                $data["8"]["0"]++;
                                break;
                            case "october":
                                $data["9"]["0"]++;
                                break;
                            case "november":
                                $data["10"]["0"]++;
                                break;
                            case "december":
                                $data["11"]["0"]++;
                                break;
                        }
                    }

                    $hits = array();
                    switch (strtolower(date("F")))
                    {
                        case "january":
                            $hits[0] = $data[1];
                            $hits[1] = $data[2];
                            $hits[2] = $data[3];
                            $hits[3] = $data[4];
                            $hits[4] = $data[5];
                            $hits[5] = $data[6];
                            $hits[6] = $data[7];
                            $hits[7] = $data[8];
                            $hits[8] = $data[9];
                            $hits[9] = $data[10];
                            $hits[10] = $data[11];
                            $hits[11] = $data[0];
                            break;

                        case "february":
                            $hits[0] = $data[2];
                            $hits[1] = $data[3];
                            $hits[2] = $data[4];
                            $hits[3] = $data[5];
                            $hits[4] = $data[6];
                            $hits[5] = $data[7];
                            $hits[6] = $data[8];
                            $hits[7] = $data[9];
                            $hits[8] = $data[10];
                            $hits[9] = $data[11];
                            $hits[10] = $data[0];
                            $hits[11] = $data[1];
                            break;

                        case "march":
                            $hits[0] = $data[3];
                            $hits[1] = $data[4];
                            $hits[2] = $data[5];
                            $hits[3] = $data[6];
                            $hits[4] = $data[7];
                            $hits[5] = $data[8];
                            $hits[6] = $data[9];
                            $hits[7] = $data[10];
                            $hits[8] = $data[11];
                            $hits[9] = $data[0];
                            $hits[10] = $data[1];
                            $hits[11] = $data[2];
                            break;

                        case "april":
                            $hits[0] = $data[4];
                            $hits[1] = $data[5];
                            $hits[2] = $data[6];
                            $hits[3] = $data[7];
                            $hits[4] = $data[8];
                            $hits[5] = $data[9];
                            $hits[6] = $data[10];
                            $hits[7] = $data[11];
                            $hits[8] = $data[0];
                            $hits[9] = $data[1];
                            $hits[10] = $data[2];
                            $hits[11] = $data[3];
                            break;

                        case "may":
                            $hits[0] = $data[5];
                            $hits[1] = $data[6];
                            $hits[2] = $data[7];
                            $hits[3] = $data[8];
                            $hits[4] = $data[9];
                            $hits[5] = $data[10];
                            $hits[6] = $data[11];
                            $hits[7] = $data[0];
                            $hits[8] = $data[1];
                            $hits[9] = $data[2];
                            $hits[10] = $data[3];
                            $hits[11] = $data[4];
                            break;

                        case "june":
                            $hits[0] = $data[6];
                            $hits[1] = $data[7];
                            $hits[2] = $data[8];
                            $hits[3] = $data[9];
                            $hits[4] = $data[10];
                            $hits[5] = $data[11];
                            $hits[6] = $data[0];
                            $hits[7] = $data[1];
                            $hits[8] = $data[2];
                            $hits[9] = $data[3];
                            $hits[10] = $data[4];
                            $hits[11] = $data[5];
                            break;

                        case "july":
                            $hits[0] = $data[7];
                            $hits[1] = $data[8];
                            $hits[2] = $data[9];
                            $hits[3] = $data[10];
                            $hits[4] = $data[11];
                            $hits[5] = $data[0];
                            $hits[6] = $data[1];
                            $hits[7] = $data[2];
                            $hits[8] = $data[3];
                            $hits[9] = $data[4];
                            $hits[10] = $data[5];
                            $hits[11] = $data[6];
                            break;

                        case "august":
                            $hits[0] = $data[8];
                            $hits[1] = $data[9];
                            $hits[2] = $data[10];
                            $hits[3] = $data[11];
                            $hits[4] = $data[0];
                            $hits[5] = $data[1];
                            $hits[6] = $data[2];
                            $hits[7] = $data[3];
                            $hits[8] = $data[4];
                            $hits[9] = $data[5];
                            $hits[10] = $data[6];
                            $hits[11] = $data[7];
                            break;

                        case "september":
                            $hits[0] = $data[9];
                            $hits[1] = $data[10];
                            $hits[2] = $data[11];
                            $hits[3] = $data[0];
                            $hits[4] = $data[1];
                            $hits[5] = $data[2];
                            $hits[6] = $data[3];
                            $hits[7] = $data[4];
                            $hits[8] = $data[5];
                            $hits[9] = $data[6];
                            $hits[10] = $data[7];
                            $hits[11] = $data[8];
                            break;

                        case "october":
                            $hits[0] = $data[10];
                            $hits[1] = $data[11];
                            $hits[2] = $data[0];
                            $hits[3] = $data[1];
                            $hits[4] = $data[2];
                            $hits[5] = $data[3];
                            $hits[6] = $data[4];
                            $hits[7] = $data[5];
                            $hits[8] = $data[6];
                            $hits[9] = $data[7];
                            $hits[10] = $data[8];
                            $hits[11] = $data[9];
                            break;

                        case "november":
                            $hits[0] = $data[11];
                            $hits[1] = $data[0];
                            $hits[2] = $data[1];
                            $hits[3] = $data[2];
                            $hits[4] = $data[3];
                            $hits[5] = $data[4];
                            $hits[6] = $data[5];
                            $hits[7] = $data[6];
                            $hits[8] = $data[7];
                            $hits[9] = $data[8];
                            $hits[10] = $data[9];
                            $hits[11] = $data[10];
                            break;

                        case "december":
                            $hits[0] = $data[0];
                            $hits[1] = $data[1];
                            $hits[2] = $data[2];
                            $hits[3] = $data[3];
                            $hits[4] = $data[4];
                            $hits[5] = $data[5];
                            $hits[6] = $data[6];
                            $hits[7] = $data[7];
                            $hits[8] = $data[8];
                            $hits[9] = $data[9];
                            $hits[10] = $data[10];
                            $hits[11] = $data[11];
                            break;
                    }
                    return $hits;

                }
                else
                    return "no_data";

                break;

            default:
                return "no_data";
                break;
        }
    }

    function created_urls_chart($time)
    {
        switch ($time) {

            case "weekly":

                $this->db->where("YEARWEEK(`creation_date`, 1) = YEARWEEK(CURDATE(), 1)");

                $query = $this->db->get("shorten_urls");
                if ($query !== false && $query->num_rows() > 0)
                {

                    $result = $query->result_array();
                    $data = array(
                        "0"=>array(0,"Monday"),
                        "1"=>array(0,"Tuesday"),
                        "2"=>array(0,"Wednesday"),
                        "3"=>array(0,"Thursday"),
                        "4"=>array(0,"Friday"),
                        "5"=>array(0,"Saturday"),
                        "6"=>array(0,"Sunday")
                    );

                    foreach ($result as $q)
                    {
                        $date = strtotime($q["creation_date"]);
                        $day = strtolower(date("l",$date));
                        switch ($day)
                        {
                            case "monday":
                                $data["0"]["0"]++;
                                break;
                            case "tuesday":
                                $data["1"]["0"]++;
                                break;
                            case "wednesday":
                                $data["2"]["0"]++;
                                break;
                            case "thursday":
                                $data["3"]["0"]++;
                                break;
                            case "friday":
                                $data["4"]["0"]++;
                                break;
                            case "saturday":
                                $data["5"]["0"]++;
                                break;
                            case "sunday":
                                $data["6"]["0"]++;
                                break;
                        }
                    }

                    return $data;
                }
                else
                    return "no_data";

                break;

            case "monthly":
                $this->db->where("YEAR(creation_date)='".date("Y")."'AND MONTH(creation_date)='".date("m")."'");

                $query = $this->db->get("shorten_urls");
                if ($query !== false && $query->num_rows() > 0)
                {

                    $result = $query->result_array();
                    $data = array();
                    $year = date("Y");
                    $month = date("m");

                    for ($d = 1; $d <= 31; $d++)
                    {
                        $time=mktime(12, 0, 0, $month, $d, $year);
                        if (date('m', $time)==$month)
                            $data[]= array(0, date('d', $time));
                    }

                    foreach ($result as $q)
                    {
                        $date = strtotime($q["creation_date"]);
                        $day = strtolower(date("d",$date));
                        $data[$day - 1]["0"]++;
                    }

                    return $data;
                }
                else
                    return "no_data";

                break;

            case 'yearly':

                $this->db->where("DATE(creation_date) > (NOW() - INTERVAL 12 MONTH)");
                $query = $this->db->get("shorten_urls");
                if ($query !== false && $query->num_rows() > 0)
                {

                    $result = $query->result_array();
                    $data = array (
                        "0"=>array(0,"January"),
                        "1"=>array(0,"February"),
                        "2"=>array(0,"March"),
                        "3"=>array(0,"April"),
                        "4"=>array(0,"May"),
                        "5"=>array(0,"June"),
                        "6"=>array(0,"July"),
                        "7"=>array(0,"August"),
                        "8"=>array(0,"Septemper"),
                        "9"=>array(0,"October"),
                        "10"=>array(0,"November"),
                        "11"=>array(0,"December"),
                    );

                    foreach ($result as $q)
                    {
                        $date = strtotime($q["creation_date"]);
                        $month = strtolower(date("F",$date));
                        switch ($month)
                        {
                            case "january":
                                $data["0"]["0"]++;
                                break;
                            case "february":
                                $data["1"]["0"]++;
                                break;
                            case "march":
                                $data["2"]["0"]++;
                                break;
                            case "april":
                                $data["3"]["0"]++;
                                break;
                            case "may":
                                $data["4"]["0"]++;
                                break;
                            case "june":
                                $data["5"]["0"]++;
                                break;
                            case "july":
                                $data["6"]["0"]++;
                                break;
                            case "august":
                                $data["7"]["0"]++;
                                break;
                            case "september":
                                $data["8"]["0"]++;
                                break;
                            case "october":
                                $data["9"]["0"]++;
                                break;
                            case "november":
                                $data["10"]["0"]++;
                                break;
                            case "december":
                                $data["11"]["0"]++;
                                break;
                        }
                    }

                    $hits = array();
                    switch (strtolower(date("F")))
                    {
                        case "january":
                            $hits[0] = $data[1];
                            $hits[1] = $data[2];
                            $hits[2] = $data[3];
                            $hits[3] = $data[4];
                            $hits[4] = $data[5];
                            $hits[5] = $data[6];
                            $hits[6] = $data[7];
                            $hits[7] = $data[8];
                            $hits[8] = $data[9];
                            $hits[9] = $data[10];
                            $hits[10] = $data[11];
                            $hits[11] = $data[0];
                            break;

                        case "february":
                            $hits[0] = $data[2];
                            $hits[1] = $data[3];
                            $hits[2] = $data[4];
                            $hits[3] = $data[5];
                            $hits[4] = $data[6];
                            $hits[5] = $data[7];
                            $hits[6] = $data[8];
                            $hits[7] = $data[9];
                            $hits[8] = $data[10];
                            $hits[9] = $data[11];
                            $hits[10] = $data[0];
                            $hits[11] = $data[1];
                            break;

                        case "march":
                            $hits[0] = $data[3];
                            $hits[1] = $data[4];
                            $hits[2] = $data[5];
                            $hits[3] = $data[6];
                            $hits[4] = $data[7];
                            $hits[5] = $data[8];
                            $hits[6] = $data[9];
                            $hits[7] = $data[10];
                            $hits[8] = $data[11];
                            $hits[9] = $data[0];
                            $hits[10] = $data[1];
                            $hits[11] = $data[2];
                            break;

                        case "april":
                            $hits[0] = $data[4];
                            $hits[1] = $data[5];
                            $hits[2] = $data[6];
                            $hits[3] = $data[7];
                            $hits[4] = $data[8];
                            $hits[5] = $data[9];
                            $hits[6] = $data[10];
                            $hits[7] = $data[11];
                            $hits[8] = $data[0];
                            $hits[9] = $data[1];
                            $hits[10] = $data[2];
                            $hits[11] = $data[3];
                            break;

                        case "may":
                            $hits[0] = $data[5];
                            $hits[1] = $data[6];
                            $hits[2] = $data[7];
                            $hits[3] = $data[8];
                            $hits[4] = $data[9];
                            $hits[5] = $data[10];
                            $hits[6] = $data[11];
                            $hits[7] = $data[0];
                            $hits[8] = $data[1];
                            $hits[9] = $data[2];
                            $hits[10] = $data[3];
                            $hits[11] = $data[4];
                            break;

                        case "june":
                            $hits[0] = $data[6];
                            $hits[1] = $data[7];
                            $hits[2] = $data[8];
                            $hits[3] = $data[9];
                            $hits[4] = $data[10];
                            $hits[5] = $data[11];
                            $hits[6] = $data[0];
                            $hits[7] = $data[1];
                            $hits[8] = $data[2];
                            $hits[9] = $data[3];
                            $hits[10] = $data[4];
                            $hits[11] = $data[5];
                            break;

                        case "july":
                            $hits[0] = $data[7];
                            $hits[1] = $data[8];
                            $hits[2] = $data[9];
                            $hits[3] = $data[10];
                            $hits[4] = $data[11];
                            $hits[5] = $data[0];
                            $hits[6] = $data[1];
                            $hits[7] = $data[2];
                            $hits[8] = $data[3];
                            $hits[9] = $data[4];
                            $hits[10] = $data[5];
                            $hits[11] = $data[6];
                            break;

                        case "august":
                            $hits[0] = $data[8];
                            $hits[1] = $data[9];
                            $hits[2] = $data[10];
                            $hits[3] = $data[11];
                            $hits[4] = $data[0];
                            $hits[5] = $data[1];
                            $hits[6] = $data[2];
                            $hits[7] = $data[3];
                            $hits[8] = $data[4];
                            $hits[9] = $data[5];
                            $hits[10] = $data[6];
                            $hits[11] = $data[7];
                            break;

                        case "september":
                            $hits[0] = $data[9];
                            $hits[1] = $data[10];
                            $hits[2] = $data[11];
                            $hits[3] = $data[0];
                            $hits[4] = $data[1];
                            $hits[5] = $data[2];
                            $hits[6] = $data[3];
                            $hits[7] = $data[4];
                            $hits[8] = $data[5];
                            $hits[9] = $data[6];
                            $hits[10] = $data[7];
                            $hits[11] = $data[8];
                            break;

                        case "october":
                            $hits[0] = $data[10];
                            $hits[1] = $data[11];
                            $hits[2] = $data[0];
                            $hits[3] = $data[1];
                            $hits[4] = $data[2];
                            $hits[5] = $data[3];
                            $hits[6] = $data[4];
                            $hits[7] = $data[5];
                            $hits[8] = $data[6];
                            $hits[9] = $data[7];
                            $hits[10] = $data[8];
                            $hits[11] = $data[9];
                            break;

                        case "november":
                            $hits[0] = $data[11];
                            $hits[1] = $data[0];
                            $hits[2] = $data[1];
                            $hits[3] = $data[2];
                            $hits[4] = $data[3];
                            $hits[5] = $data[4];
                            $hits[6] = $data[5];
                            $hits[7] = $data[6];
                            $hits[8] = $data[7];
                            $hits[9] = $data[8];
                            $hits[10] = $data[9];
                            $hits[11] = $data[10];
                            break;

                        case "december":
                            $hits[0] = $data[0];
                            $hits[1] = $data[1];
                            $hits[2] = $data[2];
                            $hits[3] = $data[3];
                            $hits[4] = $data[4];
                            $hits[5] = $data[5];
                            $hits[6] = $data[6];
                            $hits[7] = $data[7];
                            $hits[8] = $data[8];
                            $hits[9] = $data[9];
                            $hits[10] = $data[10];
                            $hits[11] = $data[11];
                            break;
                    }
                    return $hits;

                }
                else
                    return "no_data";

                break;

            default:
                return "no_data";
                break;
        }
    }

    function registered_users($time)
    {
        switch ($time) {
            case 'today':
                $this->db->where("YEAR(register_date)='".date("Y")."'AND MONTH(register_date)='".date("m")."' AND DAY(register_date)='".date("d")."'");
                break;
            case 'all':
                break;
            case 'weekly':
                $this->db->where("YEARWEEK(`register_date`, 1) = YEARWEEK(CURDATE(), 1)");
                break;
            case 'monthly':
                $this->db->where("YEAR(register_date)='".date("Y")."'AND MONTH(register_date)='".date("m")."'");
                break;
            case 'yearly':
                $this->db->where("DATE(register_date) > (NOW() - INTERVAL 12 MONTH)");
                break;
            default:
                return 0;
                break;
        }

        $query = $this->db->get("users");
        if ($query !== false && $query->num_rows() > 0)
        {
            return $query->num_rows();
        }
        else
            return 0;
    }

    function created_urls($time)
    {
        switch ($time) {
            case 'today':
                $this->db->where("YEAR(creation_date)='".date("Y")."'AND MONTH(creation_date)='".date("m")."' AND DAY(creation_date)='".date("d")."'");
                break;
            case 'all':
                break;
            case 'weekly':
                $this->db->where("YEARWEEK(`creation_date`, 1) = YEARWEEK(CURDATE(), 1)");
                break;
            case 'monthly':
                $this->db->where("YEAR(creation_date)='".date("Y")."'AND MONTH(creation_date)='".date("m")."'");
                break;
            case 'yearly':
                $this->db->where("DATE(creation_date) > (NOW() - INTERVAL 12 MONTH)");
                break;
            default:
                return 0;
                break;
        }

        $query = $this->db->get("shorten_urls");
        if ($query !== false && $query->num_rows() > 0)
        {
            return $query->num_rows();
        }
        else
            return 0;
    }
}