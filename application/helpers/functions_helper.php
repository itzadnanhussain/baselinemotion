<?php
defined('BASEPATH') or exit('No direct script access allowed');

///GetFileContents
if (!function_exists('GetFileContents')) {
    function GetFileContents($userid)
    {
        $file = $_SERVER["DOCUMENT_ROOT"] . '/patientjsonobj/' . $userid . '/results.json';
        // echo '<pre>';
        // print_r($file);
        // echo '</pre>';
        // die;
        $data = json_decode(file_get_contents($file), true);
        $data =  json_decode($data);
        if ($data != false) {
            return $data;
        } else {
            return 0;
        }
    }
}


///GetAuthToken
if (!function_exists('GetAuthToken')) {
    function GetAuthToken()
    {
        $curl = curl_init();
        ///login into api 
        curl_setopt_array($curl, array(
            CURLOPT_URL => KINETISENSE_API_URL . "/api/KinetisenseLogin",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"username\": \"" . KINETISENSE_LOGIN_USERNAME . "\",\n  \"password\": \"" . KINETISENSE_LOGIN_PASSWORD . "\",\n  \"version\": \"1\"\n}",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "zumo-api-version: 2.0.0"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $datauser = json_decode($response);
        return  $datauser->mobileServiceAuthenticationToken;
    }
}


////GetPatient
if (!function_exists('GetPatient')) {
    function GetPatient($token = null)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/tables/Patient",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "x-zumo-auth: " . $token,
                "zumo-api-version: 2.0.0"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return json_decode($response);
    }
}


///GetPatientAssessments
if (!function_exists('GetPatientAssessments')) {
    function GetPatientAssessments($token = null, $patientid = null)
    {
        $curl = curl_init();
        ///login into api 
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/api/GetPatientAssessments?patientId=" . $patientid,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "x-zumo-auth: " . $token,
                "zumo-api-version: 2.0.0"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl); 
        curl_close($curl);
        return json_decode($response);
    }
}



///GetPractitioner
if (!function_exists('GetPractitioner')) {
    function GetPractitioner($token = null)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/tables/Practitioner",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "x-zumo-auth: " . $token,
                "zumo-api-version: 2.0.0"
            ),
        ));


        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return json_decode($response);
    }
}


///GetClinic
if (!function_exists('GetClinic')) {
    function GetClinic($token = null)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://kinetisensecloudwestusapp.azurewebsites.net/tables/Clinic",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "x-zumo-auth: " . $token,
                "zumo-api-version: 2.0.0"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return json_decode($response);
    }
}


///CronInformationEmail
if (!function_exists('CronInformationEmail')) {
    function CronInformationEmail()
    { 
        $thiz=&get_instance(); 
        // Mail config
        $to = 'divyesh@foundersapproach.com';
       // $to='muhammadshaoor1707276@gmail.com';
        $from = 'no-reply@baselinemotion.com';
        $mailSubject = 'Cron Call'; 
        // Mail content
        $mailContent = '<h3>Dear, Admin</h3><p>Cron is just fired now. Please check it out.</p><br/><br/><p>Thanks<br/>The Baseline Motion Team</p>';

        $config['mailtype'] = 'html';
        $thiz->email->initialize($config);
        $thiz->email->to($to);
        $thiz->email->from($from);
        $thiz->email->subject($mailSubject);
        $thiz->email->message($mailContent);
        // Send email & return status
        return $thiz->email->send() ? true : false;

    }
}


///TestEmail
if(!function_exists('TestEmail'))
{
    function TestEmail()
    {
        $thiz=&get_instance();
        $to='observedeep@gmail.com';
        $from = 'no-reply@baselinemotion.com';
        $mailSubject = 'Cron Call'; 
        // Mail content
        $mailContent = '<h3>Dear, Admin</h3><p>Cron is just fired now. Please check it out.</p><br/><br/><p>Thanks<br/>The Baseline Motion Team</p>';

        $config['mailtype'] = 'html';
        $thiz->email->initialize($config);
        $thiz->email->to($to);
        $thiz->email->from($from);
        $thiz->email->subject($mailSubject);
        $thiz->email->message($mailContent);
        // Send email & return status
        return $thiz->email->send() ? true : false;
    }
}


////DateFormat
if (!function_exists('DateFormat')) {
    function DateFormat($intDate)
    {
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $intDate);
        $createdate = $date->format('m-d-Y h:i a');
        return $createdate;
    }
}
