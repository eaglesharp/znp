<?php



namespace App\Helpers;



use Request;



class MiscHelper

{



    public static function getLangQueryStr()

    {

        $queryString = '?lang=';

        if (!empty(Request::getQueryString())) {

            parse_str(Request::getQueryString(), $queryStringArray);

            if (Request::has('lang'))

                unset($queryStringArray['lang']);

            $queryString = http_build_query($queryStringArray);

            $queryString = (empty($queryString)) ? '?lang=' : '?' . $queryString . '&lang=';

        }

        return $queryString;

    }



    public static function getLang($lang = '')

    {

        if (Request::has('lang')) :

            $lang = Request::query('lang');

        endif;

        return ($lang != '') ? $lang : config('default_lang');

    }


    public static function gettime()
    {
        $array = ['9:00 PM' => '9:00 PM', '10:00 PM' => '10:00 PM', '11:00 PM' => '11:00 PM', '12:00 AM' => '12:00 AM', '1:00 AM' => '1:00 AM', '2:00 AM' => '2:00 AM', '3:00 AM' => '3:00 AM', '4:00 AM' => '4:00 AM', '5:00 AM' => '5:00 AM', '6:00 AM' => '6:00 AM'];
        return $array;
    }
    public static function getLangDirection($lang = '')

    {

        $lang = ($lang != '') ? $lang : config('default_lang');

        $arr = \App\Language::select('languages.iso_code')->where('is_rtl', '=', 1)->active()->pluck('languages.iso_code')->toArray(); //array('ar', 'az', 'dv', 'he', 'ku', 'fa', 'ur');

        $direction = 'ltr';

        if (Request::has('lang') && in_array(Request::query('lang'), $arr)):

            $direction = 'rtl';

        elseif (in_array($lang, $arr)):

            $direction = 'rtl';

        endif;

        return $direction;

    }



    public static function getNumOffices()

    {

        $array = ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20'];

        return $array;

    }



    public static function getNumPositions()

    {

        $array = ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30'];

        return $array;

    }



    public static function getNumEmployees()

    {

        $array = ['1-10' => '1-10', '11-50' => '11-50', '51-100' => '51-100', '101-200' => '101-200', '201-300' => '201-300', '301-600' => '301-600', '601-1000' => '601-1000', '1001-1500' => '1001-1500', '1501-2000' => '1501-2000', '2001-2500' => '2001-2500', '2501-3000' => '2501-3000', '3001-3500' => '3001-3500', '3501-4000' => '3501-4000', '4001-4500' => '4001-4500', '4501-5000' => '4501-5000', '5000+' => '5000+'];

        return $array;

    }



    public static function getEstablishedIn()

    {

        $array = array();

        for ($counter = date('Y'); $counter > 1917; $counter--) {

            $array[$counter] = $counter;

        }

        return $array;

    }



    public static function getSalaryDD()

    {

        $array = ['5000' => '5,000', '6000' => '6,000', '7000' => '7,000', '8000' => '8,000', '9000' => '9,000', '10000' => '10,000', '11000' => '11,000', '12000' => '12,000', '13000' => '13,000', '14000' => '14,000', '15000' => '15,000', '16000' => '16,000', '17000' => '17,000', '18000' => '18,000', '19000' => '19,000', '20000' => '20,000', '25000' => '25,000', '30000' => '30,000', '35000' => '35,000', '40000' => '40,000', '45000' => '45,000', '50000' => '50,000', '60000' => '60,000', '70000' => '70,000', '80000' => '80,000', '90000' => '90,000', '100000' => '100,000', '125000' => '125,000', '150000' => '150,000', '175000' => '175,000', '200000' => '200,000', '250000' => '250,000', '300000' => '300,000', '350000' => '350,000', '400000' => '400,000', '450000' => '450,000', '500000' => '500,000', '550000' => '550,000', '600000' => '600,000', '600001' => '600,000+'];

        return $array;

    }



    public static function getCcExpiryYears()

    {

        $array = array();

        for ($counter = date('Y'); $counter < date('Y') + 50; $counter++) {

            $array[$counter] = $counter;

        }

        return $array;

    }

    public static function getthousand()

    {

    

    $array=['0 Thousand'=>'0 Thousand','10 Thousand'=>'10 Thousand','20 Thousand'=>'20 Thousand','30 Thousand'=>'30 Thousand','40 Thousand'=>'40 Thousand','50 Thousand'=>'50 Thousand','60 Thousand'=>'60 Thousand','70 Thousand'=>'70 Thousand','80 Thousand'=>'80 Thousand','90 Thousand'=>'90 Thousand'];

    return $array;

    

    

    }

    public static function getthousandno()

    {

    

    $array=['0 Thousand'=>'0 Thousand','10 Thousand'=>'10 Thousand','20 Thousand'=>'20 Thousand','30 Thousand'=>'30 Thousand','40 Thousand'=>'40 Thousand','50 Thousand'=>'50 Thousand','60 Thousand'=>'60 Thousand','70 Thousand'=>'70 Thousand','80 Thousand'=>'80 Thousand','90 Thousand'=>'90 Thousand'];

    return $array;

    

    

    }

    

    public static function getlakhs()

    {

    

    $array=['0 Lakh'=>'0 Lakh','1 Lakh'=>'1 Lakh','2 Lakhs'=>'2 Lakhs','3 Lakhs'=>'3 Lakhs','4 Lakhs'=>'4 Lakhs','5 Lakhs'=>'5 Lakhs','6 Lakhs'=>'6 Lakhs','7 Lakhs'=>'7 Lakhs','8 Lakhs'=>'8 Lakhs','9 Lakhs'=>'9 Lakhs','10 Lakhs'=>'10 Lakhs','11 Lakhs'=>'11 Lakhs','12 Lakhs'=>'12 Lakhs','13 Lakhs'=>'13 Lakhs','14 Lakhs'=>'14 Lakhs','15 Lakhs'=>'15 Lakhs','16 Lakhs'=>'16 Lakhs','17 Lakhs'=>'17 Lakhs','18 Lakhs'=>'18 Lakhs','19 Lakhs'=>'19 Lakhs','20 Lakhs'=>'20 Lakhs','21 Lakhs'=>'21 Lakhs','22 Lakhs'=>'22 Lakhs','23 Lakhs'=>'23 Lakhs','24 Lakhs'=>'24 Lakhs','25 Lakhs'=>'25 Lakhs','26 Lakhs'=>'26 Lakhs','27 Lakhs'=>'27 Lakhs','28 Lakhs'=>'28 Lakhs','29 Lakhs'=>'29 Lakhs','30+ Lakhs'=>'30+ Lakhs','40+ Lakhs'=>'40+ Lakhs','50+ Lakhs'=>'50+ Lakhs',];

    return $array;

    

    

    }

    

    

    public static function getmonths()

    {

    

    $array=['Jan'=>'Jan','Feb'=>'Feb','Mar'=>'Mar','Apr'=>'Apr','May'=>'May','Jun'=>'Jun','Jul','Aug'=>'Aug','Sep'=>'Sep','Oct'=>'Oct','Nov'=>'Nov','Dec'=>'Dec'];

    return $array;

    

    }

    public static function getduration()

    {

    

    $array=['1 Month'=>'1 Month','2 Months'=>'2 Months','3 Months'=>'3 Months','6 Months'=>'6 Months','9 Months'=>'9 Months','1 Year'=>'1 Year','2 Years'=>'2 Years','3 Years'=>'3 Years'];

    return $array;

    

    

    }

    

    public static function getexperience()

    {

    

    $array=[
        '6 Months'=>'6 Months',
        '1 Year'=>'1 Year',
        '2 Years'=>'2 Years',
        '3 Years'=>'3 Years',
        '4 Years'=>'4 Years',
        '5 Years'=>'5 Years',
        '6 Years'=>'6 Years',
        '7 Years'=>'7 Years',
        '8 Years'=>'8 Years',
        '9 Years'=>'9 Years',
        '10 Years'=>'10 Years',
        '11 Years'=>'11 Years',
        '12 Years'=>'12 Years',
        '13 Years'=>'13 Years',
        '14 Years'=>'14 Years',
        '15 Years'=>'15 Years',
        '16 Years'=>'16 Years',
        '17 Years'=>'17 Years',
        '18 Years'=>'18 Years',
        '19 Years'=>'19 Years',
        '20 Years'=>'20 Years',
        '21 Year'=>'21 Year',
        '22 Years'=>'22 Years',
        '23 Years'=>'23 Years',
        '24 Years'=>'24 Years',
        '25 Years'=>'25 Years',
        '26 Years'=>'26 Years',
        '27 Years'=>'27 Years',
        '28 Years'=>'28 Years',
        '29 Years'=>'29 Years',
        '30 Years'=>'30 Years',
        ];

    return $array;

    

    

    }

    

    public static function getprojectduration()

    {

        $array=['1 Month'=>'1 Month','2 Months'=>'2 Months','3 Months'=>'3 Months','6 Months'=>'6 Months','9 Months'=>'9 Months','1 Year'=>'1 Year','2 Years'=>'2 Years','3 Years'=>'3 Years','4+ Years'=>'4+ Years'];

        return $array;

    

    

    }

    

    public static function getprojecttype()

