<?php 
    // Function to generate OTP
    function generateNumericOTP($_len) 
    {
        $_numerics   = '1234567890';
        $_container = $_numerics; 
        $otp = '';
        for($i = 0; $i < $_len; $i++) 
        { 
            $_rand = rand(0, strlen($_container) - 1);
            $otp .= substr($_container, $_rand, 1);
        }
        return $otp;
    }
      

    //create time current time into timestamp using time function + 5 add minitus 
     function timestampaddmin()
    {
        $timestamp = time();
       
        $currentTime = date('h:i:s',$timestamp);
        $newDate1 = date('h:i:s', strtotime($currentTime. '+5 minutes'));

        $d = DateTime::createFromFormat('h:i:s',$newDate1);

        if($d === false) 
        {
            die("Incorrect date string");
        } 
        else 
        {
            $newtime =  $d->getTimestamp();
        }
        return $newtime;
    }

    //create time current time into timestamp using time function 
    function timestamp()
    {
        date_default_timezone_set("Asia/Kolkata");
        $t=time();
        $datenew = date("h:i:s",$t);
        $d = DateTime::createFromFormat('h:i:s',$datenew);

        if ($d === false) {
            die("Incorrect date string");
        }
        else
        {
             $newtime =  $d->getTimestamp();
        }
        return $newtime;
    }


//create time current time into timestamp using time function + 10 add minitus souce()
    function time_url_link_expire_addmin()
    {
        $timestamp = time();
       
        $currentTime = date('h:i:s',$timestamp);
        $newDate1 = date('h:i:s', strtotime($currentTime. '+15 minutes'));

        $d = DateTime::createFromFormat('h:i:s',$newDate1);

        if($d === false) 
        {
            die("Incorrect date string");
        } 
        else 
        {
            $newtime =  $d->getTimestamp();
        }
        return $newtime;
    }

function encrypt($data)
    {
    $public_key = '-----BEGIN PUBLIC KEY-----   
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC3//sR2tXw0wrC2DySx8vNGlqt
3Y7ldU9+LBLI6e1KS5lfc5jlTGF7KBTSkCHBM3ouEHWqp1ZJ85iJe59aF5gIB2kl  
Bd6h4wrbbHA2XE1sq21ykja/Gqx7/IRia3zQfxGv/qEkyGOx+XALVoOlZqDwh76o  
2n1vP1D+tD3amHsK7QIDAQAB  
-----END PUBLIC KEY-----';  
$pu_key = openssl_pkey_get_public($public_key);
if (openssl_public_encrypt($data, $encrypted, $pu_key))
            $data = base64_encode($encrypted);
        else
            throw new Exception('Unable to encrypt data. Perhaps it is bigger than the key size?');

        return $data;    
   }

    function decrypt($data)
    {
        $private_key = '-----BEGIN RSA PRIVATE KEY-----  
MIICXQIBAAKBgQC3//sR2tXw0wrC2DySx8vNGlqt3Y7ldU9+LBLI6e1KS5lfc5jl
TGF7KBTSkCHBM3ouEHWqp1ZJ85iJe59aF5gIB2klBd6h4wrbbHA2XE1sq21ykja/  
Gqx7/IRia3zQfxGv/qEkyGOx+XALVoOlZqDwh76o2n1vP1D+tD3amHsK7QIDAQAB  
AoGBAKH14bMitESqD4PYwODWmy7rrrvyFPEnJJTECLjvKB7IkrVxVDkp1XiJnGKH  
2h5syHQ5qslPSGYJ1M/XkDnGINwaLVHVD3BoKKgKg1bZn7ao5pXT+herqxaVwWs6  
ga63yVSIC8jcODxiuvxJnUMQRLaqoF6aUb/2VWc2T5MDmxLhAkEA3pwGpvXgLiWL  
3h7QLYZLrLrbFRuRN4CYl4UYaAKokkAvZly04Glle8ycgOc2DzL4eiL4l/+x/gaq  
deJU/cHLRQJBANOZY0mEoVkwhU4bScSdnfM6usQowYBEwHYYh/OTv1a3SqcCE1f+  
qbAclCqeNiHajCcDmgYJ53LfIgyv0wCS54kCQAXaPkaHclRkQlAdqUV5IWYyJ25f  
oiq+Y8SgCCs73qixrU1YpJy9yKA/meG9smsl4Oh9IOIGI+zUygh9YdSmEq0CQQC2  
4G3IP2G3lNDRdZIm5NZ7PfnmyRabxk/UgVUWdk47IwTZHFkdhxKfC8QepUhBsAHL  
QjifGXY4eJKUBm3FpDGJAkAFwUxYssiJjvrHwnHFbg0rFkvvY63OSmnRxiL4X6EY  
yI9lblCsyfpl25l7l5zmJrAHn45zAiOoBrWqpM5edu7c  
-----END RSA PRIVATE KEY-----';
        $pi_key =  openssl_pkey_get_private($private_key);

        if (openssl_private_decrypt(base64_decode($data), $decrypted, $pi_key))
        {
            $data = $decrypted;
        }
        else
        {
          $data = '';
        }
        return $data;
    }



function publickey($key)
{
    $keypara = array(
        'adminpassword' => 'X>|Rq+zvOhnY+_?7',
        'adminsessionid' => ')Pf_1R}*E><d>#*ReY%'
    );
    return $keypara[$key];
}

function encrypttext($plaintext, $encryptedkey)
{
    if(!empty(($plaintext) && ($encryptedkey)))
    {
         $encrypted_string=openssl_encrypt($plaintext,"AES-128-ECB",$encryptedkey);
        return $encrypted_string;
    }
    else
    {
        return FALSE;
    }
   
}

function decryptedtext($encryptedtext, $decryptedkey) {
   

    if(!empty(($encryptedtext) && ($decryptedkey)))
    {
        $decrypted_string=openssl_decrypt($encryptedtext,"AES-128-ECB",$decryptedkey);
        return $decrypted_string;
    }
    else
    {
        return FALSE;
    }
}

// function cookiexpiretime()
//     {
//         $timestamp = time();
       
//         $currentTime = date('h:i:s',$timestamp);
//         $newDate1 = date('h:i:s', strtotime($currentTime. '+5 minutes'));

//         $d = DateTime::createFromFormat('h:i:s',$newDate1);

//         if($d === false) 
//         {
//             die("Incorrect date string");
//         } 
//         else 
//         {
//             $newtime =  $d->getTimestamp();
//         }
//         return $newtime;
//     }

?>