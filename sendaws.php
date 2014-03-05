<?php
/*
*   Modifications to Undesigned S3 class are licensed under the Creative Commons Attribution-ShareAlike 3.0 Unported License. 
*   To view a copy of this license, visit http://creativecommons.org/licenses/by-sa/3.0/ or send a letter to 
*   Creative Commons, 171 Second Street, Suite 300, San Francisco, California, 94105, USA.
*
*   @created-by: Zane Shannon (zcs.me or @zcs)
*   @created-on: January 25, 2011
*   @version: 0.1
*   @link: https://github.com/zshannon/Amazon-Simple-Email-Service-PHP
*/

/**
*   All code based heavily upon Undesigned Amazon S3 PHP Class located at: http://undesigned.org.za/2007/10/22/amazon-s3-php-class
*
*   SES.php Usage
*/
if (!class_exists('SES')) require_once '/var/nginx/wt/http/www/modules/aws-ses/SES.php';

// AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAJSHFFKH5E4ZS2FCQ');
if (!defined('awsSecretKey')) define('awsSecretKey', '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');


// Check for CURL
if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll')) exit("\nERROR: CURL extension not loaded\n\n");

// Pointless without your keys!
if (awsAccessKey == 'change-this' || awsSecretKey == 'change-this')
    exit("\nERROR: AWS access information required\n\nPlease edit the following lines in this file:\n\n".
    "define('awsAccessKey', 'change-me');\ndefine('awsSecretKey', 'change-me');\n\n");

// Instantiate the class
//$ses = new SES(awsAccessKey, awsSecretKey);

// List your Verified Email Addresses
#echo "SES::listVerifiedAddresses(): ".print_r($ses->listVerifiedAddresses(), 1)."\n";

//Verify your Email Address
//echo "SES::verifyAddress(): ".print_r($ses->verifyAddress('valid_email_address@example.com'), 1)."\n";

//Delete a Verified Email Address
//echo "SES::deletedVerifiedAddress(): ".print_r($ses->deletedVerifiedAddress('my_verfied_email_address@example.com'), 1)."\n";

// Get your Send Quota
#echo "SES::getSendQuota(): ".print_r($ses->getSendQuota(), 1)."\n";

// Get your Send Statistics
#echo "SES::getSendStatistics(): ".print_r($ses->getSendStatistics(), 1)."\n";

function AWSemail($MailTo, $Subject, $msg)
{
//    global $ses;

    $ses = new SES(awsAccessKey, awsSecretKey);
    $email = array(
        'Destination' => array(
            'ToAddresses'=> array($MailTo),//array('vince@blackbirdinteractive.com','vincej@gmail.com'),
            'CcAddresses'=> array(),
            'BccAddresses'=> array()
        ),
        'Message' => array(
            'Subject' => array(
                'Data'=> $Subject,
                'Charset'=>'us-ascii'//Not required if is US-ASCII
            ),
            'Body'=> array(
                'Html'=>array(
                    "Data" => nl2br($msg),
                    'Charset'=>'us-ascii'//Not required if is US-ASCII
                )
            )
        ),
        'ReplyToAddresses' => array('noreply@weaktight.com'),
        'ReturnPath' => 'noreply@weaktight.com',
        'Source' => 'noreply@weaktight.com'
    );

    $ses->sendEmail($email);
}