    {

        $array=['Onsite'=>'Onsite','Offsite'=>'Offsite'];

        return $array;

    

    

    }

    

    public static function getuniversity()

    {

    $array=array (

        0 => 'AAFT University of Media and Arts',

        1 => 'Abhilashi University',

        2 => 'Academy of Maritime Education and Training',

        3 => 'Acharya N. G. Ranga Agricultural University',

        4 => 'Acharya N.G. Ranga Agricultural University',

        5 => 'Acharya Nagarjuna University',

        6 => 'Adamas University',

        7 => 'Adesh University',

        8 => 'Adichunchanagiri University',

        9 => 'Adikavi Nannaya University',

        10 => 'Ahmedabad University',

        11 => 'AIPH University',

        12 => 'AISECT University, Jharkhand',

        13 => 'Ajeenkya D.Y. Patil University',

        14 => 'Akal University',

        15 => 'AKS University',

        16 => 'Alagappa University',

        17 => 'Alakh Prakash Goyal Shimla University',

        18 => 'Alakh Prakash Goyal University',

        19 => 'Al-Falah University',

        20 => 'Aliah University',

        21 => 'Aligarh Muslim University',

        22 => 'Alipurduar University',

        23 => 'Al-Karim University',

        24 => 'All India Institute of Medical Sciences Bhopal',

        25 => 'All India Institute of Medical Sciences Bhubaneswar',

        26 => 'All India Institute of Medical Sciences Delhi',

        27 => 'All India Institute of Medical Sciences Jodhpur',

        28 => 'All India Institute of Medical Sciences Patna',

        29 => 'All India Institute of Medical Sciences Raipur',

        30 => 'All India Institute of Medical Sciences Rishikesh',

        31 => 'Allahabad State University',

        32 => 'Alliance University',

        33 => 'Ambedkar University Delhi',

        34 => 'Amity University',

        35 => 'Amity University, Gurgaon',

        36 => 'Amity University, Gwalior',

        37 => 'Amity University, Jaipur',

        38 => 'Amity University, Jharkhand',

        39 => 'Amity University, Kolkata',

        40 => 'Amity University, Mumbai',

        41 => 'Amity University, Noida',

        42 => 'Amity University, Patna',

        43 => 'Amity University, Raipur',

        44 => 'Amrita Vishwa Vidyapeetham',

        45 => 'Anand Agricultural University',

        46 => 'Anant National University',

        47 => 'Andhra University',

        48 => 'Anna University',

        49 => 'Annamalai University',

        50 => 'Ansal University',

        51 => 'Anurag University',

        52 => 'Apeejay Stya University',

        53 => 'Apex Professional University',

        54 => 'Apex University',

        55 => 'APJ Abdul Kalam Technological University',

        56 => 'Arka Jain University',

        57 => 'Arni University',

        58 => 'Arunachal University of Studies',

        59 => 'Arunodaya University',

        60 => 'Aryabhatta Knowledge University',

        61 => 'ASBM University',

        62 => 'Ashoka University',

        63 => 'Assam Agricultural University',

        64 => 'Assam Don Bosco University',

        65 => 'Assam Down Town University',

        66 => 'Assam Rajiv Gandhi University of Cooperative Management',

        67 => 'Assam Science and Technology University',

        68 => 'Assam University',

        69 => 'Assam Women\'s University',

        70 => 'Atal Bihari Vajpayee Hindi Vishwavidyalaya',

        71 => 'Atal Bihari Vajpayee Vishwavidyalaya',

        72 => 'Atmiya University',

        73 => 'AURO University',

        74 => 'Avantika University',

        75 => 'Avinashilingam Institute for Home Science and Higher Education for Women',

        76 => 'Avinashilingam University',

        77 => 'Awadhesh Pratap Singh University',

        78 => 'Ayush and Health Sciences University of Chhattisgarh',

        79 => 'Azim Premji University',

        80 => 'B.S. Abdur Rahman Crescent Institute of Science and Technology',

        81 => 'Baba Farid University of Health Sciences',

        82 => 'Baba Ghulam Shah Badhshah University',

        83 => 'Baba Ghulam Shah Badshah University',

        84 => 'Baba Mast Nath University',

        85 => 'Baba Mastnath University',

        86 => 'Babasaheb Bhimrao Ambedkar Bihar University',

        87 => 'Babasaheb Bhimrao Ambedkar University',

        88 => 'Babu Banarasi Das University',

        89 => 'Baddi University of Emerging Sciences and Technologies',

        90 => 'BAHRA University',

        91 => 'Banaras Hindu University',

        92 => 'Banasthali Vidyapith',

        93 => 'Banda University of Agriculture and Technology',

        94 => 'Bangalore University',

        95 => 'Bankura University',

        96 => 'Bareilly International University',

        97 => 'Barkatullah University',

        98 => 'Bastar Vishwavidyalaya',

        99 => 'Bengaluru North University',

        100 => 'Bennett University',

        101 => 'Berhampur University',

        102 => 'Bhabha University',

        103 => 'Bhagat Phool Singh Mahila Vishwavidyalaya',

        104 => 'Bhagwant University',

        105 => 'Bhakta Kavi Narsinh Mehta University',

        106 => 'Bharath Institute of Higher Education and Research',

        107 => 'Bharathiar University',

        108 => 'Bharathidasan University',

        109 => 'Bharati Vidyapeeth',

        110 => 'Bharati Vidyapeeth Deemed University',

        111 => 'Bhartiya Skill Development University',

        112 => 'Bhatkhande Music Institute',

        113 => 'Bhattadev University',

        114 => 'Bhupal Nobles University',

        115 => 'Bhupendra Narayan Mandal University',

        116 => 'Bidhan Chandra Krishi Vishwavidyalaya',

        117 => 'Bidhan Chandra Krishi Viswavidyalaya',

        118 => 'Bihar Agricultural University',

        119 => 'Biju Patnaik University of Technology',

        120 => 'Binod Bihari Mahto Koyalanchal University',

        121 => 'Birla Global University',

        122 => 'Birla Institute of Technology',

        123 => 'Birla Institute of Technology and Science',

        124 => 'Birla Institute of Technology, Mesra',

        125 => 'Birsa Agricultural University',

        126 => 'Biswa Bangla Biswabidyalay',

        127 => 'BLDE',

        128 => 'BLDE University',

        129 => 'BML Munjal University',

        130 => 'Bodoland University',

        131 => 'Brainware University',

        132 => 'Bundelkhand University',

        133 => 'C. U. Shah University',

        134 => 'C.U. Shah University',

        135 => 'Capital University, Jharkhand',

        136 => 'Career Point University',

        137 => 'Career Point University, Hamirpur',

        138 => 'Central Agricultural University',

        139 => 'Central Institute of Fisheries Education',

        140 => 'Central Institute of Higher Tibetan Studies',

        141 => 'Central Sanskrit University',

        142 => 'Central Tribal University of Andhra Pradesh',

        143 => 'Central University of Andhra Pradesh',

        144 => 'Central University of Gujarat',

        145 => 'Central University of Haryana',

        146 => 'Central University of Himachal Pradesh',

        147 => 'Central University of Jammu',

        148 => 'Central University of Jharkhand',

        149 => 'Central University of Karnataka',

        150 => 'Central University of Kashmir',

        151 => 'Central University of Kerala',

        152 => 'Central University of Odisha',

        153 => 'Central University of Punjab',

        154 => 'Central University of Rajasthan',

        155 => 'Central University of South Bihar',

        156 => 'Central University of Tamil Nadu',

        157 => 'Centurion University of Technology and Management',

        158 => 'Centurion University of Technology and Management, Andhra Pradesh',

        159 => 'CEPT University',

        160 => 'Chanakya National Law University',

        161 => 'Chandigarh University',

        162 => 'Chandra Shekhar Azad University of Agriculture and Technology',

        163 => 'Charotar University of Science and Technology',

        164 => 'Chaudhary Bansi Lal University',

        165 => 'Chaudhary Charan Singh Haryana Agricultural University',

        166 => 'Chaudhary Charan Singh University',

        167 => 'Chaudhary Devi Lal University',

        168 => 'Chaudhary Ranbir Singh University',

        169 => 'Chaudhary Sarwan Kumar Himachal Pradesh Krishi Vishvavidyalaya',

        170 => 'Chennai Mathematical Institute',

        171 => 'Chettinad Academy of Research and Education',

        172 => 'Chhatrapati Shahu Ji Maharaj University',

        173 => 'Chhattisgarh Kamdhenu Vishwavidyalaya',

        174 => 'Chhattisgarh Swami Vivekanand Technical University',

        175 => 'Chhattisgarh Swami Vivekananda Technical University',

        176 => 'Children\'s University',

        177 => 'Chitkara University, Himachal Pradesh',

        178 => 'Chitkara University, Punjab',

        179 => 'Christ',

        180 => 'Christ University',

        181 => 'Cluster University of Jammu',

        182 => 'Cluster University of Srinagar',

        183 => 'CMJ University',

        184 => 'CMR University',

        185 => 'Cochin University of Science and Technology',

        186 => 'Cooch Behar Panchanan Barma University',

        187 => 'Cotton University',

        188 => 'CSK Himachal Pradesh Krishi Vishvavidyalaya',

        189 => 'CT University, Punjab',

        190 => 'D. Y. Patil Education Society',

        191 => 'Dakshina Bharat Hindi Prachar Sabha',

        192 => 'Damodaram Sanjivayya National Law University',

        193 => 'Datta Meghe Institute of Medical Sciences',

        194 => 'DAV University',

        195 => 'Davangere University',

        196 => 'Dayalbagh Educational Institute',

        197 => 'Dayananda Sagar University',

        198 => 'Deccan College Post-Graduate and Research Institute',

        199 => 'Deen Dayal Upadhyay Gorakhpur University',

        200 => 'Deenbandhu Chhotu Ram University of Science and Technology',

        201 => 'Defence Institute of Advanced Technology',

        202 => 'Delhi Pharmaceutical Science and Research University',

        203 => 'Delhi Pharmaceutical Sciences and Research University',

        204 => 'Delhi Skill and Entrepreneurship University',

        205 => 'Delhi Technological University',

        206 => 'Desh Bhagat University',

        207 => 'Dev Sanskriti Vishwavidyalaya',

        208 => 'Devi Ahilya Vishwavidyalaya',

        209 => 'Dharamsinh Desai University',

        210 => 'Dharmsinh Desai University',

        211 => 'Dhirubhai Ambani Institute of Information and Communication Technology',

        212 => 'Diamond Harbour Women\'s University',

        213 => 'Dibrugarh University',

        214 => 'DIT University',

        215 => 'Doon University',

        216 => 'Dr K.N. Modi University',

        217 => 'Dr. A.P.J Abdul Kalam University',

        218 => 'Dr. A.P.J. Abdul Kalam Technical University',

        219 => 'Dr. A.P.J. Abdul Kalam University',

        220 => 'Dr. Abdul Haq Urdu University',

        221 => 'Dr. B R Ambedkar National Institute of Technology Jalandhar',

        222 => 'Dr. B. R. Ambedkar University',

        223 => 'Dr. B.R. Ambedkar Open University',

        224 => 'Dr. B.R. Ambedkar University',

        225 => 'Dr. B.R. Ambedkar University of Social Sciences',

        226 => 'Dr. B.R. Ambedkar University, Srikakulam',

        227 => 'Dr. Babasaheb Ambedkar Marathwada University',

        228 => 'Dr. Babasaheb Ambedkar Open University',

        229 => 'Dr. Babasaheb Ambedkar Technological University',

        230 => 'Dr. Balasaheb Sawant Konkan Krishi Vidyapeeth',

        231 => 'Dr. Bhimrao Ambedkar University',

        232 => 'Dr. C.V. Raman University',

        233 => 'Dr. C.V. Raman University, Bihar',

        234 => 'Dr. C.V. Raman University, Khandwa',

        235 => 'Dr. D. Y. Patil Vidyapeeth',

        236 => 'Dr. D.Y. Patil Vidyapeeth',

        237 => 'Dr. Hari Singh Gour University',

        238 => 'Dr. K.N.Modi University',

        239 => 'Dr. M.G.R. Educational and Research Institute',

        240 => 'Dr. N.T.R. University of Health Sciences',

        241 => 'Dr. NTR University of Health Sciences',

        242 => 'Dr. Panjabrao Deshmukh Krishi Vidyapeeth',

        243 => 'Dr. Rajendra Prasad Central Agricultural University',

        244 => 'Dr. Rajendra Prasad Central Agriculture University',

        245 => 'Dr. Ram Manohar Lohia Avadh University',

        246 => 'Dr. Ram Manohar Lohiya National Law University',

        247 => 'Dr. Sarvepalli Radhakrishnan Rajasthan Ayurved University',

        248 => 'Dr. Shakuntala Misra National Rehabilitation University',

        249 => 'Dr. Shyama Prasad Mukherjee University',

        250 => 'Dr. Vishwanath Karad MIT World Peace University',

        251 => 'Dr. Y.S. Parmar University of Horticulture and Forestry',

        252 => 'Dr. Y.S.R. Horticultural University',

        253 => 'Dr. Yashwant Singh Parmar University of Horticulture and Forestry',

        254 => 'Dravidian University',

        255 => 'Durg Vishwavidyalaya',

        256 => 'EIILM University',

        257 => 'English and Foreign Languages University',

        258 => 'Era University',

        259 => 'Eternal University',

        260 => 'Fakir Mohan University',

        261 => 'Flame University',

        262 => 'Forest Research Institute',

        263 => 'G. B. Pant University of Agriculture and Technology',

        264 => 'G.H. Raisoni University',

        265 => 'G.L.S. University',

        266 => 'Galgotias University',

        267 => 'Gandhi Institute of Technology and Management',

        268 => 'Gandhigram Rural Institute',

        269 => 'Gandhigram Rural University',

        270 => 'Gangadhar Meher University',

        271 => 'Ganpat University',

        272 => 'Garden City University',

        273 => 'Gauhati University',

        274 => 'Gautam Buddha University',

        275 => 'GD Goenka University',

        276 => 'Geetanjali University',

        277 => 'GIET University',

        278 => 'GLA University',

        279 => 'Glocal University',

        280 => 'GLS University',

        281 => 'GNA University',

        282 => 'Goa University',

        283 => 'Gokhale Institute of Politics and Economics',

        284 => 'Gokul Global University',

        285 => 'Gondwana University',

        286 => 'Gopal Narayan Singh University',

        287 => 'Govind Ballabh Pant University of Agriculture and Technology',

        288 => 'Govind Guru Tribal University',

        289 => 'Graphic Era',

        290 => 'Graphic Era Hill University',

        291 => 'Graphic Era University',

        292 => 'GSFC University',

        293 => 'Gujarat Ayurved University',

        294 => 'Gujarat Forensic Sciences University',

        295 => 'Gujarat Maritime University',

        296 => 'Gujarat National Law University',

        297 => 'Gujarat Technological University',

        298 => 'Gujarat University',

        299 => 'Gujarat University of Transplantation Sciences',

        300 => 'Gujarat Vidyapith',

        301 => 'Gulbarga University',

        302 => 'Guru Angad Dev Veterinary and Animal Sciences University',

        303 => 'Guru Ghasidas Vishwavidyalaya',

        304 => 'Guru Gobind Singh Indraprastha University',

        305 => 'Guru Jambheshwar University of Science and Technology',

        306 => 'Guru Kashi University',

        307 => 'Guru Nanak Dev University',

        308 => 'Guru Ravidas Ayurved University',

        309 => 'Gurukul Kangri Vishwavidyalaya',

        310 => 'Harcourt Butler Technical University',

        311 => 'Haridev Joshi University of Journalism and Mass Communication',

        312 => 'Hemchandracharya North Gujarat University',

        313 => 'Hemwati Nandan Bahuguna Garhwal University',

        314 => 'Hemwati Nandan Bahuguna Uttarakhand Medical Education University',

        315 => 'Hidayatullah National Law University',

        316 => 'Himachal Pradesh Technical University',

        317 => 'Himachal Pradesh University',

        318 => 'Himalayan Garhwal University',

        319 => 'Himalayan University',

        320 => 'Himgiri ZEE University',

        321 => 'Hindustan Institute of Technology and Science',

        322 => 'Homi Bhabha National Institute',

        323 => 'Homoeopathy University',

        324 => 'I. K. Gujral Punjab Technical University',

        325 => 'ICFAI Foundation for Higher Education',

        326 => 'ICFAI University, Dehradun',

        327 => 'ICFAI University, Himachal Pradesh',

        328 => 'ICFAI University, Jaipur',

        329 => 'ICFAI University, Jharkhand',

        330 => 'ICFAI University, Meghalaya',

        331 => 'ICFAI University, Mizoram',

        332 => 'ICFAI University, Nagaland',

        333 => 'ICFAI University, Raipur',

        334 => 'ICFAI University, Sikkim',

        335 => 'ICFAI University, Tripura',

        336 => 'IEC University',

        337 => 'IFHE Hyderabad',

        338 => 'IFTM University',

        339 => 'IIHMR University',

        340 => 'IILM University',

        341 => 'IIMT University',

        342 => 'IIS',

        343 => 'IMS Unison University',

        344 => 'Indian Agricultural Research Institute',

        345 => 'Indian Institute of Engineering Science and Technology, Shibpur',

        346 => 'Indian Institute of Foreign Trade',

        347 => 'Indian Institute of Information Technology Allahabad',

        348 => 'Indian Institute of Information Technology and Management Gwalior',

        349 => 'Indian Institute of Information Technology, Design and Manufacturing',

        350 => 'Indian Institute of Information Technology, Guwahati',

        351 => 'Indian Institute of Information Technology, Kalyani',

        352 => 'Indian Institute of Information Technology, Kottayam',

        353 => 'Indian Institute of Information Technology, Lucknow',

        354 => 'Indian Institute of Information Technology, Manipur',

        355 => 'Indian Institute of Information Technology, Pune',

        356 => 'Indian Institute of Information Technology, Sri City',

        357 => 'Indian Institute of Information Technology, Una',

        358 => 'Indian Institute of Information Technology, Vadodara',

        359 => 'Indian Institute of Public Health',

        360 => 'Indian Institute of Public Health, Gandhinagar',

        361 => 'Indian Institute of Science',

        362 => 'Indian Institute of Science Education and Research, Bhopal',

        363 => 'Indian Institute of Science Education and Research, Kolkata',

        364 => 'Indian Institute of Science Education and Research, Mohali',

        365 => 'Indian Institute of Science Education and Research, Pune',

        366 => 'Indian Institute of Science Education and Research, Thiruvananthapuram',

        367 => 'Indian Institute of Space Science and Technology',

        368 => 'Indian Institute of Teacher Education',

        369 => 'Indian Institute of Technology Bhubaneswar',

        370 => 'Indian Institute of Technology Bombay',

        371 => 'Indian Institute of Technology Delhi',

        372 => 'Indian Institute of Technology Gandhinagar',

        373 => 'Indian Institute of Technology Guwahati',

        374 => 'Indian Institute of Technology Hyderabad',

        375 => 'Indian Institute of Technology Indore',

        376 => 'Indian Institute of Technology Jodhpur',

        377 => 'Indian Institute of Technology Kanpur',

        378 => 'Indian Institute of Technology Kharagpur',

        379 => 'Indian Institute of Technology Madras',

        380 => 'Indian Institute of Technology Mandi',

        381 => 'Indian Institute of Technology Patna',

        382 => 'Indian Institute of Technology Roorkee',

        383 => 'Indian Institute of Technology Ropar',

        384 => 'Indian Institute of Technology, BHU',

        385 => 'Indian Law Institute',

        386 => 'Indian Maritime University',

        387 => 'Indian School of Mines',

        388 => 'Indian Statistical Institute',

        389 => 'Indian Veterinary Research Institute',

        390 => 'Indira Gandhi Delhi Technical University for Women',

        391 => 'Indira Gandhi Institute of Development Research',

        392 => 'Indira Gandhi Institute of Medical Sciences',

        393 => 'Indira Gandhi Krishi Vishwavidyalaya',

        394 => 'Indira Gandhi National Open University',

        395 => 'Indira Gandhi National Tribal University',

        396 => 'Indira Gandhi Technological and Medical Sciences University',

        397 => 'Indira Gandhi University Meerpur, Rewari',

        398 => 'Indira Gandhi University, Meerpur',

        399 => 'Indira Kala Sangeet Vishwavidyalaya',

        400 => 'Indraprastha Institute of Information Technology',

        401 => 'Indraprastha Institute of Information Technology, Delhi',

        402 => 'Indrashil University',

        403 => 'Indus International University',

        404 => 'Indus University',

        405 => 'Institute of Advanced Research',

        406 => 'Institute of Advanced Studies in Education',

        407 => 'Institute of Chartered Financial Analysts of India University, Meghalaya',

        408 => 'Institute of Chartered Financial Analysts of India University, Mizoram',

        409 => 'Institute of Chartered Financial Analysts of India University, Nagaland',

        410 => 'Institute of Chartered Financial Analysts of India University, Sikkim',

        411 => 'Institute of Chartered Financial Analysts of India University, Tripura',

        412 => 'Institute of Chemical Technology',

        413 => 'Institute of Infrastructure Technology Research and Management',

        414 => 'Institute of Infrastructure, Technology, Research and Management',

        415 => 'Institute of Liver and Biliary Sciences',

        416 => 'Institute of Trans-Disciplinary Health Sciences and Technology',

        417 => 'Integral University',

        418 => 'International Institute for Population Sciences',

        419 => 'International Institute of Information Technology Bangalore',

        420 => 'International Institute of Information Technology, Bangalore',

        421 => 'International Institute of Information Technology, Bhubaneswar',

        422 => 'International Institute of Information Technology, Hyderabad',

        423 => 'International Institute of Information Technology, Naya Raipur',

        424 => 'Invertis University',

        425 => 'ISBM University',

        426 => 'Islamic University of Science & Technology',

        427 => 'Islamic University of Science and Technology',

        428 => 'ITM University Gwalior',

        429 => 'ITM University Raipur',

        430 => 'ITM University, Gwalior',

        431 => 'ITM University, Raipur',

        432 => 'ITM Vocational University',

        433 => 'J.C. Bose University of Science and Technology',

        434 => 'Jadavpur University',

        435 => 'Jagadguru Ramanandacharya Rajasthan Sanskrit University',

        436 => 'Jagadguru Rambhadracharya Handicapped University',

        437 => 'Jagan Nath University',

        438 => 'Jagannath University',

        439 => 'Jagran Lakecity University',

        440 => 'Jai Narain Vyas University',

        441 => 'Jai Prakash University',

        442 => 'Jai Prakash Vishwavidyalaya',

        443 => 'Jain University',

        444 => 'Jain Vishva Bharati Institute',

        445 => 'Jaipur National University',

        446 => 'Jamia Hamdard',

        447 => 'Jamia Millia Islamia',

        448 => 'Jananayak Chandrashekhar University',

        449 => 'Janardan Rai Nagar Rajasthan Vidhyapeeth University',

        450 => 'Janardan Rai Nagar Rajasthan Vidyapeeth',

        451 => 'Jawaharlal Institute of Postgraduate Medical Education and Research',

        452 => 'Jawaharlal Nehru Architecture and Fine Arts University',

        453 => 'Jawaharlal Nehru Centre for Advanced Scientific Research',

        454 => 'Jawaharlal Nehru Krishi Vishwa Vidyalaya',

        455 => 'Jawaharlal Nehru Krishi Vishwavidyalaya',

        456 => 'Jawaharlal Nehru Technological University',

        457 => 'Jawaharlal Nehru Technological University, Anantapur',

        458 => 'Jawaharlal Nehru Technological University, Hyderabad',

        459 => 'Jawaharlal Nehru Technological University, Kakinada',

        460 => 'Jawaharlal Nehru University',

        461 => 'Jayoti Vidyapeeth Women\'s University',

        462 => 'Jaypee Institute of Information Technology',

        463 => 'Jaypee University Anoopshahr',

        464 => 'Jaypee University of Engineering and Technology',

        465 => 'Jaypee University of Information Technology',

        466 => 'JECRC University',

        467 => 'Jharkhand Rai University',

        468 => 'Jharkhand Raksha Shakti University',

        469 => 'Jharkhand University of Technology',

        470 => 'JIS University',

        471 => 'Jiwaji University',

        472 => 'JK Lakshmipat University',

        473 => 'Jodhpur National University',

        474 => 'JS University',

        475 => 'JSS Academy of Higher Education & Research',

        476 => 'JSS Academy of Higher Education and Research',

        477 => 'JSS Science and Technology University',

        478 => 'Junagadh Agricultural University',

        479 => 'K L University',

        480 => 'K. K. University',

        481 => 'K.K. University',

        482 => 'K.R. Mangalam University',

        483 => 'Kadi Sarva Vishwavidyalaya',

        484 => 'Kakatiya University',

        485 => 'Kalahandi University',

        486 => 'Kalasalingam Academy of Research and Education',

        487 => 'Kalinga Institute of Industrial Technology',

        488 => 'Kalinga University',

        489 => 'Kamdhenu University',

        490 => 'Kameshwar Singh Darbhanga Sanskrit University',

        491 => 'Kannada University',

        492 => 'Kannur University',

        493 => 'Kanyashree University',

        494 => 'Karnatak University',

        495 => 'Karnataka Folklore University',

        496 => 'Karnataka Janapada Vishwavidyalaya',

        497 => 'Karnataka Samskrit University',

        498 => 'Karnataka State Dr. Gangubhai Hangal Music and Performing Arts University',

        499 => 'Karnataka State Law University',

        500 => 'Karnataka State Open University',

        501 => 'Karnataka State Rural Development and Panchayat Raj University',

        502 => 'Karnataka State Women\'s University',

        503 => 'Karnataka Veterinary, Animal and Fisheries Sciences University',

        504 => 'Karnavati University',

        505 => 'Karpagam Academy of Higher Education',

        506 => 'Karunya Institute of Technology and Sciences',

        507 => 'Kavayitri Bahinabai Chaudhari North Maharashtra University',

        508 => 'Kavi Kulguru Kalidas Sanskrit Vishwavidyalaya',

        509 => 'Kavikulaguru Kalidas Sanskrit University',

        510 => 'Kazi Nazrul University',

        511 => 'Kaziranga University',

        512 => 'Kerala Agricultural University',

        513 => 'Kerala Kalamandalam',

        514 => 'Kerala University of Digital Sciences, Innovation and Technology',

        515 => 'Kerala University of Fisheries and Ocean Studies',

        516 => 'Kerala University of Health Sciences',

        517 => 'Kerala Veterinary and Animal Sciences University',

        518 => 'Khaja Bandanawaz University',

        519 => 'Khallikote University',

        520 => 'Khallikote University Berhampur',

        521 => 'Khwaja Moinuddin Chishti Language University',

        522 => 'Khwaja Moinuddin Chishti Urdu, Arabi-Pharsi University',

        523 => 'KIIT University',

        524 => 'King George\'s Medical University',

        525 => 'KLE Academy of Higher Education & Research',

        526 => 'KLE Technological University',

        527 => 'KLE University',

        528 => 'Kolhan University',

        529 => 'Koneru Lakshmaiah Education Foundation',

        530 => 'Krantiguru Shyamji Krishna Verma Kachchh University',

        531 => 'Krea University',

        532 => 'Krishna Institute of Medical Sciences',

        533 => 'Krishna Kanta Handiqui State Open University',

        534 => 'Krishna University',

        535 => 'Krishnaguru Adhyatmik Vishvavidyalaya',

        536 => 'KSGH Music and Performing Arts University',

        537 => 'Kumar Bhaskar Varma Sanskrit and Ancient Studies University',

        538 => 'Kumaun University',

        539 => 'Kurukshetra University',

        540 => 'Kushabhau Thakre Patrakarita Avam Jansanchar University',

        541 => 'Kushabhau Thakre Patrakarita Avam Jansanchar Vishwavidyalaya',

        542 => 'Kuvempu University',

        543 => 'Lakshmibai National Institute of Physical Education',

        544 => 'Lakulish Yoga University',

        545 => 'Lala Lajpat Rai University of Veterinary and Animal Sciences',

        546 => 'Lalit Narayan Mithila University',

        547 => 'Lingaya\'s University',

        548 => 'Lingaya\'s Vidyapeeth',

        549 => 'LNCT University',

        550 => 'LNM Institute of Information Technology',

        551 => 'Lovely Professional University',

        552 => 'M. J. P. Rohilkhand University',

        553 => 'M. S. Ramaiah University of Applied Sciences',

        554 => 'M.J.P. Rohilkhand University',

        555 => 'Madan Mohan Malaviya University of Technology',

        556 => 'Madhabdev University',

        557 => 'Madhav University',

        558 => 'Madhusudan Law University',

        559 => 'Madhya Pradesh Bhoj Open University',

        560 => 'Madhya Pradesh Medical Science University',

        561 => 'Madhyanchal Professional University',

        562 => 'Madurai Kamaraj University',

        563 => 'Magadh University',

        564 => 'Mahapurusha Srimanta Sankaradeva Viswavidyalaya',

        565 => 'Maharaja Agrasen University',

        566 => 'Maharaja Bir Bikram University',

        567 => 'Maharaja Chhatrasal Bundelkhand University',

        568 => 'Maharaja Ganga Singh University',

        569 => 'Maharaja Krishnakumarsinhji Bhavnagar University',

        570 => 'Maharaja Ranjit Singh Punjab Technical University',

        571 => 'Maharaja Sayajirao University of Baroda',

        572 => 'Maharaja Sriram Chandra Bhanja Deo University',

        573 => 'Maharaja Surajmal Brij University',

        574 => 'Maharaja Surajmal Brij University, Bharatpur',

        575 => 'Maharana Pratap University of Agriculture and Technology',

        576 => 'Maharashtra Animal and Fishery Sciences University',

        577 => 'Maharashtra National Law University Mumbai',

        578 => 'Maharashtra National Law University, Aurangabad',

        579 => 'Maharashtra National Law University, Mumbai',

        580 => 'Maharashtra National Law University, Nagpur',

        581 => 'Maharashtra University of Health Sciences',

        582 => 'Maharishi Arvind University, Jaipur',

        583 => 'Maharishi Dayanand University',

        584 => 'Maharishi Mahesh Yogi Vedic Vishwavidyalaya',

        585 => 'Maharishi Markandeshwar',

        586 => 'Maharishi Markandeshwar University, Mullana',

        587 => 'Maharishi Markandeshwar University, Sadopur',

        588 => 'Maharishi Markandeshwar University, Solan',

        589 => 'Maharishi Panini Sanskrit Evam Vedic Vishwavidyalaya',

        590 => 'Maharishi University',

        591 => 'Maharishi University of Management and Technology',

        592 => 'Maharshi Dayanand Saraswati University',

        593 => 'Maharshi Dayanand University',

        594 => 'Maharshi Panini Sanskrit Vishwavidyalaya',

        595 => 'Mahatma Gandhi Antarrashtriya Hindi Vishwavidyalaya',

        596 => 'Mahatma Gandhi Central University',

        597 => 'Mahatma Gandhi Central University, Motihari',

        598 => 'Mahatma Gandhi Chitrakoot Gramoday Vishwavidyalaya',

        599 => 'Mahatma Gandhi Kashi Vidyapeeth',

        600 => 'Mahatma Gandhi Kashi Vidyapith',

        601 => 'Mahatma Gandhi University',

        602 => 'Mahatma Gandhi University of Medical Sciences and Technology',

        603 => 'Mahatma Gandhi University, Meghalaya',

        604 => 'Mahatma Gandhi University, Nalgonda',

        605 => 'Mahatma Gandhi University, West Bengal',

        606 => 'Mahatma Jyoti Rao Phoole University',

        607 => 'Mahatma Phule Krishi Vidyapeeth',

        608 => 'Mahindra University',

        609 => 'Majuli University of Culture',

        610 => 'Makhanlal Chaturvedi Rashtriya Patrakarita Avam Sanchar Vishwavidyalaya',

        611 => 'Makhanlal Chaturvedi Rashtriya Patrakarita Vishwavidyalaya',

        612 => 'Malaviya National Institute of Technology, Jaipur',

        613 => 'Malla Reddy University',

        614 => 'Malwanchal University',

        615 => 'Manav Bharti University',

        616 => 'Manav Rachna International Institute of Research and Studies',

        617 => 'Manav Rachna University',

        618 => 'Mandsaur University',

        619 => 'Mangalayatan University',

        620 => 'Mangalore University',

        621 => 'Manipal Academy of Higher Education',

        622 => 'Manipal University Jaipur',

        623 => 'Manipur International University',

        624 => 'Manipur Technical University',

        625 => 'Manipur University',

        626 => 'Manipur University of Culture',

        627 => 'Manonmaniam Sundaranar University',

        628 => 'Martin Luther Christian University',

        629 => 'Marwadi University',

        630 => 'Mata Gujri University',

        631 => 'MATS University',

        632 => 'Maulana Abul Kalam Azad University of Technology',

        633 => 'Maulana Abul Kalam Azad University of Technology, West Bengal',

        634 => 'Maulana Azad National Institute of Technology',

        635 => 'Maulana Azad National Urdu University',

        636 => 'Maulana Azad University, Jodhpur',

        637 => 'Maulana Mazharul Haque Arabic and Persian University',

        638 => 'Medi-Caps University',

        639 => 'Meenakshi Academy of Higher Education and Research',

        640 => 'Mewar University',

        641 => 'MGM Institute of Health Sciences',

        642 => 'MIT - World Peace University',

        643 => 'MIT ADT University',

        644 => 'MIT Art Design and Technology University',

        645 => 'MIT University',

        646 => 'Mizoram University',

        647 => 'Mody University of Science and Technology',

        648 => 'Mohammad Ali Jauhar University',

        649 => 'Mohanlal Sukhadia University',

        650 => 'Monad University',

        651 => 'Mother Teresa Women\'s University',

        652 => 'Motherhood University',

        653 => 'Motilal Nehru National Institute of Technology Allahabad',

        654 => 'Munger University',

        655 => 'MVN University',

        656 => 'Nagaland University',

        657 => 'Nalanda Open University',

        658 => 'Nalanda University',

        659 => 'NALSAR University of Law',

        660 => 'Nanaji Deshmukh Veterinary Science University',

        661 => 'Narendra Dev University of Agriculture and Technology',

        662 => 'Narendra Deva University of Agriculture and Technology',

        663 => 'Narsee Monjee Institute of Management and Higher Studies',

        664 => 'Narsee Monjee Institute of Management Studies',

        665 => 'National Brain Research Centre',

        666 => 'National Dairy Research Institute',

        667 => 'National Institute of Design',

        668 => 'National Institute of Educational Planning and Administration',

        669 => 'National Institute of Fashion Technology',

        670 => 'National Institute of Food Technology Entrepreneurship and Management',

        671 => 'National Institute of Mental Health and Neuro Sciences',

        672 => 'National Institute of Pharmaceutical Education and Research, Ahmedabad',

        673 => 'National Institute of Pharmaceutical Education and Research, Guwahati',

        674 => 'National Institute of Pharmaceutical Education and Research, Hajipur',

        675 => 'National Institute of Pharmaceutical Education and Research, Hyderabad',

        676 => 'National Institute of Pharmaceutical Education and Research, Kolkata',

        677 => 'National Institute of Pharmaceutical Education and Research, Rae Bareli',

        678 => 'National Institute of Pharmaceutical Education and Research, S.A.S. Nagar',

        679 => 'National Institute of Technology, Agartala',

        680 => 'National Institute of Technology, Arunachal Pradesh',

        681 => 'National Institute of Technology, Calicut',

        682 => 'National Institute of Technology, Delhi',

        683 => 'National Institute of Technology, Durgapur',

        684 => 'National Institute of Technology, Goa',

        685 => 'National Institute of Technology, Hamirpur',

        686 => 'National Institute of Technology, Jamshedpur',

        687 => 'National Institute of Technology, Karnataka',

        688 => 'National Institute of Technology, Kurukshetra',

        689 => 'National Institute of Technology, Manipur',

        690 => 'National Institute of Technology, Meghalaya',

        691 => 'National Institute of Technology, Mizoram',

        692 => 'National Institute of Technology, Nagaland',

        693 => 'National Institute of Technology, Patna',

        694 => 'National Institute of Technology, Puducherry',

        695 => 'National Institute of Technology, Raipur',

        696 => 'National Institute of Technology, Rourkela',

        697 => 'National Institute of Technology, Sikkim',

        698 => 'National Institute of Technology, Silchar',

        699 => 'National Institute of Technology, Srinagar',

        700 => 'National Institute of Technology, Tiruchirappalli',

        701 => 'National Institute of Technology, Uttarakhand',

        702 => 'National Institute of Technology, Warangal',

        703 => 'National Law Institute University',

        704 => 'National Law School of India University',

        705 => 'National Law University and Judicial Academy',

        706 => 'National Law University and Judicial Academy, Assam',

        707 => 'National Law University Odisha',

        708 => 'National Law University, Delhi',

        709 => 'National Law University, Jodhpur',

        710 => 'National Museum Institute of the History of Art, Conservation and Museology',

        711 => 'National Sanskrit University',

        712 => 'National Sports University',

        713 => 'National University of Advanced Legal Studies',

        714 => 'National University of Study and Research in Law',

        715 => 'Nava Nalanda Mahavihara',

        716 => 'Navrachana University',

        717 => 'Navsari Agricultural University',

        718 => 'Nehru Gram Bharati',

        719 => 'Nehru Gram Bharati Vishwavidyalaya',

        720 => 'Neotia University',

        721 => 'Netaji Subhas Open University',

        722 => 'Netaji Subhas University',

        723 => 'Netaji Subhas University of Technology',

        724 => 'NIILM University',

        725 => 'NIIT University',

        726 => 'Nilamber-Pitamber University',

        727 => 'NIMS University',

        728 => 'Nirma University',

        729 => 'NITTE',

        730 => 'NITTE University',

        731 => 'Nizam\'s Institute of Medical Sciences',

        732 => 'Noida International University',

        733 => 'Noorul Islam Centre for Higher Education',

        734 => 'North East Frontier Technical University',

        735 => 'North Eastern Hill University',

        736 => 'North Eastern Regional Institute of Science and Technology',

        737 => 'North Maharashtra University',

        738 => 'North Orissa University',

        739 => 'O. P. Jindal Global University',

        740 => 'O.P. Jindal Global University',

        741 => 'O.P. Jindal University',

        742 => 'Odisha State Open University',

        743 => 'Odisha University of Agriculture and Technology',

        744 => 'OPJS University',

        745 => 'Oriental University',

        746 => 'Osmania University',

        747 => 'P P Savani University',

        748 => 'P.K. University',

        749 => 'Pacific Medical University',

        750 => 'Pacific University',

        751 => 'Pacific University, India',

        752 => 'Padmashree Dr. D. Y. Patil Vidyapeeth',

        753 => 'Padmashree Dr. D.Y. Patil Vidyapith',

        754 => 'Palamuru University',

        755 => 'Pandit Bhagwat Dayal Sharma University of Health Sciences',

        756 => 'Pandit Deendayal Energy University',

        757 => 'Pandit Deendayal Petroleum University',

        758 => 'Pandit Deendayal Upadhyaya Shekhawati University',

        759 => 'Pandit Ravishankar Shukla University',

        760 => 'Pandit Sundarlal Sharma (Open) University',

        761 => 'Panjab University',

        762 => 'Panjab University[note 11]',

        763 => 'Parul University',

        764 => 'Patliputra University',

        765 => 'Patna University',

        766 => 'PDM University',

        767 => 'PDPM Indian Institute of Information Technology, Design and Manufacturing',

        768 => 'PEC University of Technology',

        769 => 'People\'s University',

        770 => 'Periyar Maniammai Institute of Science & Technology',

        771 => 'Periyar Maniammai Institute of Science and Technology',

        772 => 'Periyar University',

        773 => 'PES University',

        774 => 'Plaksha University',

        775 => 'Plastindia International University',

        776 => 'Pondicherry University',

        777 => 'Ponnaiyah Ramajayam Institute of Science and Technology',

        778 => 'Ponnaiyan Ramajayam Institute of Science and Technology',

        779 => 'Poornima University',

        780 => 'Post Graduate Institute of Medical Education and Research',

        781 => 'Potti Sreeramulu Telugu University',

        782 => 'Pragyan International University',

        783 => 'Pratap University',

        784 => 'Pravara Institute of Medical Sciences',

        785 => 'Presidency University',

        786 => 'Presidency University, Kolkata',

        787 => 'Professor Jayashankar Telangana State Agricultural University',

        788 => 'Pt. Bhagwat Dayal Sharma University of Health Sciences',

        789 => 'Pt. Deendayal Upadhyay Memorial Health Sciences and Ayush University of Chhattisgarh',

        790 => 'Punjab Agricultural University',

        791 => 'Punjab Engineering College',

        792 => 'Punjab Technical University',

        793 => 'Punjabi University',

        794 => 'Punjabi University Patiala',

        795 => 'Punyashlok Ahilyadevi Holkar University, Solapur',

        796 => 'Purnea University',

        797 => 'Quantum University',

        798 => 'Rabindra Bharati University',

        799 => 'Rabindranath Tagore University',

        800 => 'Rabindranath Tagore University, Hojai',

        801 => 'Radha Govind University',

        802 => 'Raffles University',

        803 => 'Rai Technology University',

        804 => 'Rai University',

        805 => 'Raiganj University',

        806 => 'Raj Rishi Bharthari Matsya University',

        807 => 'Raj Rishi Bhartrihari Matsya University',

        808 => 'Raja Mansingh Tomar Music & Arts University',

        809 => 'Raja Mansingh Tomar Music and Arts University',

        810 => 'Rajasthan Technical University',

        811 => 'Rajasthan Technical University Kota',

        812 => 'Rajasthan University of Health Sciences',

        813 => 'Rajasthan University of Veterinary and Animal Sciences',

        814 => 'Rajendra Agricultural University',

        815 => 'Rajendra Narayan University',

        816 => 'Rajiv Gandhi Institute of Petroleum Technology',

        817 => 'Rajiv Gandhi National Aviation University',

        818 => 'Rajiv Gandhi National Institute of Youth Development',

        819 => 'Rajiv Gandhi National University of Law',

        820 => 'Rajiv Gandhi Proudyogiki Vishwavidyalaya',

        821 => 'Rajiv Gandhi University',

        822 => 'Rajiv Gandhi University of Health Sciences',

        823 => 'Rajiv Gandhi University of Knowledge Technologies',

        824 => 'Rajmata Vijayaraje Scindia Krishi Vishwa Vidyalaya',

        825 => 'Rajmata Vijayaraje Scindia Krishi Vishwavidyalaya',

        826 => 'Raksha Shakti University',

        827 => 'Rama Devi Women\'s University',

        828 => 'Rama University',

        829 => 'Ramaiah University of Applied Sciences',

        830 => 'Ramakrishna Mission Vivekananda Educational and Research Institute',

        831 => 'Ranchi University',

        832 => 'Rani Channamma University, Belagavi',

        833 => 'Rani Durgavati Vishwavidyalaya',

        834 => 'Rani Lakshmi Bai Central Agricultural University',

        835 => 'Rani Rashmoni Green University',

        836 => 'Ras Bihari Bose Subharti University',

        837 => 'Rashtrasant Tukadoji Maharaj Nagpur University',

        838 => 'Rashtriya Sanskrit Sansthan University',

        839 => 'Rashtriya Sanskrit Vidyapeetha',

        840 => 'Ravenshaw University',

        841 => 'Rayalaseema University',

        842 => 'Rayat-Bahra University',

        843 => 'REVA University',

        844 => 'RIMT University',

        845 => 'Rishihood University',

        846 => 'RK University',

        847 => 'RKDF University',

        848 => 'RNB Global University',

        849 => 'Royal Global University',

        850 => 'Sabarmati University',

        851 => 'Sage University',

        852 => 'Sai Nath University',

        853 => 'Sai Tirupati University',

        854 => 'SAM Global University',

        855 => 'Sam Higginbottom Institute of Agriculture, Technology and Sciences',

        856 => 'Sambalpur University',

        857 => 'Sampurnanand Sanskrit Vishvavidyalaya',

        858 => 'Sampurnanand Sanskrit Vishwavidyalaya',

        859 => 'Sanchi University of Buddhist-Indic Studies',

        860 => 'Sandip University',

        861 => 'Sandip University, Nashik',

        862 => 'Sandip University, Sijoul',

        863 => 'Sangai International University',

        864 => 'Sangam University',

        865 => 'Sanjay Gandhi Post Graduate Institute of Medical Sciences',

        866 => 'Sanjay Ghodawat University',

        867 => 'Sankalchand Patel University',

        868 => 'Sanskriti University',

        869 => 'Sant Baba Bhag Singh University',

        870 => 'Sant Gadge Baba Amravati University',

        871 => 'Sant Longowal Institute of Engineering and Technology',

        872 => 'Santosh',

        873 => 'Santosh University',

        874 => 'Sarala Birla University',

        875 => 'Sardar Patel University',

        876 => 'Sardar Patel University of Police, Security and Criminal Justice',

        877 => 'Sardar Vallabhbhai National Institute of Technology, Surat',

        878 => 'Sardar Vallabhbhai Patel University of Agriculture and Technology',

        879 => 'Sardarkrushinagar Dantiwada Agricultural University',

        880 => 'Sardarkrushinagar Dantiwada Agricultural University[note 19]',

        881 => 'Sarguja University',

        882 => 'Sarvepalli Radhakrishnan University',

        883 => 'SASTRA University',

        884 => 'Satavahana University',

        885 => 'Sathyabama Institute of Science and Technology',

        886 => 'Saurashtra University',

        887 => 'Saveetha Amaravati University',

        888 => 'Saveetha Institute of Medical and Technical Sciences',

        889 => 'Savitribai Phule Pune University',

        890 => 'School of Planning and Architecture, Bhopal',

        891 => 'School of Planning and Architecture, Delhi',

        892 => 'School of Planning and Architecture, Vijayawada',

        893 => 'Seacom Skills University',

        894 => 'Shanmugha Arts, Science, Technology & Research Academy',

        895 => 'Sharda University',

        896 => 'Sharnbasva University',

        897 => 'Sher-e-Kashmir University of Agricultural Sciences and Technology of Jammu',

        898 => 'Sher-e-Kashmir University of Agricultural Sciences and Technology of Kashmir',

        899 => 'Sher-i-Kashmir Institute of Medical Sciences',

        900 => 'Shiv Nadar University',

        901 => 'Shivaji University',

        902 => 'Shobhit Institute of Engineering & Technology',

        903 => 'Shobhit Institute of Engineering and Technology',

        904 => 'Shobhit University',

        905 => 'Shoolini University of Biotechnology and Management Sciences',

        906 => 'Shree Guru Gobind Singh Tricentenary University',

        907 => 'Shree Somnath Sanskrit University',

        908 => 'Shreemati Nathibai Damodar Thackersey Women\'s University',

        909 => 'Shri Govind Guru University',

        910 => 'Shri Guru Ram Rai Education Mission',

        911 => 'Shri Guru Ram Rai University',

        912 => 'Shri Jagannath Sanskrit Vishvavidayalaya',

        913 => 'Shri Jagannath Sanskrit Vishvavidyalaya',

        914 => 'Shri Jagdishprasad Jhabrmal Tibrewala University',

        915 => 'Shri Khushal Das University',

        916 => 'Shri Lal Bahadur Shastri National Sanskrit University',

        917 => 'Shri Lal Bahadur Shastri Rashtriya Sanskrit Vidyapeetha',

        918 => 'Shri Mata Vaishno Devi University',

        919 => 'Shri Ramswaroop Memorial University',

        920 => 'Shri Rawatpura Sarkar University',

        921 => 'Shri Vaishnav Vidyapeeth Vishwavidyalaya',

        922 => 'Shri Venkateshwara University',

        923 => 'Shri Vishwakarma Skill University',

        924 => 'Shridhar University',

        925 => 'Siddharth University',

        926 => 'Sidho Kanho Birsha University',

        927 => 'Sido Kanhu Murmu University',

        928 => 'Sikkim Manipal University',

        929 => 'Sikkim University',

        930 => 'Siksha \'O\' Anusandhan',

        931 => 'Singhania University',

        932 => 'Sir Padampat Singhania University',

        933 => 'Sister Nivedita University',

        934 => 'SNDT Women\'s University',

        935 => 'Soban Singh Jeena University',

        936 => 'Somaiya Vidyavihar University',

        937 => 'South Asian University',

        938 => 'Spicer Adventist University',

        939 => 'SR University',

        940 => 'Sree Chitra Thirunal Institute of Medical Sciences and Technology',

        941 => 'Sree Narayanaguru Open University',

        942 => 'Sree Sankaracharya University of Sanskrit',

        943 => 'Sri Balaji Vidyapeeth',

        944 => 'Sri Chandrasekharendra Saraswathi Viswa Mahavidyalaya',

        945 => 'Sri Dev Suman Uttarakhand University',

        946 => 'Sri Devaraj Urs Academy of Higher Education and Research',

        947 => 'Sri Guru Granth Sahib World University',

        948 => 'Sri Guru Ram Das University of Health Sciences',

        949 => 'Sri Konda Laxman Telangana State Horticultural University',

        950 => 'Sri Krishnadevaraya University',

        951 => 'Sri Padmavati Mahila Visvavidyalayam',

        952 => 'Sri Ramachandra Institute of Higher Education and Research',

        953 => 'Sri Ramachandra Medical College and Research Institute',

        954 => 'Sri Sai University',

        955 => 'Sri Sathya Sai Institute of Higher Learning',

        956 => 'Sri Satya Sai University of Technology & Medical Sciences',

        957 => 'Sri Satya Sai University of Technology and Medical Sciences',

        958 => 'Sri Siddhartha Academy of Higher Education',

        959 => 'Sri Sri Aniruddhadeva Sports University',

        960 => 'Sri Sri University',

        961 => 'Sri Venkateswara Institute of Medical Sciences',

        962 => 'Sri Venkateswara University',

        963 => 'Sri Venkateswara Vedic University',

        964 => 'Sri Venkateswara Veterinary University',

        965 => 'Srimanta Sankaradeva University of Health Sciences',

        966 => 'Srinivas University',

        967 => 'SRM Institute of Science and Technology',

        968 => 'SRM University Haryana',

        969 => 'SRM University, Andhra Pradesh',

        970 => 'SRM University, Haryana',

        971 => 'SRM University, Sikkim',

        972 => 'St. Joseph University',

        973 => 'St. Peter\'s Institute of Higher Education and Research',

        974 => 'St. Xavier\'s University',

        975 => 'St. Xavier\'s University, Kolkata',

        976 => 'Starex University',

        977 => 'State University of Performing and Visual Arts',

        978 => 'Suamandeep Vidyapeeth',

        979 => 'Sumandeep Vidyapeeth',

        980 => 'Sunrise University',

        981 => 'Suresh Gyan Vihar University',

        982 => 'Sushant University',

        983 => 'Swami Keshwanand Rajasthan Agricultural University',

        984 => 'Swami Rama Himalayan University',

        985 => 'Swami Ramanand Teerth Marathwada University',

        986 => 'Swami Vivekanand Subharti University',

        987 => 'Swami Vivekanand University',

        988 => 'Swami Vivekananda Yoga Anusandhana Samsthana',

        989 => 'Swarnim Gujarat Sports University',

        990 => 'Swarnim Startup & Innovation University',

        991 => 'Swarnim Startup and Innovation University',

        992 => 'Symbiosis International',

        993 => 'Symbiosis International University',

        994 => 'Symbiosis Skills and Open University',

        995 => 'Symbiosis University of Applied Sciences',

        996 => 'Tamil Nadu Agricultural University',

        997 => 'Tamil Nadu Dr Ambedkar Law University',

        998 => 'Tamil Nadu Dr. Ambedkar Law University',

        999 => 'Tamil Nadu Dr. J. Jayalalithaa Fisheries University',

        1000 => 'Tamil Nadu Dr. M.G.R. Medical University',

        1001 => 'Tamil Nadu Dr. M.G.R.Medical University',

        1002 => 'Tamil Nadu Fisheries University',

        1003 => 'Tamil Nadu Music and Fine Arts University',

        1004 => 'Tamil Nadu National Law School',

        1005 => 'Tamil Nadu National Law University',

        1006 => 'Tamil Nadu Open University',

        1007 => 'Tamil Nadu Physical Education and Sports University',

        1008 => 'Tamil Nadu Teacher Education University',

        1009 => 'Tamil Nadu Teachers Education University',

        1010 => 'Tamil Nadu Veterinary and Animal Sciences University',

        1011 => 'Tamil University',

        1012 => 'Tantia University',

        1013 => 'Tata Institute of Fundamental Research',

        1014 => 'Tata Institute of Social Sciences',

        1015 => 'TeamLease Skills University',

        1016 => 'Techno Global University',

        1017 => 'Techno India University',

        1018 => 'Teerthanker Mahaveer University',

        1019 => 'Telangana University',

        1020 => 'TERI School of Advanced Studies',

        1021 => 'Tezpur University',

        1022 => 'Thapar Institute of Engineering and Technology',

        1023 => 'The English and Foreign Languages University',

        1024 => 'The Global Open University Nagaland',

        1025 => 'The Glocal University',

        1026 => 'The IIS University',

        1027 => 'The Indian Law Institute',

        1028 => 'The LNM Institute of Information Technology',

        1029 => 'The Maharaja Sayajirao University of Baroda',

        1030 => 'The National University of Advanced Legal Studies',

        1031 => 'The Neotia University',

        1032 => 'The Northcap University',

        1033 => 'The Sanskrit College and University',

        1034 => 'The West Bengal National University of Juridical Sciences',

        1035 => 'Thiruvalluvar University',

        1036 => 'Thunchath Ezhuthachan Malayalam University',

        1037 => 'Tilak Maharashtra Vidyapeeth',

        1038 => 'Tilka Manjhi Bhagalpur University',

        1039 => 'Tripura University',

        1040 => 'Tumkur University',

        1041 => 'U.P. Pt. Deen Dayal Upadhyay Pashu Chikitsa Vigyan Vishwavidyalaya Evam Go-Ansundhan Sansthan',

        1042 => 'U.P. Pt. Deen Dayal Upadhyaya Veterinary Science University and Cattle Research Institute',

        1043 => 'Uka Tarsadia University',

        1044 => 'University of Agricultural and Horticultural Sciences, Shivamogga',

        1045 => 'University of Agricultural Sciences, Bangalore',

        1046 => 'University of Agricultural Sciences, Dharwad',

        1047 => 'University of Agricultural Sciences, Raichur',

        1048 => 'University of Allahabad',

        1049 => 'University of Burdwan',

        1050 => 'University of Calcutta',

        1051 => 'University of Calicut',

        1052 => 'University of Delhi',

        1053 => 'University of Engineering & Management (UEM), Jaipur',

        1054 => 'University of Engineering & Management (UEM), Kolkata',

        1055 => 'University of Engineering and Management, Kolkata',

        1056 => 'University of Gour Banga',

        1057 => 'University of Horticultural Sciences, Bagalkot',

        1058 => 'University of Hyderabad',

        1059 => 'University of Jammu',

        1060 => 'University of Kalyani',

        1061 => 'University of Kashmir',

        1062 => 'University of Kerala',

        1063 => 'University of Kota',

        1064 => 'University of Lucknow',

        1065 => 'University of Madras',

        1066 => 'University of Mumbai',

        1067 => 'University of Mysore',

        1068 => 'University of North Bengal',

        1069 => 'University of Patanjali',

        1070 => 'University of Petroleum and Energy Studies',

        1071 => 'University of Rajasthan',

        1072 => 'University of Science and Technology, Meghalaya',

        1073 => 'University of Science and Technology, Meghalaya (USTM)',

        1074 => 'University of Solapur',

        1075 => 'University of Technology',

        1076 => 'University of Technology and Management',

        1077 => 'University of Trans-Disciplinary Health Sciences and Technology',

        1078 => 'Usha Martin University',

        1079 => 'Utkal University',

        1080 => 'Utkal University of Culture',

        1081 => 'Uttar Banga Krishi Viswavidyalaya',

        1082 => 'Uttar Pradesh Rajarshi Tandon Open University',

        1083 => 'Uttar Pradesh University of Medical Sciences',

        1084 => 'Uttarakhand Aawasiya Vishwavidyalaya, Almora',

        1085 => 'Uttarakhand Ayurved University',

        1086 => 'Uttarakhand Open University',

        1087 => 'Uttarakhand Sanskrit University',

        1088 => 'Uttarakhand Technical University',

        1089 => 'Uttaranchal University',

        1090 => 'Vardhaman Mahaveer Open University',

        1091 => 'Vasantrao Naik Marathwada Krishi Vidyapeeth',

        1092 => 'Veer Bahadur Singh Purvanchal University',

        1093 => 'Veer Chandra Singh Garhwali Uttarakhand University of Horticulture & Forestry',

        1094 => 'Veer Kunwar Singh University',

        1095 => 'Veer Narmad South Gujarat University',

        1096 => 'Veer Surendra Sai University of Technology',

        1097 => 'Vel Tech Rangarajan Dr. Sagunthala R&D Institute of Science and Technology',

        1098 => 'Vellore Institute of Technology',

        1099 => 'Vels Institute of Science, Technology & Advanced Studies',

        1100 => 'Vels University',

        1101 => 'Venkateshwara Open University',

        1102 => 'Vidyasagar University',

        1103 => 'Vignan University',

        1104 => 'Vignan\'s Foundation for Science, Technology & Research',

        1105 => 'Vijayanagara Sri Krishnadevaraya University',

        1106 => 'Vikram University',

        1107 => 'Vikrama Simhapuri University',

        1108 => 'Vinayaka Mission\'s Research Foundation',

        1109 => 'Vinayaka Missions Sikkim University',

        1110 => 'Vinoba Bhave University',

        1111 => 'Vishwakarma University',

        1112 => 'Visva-Bharati University',

        1113 => 'Visvesvaraya National Institute of Technology',

        1114 => 'Visvesvaraya Technological University',

        1115 => 'VIT Bhopal University',

        1116 => 'VIT-AP University',

        1117 => 'Vivekananda Global University',

        1118 => 'West Bengal National University of Juridical Sciences',

        1119 => 'West Bengal State University',

        1120 => 'West Bengal University of Animal and Fishery Sciences',

        1121 => 'West Bengal University of Health Sciences',

        1122 => 'West Bengal University of Teachers\' Training, Education Planning and Administration',

        1123 => 'William Carey University',

        1124 => 'William Carey University, Meghalaya',

        1125 => 'World University of Design',

        1126 => 'Woxsen University',

        1127 => 'Xavier University',

        1128 => 'XIM University',

        1129 => 'Yashwantrao Chavan Maharashtra Open University',

        1130 => 'YBN University',

        1131 => 'Yenepoya',

        1132 => 'Yenepoya University',

        1133 => 'YMCA University of Science and Technology',

        1134 => 'Yogi Vemana University',

        1135 => 'Other College/University',

    );

    return $array;

    

    }

    

