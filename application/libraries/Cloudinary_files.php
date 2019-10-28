<?php

require APPPATH . 'third_party/cloudinary/Cloudinary.php';
require APPPATH . 'third_party/cloudinary/Uploader.php';
require APPPATH . 'third_party/cloudinary/Api.php';

class Cloudinary_files
{
    
    public function saveFile($file, $public_id)
    {
        $cloudinaryImage = \Cloudinary\Uploader::upload($file, array(
            "public_id" => $public_id
        ));
        return $cloudinaryImage;
    }

    // public function saveFile($file, $public_id)
    // {

    //     // $_POST['file'] = $file;
    //     // $_POST['public_id'] = $public_id;
    //     $url = getenv('cloudinary_url') . getenv('cloud_name') . '/image/upload';
    //     $api_key = getenv('api_key');
    //     $api_secret = getenv('api_secret');
    //     // $_POST['api_key'] = $api_key;
    //     $timestamp = time();
    //     // $_POST['timestamp'] = $timestamp;
    //     // $_POST['signature']  = sha1(`public_id=$public_id&timestamp=$timestamp$api_key`);
    //     // var_dump('public_id='.$public_id.'&timestamp='.$timestamp.''.$api_key);
    //     $signature  = sha1('public_id='.$public_id.'&timestamp='.$timestamp.''.$api_secret);
    //     $data = array(
    //         'file' => $file,
    //         'api_key' => $api_key,
    //         'timestamp' => $timestamp,
    //         'public_id' => $public_id,
    //         'signature' => $signature
    //     );

    //     // var_dump('timestamp ' . $data['timestamp'] . 'public_id ' . $data['public_id'] . 'sign ' . $data['signature']);
    //     $ch = curl_init($url);
    //     $postString = http_build_query($data);
    //     // var_dump($postString);
    //     // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: multipart/form-data'));
    //     curl_setopt($ch, CURLOPT_POST, 1);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $response = curl_exec($ch);
    //     curl_close($ch);
    //     return $response;
    // }
    // public function saveFile($file, $public_id)
    // {

    //     // $_POST['file'] = $file;
    //     // $_POST['public_id'] = $public_id;
    //     $url = getenv('cloudinary_url') . getenv('cloud_name') . '/image/upload';
    //     $api_key = getenv('api_key');
    //     // $_POST['api_key'] = $api_key;
    //     $timestamp = time();
    //     // $_POST['timestamp'] = $timestamp;
    //     // $_POST['signature']  = sha1(`public_id=$public_id&timestamp=$timestamp$api_key`);
    //     $signature  = sha1(`public_id=$public_id&timestamp=$timestamp$api_key`);
    //     $data = array(
    //         'file' => $file,
    //         'api_key' => $api_key,
    //         'timestamp' => $timestamp,
    //         'public_id' => $public_id,
    //         'signature' => $signature
    //     );
    //     var_dump($data);
    //     var_dump(http_build_query($data));
    //     // print_r($data);

    //     // use key 'http' even if you send the request to https://...
    //     $options = array(
    //         'http' => array(
    //             'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
    //             'method'  => 'POST',
    //             'content' => http_build_query($data)
    //         )
    //     );
    //     $context  = stream_context_create($options);
    //     // $result = file_get_contents($url, false, $context);
    //     $result = fopen($url, 'r', false, $context);
    //     return $result;
    // }
}//end class