    public static function geteducation()

    {

        $array=['Doctorate/PhD'=>'Doctorate/PhD','Masters/Post-Graduation'=>'Masters/Post-Graduation','Graudation/Diploma'=>'Graudation/Diploma','12th'=>'12th','10th'=>'10th'];

        return $array;

    

    

    }

    // public function getlanguagetypes(){

    

    // $array=["Local"=>"Local","International"=>"International"];

    // return $array;

    

    // }

    public static function getlanguagetypes()

    {

        $array=['Local'=>'Local','International'=>'International'];

        return $array;

    

    

    }

    public static function getnoptypes(){

    $array=['Verified'=>'Verified','Pending Verification'=>'Pending Verification'];

    return $array;

    

    }

    

    public static function getindustry()

    {

    

    $array=['1'=>'IT','2'=>'NON-IT'];

    return $array;

    }

    

   public static function gethand()

   {

   $array=['Yes'=>'Yes','No'=>'No'];

   return $array;

   }

   

   

   public static function gettotalexp()

   {

   $array=['0 Year'=>'0 Year','1 Year'=>'1 Year','2 Years'=>'2 Years','3 Years'=>'3 Years','4 Years'=>'4 Years','5 Years'=>'5 Years','6 Years'=>'6 Years','7 Years'=>'7 Years','8 Years'=>'8 Years','9 Years'=>'9 Years','10 Years'=>'10 Years','11 Years'=>'11 Years','12 Years'=>'12 Years','13 Years'=>'13 Years','14 Years'=>'14 Years','15 Years'=>'15 Years','16 Years'=>'16 Years','17 Years'=>'17 Years','18 Years'=>'18 Years','19 Years'=>'19 Years','20 Years'=>'20 Years','21 Years'=>'21 Years','22 Years'=>'22 Years','23 Years'=>'23 Years','24 Years'=>'24 Years','25 Years'=>'25 Years','26 Years'=>'26 Years','27 Years'=>'27 Years','28 Years'=>'28 Years','29 Years'=>'29 Years','30 Years'=>'30 Years','31 Years'=>'31 Years','32 Years'=>'32 Years','33 Years'=>'33 Years','34 Years'=>'34 Years','35 Years'=>'35 Years','36 Years'=>'36 Years','37 Years'=>'37 Years','38 Years'=>'38 Years','39 Years'=>'39 Years','40 Years'=>'40 Years','41 Years'=>'41 Years','42 Years'=>'42 Years','43 Years'=>'43 Years','44 Years'=>'44 Years','45 Years'=>'45 Years','46 Years'=>'46 Years','47 Years'=>'47 Years','48 Years'=>'48 Years','49 Years'=>'49 Years','50+ Years'=>'50+ Years'];

   

   return $array;

   

   

   }

   

   public static function getprofilemonths()

    {

        $array=['0 Month'=>'0 Month','1 Month'=>'1 Month','2 Months'=>'2 Months','3 Months'=>'3 Months','4 Months'=>'4 Months','5 Months'=>'5 Months','6 Months'=>'6 Months','7 Months'=>'7 Months','8 Months'=>'8 Months','9 Months'=>'9 Months','10 Months'=>'10 Months','11 Months'=>'11 Months'];

        return $array;

    

    

    }

    

     

   public static function getprofilemonths1()

   {

       $array=['1 Month'=>'1 Month','1 Month'=>'1 Month','2 Months'=>'2 Months','3 Months'=>'3 Months','4 Months'=>'4 Months','5 Months'=>'5 Months','6 Months'=>'6 Months','7 Months'=>'7 Months','8 Months'=>'8 Months','9 Months'=>'9 Months','10 Months'=>'10 Months','10 Months'=>'10 Months','11 Months'=>'11 Months','1 Year'=>'1 Year','2 Years'=>'2 Years','3 Years'=>'3 Years','4 Years'=>'4 Years','5 Years'=>'5 Years','6 Years'=>'6 Years','7 Years'=>'7 Years','8 Years'=>'8 Years','9 Years'=>'9 Years','10+ Years'=>'10+ Years'];

       return $array;

   

   

   }

    

    public static function getprocess()

    {

    

    $array=['Voice Process'=>'Voice Process','Non Voice Process'=>'Non Voice Process','Semi Voice Process'=>'Semi Voice Process','Not Applicable'=>'Not Applicable'];

    return $array;

    

    }

    

        



        



}

