<?php

namespace common\components;

use ApiTypes;

class ElasticEmailClient
{
    private static $apiKey = "25e7291b-a82c-4b5c-a272-c658816c1c54";
    private static $ApiUri = "https://api.elasticemail.com/v2/";

    public static function Request($target, $data = array(), $method = "GET", $attachment = null)
    {
        self::cleanNullData($data);
        $data['apikey'] = self::$apiKey;
        $ch = curl_init();
        $url = self::$ApiUri . $target . (($method === "GET") ? '?' . http_build_query($data) : '');
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            //CURLOPT_CAINFO => dirname(__FILE__) . '\cacert.pem'
        ));
        if ($method === "POST") {
            if (empty($attachment) === false) {
                $data['file'] = self::attachFile($attachment);
            }
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        $response = curl_exec($ch);
        if ($response === false) {
            throw new ApiException($url, $method, 'Request Error: ' . curl_error($ch));
        }
        curl_close($ch);
        $jsonResult = json_decode($response);
        $parseError = self::getParseError();
        if ($parseError !== false) {
            throw new ApiException($url, $method, 'Request Error: ' . $parseError, $response);
        }
        return $jsonResult;
    }

    public static function getFile($target, $data)
    {
        self::cleanNullData($data);
        $data['apikey'] = self::$apiKey;
        $url = self::$ApiUri . $target;
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data
        ));
        $response = curl_exec($ch);
        if ($response === false) {
            throw new ApiException($url, "POST", 'Request Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $response;
    }

    public static function SetApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }

    private static function cleanNullData(&$data)
    {
        foreach ($data as $key => $item) {
            if ($item === null) {
                unset($data[$key]);
            }
            if (is_bool($item)) {
                $data[$key] = ($item) ? 'true' : 'false';
            }
        }
    }

    private static function attachFile($attachment)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $attachment);
        finfo_close($finfo);
        $save_file = realpath($attachment);
        return new \CurlFile($save_file, $mimeType, $attachment);
    }

    private static function getParseError()
    {
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return false;
            case JSON_ERROR_DEPTH:
                return 'Maximum stack depth exceeded';
            case JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch';
            case JSON_ERROR_CTRL_CHAR:
                return 'Unexpected control character found';
            case JSON_ERROR_SYNTAX:
                return 'Syntax error, malformed JSON';
            case JSON_ERROR_UTF8:
                return 'Malformed UTF-8 characters, possibly incorrectly encoded';
            default:
                return 'Unknown error';
        }
    }

}

class ApiException extends \Exception
{

    public $url;
    public $method;
    public $rawResponse;

    /**
     * @param string $url
     * @param string $method
     * @param string $message
     * @param string $rawResponse
     */
    public function __construct($url, $method, $message = "", $rawResponse = "")
    {
        $this->url = $url;
        $this->method = $method;
        $this->rawResponse = $rawResponse;
        parent::__construct($message);
    }

    public function __toString()
    {
        return strtoupper($this->method) . ' ' . $this->url . ' returned: ' . $this->getMessage();
    }

}

/**
 * Methods for managing your account and subaccounts.
 */
class Account
{
    /**
     * Create new subaccount and provide most important data about it.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $email Proper email address.
     * @param ApiTypes\AccountType $accountType Type of account: 1 for Transactional Email, 2 for Marketing Email.
     * @param string $password Current password.
     * @param string $confirmPassword Repeat new password.
     * @param bool $requiresEmailCredits True, if account needs credits to send emails. Otherwise, false
     * @param bool $enableLitmusTest True, if account is able to send template tests to Litmus. Otherwise, false
     * @param bool $requiresLitmusCredits True, if account needs credits to send emails. Otherwise, false
     * @param int $maxContacts Maximum number of contacts the account can havelkd
     * @param bool $enablePrivateIPRequest True, if account can request for private IP on its own. Otherwise, false
     * @param bool $sendActivation True, if you want to send activation email to this account. Otherwise, false
     * @param string $return_Url URL to navigate to after account creation
     * @param ?ApiTypes\SendingPermission $sendingPermission Sending permission setting for account
     * @param ?bool $enableContactFeatures True, if you want to use Advanced Tools.  Otherwise, false
     * @return string
     */
    public function AddSubAccount($email, $accountType, $password, $confirmPassword, $requiresEmailCredits = false, $enableLitmusTest = false, $requiresLitmusCredits = false, $maxContacts = 0, $enablePrivateIPRequest = true, $sendActivation = false, $return_Url = null, $sendingPermission = null, $enableContactFeatures = null)
    {
        return ApiClient::Request('account/addsubaccount', array(
            'email' => $email,
            'accountType' => $accountType,
            'password' => $password,
            'confirmPassword' => $confirmPassword,
            'requiresEmailCredits' => $requiresEmailCredits,
            'enableLitmusTest' => $enableLitmusTest,
            'requiresLitmusCredits' => $requiresLitmusCredits,
            'maxContacts' => $maxContacts,
            'enablePrivateIPRequest' => $enablePrivateIPRequest,
            'sendActivation' => $sendActivation,
            'return_Url' => $return_Url,
            'sendingPermission' => $sendingPermission,
            'enableContactFeatures' => $enableContactFeatures
        ));
    }

    /**
     * Add email, template or litmus credits to a sub-account
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $creditType Type of credits to add (EmailCredits, TemplateCredits or LitmusCredits
     * @param int $credits Amount of credits to add
     * @param string $notes Specific notes about the transaction
     * @param string $subAccountEmail Email address of sub-account
     * @param string $publicAccountID Public key for limited access to your account such as contact/add so you can use it safely on public websites.
     */
    public function AddSubAccountCredits($creditType, $credits, $notes, $subAccountEmail = null, $publicAccountID = null)
    {
        return ApiClient::Request('account/addsubaccountcredits', array(
            'creditType' => $creditType,
            'credits' => $credits,
            'notes' => $notes,
            'subAccountEmail' => $subAccountEmail,
            'publicAccountID' => $publicAccountID
        ));
    }

    /**
     * Change your email address. Remember, that your email address is used as login!
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $sourceUrl URL from which request was sent.
     * @param string $newEmail New email address.
     * @param string $confirmEmail New email address.
     */
    public function ChangeEmail($sourceUrl, $newEmail, $confirmEmail)
    {
        return ApiClient::Request('account/changeemail', array(
            'sourceUrl' => $sourceUrl,
            'newEmail' => $newEmail,
            'confirmEmail' => $confirmEmail
        ));
    }

    /**
     * Create new password for your account. Password needs to be at least 6 characters long.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $currentPassword Current password.
     * @param string $newPassword New password for account.
     * @param string $confirmPassword Repeat new password.
     */
    public function ChangePassword($currentPassword, $newPassword, $confirmPassword)
    {
        return ApiClient::Request('account/changepassword', array(
            'currentPassword' => $currentPassword,
            'newPassword' => $newPassword,
            'confirmPassword' => $confirmPassword
        ));
    }

    /**
     * Deletes specified Subaccount
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param bool $notify True, if you want to send an email notification. Otherwise, false
     * @param string $subAccountEmail Email address of sub-account
     * @param string $publicAccountID Public key for limited access to your account such as contact/add so you can use it safely on public websites.
     */
    public function DeleteSubAccount($notify = true, $subAccountEmail = null, $publicAccountID = null)
    {
        return ApiClient::Request('account/deletesubaccount', array(
            'notify' => $notify,
            'subAccountEmail' => $subAccountEmail,
            'publicAccountID' => $publicAccountID
        ));
    }

    /**
     * Returns API Key for the given Sub Account.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $subaccountEmail Email address of sub-account
     * @param string $publicAccountID Public key for limited access to your account such as contact/add so you can use it safely on public websites.
     * @return string
     */
    public function GetSubAccountApiKey($subaccountEmail = null, $publicAccountID = null)
    {
        return ApiClient::Request('account/getsubaccountapikey', array(
            'subaccountEmail' => $subaccountEmail,
            'publicAccountID' => $publicAccountID
        ));
    }

    /**
     * Lists all of your subaccounts
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @return Array<ApiTypes\SubAccount>
     */
    public function GetSubAccountList()
    {
        return ApiClient::Request('account/getsubaccountlist');
    }

    /**
     * Loads your account. Returns detailed information about your account.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @return ApiTypes\Account
     */
    public function Load()
    {
        return ApiClient::Request('account/load');
    }

    /**
     * Load advanced options of your account
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @return ApiTypes\AdvancedOptions
     */
    public function LoadAdvancedOptions()
    {
        return ApiClient::Request('account/loadadvancedoptions');
    }

    /**
     * Lists email credits history
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @return Array<ApiTypes\EmailCredits>
     */
    public function LoadEmailCreditsHistory()
    {
        return ApiClient::Request('account/loademailcreditshistory');
    }

    /**
     * Lists litmus credits history
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @return Array<ApiTypes\LitmusCredits>
     */
    public function LoadLitmusCreditsHistory()
    {
        return ApiClient::Request('account/loadlitmuscreditshistory');
    }

    /**
     * Shows queue of newest notifications - very useful when you want to check what happened with mails that were not received.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @return Array<ApiTypes\NotificationQueue>
     */
    public function LoadNotificationQueue()
    {
        return ApiClient::Request('account/loadnotificationqueue');
    }

    /**
     * Lists all payments
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param int $limit Maximum of loaded items.
     * @param int $offset How many items should be loaded ahead.
     * @param DateTime $fromDate Starting date for search in YYYY-MM-DDThh:mm:ss format.
     * @param DateTime $toDate Ending date for search in YYYY-MM-DDThh:mm:ss format.
     * @return Array<ApiTypes\Payment>
     */
    public function LoadPaymentHistory($limit, $offset, $fromDate, $toDate)
    {
        return ApiClient::Request('account/loadpaymenthistory', array(
            'limit' => $limit,
            'offset' => $offset,
            'fromDate' => $fromDate,
            'toDate' => $toDate
        ));
    }

    /**
     * Lists all referral payout history
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @return Array<ApiTypes\Payment>
     */
    public function LoadPayoutHistory()
    {
        return ApiClient::Request('account/loadpayouthistory');
    }

    /**
     * Shows information about your referral details
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @return ApiTypes\Referral
     */
    public function LoadReferralDetails()
    {
        return ApiClient::Request('account/loadreferraldetails');
    }

    /**
     * Shows latest changes in your sending reputation
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param int $limit Maximum of loaded items.
     * @param int $offset How many items should be loaded ahead.
     * @return Array<ApiTypes\ReputationHistory>
     */
    public function LoadReputationHistory($limit = 20, $offset = 0)
    {
        return ApiClient::Request('account/loadreputationhistory', array(
            'limit' => $limit,
            'offset' => $offset
        ));
    }

    /**
     * Shows detailed information about your actual reputation score
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @return ApiTypes\ReputationDetail
     */
    public function LoadReputationImpact()
    {
        return ApiClient::Request('account/loadreputationimpact');
    }

    /**
     * Returns detailed spam check.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param int $limit Maximum of loaded items.
     * @param int $offset How many items should be loaded ahead.
     * @return Array<ApiTypes\SpamCheck>
     */
    public function LoadSpamCheck($limit = 20, $offset = 0)
    {
        return ApiClient::Request('account/loadspamcheck', array(
            'limit' => $limit,
            'offset' => $offset
        ));
    }

    /**
     * Lists email credits history for sub-account
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $subAccountEmail Email address of sub-account
     * @param string $publicAccountID Public key for limited access to your account such as contact/add so you can use it safely on public websites.
     * @return Array<ApiTypes\EmailCredits>
     */
    public function LoadSubAccountsEmailCreditsHistory($subAccountEmail = null, $publicAccountID = null)
    {
        return ApiClient::Request('account/loadsubaccountsemailcreditshistory', array(
            'subAccountEmail' => $subAccountEmail,
            'publicAccountID' => $publicAccountID
        ));
    }

    /**
     * Loads settings of subaccount
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $subAccountemail Email address of sub-account
     * @param string $publicAccountID Public key for limited access to your account such as contact/add so you can use it safely on public websites.
     * @return ApiTypes\SubAccountSettings
     */
    public function LoadSubAccountSettings($subAccountemail = null, $publicAccountID = null)
    {
        return ApiClient::Request('account/loadsubaccountsettings', array(
            'subAccountemail' => $subAccountemail,
            'publicAccountID' => $publicAccountID
        ));
    }

    /**
     * Lists litmus credits history for sub-account
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $subAccountEmail Email address of sub-account
     * @param string $publicAccountID Public key for limited access to your account such as contact/add so you can use it safely on public websites.
     * @return Array<ApiTypes\LitmusCredits>
     */
    public function LoadSubAccountsLitmusCreditsHistory($subAccountEmail = null, $publicAccountID = null)
    {
        return ApiClient::Request('account/loadsubaccountslitmuscreditshistory', array(
            'subAccountEmail' => $subAccountEmail,
            'publicAccountID' => $publicAccountID
        ));
    }

    /**
     * Shows usage of your account in given time.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param DateTime $from Starting date for search in YYYY-MM-DDThh:mm:ss format.
     * @param DateTime $to Ending date for search in YYYY-MM-DDThh:mm:ss format.
     * @return Array<ApiTypes\Usage>
     */
    public function LoadUsage($from, $to)
    {
        return ApiClient::Request('account/loadusage', array(
            'from' => $from,
            'to' => $to
        ));
    }

    /**
     * Manages your apikeys.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $apiKey APIKey you would like to manage.
     * @param ApiTypes\APIKeyAction $action Specific action you would like to perform on the APIKey
     * @return Array<string>
     */
    public function ManageApiKeys($apiKey, $action)
    {
        return ApiClient::Request('account/manageapikeys', array(
            'apiKey' => $apiKey,
            'action' => $action
        ));
    }

    /**
     * Shows summary for your account.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @return ApiTypes\AccountOverview
     */
    public function Overview()
    {
        return ApiClient::Request('account/overview');
    }

    /**
     * Remove email, template or litmus credits from a sub-account
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $creditType Type of credits to add (EmailCredits, TemplateCredits or LitmusCredits
     * @param string $notes Specific notes about the transaction
     * @param string $subAccountEmail Email address of sub-account
     * @param string $publicAccountID Public key for limited access to your account such as contact/add so you can use it safely on public websites.
     * @param ?int $credits Amount of credits to remove
     * @param bool $removeAll Remove all credits of this type from sub-account (overrides credits if provided)
     */
    public function RemoveSubAccountCredits($creditType, $notes, $subAccountEmail = null, $publicAccountID = null, $credits = null, $removeAll = false)
    {
        return ApiClient::Request('account/removesubaccountcredits', array(
            'creditType' => $creditType,
            'notes' => $notes,
            'subAccountEmail' => $subAccountEmail,
            'publicAccountID' => $publicAccountID,
            'credits' => $credits,
            'removeAll' => $removeAll
        ));
    }

    /**
     * Request a private IP for your Account
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param int $count Number of items.
     * @param string $notes Free form field of notes
     */
    public function RequestPrivateIP($count, $notes)
    {
        return ApiClient::Request('account/requestprivateip', array(
            'count' => $count,
            'notes' => $notes
        ));
    }

    /**
     * Update sending and tracking options of your account.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param ?bool $enableClickTracking True, if you want to track clicks. Otherwise, false
     * @param ?bool $enableLinkClickTracking True, if you want to track by link tracking. Otherwise, false
     * @param ?bool $skipListUnsubscribe True, if you do not want to use list-unsubscribe headers. Otherwise, false
     * @param ?bool $autoTextFromHtml True, if text BODY of message should be created automatically. Otherwise, false
     * @param ?bool $allowCustomHeaders True, if you want to apply custom headers to your emails. Otherwise, false
     * @param string $bccEmail Email address to send a copy of all email to.
     * @param string $contentTransferEncoding Type of content encoding
     * @param ?bool $emailNotificationForError True, if you want bounce notifications returned. Otherwise, false
     * @param string $emailNotificationEmail Specific email address to send bounce email notifications to.
     * @param string $webNotificationUrl URL address to receive web notifications to parse and process.
     * @param ?bool $webNotificationForSent True, if you want to send web notifications for sent email. Otherwise, false
     * @param ?bool $webNotificationForOpened True, if you want to send web notifications for opened email. Otherwise, false
     * @param ?bool $webNotificationForClicked True, if you want to send web notifications for clicked email. Otherwise, false
     * @param ?bool $webNotificationForUnsubscribed True, if you want to send web notifications for unsubscribed email. Otherwise, false
     * @param ?bool $webNotificationForAbuseReport True, if you want to send web notifications for complaint email. Otherwise, false
     * @param ?bool $webNotificationForError True, if you want to send web notifications for bounced email. Otherwise, false
     * @param string $hubCallBackUrl URL used for tracking action of inbound emails
     * @param string $inboundDomain Domain you use as your inbound domain
     * @param ?bool $inboundContactsOnly True, if you want inbound email to only process contacts from your account. Otherwise, false
     * @param ?bool $lowCreditNotification True, if you want to receive low credit email notifications. Otherwise, false
     * @param ?bool $enableUITooltips True, if account has tooltips active. Otherwise, false
     * @param ?bool $enableContactFeatures True, if you want to use Advanced Tools.  Otherwise, false
     * @return ApiTypes\AdvancedOptions
     */
    public function UpdateAdvancedOptions($enableClickTracking = null, $enableLinkClickTracking = null, $skipListUnsubscribe = null, $autoTextFromHtml = null, $allowCustomHeaders = null, $bccEmail = "", $contentTransferEncoding = null, $emailNotificationForError = null, $emailNotificationEmail = "", $webNotificationUrl = "", $webNotificationForSent = null, $webNotificationForOpened = null, $webNotificationForClicked = null, $webNotificationForUnsubscribed = null, $webNotificationForAbuseReport = null, $webNotificationForError = null, $hubCallBackUrl = "", $inboundDomain = "", $inboundContactsOnly = null, $lowCreditNotification = null, $enableUITooltips = null, $enableContactFeatures = null)
    {
        return ApiClient::Request('account/updateadvancedoptions', array(
            'enableClickTracking' => $enableClickTracking,
            'enableLinkClickTracking' => $enableLinkClickTracking,
            'skipListUnsubscribe' => $skipListUnsubscribe,
            'autoTextFromHtml' => $autoTextFromHtml,
            'allowCustomHeaders' => $allowCustomHeaders,
            'bccEmail' => $bccEmail,
            'contentTransferEncoding' => $contentTransferEncoding,
            'emailNotificationForError' => $emailNotificationForError,
            'emailNotificationEmail' => $emailNotificationEmail,
            'webNotificationUrl' => $webNotificationUrl,
            'webNotificationForSent' => $webNotificationForSent,
            'webNotificationForOpened' => $webNotificationForOpened,
            'webNotificationForClicked' => $webNotificationForClicked,
            'webNotificationForUnsubscribed' => $webNotificationForUnsubscribed,
            'webNotificationForAbuseReport' => $webNotificationForAbuseReport,
            'webNotificationForError' => $webNotificationForError,
            'hubCallBackUrl' => $hubCallBackUrl,
            'inboundDomain' => $inboundDomain,
            'inboundContactsOnly' => $inboundContactsOnly,
            'lowCreditNotification' => $lowCreditNotification,
            'enableUITooltips' => $enableUITooltips,
            'enableContactFeatures' => $enableContactFeatures
        ));
    }

    /**
     * Update settings of your private branding. These settings are needed, if you want to use Elastic Email under your brand.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param bool $enablePrivateBranding True: Turn on or off ability to send mails under your brand. Otherwise, false
     * @param string $logoUrl URL to your logo image.
     * @param string $supportLink Address to your support.
     * @param string $privateBrandingUrl Subdomain for your rebranded service
     * @param string $smtpAddress Address of SMTP server.
     * @param string $smtpAlternative Address of alternative SMTP server.
     * @param string $paymentUrl URL for making payments.
     */
    public function UpdateCustomBranding($enablePrivateBranding = false, $logoUrl = null, $supportLink = null, $privateBrandingUrl = null, $smtpAddress = null, $smtpAlternative = null, $paymentUrl = null)
    {
        return ApiClient::Request('account/updatecustombranding', array(
            'enablePrivateBranding' => $enablePrivateBranding,
            'logoUrl' => $logoUrl,
            'supportLink' => $supportLink,
            'privateBrandingUrl' => $privateBrandingUrl,
            'smtpAddress' => $smtpAddress,
            'smtpAlternative' => $smtpAlternative,
            'paymentUrl' => $paymentUrl
        ));
    }

    /**
     * Update http notification URL.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $url URL of notification.
     * @param string $settings Http notification settings serialized to JSON
     */
    public function UpdateHttpNotification($url, $settings = null)
    {
        return ApiClient::Request('account/updatehttpnotification', array(
            'url' => $url,
            'settings' => $settings
        ));
    }

    /**
     * Update your profile.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $firstName First name.
     * @param string $lastName Last name.
     * @param string $company Company name.
     * @param string $address1 First line of address.
     * @param string $address2 Second line of address.
     * @param string $city City.
     * @param string $state State or province.
     * @param string $zip Zip/postal code.
     * @param string $countryID Numeric ID of country.
     * @param string $deliveryReason Why your clients are receiving your emails.
     * @param bool $marketingConsent True if you want to receive newsletters from Elastic Email. Otherwise, false.
     * @param string $website HTTP address of your website.
     * @param string $logoUrl URL to your logo image.
     * @param string $taxCode Code used for tax purposes.
     * @param string $phone Phone number
     */
    public function UpdateProfile($firstName, $lastName, $company, $address1, $address2, $city, $state, $zip, $countryID, $deliveryReason, $marketingConsent, $website = null, $logoUrl = null, $taxCode = null, $phone = null)
    {
        return ApiClient::Request('account/updateprofile', array(
            'firstName' => $firstName,
            'lastName' => $lastName,
            'company' => $company,
            'address1' => $address1,
            'address2' => $address2,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,
            'countryID' => $countryID,
            'deliveryReason' => $deliveryReason,
            'marketingConsent' => $marketingConsent,
            'website' => $website,
            'logoUrl' => $logoUrl,
            'taxCode' => $taxCode,
            'phone' => $phone
        ));
    }

    /**
     * Updates settings of specified subaccount
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param bool $requiresEmailCredits True, if account needs credits to send emails. Otherwise, false
     * @param int $monthlyRefillCredits Amount of credits added to account automatically
     * @param bool $requiresLitmusCredits True, if account needs credits to send emails. Otherwise, false
     * @param bool $enableLitmusTest True, if account is able to send template tests to Litmus. Otherwise, false
     * @param int $dailySendLimit Amount of emails account can send daily
     * @param int $emailSizeLimit Maximum size of email including attachments in MB's
     * @param bool $enablePrivateIPRequest True, if account can request for private IP on its own. Otherwise, false
     * @param int $maxContacts Maximum number of contacts the account can havelkd
     * @param string $subAccountEmail Email address of sub-account
     * @param string $publicAccountID Public key for limited access to your account such as contact/add so you can use it safely on public websites.
     * @param ?ApiTypes\SendingPermission $sendingPermission Sending permission setting for account
     * @param ?bool $enableContactFeatures True, if you want to use Advanced Tools.  Otherwise, false
     */
    public function UpdateSubAccountSettings($requiresEmailCredits = false, $monthlyRefillCredits = 0, $requiresLitmusCredits = false, $enableLitmusTest = false, $dailySendLimit = 50, $emailSizeLimit = 10, $enablePrivateIPRequest = false, $maxContacts = 0, $subAccountEmail = null, $publicAccountID = null, $sendingPermission = null, $enableContactFeatures = null)
    {
        return ApiClient::Request('account/updatesubaccountsettings', array(
            'requiresEmailCredits' => $requiresEmailCredits,
            'monthlyRefillCredits' => $monthlyRefillCredits,
            'requiresLitmusCredits' => $requiresLitmusCredits,
            'enableLitmusTest' => $enableLitmusTest,
            'dailySendLimit' => $dailySendLimit,
            'emailSizeLimit' => $emailSizeLimit,
            'enablePrivateIPRequest' => $enablePrivateIPRequest,
            'maxContacts' => $maxContacts,
            'subAccountEmail' => $subAccountEmail,
            'publicAccountID' => $publicAccountID,
            'sendingPermission' => $sendingPermission,
            'enableContactFeatures' => $enableContactFeatures
        ));
    }

}

/**
 * Managing attachments uploaded to your account.
 */
class Attachment
{
    /**
     * Permanently deletes attachment file from your account
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param long $attachmentID ID number of your attachment.
     */
    public function EEDelete($attachmentID)
    {
        return ApiClient::Request('attachment/delete', array(
            'attachmentID' => $attachmentID
        ));
    }

    /**
     * Gets address of chosen Attachment
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $fileName Name of your file.
     * @param long $attachmentID ID number of your attachment.
     * @return File
     */
    public function Get($fileName, $attachmentID)
    {
        return ApiClient::getFile('attachment/get', array(
            'fileName' => $fileName,
            'attachmentID' => $attachmentID
        ));
    }

    /**
     * Lists your available Attachments
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $msgID ID number of selected message.
     * @return Array<ApiTypes\Attachment>
     */
    public function EEList($msgID)
    {
        return ApiClient::Request('attachment/list', array(
            'msgID' => $msgID
        ));
    }

    /**
     * Permanently removes attachment file from your account
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $fileName Name of your file.
     */
    public function Remove($fileName)
    {
        return ApiClient::Request('attachment/remove', array(
            'fileName' => $fileName
        ));
    }

    /**
     * Uploads selected file to the server using http form upload format (MIME multipart/form-data) or PUT method.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param File $attachmentFile Content of your attachment.
     * @return ApiTypes\Attachment
     */
    public function Upload($attachmentFile)
    {
        return ApiClient::Request('attachment/upload', array(), "POST", $attachmentFile);
    }

}

/**
 * Sending and monitoring progress of your Campaigns
 */
class Campaign
{
    /**
     * Adds a campaign to the queue for processing based on the configuration
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param ApiTypes\Campaign $campaign Json representation of a campaign
     * @return int
     */
    public function Add($campaign)
    {
        return ApiClient::Request('campaign/add', array(
            'campaign' => $campaign
        ));
    }

    /**
     * Copy selected campaign
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param int $channelID ID number of selected Channel.
     */
    public function EECopy($channelID)
    {
        return ApiClient::Request('campaign/copy', array(
            'channelID' => $channelID
        ));
    }

    /**
     * Delete selected campaign
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param int $channelID ID number of selected Channel.
     */
    public function EEDelete($channelID)
    {
        return ApiClient::Request('campaign/delete', array(
            'channelID' => $channelID
        ));
    }

    /**
     * Export selected campaigns to chosen file format.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param array <string> $campaignNames
     * @param ApiTypes\ExportFileFormats $fileFormat
     * @param ApiTypes\CompressionFormat $compressionFormat FileResponse compression format. None or Zip.
     * @param string $fileName Name of your file.
     */
    public function Export($campaignNames, $fileFormat = ApiTypes\ExportFileFormats::Csv, $compressionFormat = ApiTypes\CompressionFormat::None, $fileName = null)
    {
        return ApiClient::Request('campaign/export', array(
            'campaignNames' => (count($campaignNames) === 0) ? null : join(';', $campaignNames),
            'fileFormat' => $fileFormat,
            'compressionFormat' => $compressionFormat,
            'fileName' => $fileName
        ));
    }

    /**
     * List all of your campaigns
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $search Text fragment used for searching.
     * @param int $offset How many items should be loaded ahead.
     * @param int $limit Maximum of loaded items.
     * @return Array<ApiTypes\CampaignChannel>
     */
    public function EEList($search = null, $offset = 0, $limit = 0)
    {
        return ApiClient::Request('campaign/list', array(
            'search' => $search,
            'offset' => $offset,
            'limit' => $limit
        ));
    }

    /**
     * Updates a previously added campaign.  Only Active and Paused campaigns can be updated.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param ApiTypes\Campaign $campaign Json representation of a campaign
     * @return int
     */
    public function Update($campaign)
    {
        return ApiClient::Request('campaign/update', array(
            'campaign' => $campaign
        ));
    }

}

/**
 * SMTP and HTTP API channels for grouping email delivery.
 */
class Channel
{
    /**
     * Manually add a channel to your account to group email
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $name Descriptive name of the channel
     * @return string
     */
    public function Add($name)
    {
        return ApiClient::Request('channel/add', array(
            'name' => $name
        ));
    }

    /**
     * Delete the channel.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $name The name of the channel to delete.
     */
    public function EEDelete($name)
    {
        return ApiClient::Request('channel/delete', array(
            'name' => $name
        ));
    }

    /**
     * Export channels in CSV file format.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param array <string> $channelNames
     * @param ApiTypes\CompressionFormat $compressionFormat FileResponse compression format. None or Zip.
     * @param string $fileName Name of your file.
     * @return File
     */
    public function ExportCsv($channelNames, $compressionFormat = ApiTypes\CompressionFormat::None, $fileName = null)
    {
        return ApiClient::getFile('channel/exportcsv', array(
            'channelNames' => (count($channelNames) === 0) ? null : join(';', $channelNames),
            'compressionFormat' => $compressionFormat,
            'fileName' => $fileName
        ));
    }

    /**
     * Export channels in JSON file format.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param array <string> $channelNames
     * @param ApiTypes\CompressionFormat $compressionFormat FileResponse compression format. None or Zip.
     * @param string $fileName Name of your file.
     * @return File
     */
    public function ExportJson($channelNames, $compressionFormat = ApiTypes\CompressionFormat::None, $fileName = null)
    {
        return ApiClient::getFile('channel/exportjson', array(
            'channelNames' => (count($channelNames) === 0) ? null : join(';', $channelNames),
            'compressionFormat' => $compressionFormat,
            'fileName' => $fileName
        ));
    }

    /**
     * Export channels in XML file format.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param array <string> $channelNames
     * @param ApiTypes\CompressionFormat $compressionFormat FileResponse compression format. None or Zip.
     * @param string $fileName Name of your file.
     * @return File
     */
    public function ExportXml($channelNames, $compressionFormat = ApiTypes\CompressionFormat::None, $fileName = null)
    {
        return ApiClient::getFile('channel/exportxml', array(
            'channelNames' => (count($channelNames) === 0) ? null : join(';', $channelNames),
            'compressionFormat' => $compressionFormat,
            'fileName' => $fileName
        ));
    }

    /**
     * List all of your channels
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @return Array<ApiTypes\Channel>
     */
    public function EEList()
    {
        return ApiClient::Request('channel/list');
    }

    /**
     * Rename an existing channel.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $name The name of the channel to update.
     * @param string $newName The new name for the channel.
     * @return string
     */
    public function Update($name, $newName)
    {
        return ApiClient::Request('channel/update', array(
            'name' => $name,
            'newName' => $newName
        ));
    }

}

/**
 * Methods used to manage your Contacts.
 */
class Contact
{
    /**
     * Activate contacts that are currently blocked.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param bool $activateAllBlocked Activate all your blocked contacts.  Passing True will override email list and activate all your blocked contacts.
     * @param array <string> $emails Comma delimited list of contact emails
     */
    public function ActivateBlocked($activateAllBlocked = false, array $emails = array())
    {
        return ApiClient::Request('contact/activateblocked', array(
            'activateAllBlocked' => $activateAllBlocked,
            'emails' => (count($emails) === 0) ? null : join(';', $emails)
        ));
    }

    /**
     * Add a new contact and optionally to one of your lists.  Note that your API KEY is not required for this call.
     * @param string $publicAccountID Public key for limited access to your account such as contact/add so you can use it safely on public websites.
     * @param string $email Proper email address.
     * @param array <string> $publicListID ID code of list
     * @param array <string> $listName Name of your list.
     * @param string $title Title
     * @param string $firstName First name.
     * @param string $lastName Last name.
     * @param string $phone Phone number
     * @param string $mobileNumber Mobile phone number
     * @param string $notes Free form field of notes
     * @param string $gender Your gender
     * @param ?DateTime $birthDate Date of birth in YYYY-MM-DD format
     * @param string $city City.
     * @param string $state State or province.
     * @param string $postalCode Zip/postal code.
     * @param string $country Name of country.
     * @param string $organizationName Name of organization
     * @param string $website HTTP address of your website.
     * @param ?int $annualRevenue Annual revenue of contact
     * @param string $industry Industry contact works in
     * @param ?int $numberOfEmployees Number of employees
     * @param ApiTypes\ContactSource $type
     * @param string $return_Url URL to navigate to after account creation
     * @param string $source_Url The url for activation for private branding.
     * @param string $activation_Return_Url The url to return the contact to after activation.
     * @param string $activation_Template The custom template for double optin-in activation. Requires {url} merge tag.
     * @param bool $requiresActivation True, if you want to send an activation notice to double opt-in the contact. Otherwise, false
     * @return string
     */
    public function Add($publicAccountID, $email, array $publicListID = array(), array $listName = array(), $title = null, $firstName = null, $lastName = null, $phone = null, $mobileNumber = null, $notes = null, $gender = null, $birthDate = null, $city = null, $state = null, $postalCode = null, $country = null, $organizationName = null, $website = null, $annualRevenue = 0, $industry = null, $numberOfEmployees = 0, $type = ApiTypes\ContactSource::Unknown, $return_Url = null, $source_Url = null, $activation_Return_Url = null, $activation_Template = null, $requiresActivation = true)
    {
        return ApiClient::Request('contact/add', array(
            'publicAccountID' => $publicAccountID,
            'email' => $email,
            'publicListID' => (count($publicListID) === 0) ? null : join(';', $publicListID),
            'listName' => (count($listName) === 0) ? null : join(';', $listName),
            'title' => $title,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'phone' => $phone,
            'mobileNumber' => $mobileNumber,
            'notes' => $notes,
            'gender' => $gender,
            'birthDate' => $birthDate,
            'city' => $city,
            'state' => $state,
            'postalCode' => $postalCode,
            'country' => $country,
            'organizationName' => $organizationName,
            'website' => $website,
            'annualRevenue' => $annualRevenue,
            'industry' => $industry,
            'numberOfEmployees' => $numberOfEmployees,
            'type' => $type,
            'return_Url' => $return_Url,
            'source_Url' => $source_Url,
            'activation_Return_Url' => $activation_Return_Url,
            'activation_Template' => $activation_Template,
            'requiresActivation' => $requiresActivation
        ));
    }

    /**
     * Manually add or update a contacts status to Abuse, Bounced or Unsubscribed status (blocked).
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $email Proper email address.
     * @param ApiTypes\ContactStatus $status Name of status: Active, Engaged, Inactive, Abuse, Bounced, Unsubscribed.
     */
    public function AddBlocked($email, $status)
    {
        return ApiClient::Request('contact/addblocked', array(
            'email' => $email,
            'status' => $status
        ));
    }

    /**
     * Change any property on the contact record.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $email Proper email address.
     * @param string $name Name of the contact property you want to change.
     * @param string $value Value you would like to change the contact property to.
     */
    public function ChangeProperty($email, $name, $value)
    {
        return ApiClient::Request('contact/changeproperty', array(
            'email' => $email,
            'name' => $name,
            'value' => $value
        ));
    }

    /**
     * Changes status of selected Contacts. You may provide RULE for selection or specify list of Contact IDs.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param ApiTypes\ContactStatus $status Name of status: Active, Engaged, Inactive, Abuse, Bounced, Unsubscribed.
     * @param string $rule Query used for filtering.
     * @param array <string> $emails Comma delimited list of contact emails
     * @param bool $allContacts True: Include every Contact in your Account. Otherwise, false
     */
    public function ChangeStatus($status, $rule = null, array $emails = array(), $allContacts = false)
    {
        return ApiClient::Request('contact/changestatus', array(
            'status' => $status,
            'rule' => $rule,
            'emails' => (count($emails) === 0) ? null : join(';', $emails),
            'allContacts' => $allContacts
        ));
    }

    /**
     * Returns number of Contacts, RULE specifies contact Status.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $rule Query used for filtering.
     * @param bool $allContacts True: Include every Contact in your Account. Otherwise, false
     * @return ApiTypes\ContactStatusCounts
     */
    public function CountByStatus($rule = null, $allContacts = false)
    {
        return ApiClient::Request('contact/countbystatus', array(
            'rule' => $rule,
            'allContacts' => $allContacts
        ));
    }

    /**
     * Permanantly deletes the contacts provided.  You can provide either a qualified rule or a list of emails (comma separated string).
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $rule Query used for filtering.
     * @param array <string> $emails Comma delimited list of contact emails
     * @param bool $allContacts True: Include every Contact in your Account. Otherwise, false
     */
    public function EEDelete($rule = null, array $emails = array(), $allContacts = false)
    {
        return ApiClient::Request('contact/delete', array(
            'rule' => $rule,
            'emails' => (count($emails) === 0) ? null : join(';', $emails),
            'allContacts' => $allContacts
        ));
    }

    /**
     * Export selected Contacts to JSON.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param ApiTypes\ExportFileFormats $fileFormat
     * @param string $rule Query used for filtering.
     * @param array <string> $emails Comma delimited list of contact emails
     * @param bool $allContacts True: Include every Contact in your Account. Otherwise, false
     * @param ApiTypes\CompressionFormat $compressionFormat FileResponse compression format. None or Zip.
     * @param string $fileName Name of your file.
     * @return ApiTypes\ExportLink
     */
    public function Export($fileFormat = ApiTypes\ExportFileFormats::Csv, $rule = null, array $emails = array(), $allContacts = false, $compressionFormat = ApiTypes\CompressionFormat::None, $fileName = null)
    {
        return ApiClient::Request('contact/export', array(
            'fileFormat' => $fileFormat,
            'rule' => $rule,
            'emails' => (count($emails) === 0) ? null : join(';', $emails),
            'allContacts' => $allContacts,
            'compressionFormat' => $compressionFormat,
            'fileName' => $fileName
        ));
    }

    /**
     * Finds all Lists and Segments this email belongs to.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $email Proper email address.
     * @return ApiTypes\ContactCollection
     */
    public function FindContact($email)
    {
        return ApiClient::Request('contact/findcontact', array(
            'email' => $email
        ));
    }

    /**
     * List of all contacts. If you have not specified RULE, all Contacts will be listed.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $rule Query used for filtering.
     * @param bool $allContacts True: Include every Contact in your Account. Otherwise, false
     * @param int $limit Maximum of loaded items.
     * @param int $offset How many items should be loaded ahead.
     * @return Array<ApiTypes\Contact>
     */
    public function EEList($rule = null, $allContacts = false, $limit = 20, $offset = 0)
    {
        return ApiClient::Request('contact/list', array(
            'rule' => $rule,
            'allContacts' => $allContacts,
            'limit' => $limit,
            'offset' => $offset
        ));
    }

    /**
     * Load blocked contacts
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $search Text fragment used for searching.
     * @param ?ApiTypes\ContactStatus $status Name of blocked status: Abuse, Bounced or Unsubscribed
     * @param int $limit Maximum of loaded items.
     * @param int $offset How many items should be loaded ahead.
     * @return Array<ApiTypes\BlockedContact>
     */
    public function LoadBlocked($search, $status = null, $limit = 0, $offset = 0)
    {
        return ApiClient::Request('contact/loadblocked', array(
            'search' => $search,
            'status' => $status,
            'limit' => $limit,
            'offset' => $offset
        ));
    }

    /**
     * Load detailed contact information
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $email Proper email address.
     * @return ApiTypes\Contact
     */
    public function LoadContact($email)
    {
        return ApiClient::Request('contact/loadcontact', array(
            'email' => $email
        ));
    }

    /**
     * Shows detailed history of chosen Contact.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $email Proper email address.
     * @return Array<ApiTypes\ContactHistory>
     */
    public function LoadHistory($email)
    {
        return ApiClient::Request('contact/loadhistory', array(
            'email' => $email
        ));
    }

    /**
     * Add new Contact to one of your Lists.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param array <string> $emails Comma delimited list of contact emails
     * @param string $firstName First name.
     * @param string $lastName Last name.
     * @param string $title Title
     * @param string $organization Name of organization
     * @param string $city City.
     * @param string $country Name of country.
     * @param string $state State or province.
     * @param string $zip Zip/postal code.
     * @param int $listID ID number of selected list.
     * @param ApiTypes\ContactStatus $status Name of status: Active, Engaged, Inactive, Abuse, Bounced, Unsubscribed.
     * @param string $notes Free form field of notes
     */
    public function QuickAdd($emails, $firstName = null, $lastName = null, $title = null, $organization = null, $city = null, $country = null, $state = null, $zip = null, $listID = 0, $status = ApiTypes\ContactStatus::Active, $notes = null)
    {
        return ApiClient::Request('contact/quickadd', array(
            'emails' => (count($emails) === 0) ? null : join(';', $emails),
            'firstName' => $firstName,
            'lastName' => $lastName,
            'title' => $title,
            'organization' => $organization,
            'city' => $city,
            'country' => $country,
            'state' => $state,
            'zip' => $zip,
            'listID' => $listID,
            'status' => $status,
            'notes' => $notes
        ));
    }

    /**
     * Update selected contact. Omitted contact's fields will be reset by default (see the clearRestOfFields parameter)
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $email Proper email address.
     * @param string $newEmail New email address.
     * @param string $firstName First name.
     * @param string $lastName Last name.
     * @param string $organizationName Name of organization
     * @param string $title Title
     * @param string $city City.
     * @param string $state State or province.
     * @param string $country Name of country.
     * @param string $zip Zip/postal code.
     * @param string $birthDate Date of birth in YYYY-MM-DD format
     * @param string $gender Your gender
     * @param string $phone Phone number
     * @param string $activate True, if Contact should be activated. Otherwise, false
     * @param string $industry Industry contact works in
     * @param int $numberOfEmployees Number of employees
     * @param string $annualRevenue Annual revenue of contact
     * @param int $purchaseCount Number of purchases contact has made
     * @param string $firstPurchase Date of first purchase in YYYY-MM-DD format
     * @param string $lastPurchase Date of last purchase in YYYY-MM-DD format
     * @param string $notes Free form field of notes
     * @param string $websiteUrl Website of contact
     * @param string $mobileNumber Mobile phone number
     * @param string $faxNumber Fax number
     * @param string $linkedInBio Biography for Linked-In
     * @param int $linkedInConnections Number of Linked-In connections
     * @param string $twitterBio Biography for Twitter
     * @param string $twitterUsername User name for Twitter
     * @param string $twitterProfilePhoto URL for Twitter photo
     * @param int $twitterFollowerCount Number of Twitter followers
     * @param int $pageViews Number of page views
     * @param int $visits Number of website visits
     * @param bool $clearRestOfFields
     * @return ApiTypes\Contact
     */
    public function Update($email, $newEmail = null, $firstName = null, $lastName = null, $organizationName = null, $title = null, $city = null, $state = null, $country = null, $zip = null, $birthDate = null, $gender = null, $phone = null, $activate = null, $industry = null, $numberOfEmployees = 0, $annualRevenue = null, $purchaseCount = 0, $firstPurchase = null, $lastPurchase = null, $notes = null, $websiteUrl = null, $mobileNumber = null, $faxNumber = null, $linkedInBio = null, $linkedInConnections = 0, $twitterBio = null, $twitterUsername = null, $twitterProfilePhoto = null, $twitterFollowerCount = 0, $pageViews = 0, $visits = 0, $clearRestOfFields = true)
    {
        return ApiClient::Request('contact/update', array(
            'email' => $email,
            'newEmail' => $newEmail,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'organizationName' => $organizationName,
            'title' => $title,
            'city' => $city,
            'state' => $state,
            'country' => $country,
            'zip' => $zip,
            'birthDate' => $birthDate,
            'gender' => $gender,
            'phone' => $phone,
            'activate' => $activate,
            'industry' => $industry,
            'numberOfEmployees' => $numberOfEmployees,
            'annualRevenue' => $annualRevenue,
            'purchaseCount' => $purchaseCount,
            'firstPurchase' => $firstPurchase,
            'lastPurchase' => $lastPurchase,
            'notes' => $notes,
            'websiteUrl' => $websiteUrl,
            'mobileNumber' => $mobileNumber,
            'faxNumber' => $faxNumber,
            'linkedInBio' => $linkedInBio,
            'linkedInConnections' => $linkedInConnections,
            'twitterBio' => $twitterBio,
            'twitterUsername' => $twitterUsername,
            'twitterProfilePhoto' => $twitterProfilePhoto,
            'twitterFollowerCount' => $twitterFollowerCount,
            'pageViews' => $pageViews,
            'visits' => $visits,
            'clearRestOfFields' => $clearRestOfFields
        ));
    }

    /**
     * Upload contacts in CSV file.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param int $listID ID number of selected list.
     * @param File $contactFile Name of CSV file with Contacts.
     * @param ApiTypes\ContactStatus $status Name of status: Active, Engaged, Inactive, Abuse, Bounced, Unsubscribed.
     * @return int
     */
    public function Upload($listID, $contactFile, $status = ApiTypes\ContactStatus::Active)
    {
        return ApiClient::Request('contact/upload', array(
            'listID' => $listID,
            'status' => $status
        ), "POST", $contactFile);
    }

}

/**
 * Managing sender domains. Creating new entries and validating domain records.
 */
class Domain
{
    /**
     * Add new domain to account
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $domain Name of selected domain.
     */
    public function Add($domain)
    {
        return ApiClient::Request('domain/add', array(
            'domain' => $domain
        ));
    }

    /**
     * Deletes configured domain from account
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $domain Name of selected domain.
     */
    public function EEDelete($domain)
    {
        return ApiClient::Request('domain/delete', array(
            'domain' => $domain
        ));
    }

    /**
     * Lists all domains configured for this account.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @return Array<ApiTypes\DomainDetail>
     */
    public function EEList()
    {
        return ApiClient::Request('domain/list');
    }

    /**
     * Verification of email addres set for domain.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $domain Default email sender, example: mail@yourdomain.com
     */
    public function SetDefault($domain)
    {
        return ApiClient::Request('domain/setdefault', array(
            'domain' => $domain
        ));
    }

    /**
     * Verification of DKIM record for domain
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $domain Name of selected domain.
     */
    public function VerifyDkim($domain)
    {
        return ApiClient::Request('domain/verifydkim', array(
            'domain' => $domain
        ));
    }

    /**
     * Verification of MX record for domain
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $domain Name of selected domain.
     */
    public function VerifyMX($domain)
    {
        return ApiClient::Request('domain/verifymx', array(
            'domain' => $domain
        ));
    }

    /**
     * Verification of SPF record for domain
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $domain Name of selected domain.
     */
    public function VerifySpf($domain)
    {
        return ApiClient::Request('domain/verifyspf', array(
            'domain' => $domain
        ));
    }

    /**
     * Verification of tracking CNAME record for domain
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $domain Name of selected domain.
     */
    public function VerifyTracking($domain)
    {
        return ApiClient::Request('domain/verifytracking', array(
            'domain' => $domain
        ));
    }

}

/**
 *
 */
class Email
{
    /**
     * Get email batch status
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $transactionID Transaction identifier
     * @param bool $showFailed Include Bounced email addresses.
     * @param bool $showDelivered Include Sent email addresses.
     * @param bool $showPending Include Ready to send email addresses.
     * @param bool $showOpened Include Opened email addresses.
     * @param bool $showClicked Include Clicked email addresses.
     * @param bool $showAbuse Include Reported as abuse email addresses.
     * @param bool $showUnsubscribed Include Unsubscribed email addresses.
     * @param bool $showErrors Include error messages for bounced emails.
     * @return ApiTypes\EmailJobStatus
     */
    public function GetStatus($transactionID, $showFailed = false, $showDelivered = false, $showPending = false, $showOpened = false, $showClicked = false, $showAbuse = false, $showUnsubscribed = false, $showErrors = false)
    {
        return ApiClient::Request('email/getstatus', array(
            'transactionID' => $transactionID,
            'showFailed' => $showFailed,
            'showDelivered' => $showDelivered,
            'showPending' => $showPending,
            'showOpened' => $showOpened,
            'showClicked' => $showClicked,
            'showAbuse' => $showAbuse,
            'showUnsubscribed' => $showUnsubscribed,
            'showErrors' => $showErrors
        ));
    }

    /**
     * Submit emails
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $subject Email subject
     * @param string $from From email address
     * @param string $fromName Display name for from email address
     * @param string $sender Email address of the sender
     * @param string $senderName Display name sender
     * @param string $msgFrom Optional parameter. Sets FROM MIME header.
     * @param string $msgFromName Optional parameter. Sets FROM name of MIME header.
     * @param string $replyTo Email address to reply to
     * @param string $replyToName Display name of the reply to address
     * @param array <string> $to List of email recipients (each email is treated separately, like a BCC). Separated by comma or semicolon.
     * @param array <string> $msgTo Optional parameter. Will be ignored if the 'to' parameter is also provided. List of email recipients (visible to all other recipients of the message as TO MIME header). Separated by comma or semicolon.
     * @param array <string> $msgCC Optional parameter. Will be ignored if the 'to' parameter is also provided. List of email recipients (visible to all other recipients of the message as CC MIME header). Separated by comma or semicolon.
     * @param array <string> $msgBcc Optional parameter. Will be ignored if the 'to' parameter is also provided. List of email recipients (each email is treated seperately). Separated by comma or semicolon.
     * @param array <string> $lists The name of a contact list you would like to send to. Separate multiple contact lists by commas or semicolons.
     * @param array <string> $segments The name of a segment you would like to send to. Separate multiple segments by comma or semicolon. Input "0" for "All Contacts".
     * @param string $mergeSourceFilename File name one of attachments which is a CSV list of Recipients.
     * @param string $channel An ID field (max 60 chars) that can be used for reporting [will default to HTTP API or SMTP API]
     * @param string $bodyHtml Html email body
     * @param string $bodyText Text email body
     * @param string $charset Text value of charset encoding for example: iso-8859-1, windows-1251, utf-8, us-ascii, windows-1250 and more…
     * @param string $charsetBodyHtml Sets charset for body html MIME part (overrides default value from charset parameter)
     * @param string $charsetBodyText Sets charset for body text MIME part (overrides default value from charset parameter)
     * @param ApiTypes\EncodingType $encodingType 0 for None, 1 for Raw7Bit, 2 for Raw8Bit, 3 for QuotedPrintable, 4 for Base64 (Default), 5 for Uue  note that you can also provide the text version such as "Raw7Bit" for value 1.  NOTE: Base64 or QuotedPrintable is recommended if you are validating your domain(s) with DKIM.
     * @param string $template The name of an email template you have created in your account.
     * @param array <File> $attachmentFiles Attachment files. These files should be provided with the POST multipart file upload, not directly in the request's URL. Should also include merge CSV file
     * @param array <string, string> $headers Optional Custom Headers. Request parameters prefixed by headers_ like headers_customheader1, headers_customheader2. Note: a space is required after the colon before the custom header value. headers_customheader1=customheader1: header-value1 headers_customheader2 = customheader2: header-value2
     * @param string $postBack Optional header returned in notifications.
     * @param array <string, string> $merge Request parameters prefixed by merge_ like merge_firstname, merge_lastname. If sending to a template you can send merge_ fields to merge data with the template. Template fields are entered with {firstname}, {lastname} etc.
     * @param string $timeOffSetMinutes Number of minutes in the future this email should be sent
     * @return ApiTypes\EmailSend
     */
    public function Send($subject = null, $from = null, $fromName = null, $sender = null, $senderName = null, $msgFrom = null, $msgFromName = null, $replyTo = null, $replyToName = null, array $to = array(), array $msgTo = array(), array $msgCC = array(), array $msgBcc = array(), array $lists = array(), array $segments = array(), $mergeSourceFilename = null, $channel = null, $bodyHtml = null, $bodyText = null, $charset = null, $charsetBodyHtml = null, $charsetBodyText = null, $encodingType = ApiTypes\EncodingType::None, $template = null, array $attachmentFiles = array(), array $headers = array(), $postBack = null, array $merge = array(), $timeOffSetMinutes = null)
    {
        return ApiClient::Request('email/send', array(
            'subject' => $subject,
            'from' => $from,
            'fromName' => $fromName,
            'sender' => $sender,
            'senderName' => $senderName,
            'msgFrom' => $msgFrom,
            'msgFromName' => $msgFromName,
            'replyTo' => $replyTo,
            'replyToName' => $replyToName,
            'to' => (count($to) === 0) ? null : join(';', $to),
            'msgTo' => (count($msgTo) === 0) ? null : join(';', $msgTo),
            'msgCC' => (count($msgCC) === 0) ? null : join(';', $msgCC),
            'msgBcc' => (count($msgBcc) === 0) ? null : join(';', $msgBcc),
            'lists' => (count($lists) === 0) ? null : join(';', $lists),
            'segments' => (count($segments) === 0) ? null : join(';', $segments),
            'mergeSourceFilename' => $mergeSourceFilename,
            'channel' => $channel,
            'bodyHtml' => $bodyHtml,
            'bodyText' => $bodyText,
            'charset' => $charset,
            'charsetBodyHtml' => $charsetBodyHtml,
            'charsetBodyText' => $charsetBodyText,
            'encodingType' => $encodingType,
            'template' => $template,
            $headers,
            'postBack' => $postBack,
            $merge,
            'timeOffSetMinutes' => $timeOffSetMinutes
        ), "POST", $attachmentFiles);
    }

    /**
     * Detailed status of a unique email sent through your account.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $messageID Unique identifier for this email.
     * @return ApiTypes\EmailStatus
     */
    public function Status($messageID)
    {
        return ApiClient::Request('email/status', array(
            'messageID' => $messageID
        ));
    }

    /**
     * View email
     * @param string $messageID Message identifier
     * @return ApiTypes\EmailView
     */
    public function View($messageID)
    {
        return ApiClient::Request('email/view', array(
            'messageID' => $messageID
        ));
    }

}

/**
 *
 */
class Export
{
    /**
     * Check the current status of the export.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param Guid $publicExportID
     * @return ApiTypes\ExportStatus
     */
    public function CheckStatus($publicExportID)
    {
        return ApiClient::Request('export/checkstatus', array(
            'publicExportID' => $publicExportID
        ));
    }

    /**
     * Summary of export type counts.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @return ApiTypes\ExportTypeCounts
     */
    public function CountByType()
    {
        return ApiClient::Request('export/countbytype');
    }

    /**
     * Delete the specified export.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param Guid $publicExportID
     */
    public function EEDelete($publicExportID)
    {
        return ApiClient::Request('export/delete', array(
            'publicExportID' => $publicExportID
        ));
    }

    /**
     * Returns a list of all exported data.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param int $limit Maximum of loaded items.
     * @param int $offset How many items should be loaded ahead.
     * @return Array<ApiTypes\Export>
     */
    public function EEList($limit = 0, $offset = 0)
    {
        return ApiClient::Request('export/list', array(
            'limit' => $limit,
            'offset' => $offset
        ));
    }

}

/**
 * API methods for managing your Lists
 */
class EEList
{
    /**
     * Create new list, based on filtering rule or list of IDs
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $listName Name of your list.
     * @param bool $createEmptyList True to create an empty list, otherwise false. Ignores rule and emails parameters if provided.
     * @param bool $allowUnsubscribe True: Allow unsubscribing from this list. Otherwise, false
     * @param string $rule Query used for filtering.
     * @param array <string> $emails Comma delimited list of contact emails
     * @param bool $allContacts True: Include every Contact in your Account. Otherwise, false
     * @return int
     */
    public function Add($listName, $createEmptyList = false, $allowUnsubscribe = false, $rule = null, array $emails = array(), $allContacts = false)
    {
        return ApiClient::Request('list/add', array(
            'listName' => $listName,
            'createEmptyList' => $createEmptyList,
            'allowUnsubscribe' => $allowUnsubscribe,
            'rule' => $rule,
            'emails' => (count($emails) === 0) ? null : join(';', $emails),
            'allContacts' => $allContacts
        ));
    }

    /**
     * Add Contacts to chosen list
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $listName Name of your list.
     * @param string $rule Query used for filtering.
     * @param array <string> $emails Comma delimited list of contact emails
     * @param bool $allContacts True: Include every Contact in your Account. Otherwise, false
     */
    public function AddContacts($listName, $rule = null, array $emails = array(), $allContacts = false)
    {
        return ApiClient::Request('list/addcontacts', array(
            'listName' => $listName,
            'rule' => $rule,
            'emails' => (count($emails) === 0) ? null : join(';', $emails),
            'allContacts' => $allContacts
        ));
    }

    /**
     * Create a series of nth selection lists from an existing list or segment
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $listName Name of your list.
     * @param int $numberOfLists The number of evenly distributed lists to create.
     * @param bool $excludeBlocked True if you want to exclude contacts that are currently in a blocked status of either unsubscribe, complaint or bounce. Otherwise, false.
     * @param bool $allowUnsubscribe True: Allow unsubscribing from this list. Otherwise, false
     * @param string $rule Query used for filtering.
     * @param bool $allContacts True: Include every Contact in your Account. Otherwise, false
     */
    public function CreateNthSelectionLists($listName, $numberOfLists, $excludeBlocked = true, $allowUnsubscribe = false, $rule = null, $allContacts = false)
    {
        return ApiClient::Request('list/createnthselectionlists', array(
            'listName' => $listName,
            'numberOfLists' => $numberOfLists,
            'excludeBlocked' => $excludeBlocked,
            'allowUnsubscribe' => $allowUnsubscribe,
            'rule' => $rule,
            'allContacts' => $allContacts
        ));
    }

    /**
     * Create a new list with randomized contacts from an existing list or segment
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $listName Name of your list.
     * @param int $count Number of items.
     * @param bool $excludeBlocked True if you want to exclude contacts that are currently in a blocked status of either unsubscribe, complaint or bounce. Otherwise, false.
     * @param bool $allowUnsubscribe True: Allow unsubscribing from this list. Otherwise, false
     * @param string $rule Query used for filtering.
     * @param bool $allContacts True: Include every Contact in your Account. Otherwise, false
     * @return int
     */
    public function CreateRandomList($listName, $count, $excludeBlocked = true, $allowUnsubscribe = false, $rule = null, $allContacts = false)
    {
        return ApiClient::Request('list/createrandomlist', array(
            'listName' => $listName,
            'count' => $count,
            'excludeBlocked' => $excludeBlocked,
            'allowUnsubscribe' => $allowUnsubscribe,
            'rule' => $rule,
            'allContacts' => $allContacts
        ));
    }

    /**
     * Deletes List and removes all the Contacts from it (does not delete Contacts).
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $listName Name of your list.
     */
    public function EEDelete($listName)
    {
        return ApiClient::Request('list/delete', array(
            'listName' => $listName
        ));
    }

    /**
     * Exports all the contacts from the provided list
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $listName Name of your list.
     * @param ApiTypes\ExportFileFormats $fileFormat
     * @param ApiTypes\CompressionFormat $compressionFormat FileResponse compression format. None or Zip.
     * @param string $fileName Name of your file.
     * @return ApiTypes\ExportLink
     */
    public function Export($listName, $fileFormat = ApiTypes\ExportFileFormats::Csv, $compressionFormat = ApiTypes\CompressionFormat::None, $fileName = null)
    {
        return ApiClient::Request('list/export', array(
            'listName' => $listName,
            'fileFormat' => $fileFormat,
            'compressionFormat' => $compressionFormat,
            'fileName' => $fileName
        ));
    }

    /**
     * Shows all your existing lists
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @return Array<ApiTypes\List>
     */
    public function EElist()
    {
        return ApiClient::Request('list/list');
    }

    /**
     * Returns detailed information about specific list.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $listName Name of your list.
     * @return ApiTypes\List
     */
    public function Load($listName)
    {
        return ApiClient::Request('list/load', array(
            'listName' => $listName
        ));
    }

    /**
     * Remove selected Contacts from your list
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $listName Name of your list.
     * @param string $rule Query used for filtering.
     * @param array <string> $emails Comma delimited list of contact emails
     */
    public function RemoveContacts($listName, $rule = null, array $emails = array())
    {
        return ApiClient::Request('list/removecontacts', array(
            'listName' => $listName,
            'rule' => $rule,
            'emails' => (count($emails) === 0) ? null : join(';', $emails)
        ));
    }

    /**
     * Update existing list
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $listName Name of your list.
     * @param string $newListName Name of your list if you want to change it.
     * @param bool $allowUnsubscribe True: Allow unsubscribing from this list. Otherwise, false
     */
    public function Update($listName, $newListName, $allowUnsubscribe)
    {
        return ApiClient::Request('list/update', array(
            'listName' => $listName,
            'newListName' => $newListName,
            'allowUnsubscribe' => $allowUnsubscribe
        ));
    }

}

/**
 * Methods to check logs of your campaigns
 */
class Log
{
    /**
     * Cancels emails that are waiting to be sent.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $channelName Name of selected channel.
     * @param string $transactionID ID number of transaction
     */
    public function CancelInProgress($channelName = null, $transactionID = null)
    {
        return ApiClient::Request('log/cancelinprogress', array(
            'channelName' => $channelName,
            'transactionID' => $transactionID
        ));
    }

    /**
     * Track link clicks
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param ?DateTime $from Starting date for search in YYYY-MM-DDThh:mm:ss format.
     * @param ?DateTime $to Ending date for search in YYYY-MM-DDThh:mm:ss format.
     * @param int $limit Maximum of loaded items.
     * @param int $offset How many items should be loaded ahead.
     * @param string $channelName Name of selected channel.
     * @return ApiTypes\LinkTrackingDetails
     */
    public function LinkTracking($from, $to, $limit = 0, $offset = 0, $channelName = null)
    {
        return ApiClient::Request('log/linktracking', array(
            'from' => $from,
            'to' => $to,
            'limit' => $limit,
            'offset' => $offset,
            'channelName' => $channelName
        ));
    }

    /**
     * Returns logs filtered by specified parameters.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param array <ApiTypes\LogJobStatus> $statuses List of comma separated message statuses: 0 or all, 1 for ReadyToSend, 2 for InProgress, 4 for Bounced, 5 for Sent, 6 for Opened, 7 for Clicked, 8 for Unsubscribed, 9 for Abuse Report
     * @param ?DateTime $from Starting date for search in YYYY-MM-DDThh:mm:ss format.
     * @param ?DateTime $to Ending date for search in YYYY-MM-DDThh:mm:ss format.
     * @param string $channelName Name of selected channel.
     * @param int $limit Maximum of loaded items.
     * @param int $offset How many items should be loaded ahead.
     * @param bool $includeEmail True: Search includes emails. Otherwise, false.
     * @param bool $includeSms True: Search includes SMS. Otherwise, false.
     * @param int $messagecategory ID of message category
     * @return ApiTypes\Log
     */
    public function Load($statuses, $from = null, $to = null, $channelName = null, $limit = 0, $offset = 0, $includeEmail = true, $includeSms = true, $messagecategory = -1)
    {
        return ApiClient::Request('log/load', array(
            'statuses' => (count($statuses) === 0) ? null : join(';', $statuses),
            'from' => $from,
            'to' => $to,
            'channelName' => $channelName,
            'limit' => $limit,
            'offset' => $offset,
            'includeEmail' => $includeEmail,
            'includeSms' => $includeSms,
            'messagecategory' => $messagecategory
        ));
    }

    /**
     * Retry sending of temporarily not delivered message.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $msgID ID number of selected message.
     */
    public function RetryNow($msgID)
    {
        return ApiClient::Request('log/retrynow', array(
            'msgID' => $msgID
        ));
    }

    /**
     * Loads summary information about activity in chosen date range.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param DateTime $from Starting date for search in YYYY-MM-DDThh:mm:ss format.
     * @param DateTime $to Ending date for search in YYYY-MM-DDThh:mm:ss format.
     * @param string $channelName Name of selected channel.
     * @param string $interval 'Hourly' for detailed information, 'summary' for daily overview
     * @param string $transactionID ID number of transaction
     * @return ApiTypes\LogSummary
     */
    public function Summary($from, $to, $channelName = null, $interval = "summary", $transactionID = null)
    {
        return ApiClient::Request('log/summary', array(
            'from' => $from,
            'to' => $to,
            'channelName' => $channelName,
            'interval' => $interval,
            'transactionID' => $transactionID
        ));
    }

}

/**
 * Manages your segments - dynamically created lists of contacts
 */
class Segment
{
    /**
     * Create new segment, based on specified RULE.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $segmentName Name of your segment.
     * @param string $rule Query used for filtering.
     * @return ApiTypes\Segment
     */
    public function Add($segmentName, $rule)
    {
        return ApiClient::Request('segment/add', array(
            'segmentName' => $segmentName,
            'rule' => $rule
        ));
    }

    /**
     * Delete existing segment.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $segmentName Name of your segment.
     */
    public function EEDelete($segmentName)
    {
        return ApiClient::Request('segment/delete', array(
            'segmentName' => $segmentName
        ));
    }

    /**
     * Exports all the contacts from the provided segment
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $segmentName Name of your segment.
     * @param ApiTypes\ExportFileFormats $fileFormat
     * @param ApiTypes\CompressionFormat $compressionFormat FileResponse compression format. None or Zip.
     * @param string $fileName Name of your file.
     * @return ApiTypes\ExportLink
     */
    public function Export($segmentName, $fileFormat = ApiTypes\ExportFileFormats::Csv, $compressionFormat = ApiTypes\CompressionFormat::None, $fileName = null)
    {
        return ApiClient::Request('segment/export', array(
            'segmentName' => $segmentName,
            'fileFormat' => $fileFormat,
            'compressionFormat' => $compressionFormat,
            'fileName' => $fileName
        ));
    }

    /**
     * Lists all your available Segments
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param bool $includeHistory True: Include history of last 30 days. Otherwise, false.
     * @return Array<ApiTypes\Segment>
     */
    public function EEList($includeHistory = false)
    {
        return ApiClient::Request('segment/list', array(
            'includeHistory' => $includeHistory
        ));
    }

    /**
     * Rename or change RULE for your segment
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $segmentName Name of your segment.
     * @param string $newSegmentName New name of your segment if you want to change it.
     * @param string $rule Query used for filtering.
     * @return ApiTypes\Segment
     */
    public function Update($segmentName, $newSegmentName = null, $rule = null)
    {
        return ApiClient::Request('segment/update', array(
            'segmentName' => $segmentName,
            'newSegmentName' => $newSegmentName,
            'rule' => $rule
        ));
    }

}

/**
 * Managing texting to your clients.
 */
class SMS
{
    /**
     * Send a short SMS Message (maximum of 1600 characters) to any mobile phone.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $to Mobile number you want to message. Can be any valid mobile number in E.164 format. To provide the country code you need to provide "+" before the number.  If your URL is not encoded then you need to replace the "+" with "%2B" instead.
     * @param string $body Body of your message. The maximum body length is 160 characters.  If the message body is greater than 160 characters it is split into multiple messages and you are charged per message for the number of message required to send your length
     */
    public function Send($to, $body)
    {
        return ApiClient::Request('sms/send', array(
            'to' => $to,
            'body' => $body
        ));
    }

}

/**
 * Methods to organize and get results of your surveys
 */
class Survey
{
    /**
     * Adds a new survey
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param ApiTypes\Survey $survey Json representation of a survey
     * @return ApiTypes\Survey
     */
    public function Add($survey)
    {
        return ApiClient::Request('survey/add', array(
            'survey' => $survey
        ));
    }

    /**
     * Deletes the survey
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param Guid $publicSurveyID Survey identifier
     */
    public function EEDelete($publicSurveyID)
    {
        return ApiClient::Request('survey/delete', array(
            'publicSurveyID' => $publicSurveyID
        ));
    }

    /**
     * Export given survey's data to provided format
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param Guid $publicSurveyID Survey identifier
     * @param string $fileName Name of your file.
     * @param ApiTypes\ExportFileFormats $fileFormat
     * @param ApiTypes\CompressionFormat $compressionFormat FileResponse compression format. None or Zip.
     */
    public function Export($publicSurveyID, $fileName, $fileFormat = ApiTypes\ExportFileFormats::Csv, $compressionFormat = ApiTypes\CompressionFormat::None)
    {
        return ApiClient::Request('survey/export', array(
            'publicSurveyID' => $publicSurveyID,
            'fileName' => $fileName,
            'fileFormat' => $fileFormat,
            'compressionFormat' => $compressionFormat
        ));
    }

    /**
     * Shows all your existing surveys
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @return Array<ApiTypes\Survey>
     */
    public function EEList()
    {
        return ApiClient::Request('survey/list');
    }

    /**
     * Get list of personal answers for the specific survey
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param Guid $publicSurveyID Survey identifier
     * @return Array<ApiTypes\SurveyResultInfo>
     */
    public function LoadResponseList($publicSurveyID)
    {
        return ApiClient::Request('survey/loadresponselist', array(
            'publicSurveyID' => $publicSurveyID
        ));
    }

    /**
     * Get general results of the specific survey
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param Guid $publicSurveyID Survey identifier
     * @return ApiTypes\SurveyResultsSummaryInfo
     */
    public function LoadResults($publicSurveyID)
    {
        return ApiClient::Request('survey/loadresults', array(
            'publicSurveyID' => $publicSurveyID
        ));
    }

    /**
     * Update the survey information
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param ApiTypes\Survey $survey Json representation of a survey
     * @return ApiTypes\Survey
     */
    public function Update($survey)
    {
        return ApiClient::Request('survey/update', array(
            'survey' => $survey
        ));
    }

}

/**
 * Managing and editing templates of your emails
 */
class Template
{
    /**
     * Create new Template. Needs to be sent using POST method
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param ApiTypes\TemplateType $templateType 0 for API connections
     * @param string $templateName Name of template.
     * @param string $subject Default subject of email.
     * @param string $fromEmail Default From: email address.
     * @param string $fromName Default From: name.
     * @param ApiTypes\TemplateScope $templateScope Enum: 0 - private, 1 - public, 2 - mockup
     * @param string $bodyHtml HTML code of email (needs escaping).
     * @param string $bodyText Text body of email.
     * @param string $css CSS style
     * @param int $originalTemplateID ID number of original template.
     * @return int
     */
    public function Add($templateType, $templateName, $subject, $fromEmail, $fromName, $templateScope = ApiTypes\TemplateScope::EEPrivate, $bodyHtml = null, $bodyText = null, $css = null, $originalTemplateID = 0)
    {
        return ApiClient::Request('template/add', array(
            'templateType' => $templateType,
            'templateName' => $templateName,
            'subject' => $subject,
            'fromEmail' => $fromEmail,
            'fromName' => $fromName,
            'templateScope' => $templateScope,
            'bodyHtml' => $bodyHtml,
            'bodyText' => $bodyText,
            'css' => $css,
            'originalTemplateID' => $originalTemplateID
        ));
    }

    /**
     * Check if template is used by campaign.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param int $templateID ID number of template.
     * @return bool
     */
    public function CheckUsage($templateID)
    {
        return ApiClient::Request('template/checkusage', array(
            'templateID' => $templateID
        ));
    }

    /**
     * Copy Selected Template
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param int $templateID ID number of template.
     * @param string $templateName Name of template.
     * @param string $subject Default subject of email.
     * @param string $fromEmail Default From: email address.
     * @param string $fromName Default From: name.
     * @return ApiTypes\Template
     */
    public function EECopy($templateID, $templateName, $subject, $fromEmail, $fromName)
    {
        return ApiClient::Request('template/copy', array(
            'templateID' => $templateID,
            'templateName' => $templateName,
            'subject' => $subject,
            'fromEmail' => $fromEmail,
            'fromName' => $fromName
        ));
    }

    /**
     * Delete template with the specified ID
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param int $templateID ID number of template.
     */
    public function EEDelete($templateID)
    {
        return ApiClient::Request('template/delete', array(
            'templateID' => $templateID
        ));
    }

    /**
     * Search for references to images and replaces them with base64 code.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param int $templateID ID number of template.
     * @return string
     */
    public function GetEmbeddedHtml($templateID)
    {
        return ApiClient::Request('template/getembeddedhtml', array(
            'templateID' => $templateID
        ));
    }

    /**
     * Lists your templates
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param int $limit Maximum of loaded items.
     * @param int $offset How many items should be loaded ahead.
     * @return ApiTypes\TemplateList
     */
    public function GetList($limit = 200, $offset = 0)
    {
        return ApiClient::Request('template/getlist', array(
            'limit' => $limit,
            'offset' => $offset
        ));
    }

    /**
     * Load template with content
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param int $templateID ID number of template.
     * @param bool $ispublic
     * @return ApiTypes\Template
     */
    public function LoadTemplate($templateID, $ispublic = false)
    {
        return ApiClient::Request('template/loadtemplate', array(
            'templateID' => $templateID,
            'ispublic' => $ispublic
        ));
    }

    /**
     * Removes previously generated screenshot of template
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param int $templateID ID number of template.
     */
    public function RemoveScreenshot($templateID)
    {
        return ApiClient::Request('template/removescreenshot', array(
            'templateID' => $templateID
        ));
    }

    /**
     * Saves screenshot of chosen Template
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param string $base64Image Image, base64 coded.
     * @param int $templateID ID number of template.
     * @return string
     */
    public function SaveScreenshot($base64Image, $templateID)
    {
        return ApiClient::Request('template/savescreenshot', array(
            'base64Image' => $base64Image,
            'templateID' => $templateID
        ));
    }

    /**
     * Update existing template, overwriting existing data. Needs to be sent using POST method.
     * @param string $apikey ApiKey that gives you access to our SMTP and HTTP API's.
     * @param int $templateID ID number of template.
     * @param ApiTypes\TemplateScope $templateScope Enum: 0 - private, 1 - public, 2 - mockup
     * @param string $templateName Name of template.
     * @param string $subject Default subject of email.
     * @param string $fromEmail Default From: email address.
     * @param string $fromName Default From: name.
     * @param string $bodyHtml HTML code of email (needs escaping).
     * @param string $bodyText Text body of email.
     * @param string $css CSS style
     * @param bool $removeScreenshot
     */
    public function Update($templateID, $templateScope = ApiTypes\TemplateScope::EEPrivate, $templateName = null, $subject = null, $fromEmail = null, $fromName = null, $bodyHtml = null, $bodyText = null, $css = null, $removeScreenshot = true)
    {
        return ApiClient::Request('template/update', array(
            'templateID' => $templateID,
            'templateScope' => $templateScope,
            'templateName' => $templateName,
            'subject' => $subject,
            'fromEmail' => $fromEmail,
            'fromName' => $fromName,
            'bodyHtml' => $bodyHtml,
            'bodyText' => $bodyText,
            'css' => $css,
            'removeScreenshot' => $removeScreenshot
        ));
    }

}


namespace ApiTypes;

/**
 * Detailed information about your account
 */
class Account
{
    /**
     * Code used for tax purposes.
     */
    public /*string*/
        $TaxCode;

    /**
     * Public key for limited access to your account such as contact/add so you can use it safely on public websites.
     */
    public /*string*/
        $PublicAccountID;

    /**
     * ApiKey that gives you access to our SMTP and HTTP API's.
     */
    public /*string*/
        $ApiKey;

    /**
     * Second ApiKey that gives you access to our SMTP and HTTP API's.  Used mainly for changing ApiKeys without disrupting services.
     */
    public /*string*/
        $ApiKey2;

    /**
     * True, if account is a subaccount. Otherwise, false
     */
    public /*bool*/
        $IsSub;

    /**
     * The number of subaccounts this account has.
     */
    public /*long*/
        $SubAccountsCount;

    /**
     * Number of status: 1 - Active
     */
    public /*int*/
        $StatusNumber;

    /**
     * Account status: Active
     */
    public /*string*/
        $StatusFormatted;

    /**
     * Type of account: 1 for Transactional Email, 2 for Marketing Email.
     */
    public /*ApiTypes\AccountType*/
        $AccountType;

    /**
     * URL form for payments.
     */
    public /*string*/
        $PaymentFormUrl;

    /**
     * URL to your logo image.
     */
    public /*string*/
        $LogoUrl;

    /**
     * HTTP address of your website.
     */
    public /*string*/
        $Website;

    /**
     * True: Turn on or off ability to send mails under your brand. Otherwise, false
     */
    public /*bool*/
        $EnablePrivateBranding;

    /**
     * Address to your support.
     */
    public /*string*/
        $SupportLink;

    /**
     * Subdomain for your rebranded service
     */
    public /*string*/
        $PrivateBrandingUrl;

    /**
     * First name.
     */
    public /*string*/
        $FirstName;

    /**
     * Last name.
     */
    public /*string*/
        $LastName;

    /**
     * Company name.
     */
    public /*string*/
        $Company;

    /**
     * First line of address.
     */
    public /*string*/
        $Address1;

    /**
     * Second line of address.
     */
    public /*string*/
        $Address2;

    /**
     * City.
     */
    public /*string*/
        $City;

    /**
     * State or province.
     */
    public /*string*/
        $State;

    /**
     * Zip/postal code.
     */
    public /*string*/
        $Zip;

    /**
     * Numeric ID of country.
     */
    public /*?int*/
        $CountryID;

    /**
     * Phone number
     */
    public /*string*/
        $Phone;

    /**
     * Proper email address.
     */
    public /*string*/
        $Email;

    /**
     * URL for affiliating.
     */
    public /*string*/
        $AffiliateLink;

    /**
     * Numeric reputation
     */
    public /*double*/
        $Reputation;

    /**
     * Amount of emails sent from this account
     */
    public /*long*/
        $TotalEmailsSent;

    /**
     * Amount of emails sent from this account
     */
    public /*?long*/
        $MonthlyEmailsSent;

    /**
     * Amount of emails sent from this account
     */
    public /*decimal*/
        $Credit;

    /**
     * Amount of email credits
     */
    public /*int*/
        $EmailCredits;

    /**
     * Amount of emails sent from this account
     */
    public /*decimal*/
        $PricePerEmail;

    /**
     * Why your clients are receiving your emails.
     */
    public /*string*/
        $DeliveryReason;

    /**
     * URL for making payments.
     */
    public /*string*/
        $AccountPaymentUrl;

    /**
     * Address of SMTP server.
     */
    public /*string*/
        $Smtp;

    /**
     * Address of alternative SMTP server.
     */
    public /*string*/
        $SmtpAlternative;

    /**
     * Status of automatic payments configuration.
     */
    public /*string*/
        $AutoCreditStatus;

    /**
     * When AutoCreditStatus is Enabled, the credit level that triggers the credit to be recharged.
     */
    public /*decimal*/
        $AutoCreditLevel;

    /**
     * When AutoCreditStatus is Enabled, the amount of credit to be recharged.
     */
    public /*decimal*/
        $AutoCreditAmount;

    /**
     * Amount of emails account can send daily
     */
    public /*int*/
        $DailySendLimit;

    /**
     * Creation date.
     */
    public /*DateTime*/
        $DateCreated;

    /**
     * True, if you have enabled link tracking. Otherwise, false
     */
    public /*bool*/
        $LinkTracking;

    /**
     * Type of content encoding
     */
    public /*string*/
        $ContentTransferEncoding;

    /**
     * Amount of Litmus credits
     */
    public /*decimal*/
        $LitmusCredits;

    /**
     * Enable advanced tools on your Account.
     */
    public /*bool*/
        $EnableContactFeatures;

}

/**
 * Basic overview of your account
 */
class AccountOverview
{
    /**
     * Amount of emails sent from this account
     */
    public /*long*/
        $TotalEmailsSent;

    /**
     * Amount of emails sent from this account
     */
    public /*decimal*/
        $Credit;

    /**
     * Cost of 1000 emails
     */
    public /*decimal*/
        $CostPerThousand;

    /**
     * Number of messages in progress
     */
    public /*long*/
        $InProgressCount;

    /**
     * Number of contacts currently with blocked status of Unsubscribed, Complaint, Bounced or InActive
     */
    public /*long*/
        $BlockedContactsCount;

    /**
     * Numeric reputation
     */
    public /*double*/
        $Reputation;

    /**
     * Number of contacts
     */
    public /*long*/
        $ContactCount;

    /**
     * Number of created campaigns
     */
    public /*long*/
        $CampaignCount;

    /**
     * Number of available templates
     */
    public /*long*/
        $TemplateCount;

    /**
     * Number of created subaccounts
     */
    public /*long*/
        $SubAccountCount;

    /**
     * Number of active referrals
     */
    public /*long*/
        $ReferralCount;

}

/**
 *
 * Enum class
 */
abstract class AccountType
{
    /**
     * Account is used for sending transactional mail only.
     */
    const Transactional = 1;

    /**
     * Account is used for sending bulk marketing email
     */
    const Marketing = 2;

}

/**
 * Lists advanced sending options of your account.
 */
class AdvancedOptions
{
    /**
     * True, if you want to track clicks. Otherwise, false
     */
    public /*bool*/
        $EnableClickTracking;

    /**
     * True, if you want to track by link tracking. Otherwise, false
     */
    public /*bool*/
        $EnableLinkClickTracking;

    /**
     * True, if text BODY of message should be created automatically. Otherwise, false
     */
    public /*bool*/
        $AutoTextFormat;

    /**
     * True, if you want bounce notifications returned. Otherwise, false
     */
    public /*bool*/
        $EmailNotificationForError;

    /**
     * True, if you want to send web notifications for sent email. Otherwise, false
     */
    public /*bool*/
        $WebNotificationForSent;

    /**
     * True, if you want to send web notifications for opened email. Otherwise, false
     */
    public /*bool*/
        $WebNotificationForOpened;

    /**
     * True, if you want to send web notifications for clicked email. Otherwise, false
     */
    public /*bool*/
        $WebNotificationForClicked;

    /**
     * True, if you want to send web notifications for unsubscribed email. Otherwise, false
     */
    public /*bool*/
        $WebnotificationForUnsubscribed;

    /**
     * True, if you want to send web notifications for complaint email. Otherwise, false
     */
    public /*bool*/
        $WebNotificationForAbuse;

    /**
     * True, if you want to send web notifications for bounced email. Otherwise, false
     */
    public /*bool*/
        $WebNotificationForError;

    /**
     * True, if you want to receive low credit email notifications. Otherwise, false
     */
    public /*bool*/
        $LowCreditNotification;

    /**
     * True, if you want inbound email to only process contacts from your account. Otherwise, false
     */
    public /*bool*/
        $InboundContactsOnly;

    /**
     * True, if this account is a sub-account. Otherwise, false
     */
    public /*bool*/
        $IsSubAccount;

    /**
     * True, if this account resells Elastic Email. Otherwise, false.
     */
    public /*bool*/
        $IsOwnedByReseller;

    /**
     * True, if you want to enable list-unsubscribe header. Otherwise, false
     */
    public /*bool*/
        $EnableUnsubscribeHeader;

    /**
     * True, if you want to apply custom headers to your emails. Otherwise, false
     */
    public /*bool*/
        $AllowCustomHeaders;

    /**
     * Email address to send a copy of all email to.
     */
    public /*string*/
        $BccEmail;

    /**
     * Type of content encoding
     */
    public /*string*/
        $ContentTransferEncoding;

    /**
     * True, if you want to receive bounce email notifications. Otherwise, false
     */
    public /*string*/
        $EmailNotification;

    /**
     * URL address to receive web notifications to parse and process.
     */
    public /*string*/
        $WebNotificationUrl;

    /**
     * URL used for tracking action of inbound emails
     */
    public /*string*/
        $HubCallbackUrl;

    /**
     * Domain you use as your inbound domain
     */
    public /*string*/
        $InboundDomain;

    /**
     * True, if account has tooltips active. Otherwise, false
     */
    public /*bool*/
        $EnableUITooltips;

    /**
     * True, if you want to use Advanced Tools.  Otherwise, false
     */
    public /*bool*/
        $EnableContactFeatures;

}

/**
 *
 * Enum class
 */
abstract class APIKeyAction
{
    /**
     * Add an additional APIKey to your Account.
     */
    const Add = 1;

    /**
     * Change this APIKey to a new one.
     */
    const Change = 2;

    /**
     * Delete this APIKey
     */
    const EEDelete = 3;

}

/**
 * Attachment data
 */
class Attachment
{
    /**
     * Name of your file.
     */
    public /*string*/
        $FileName;

    /**
     * ID number of your attachment
     */
    public /*string*/
        $ID;

    /**
     * Size of your attachment.
     */
    public /*int*/
        $Size;

}

/**
 * Blocked Contact - Contact returning Hard Bounces
 */
class BlockedContact
{
    /**
     * Proper email address.
     */
    public /*string*/
        $Email;

    /**
     * Name of status: Active, Engaged, Inactive, Abuse, Bounced, Unsubscribed.
     */
    public /*string*/
        $Status;

    /**
     * RFC error message
     */
    public /*string*/
        $FriendlyErrorMessage;

    /**
     * Last change date
     */
    public /*string*/
        $DateUpdated;

}

/**
 * Summary of bounced categories, based on specified date range.
 */
class BouncedCategorySummary
{
    /**
     * Number of messages marked as SPAM
     */
    public /*long*/
        $Spam;

    /**
     * Number of blacklisted messages
     */
    public /*long*/
        $BlackListed;

    /**
     * Number of messages flagged with 'No Mailbox'
     */
    public /*long*/
        $NoMailbox;

    /**
     * Number of messages flagged with 'Grey Listed'
     */
    public /*long*/
        $GreyListed;

    /**
     * Number of messages flagged with 'Throttled'
     */
    public /*long*/
        $Throttled;

    /**
     * Number of messages flagged with 'Timeout'
     */
    public /*long*/
        $Timeout;

    /**
     * Number of messages flagged with 'Connection Problem'
     */
    public /*long*/
        $ConnectionProblem;

    /**
     * Number of messages flagged with 'SPF Problem'
     */
    public /*long*/
        $SpfProblem;

    /**
     * Number of messages flagged with 'Account Problem'
     */
    public /*long*/
        $AccountProblem;

    /**
     * Number of messages flagged with 'DNS Problem'
     */
    public /*long*/
        $DnsProblem;

    /**
     * Number of messages flagged with 'WhiteListing Problem'
     */
    public /*long*/
        $WhitelistingProblem;

    /**
     * Number of messages flagged with 'Code Error'
     */
    public /*long*/
        $CodeError;

    /**
     * Number of messages flagged with 'Not Delivered'
     */
    public /*long*/
        $NotDelivered;

    /**
     * Number of manually cancelled messages
     */
    public /*long*/
        $ManualCancel;

    /**
     * Number of messages flagged with 'Connection terminated'
     */
    public /*long*/
        $ConnectionTerminated;

}

/**
 * Campaign
 */
class Campaign
{
    /**
     * ID number of selected Channel.
     */
    public /*?int*/
        $ChannelID;

    /**
     * Filename
     */
    public /*string*/
        $Name;

    /**
     * Name of status: Active, Engaged, Inactive, Abuse, Bounced, Unsubscribed.
     */
    public /*ApiTypes\CampaignStatus*/
        $Status;

    /**
     * List of Segment and List IDs, comma separated
     */
    public /*Array<string>*/
        $Targets;

    /**
     * Number of event, triggering mail sending
     */
    public /*ApiTypes\CampaignTriggerType*/
        $TriggerType;

    /**
     * Date of triggered send
     */
    public /*?DateTime*/
        $TriggerDate;

    /**
     * True, if campaign should be delayed. Otherwise, false.
     */
    public /*double*/
        $TriggerDelay;

    /**
     * When your next automatic mail will be sent, in days
     */
    public /*double*/
        $TriggerFrequency;

    /**
     * Date of send
     */
    public /*int*/
        $TriggerCount;

    /**
     * ID number of transaction
     */
    public /*int*/
        $TriggerChannelID;

    /**
     * Data for filtering event campaigns such as specific link addresses.
     */
    public /*string*/
        $TriggerData;

    /**
     * What should be checked for choosing the winner: opens or clicks
     */
    public /*ApiTypes\SplitOptimization*/
        $SplitOptimization;

    /**
     * Number of minutes between sends during optimization period
     */
    public /*int*/
        $SplitOptimizationMinutes;

    /**
     *
     */
    public /*Array<ApiTypes\CampaignTemplate>*/
        $CampaignTemplates;

}

/**
 * Channel
 */
class CampaignChannel
{
    /**
     * ID number of selected Channel.
     */
    public /*int*/
        $ChannelID;

    /**
     * Filename
     */
    public /*string*/
        $Name;

    /**
     * True, if you are sending a campaign. Otherwise, false.
     */
    public /*bool*/
        $IsCampaign;

    /**
     * ID number of mailer
     */
    public /*?int*/
        $MailerID;

    /**
     * Date of creation in YYYY-MM-DDThh:ii:ss format
     */
    public /*DateTime*/
        $DateAdded;

    /**
     * Name of status: Active, Engaged, Inactive, Abuse, Bounced, Unsubscribed.
     */
    public /*ApiTypes\CampaignStatus*/
        $Status;

    /**
     * Date of last activity on account
     */
    public /*?DateTime*/
        $LastActivity;

    /**
     * Datetime of last action done on campaign.
     */
    public /*?DateTime*/
        $LastProcessed;

    /**
     * Id number of parent channel
     */
    public /*int*/
        $ParentChannelID;

    /**
     * List of Segment and List IDs, comma separated
     */
    public /*Array<string>*/
        $Targets;

    /**
     * Number of event, triggering mail sending
     */
    public /*ApiTypes\CampaignTriggerType*/
        $TriggerType;

    /**
     * Date of triggered send
     */
    public /*?DateTime*/
        $TriggerDate;

    /**
     * True, if campaign should be delayed. Otherwise, false.
     */
    public /*double*/
        $TriggerDelay;

    /**
     * When your next automatic mail will be sent, in days
     */
    public /*double*/
        $TriggerFrequency;

    /**
     * Date of send
     */
    public /*int*/
        $TriggerCount;

    /**
     * ID number of transaction
     */
    public /*int*/
        $TriggerChannelID;

    /**
     * Data for filtering event campaigns such as specific link addresses.
     */
    public /*string*/
        $TriggerData;

    /**
     * What should be checked for choosing the winner: opens or clicks
     */
    public /*ApiTypes\SplitOptimization*/
        $SplitOptimization;

    /**
     * Number of minutes between sends during optimization period
     */
    public /*int*/
        $SplitOptimizationMinutes;

    /**
     * ID number of template.
     */
    public /*?int*/
        $TemplateID;

    /**
     * Default subject of email.
     */
    public /*string*/
        $TemplateSubject;

    /**
     * Default From: email address.
     */
    public /*string*/
        $TemplateFromEmail;

    /**
     * Default From: name.
     */
    public /*string*/
        $TemplateFromName;

    /**
     * Default Reply: email address.
     */
    public /*string*/
        $TemplateReplyEmail;

    /**
     * Default Reply: name.
     */
    public /*string*/
        $TemplateReplyName;

    /**
     * Total emails clicked
     */
    public /*int*/
        $ClickedCount;

    /**
     * Total emails opened.
     */
    public /*int*/
        $OpenedCount;

    /**
     * Overall number of recipients
     */
    public /*int*/
        $RecipientCount;

    /**
     * Total emails sent.
     */
    public /*int*/
        $SentCount;

    /**
     * Total emails sent.
     */
    public /*int*/
        $FailedCount;

    /**
     * Total emails clicked
     */
    public /*int*/
        $UnsubscribedCount;

    /**
     * Abuses - mails sent to user without their consent
     */
    public /*int*/
        $FailedAbuse;

    /**
     * List of CampaignTemplate for sending A-X split testing.
     */
    public /*Array<ApiTypes\CampaignChannel>*/
        $TemplateChannels;

}

/**
 *
 * Enum class
 */
abstract class CampaignStatus
{
    /**
     * Campaign is logically deleted and not returned by API or interface calls.
     */
    const Deleted = -1;

    /**
     * Campaign is curently active and available.
     */
    const Active = 0;

    /**
     * Campaign is currently being processed for delivery.
     */
    const Processing = 1;

    /**
     * Campaign is currently sending.
     */
    const Sending = 2;

    /**
     * Campaign has completed sending.
     */
    const Completed = 3;

    /**
     * Campaign is currently paused and not sending.
     */
    const Paused = 4;

    /**
     * Campaign has been cancelled during delivery.
     */
    const Cancelled = 5;

    /**
     * Campaign is save as draft and not processing.
     */
    const Draft = 6;

}

/**
 *
 */
class CampaignTemplate
{
    /**
     * ID number of selected Channel.
     */
    public /*?int*/
        $ChannelID;

    /**
     * Name of status: Active, Engaged, Inactive, Abuse, Bounced, Unsubscribed.
     */
    public /*ApiTypes\CampaignStatus*/
        $Status;

    /**
     * ID number of mailer
     */
    public /*?int*/
        $MailerID;

    /**
     * ID number of template.
     */
    public /*?int*/
        $TemplateID;

    /**
     * Default subject of email.
     */
    public /*string*/
        $TemplateSubject;

    /**
     * Default From: email address.
     */
    public /*string*/
        $TemplateFromEmail;

    /**
     * Default From: name.
     */
    public /*string*/
        $TemplateFromName;

    /**
     * Default Reply: email address.
     */
    public /*string*/
        $TemplateReplyEmail;

    /**
     * Default Reply: name.
     */
    public /*string*/
        $TemplateReplyName;

}

/**
 *
 * Enum class
 */
abstract class CampaignTriggerType
{
    /**
     *
     */
    const SendNow = 1;

    /**
     *
     */
    const FutureScheduled = 2;

    /**
     *
     */
    const OnAdd = 3;

    /**
     *
     */
    const OnOpen = 4;

    /**
     *
     */
    const OnClick = 5;

}

/**
 * SMTP and HTTP API channel for grouping email delivery
 */
class Channel
{
    /**
     * Descriptive name of the channel.
     */
    public /*string*/
        $Name;

    /**
     * The date the channel was added to your account.
     */
    public /*DateTime*/
        $DateAdded;

    /**
     * The date the channel was last sent through.
     */
    public /*?DateTime*/
        $LastActivity;

    /**
     * The number of email jobs this channel has been used with.
     */
    public /*int*/
        $JobCount;

    /**
     * The number of emails that have been clicked within this channel.
     */
    public /*int*/
        $ClickedCount;

    /**
     * The number of emails that have been opened within this channel.
     */
    public /*int*/
        $OpenedCount;

    /**
     * The number of emails attempted to be sent within this channel.
     */
    public /*int*/
        $RecipientCount;

    /**
     * The number of emails that have been sent within this channel.
     */
    public /*int*/
        $SentCount;

    /**
     * The number of emails that have been bounced within this channel.
     */
    public /*int*/
        $FailedCount;

    /**
     * The number of emails that have been unsubscribed within this channel.
     */
    public /*int*/
        $UnsubscribedCount;

    /**
     * The number of emails that have been marked as abuse or complaint within this channel.
     */
    public /*int*/
        $FailedAbuse;

    /**
     * The total cost for emails/attachments within this channel.
     */
    public /*decimal*/
        $Cost;

}

/**
 * FileResponse compression format
 * Enum class
 */
abstract class CompressionFormat
{
    /**
     * No compression
     */
    const None = 0;

    /**
     * Zip compression
     */
    const Zip = 1;

}

/**
 * Contact
 */
class Contact
{
    /**
     * Date of creation in YYYY-MM-DDThh:ii:ss format
     */
    public /*DateTime*/
        $DateAdded;

    /**
     * Proper email address.
     */
    public /*string*/
        $Email;

    /**
     * First name.
     */
    public /*string*/
        $FirstName;

    /**
     * Last name.
     */
    public /*string*/
        $LastName;

    /**
     * Title
     */
    public /*string*/
        $Title;

    /**
     * Name of organization
     */
    public /*string*/
        $OrganizationName;

    /**
     * City.
     */
    public /*string*/
        $City;

    /**
     * Name of country.
     */
    public /*string*/
        $Country;

    /**
     * State or province.
     */
    public /*string*/
        $State;

    /**
     * Zip/postal code.
     */
    public /*string*/
        $Zip;

    /**
     * Phone number
     */
    public /*string*/
        $Phone;

    /**
     * Date of birth in YYYY-MM-DD format
     */
    public /*?DateTime*/
        $BirthDate;

    /**
     * Your gender
     */
    public /*string*/
        $Gender;

    /**
     * Name of status: Active, Engaged, Inactive, Abuse, Bounced, Unsubscribed.
     */
    public /*ApiTypes\ContactStatus*/
        $Status;

    /**
     * RFC Error code
     */
    public /*?int*/
        $BouncedErrorCode;

    /**
     * RFC error message
     */
    public /*string*/
        $BouncedErrorMessage;

    /**
     * Total emails sent.
     */
    public /*int*/
        $TotalSent;

    /**
     * Total emails sent.
     */
    public /*int*/
        $TotalFailed;

    /**
     * Total emails opened.
     */
    public /*int*/
        $TotalOpened;

    /**
     * Total emails clicked
     */
    public /*int*/
        $TotalClicked;

    /**
     * Date of first failed message
     */
    public /*?DateTime*/
        $FirstFailedDate;

    /**
     * Number of fails in sending to this Contact
     */
    public /*int*/
        $LastFailedCount;

    /**
     * Last change date
     */
    public /*DateTime*/
        $DateUpdated;

    /**
     * Source of URL of payment
     */
    public /*ApiTypes\ContactSource*/
        $Source;

    /**
     * RFC Error code
     */
    public /*?int*/
        $ErrorCode;

    /**
     * RFC error message
     */
    public /*string*/
        $FriendlyErrorMessage;

    /**
     * IP address
     */
    public /*string*/
        $CreatedFromIP;

    /**
     * Yearly revenue for the contact
     */
    public /*decimal*/
        $Revenue;

    /**
     * Number of purchases contact has made
     */
    public /*int*/
        $PurchaseCount;

    /**
     * Mobile phone number
     */
    public /*string*/
        $MobileNumber;

    /**
     * Fax number
     */
    public /*string*/
        $FaxNumber;

    /**
     * Biography for Linked-In
     */
    public /*string*/
        $LinkedInBio;

    /**
     * Number of Linked-In connections
     */
    public /*int*/
        $LinkedInConnections;

    /**
     * Biography for Twitter
     */
    public /*string*/
        $TwitterBio;

    /**
     * User name for Twitter
     */
    public /*string*/
        $TwitterUsername;

    /**
     * URL for Twitter photo
     */
    public /*string*/
        $TwitterProfilePhoto;

    /**
     * Number of Twitter followers
     */
    public /*int*/
        $TwitterFollowerCount;

    /**
     * Unsubscribed date in YYYY-MM-DD format
     */
    public /*?DateTime*/
        $UnsubscribedDate;

    /**
     * Industry contact works in
     */
    public /*string*/
        $Industry;

    /**
     * Number of employees
     */
    public /*int*/
        $NumberOfEmployees;

    /**
     * Annual revenue of contact
     */
    public /*?decimal*/
        $AnnualRevenue;

    /**
     * Date of first purchase in YYYY-MM-DD format
     */
    public /*?DateTime*/
        $FirstPurchase;

    /**
     * Date of last purchase in YYYY-MM-DD format
     */
    public /*?DateTime*/
        $LastPurchase;

    /**
     * Free form field of notes
     */
    public /*string*/
        $Notes;

    /**
     * Website of contact
     */
    public /*string*/
        $WebsiteUrl;

    /**
     * Number of page views
     */
    public /*int*/
        $PageViews;

    /**
     * Number of website visits
     */
    public /*int*/
        $Visits;

    /**
     * Number of messages sent last month
     */
    public /*?int*/
        $LastMonthSent;

    /**
     * Date this contact last opened an email
     */
    public /*?DateTime*/
        $LastOpened;

    /**
     *
     */
    public /*?DateTime*/
        $LastClicked;

    /**
     * Your gravatar hash for image
     */
    public /*string*/
        $GravatarHash;

}

/**
 * Collection of lists and segments
 */
class ContactCollection
{
    /**
     * Lists which contain the requested contact
     */
    public /*Array<ApiTypes\ContactContainer>*/
        $Lists;

    /**
     * Segments which contain the requested contact
     */
    public /*Array<ApiTypes\ContactContainer>*/
        $Segments;

}

/**
 * List's or segment's short info
 */
class ContactContainer
{
    /**
     * ID of the list/segment
     */
    public /*int*/
        $ID;

    /**
     * Name of the list/segment
     */
    public /*string*/
        $Name;

}

/**
 * History of chosen Contact
 */
class ContactHistory
{
    /**
     * ID of history of selected Contact.
     */
    public /*int*/
        $ContactHistoryID;

    /**
     * Type of event occured on this Contact.
     */
    public /*string*/
        $EventType;

    /**
     * Numeric code of event occured on this Contact.
     */
    public /*int*/
        $EventTypeValue;

    /**
     * Formatted date of event.
     */
    public /*string*/
        $EventDate;

    /**
     * Name of selected channel.
     */
    public /*string*/
        $ChannelName;

    /**
     * Name of template.
     */
    public /*string*/
        $TemplateName;

}

/**
 *
 * Enum class
 */
abstract class ContactSource
{
    /**
     * Source of the contact is not known.
     */
    const Unknown = 0;

    /**
     * Contact was inputted from the website interface.
     */
    const ManualInput = 1;

    /**
     * Contact was uploaded from the website interface.
     */
    const ListUpload = 2;

    /**
     * Contact was added from a public web form.
     */
    const WebForm = 3;

    /**
     * Contact was added from an API call.
     */
    const APICall = 4;

}

/**
 *
 * Enum class
 */
abstract class ContactStatus
{
    /**
     * Number of engaged contacts
     */
    const Engaged = -1;

    /**
     * Number of active contacts
     */
    const Active = 0;

    /**
     * Number of bounced messages
     */
    const Bounced = 1;

    /**
     * Number of unsubscribed messages
     */
    const Unsubscribed = 2;

    /**
     * Abuses - mails sent to user without their consent
     */
    const Abuse = 3;

    /**
     * Number of inactive contacts
     */
    const Inactive = 4;

}

/**
 * Number of Contacts, grouped by Status;
 */
class ContactStatusCounts
{
    /**
     * Number of engaged contacts
     */
    public /*long*/
        $Engaged;

    /**
     * Number of active contacts
     */
    public /*long*/
        $Active;

    /**
     * Number of complaint messages
     */
    public /*long*/
        $Complaint;

    /**
     * Number of unsubscribed messages
     */
    public /*long*/
        $Unsubscribed;

    /**
     * Number of bounced messages
     */
    public /*long*/
        $Bounced;

    /**
     * Number of inactive contacts
     */
    public /*long*/
        $Inactive;

}

/**
 * Daily summary of log status, based on specified date range.
 */
class DailyLogStatusSummary
{
    /**
     * Date in YYYY-MM-DDThh:ii:ss format
     */
    public /*string*/
        $Date;

    /**
     * Proper email address.
     */
    public /*int*/
        $Email;

    /**
     * Number of SMS
     */
    public /*int*/
        $Sms;

    /**
     * Number of delivered messages
     */
    public /*int*/
        $Delivered;

    /**
     * Number of opened messages
     */
    public /*int*/
        $Opened;

    /**
     * Number of clicked messages
     */
    public /*int*/
        $Clicked;

    /**
     * Number of unsubscribed messages
     */
    public /*int*/
        $Unsubscribed;

    /**
     * Number of complaint messages
     */
    public /*int*/
        $Complaint;

    /**
     * Number of bounced messages
     */
    public /*int*/
        $Bounced;

    /**
     * Number of inbound messages
     */
    public /*int*/
        $Inbound;

    /**
     * Number of manually cancelled messages
     */
    public /*int*/
        $ManualCancel;

}

/**
 * Domain data, with information about domain records.
 */
class DomainDetail
{
    /**
     * Name of selected domain.
     */
    public /*string*/
        $Domain;

    /**
     * True, if domain is used as default. Otherwise, false,
     */
    public /*bool*/
        $DefaultDomain;

    /**
     * True, if SPF record is verified
     */
    public /*bool*/
        $Spf;

    /**
     * True, if DKIM record is verified
     */
    public /*bool*/
        $Dkim;

    /**
     * True, if MX record is verified
     */
    public /*bool*/
        $MX;

    /**
     *
     */
    public /*bool*/
        $DMARC;

    /**
     * True, if tracking CNAME record is verified
     */
    public /*bool*/
        $IsRewriteDomainValid;

    /**
     * True, if verification is available
     */
    public /*bool*/
        $Verify;

}

/**
 * Detailed information about email credits
 */
class EmailCredits
{
    /**
     * Date in YYYY-MM-DDThh:ii:ss format
     */
    public /*DateTime*/
        $Date;

    /**
     * Amount of money in transaction
     */
    public /*decimal*/
        $Amount;

    /**
     * Source of URL of payment
     */
    public /*string*/
        $Source;

    /**
     * Free form field of notes
     */
    public /*string*/
        $Notes;

}

/**
 *
 */
class EmailJobFailedStatus
{
    /**
     *
     */
    public /*string*/
        $Address;

    /**
     *
     */
    public /*string*/
        $Error;

    /**
     * RFC Error code
     */
    public /*int*/
        $ErrorCode;

    /**
     *
     */
    public /*string*/
        $Category;

}

/**
 *
 */
class EmailJobStatus
{
    /**
     * ID number of your attachment
     */
    public /*string*/
        $ID;

    /**
     * Name of status: Active, Engaged, Inactive, Abuse, Bounced, Unsubscribed.
     */
    public /*string*/
        $Status;

    /**
     *
     */
    public /*int*/
        $RecipientsCount;

    /**
     *
     */
    public /*Array<ApiTypes\EmailJobFailedStatus>*/
        $Failed;

    /**
     * Total emails sent.
     */
    public /*int*/
        $FailedCount;

    /**
     * Number of delivered messages
     */
    public /*Array<string>*/
        $Delivered;

    /**
     *
     */
    public /*int*/
        $DeliveredCount;

    /**
     *
     */
    public /*Array<string>*/
        $Pending;

    /**
     *
     */
    public /*int*/
        $PendingCount;

    /**
     * Number of opened messages
     */
    public /*Array<string>*/
        $Opened;

    /**
     * Total emails opened.
     */
    public /*int*/
        $OpenedCount;

    /**
     * Number of clicked messages
     */
    public /*Array<string>*/
        $Clicked;

    /**
     * Total emails clicked
     */
    public /*int*/
        $ClickedCount;

    /**
     * Number of unsubscribed messages
     */
    public /*Array<string>*/
        $Unsubscribed;

    /**
     * Total emails clicked
     */
    public /*int*/
        $UnsubscribedCount;

    /**
     *
     */
    public /*Array<string>*/
        $AbuseReports;

    /**
     *
     */
    public /*int*/
        $AbuseReportsCount;

}

/**
 *
 */
class EmailSend
{
    /**
     * ID number of transaction
     */
    public /*string*/
        $TransactionID;

    /**
     * Unique identifier for this email.
     */
    public /*string*/
        $MessageID;

}

/**
 * Status information of the specified email
 */
class EmailStatus
{
    /**
     * Email address this email was sent from.
     */
    public /*string*/
        $From;

    /**
     * Email address this email was sent to.
     */
    public /*string*/
        $To;

    /**
     * Date the email was submitted.
     */
    public /*DateTime*/
        $Date;

    /**
     * Name of status: Active, Engaged, Inactive, Abuse, Bounced, Unsubscribed.
     */
    public /*ApiTypes\LogJobStatus*/
        $Status;

    /**
     * Date of last status change.
     */
    public /*DateTime*/
        $StatusChangeDate;

    /**
     * Detailed error or bounced message.
     */
    public /*string*/
        $ErrorMessage;

    /**
     * ID number of transaction
     */
    public /*Guid*/
        $TransactionID;

}

/**
 * Email details formatted in json
 */
class EmailView
{
    /**
     * Body (text) of your message.
     */
    public /*string*/
        $Body;

    /**
     * Default subject of email.
     */
    public /*string*/
        $Subject;

    /**
     * Starting date for search in YYYY-MM-DDThh:mm:ss format.
     */
    public /*string*/
        $From;

}

/**
 * Encoding type for the email headers
 * Enum class
 */
abstract class EncodingType
{
    /**
     * Encoding of th eemail is provided by the sender and not altered.
     */
    const UserProvided = -1;

    /**
     * No endcoding is set for the email.
     */
    const None = 0;

    /**
     * Encoding of the email is in Raw7bit format.
     */
    const Raw7bit = 1;

    /**
     * Encoding of the email is in Raw8bit format.
     */
    const Raw8bit = 2;

    /**
     * Encoding of the email is in QuotedPrintable format.
     */
    const QuotedPrintable = 3;

    /**
     * Encoding of the email is in Base64 format.
     */
    const Base64 = 4;

    /**
     * Encoding of the email is in Uue format.
     */
    const Uue = 5;

}

/**
 * Record of exported data from the system.
 */
class Export
{
    /**
     *
     */
    public /*Guid*/
        $PublicExportID;

    /**
     * Date the export was created
     */
    public /*DateTime*/
        $DateAdded;

    /**
     * Type of export
     */
    public /*string*/
        $Type;

    /**
     * Current status of export
     */
    public /*string*/
        $Status;

    /**
     * Long description of the export
     */
    public /*string*/
        $Info;

    /**
     * Name of the file
     */
    public /*string*/
        $Filename;

    /**
     * Link to download the export
     */
    public /*string*/
        $Link;

}

/**
 * Type of export
 * Enum class
 */
abstract class ExportFileFormats
{
    /**
     * Export in comma separated values format.
     */
    const Csv = 1;

    /**
     * Export in xml format
     */
    const Xml = 2;

    /**
     * Export in json format
     */
    const Json = 3;

}

/**
 *
 */
class ExportLink
{
    /**
     * Direct URL to the exported file
     */
    public /*string*/
        $Link;

}

/**
 * Current status of export
 * Enum class
 */
abstract class ExportStatus
{
    /**
     * Export had an error and can not be downloaded.
     */
    const Error = -1;

    /**
     * Export is currently loading and can not be downloaded.
     */
    const Loading = 0;

    /**
     * Export is currently available for downloading.
     */
    const Ready = 1;

    /**
     * Export is no longer available for downloading.
     */
    const Expired = 2;

}

/**
 * Number of Exports, grouped by export type
 */
class ExportTypeCounts
{
    /**
     *
     */
    public /*long*/
        $Log;

    /**
     *
     */
    public /*long*/
        $Contact;

    /**
     * Json representation of a campaign
     */
    public /*long*/
        $Campaign;

    /**
     * True, if you have enabled link tracking. Otherwise, false
     */
    public /*long*/
        $LinkTracking;

    /**
     * Json representation of a survey
     */
    public /*long*/
        $Survey;

}

/**
 * Object containig tracking data.
 */
class LinkTrackingDetails
{
    /**
     * Number of items.
     */
    public /*int*/
        $Count;

    /**
     * True, if there are more detailed data available. Otherwise, false
     */
    public /*bool*/
        $MoreAvailable;

    /**
     *
     */
    public /*Array<ApiTypes\TrackedLink>*/
        $TrackedLink;

}

/**
 * List of Contacts, with detailed data about its contents.
 */
class EEList
{
    /**
     * ID number of selected list.
     */
    public /*int*/
        $ListID;

    /**
     * Name of your list.
     */
    public /*string*/
        $ListName;

    /**
     * Number of items.
     */
    public /*int*/
        $Count;

    /**
     * ID code of list
     */
    public /*?Guid*/
        $PublicListID;

    /**
     * Date of creation in YYYY-MM-DDThh:ii:ss format
     */
    public /*DateTime*/
        $DateAdded;

    /**
     * True: Allow unsubscribing from this list. Otherwise, false
     */
    public /*bool*/
        $AllowUnsubscribe;

}

/**
 * Detailed information about litmus credits
 */
class LitmusCredits
{
    /**
     * Date in YYYY-MM-DDThh:ii:ss format
     */
    public /*DateTime*/
        $Date;

    /**
     * Amount of money in transaction
     */
    public /*decimal*/
        $Amount;

}

/**
 * Logs for selected date range
 */
class Log
{
    /**
     * Starting date for search in YYYY-MM-DDThh:mm:ss format.
     */
    public /*?DateTime*/
        $From;

    /**
     * Ending date for search in YYYY-MM-DDThh:mm:ss format.
     */
    public /*?DateTime*/
        $To;

    /**
     * Number of recipients
     */
    public /*Array<ApiTypes\Recipient>*/
        $Recipients;

}

/**
 *
 * Enum class
 */
abstract class LogJobStatus
{
    /**
     * Email has been submitted successfully and is queued for sending.
     */
    const ReadyToSend = 1;

    /**
     * Email has soft bounced and is scheduled to retry.
     */
    const WaitingToRetry = 2;

    /**
     * Email is currently sending.
     */
    const Sending = 3;

    /**
     * Email has errored or bounced for some reason.
     */
    const Error = 4;

    /**
     * Email has been successfully delivered.
     */
    const Sent = 5;

    /**
     * Email has been opened by the recipient.
     */
    const Opened = 6;

    /**
     * Email has had at least one link clicked by the recipient.
     */
    const Clicked = 7;

    /**
     * Email has been unsubscribed by the recipient.
     */
    const Unsubscribed = 8;

    /**
     * Email has been complained about or marked as spam by the recipient.
     */
    const AbuseReport = 9;

}

/**
 * Summary of log status, based on specified date range.
 */
class LogStatusSummary
{
    /**
     * Starting date for search in YYYY-MM-DDThh:mm:ss format.
     */
    public /*string*/
        $From;

    /**
     * Ending date for search in YYYY-MM-DDThh:mm:ss format.
     */
    public /*string*/
        $To;

    /**
     * Overall duration
     */
    public /*double*/
        $Duration;

    /**
     * Number of recipients
     */
    public /*long*/
        $Recipients;

    /**
     * Number of emails
     */
    public /*long*/
        $EmailTotal;

    /**
     * Number of SMS
     */
    public /*long*/
        $SmsTotal;

    /**
     * Number of delivered messages
     */
    public /*long*/
        $Delivered;

    /**
     * Number of bounced messages
     */
    public /*long*/
        $Bounced;

    /**
     * Number of messages in progress
     */
    public /*long*/
        $InProgress;

    /**
     * Number of opened messages
     */
    public /*long*/
        $Opened;

    /**
     * Number of clicked messages
     */
    public /*long*/
        $Clicked;

    /**
     * Number of unsubscribed messages
     */
    public /*long*/
        $Unsubscribed;

    /**
     * Number of complaint messages
     */
    public /*long*/
        $Complaints;

    /**
     * Number of inbound messages
     */
    public /*long*/
        $Inbound;

    /**
     * Number of manually cancelled messages
     */
    public /*long*/
        $ManualCancel;

    /**
     * ID number of template used
     */
    public /*bool*/
        $TemplateChannel;

}

/**
 * Overall log summary information.
 */
class LogSummary
{
    /**
     * Summary of log status, based on specified date range.
     */
    public /*ApiTypes\LogStatusSummary*/
        $LogStatusSummary;

    /**
     * Summary of bounced categories, based on specified date range.
     */
    public /*ApiTypes\BouncedCategorySummary*/
        $BouncedCategorySummary;

    /**
     * Daily summary of log status, based on specified date range.
     */
    public /*Array<ApiTypes\DailyLogStatusSummary>*/
        $DailyLogStatusSummary;

}

/**
 * Queue of notifications
 */
class NotificationQueue
{
    /**
     * Creation date.
     */
    public /*string*/
        $DateCreated;

    /**
     * Date of last status change.
     */
    public /*string*/
        $StatusChangeDate;

    /**
     * Actual status.
     */
    public /*string*/
        $NewStatus;

    /**
     *
     */
    public /*string*/
        $Reference;

    /**
     * Error message.
     */
    public /*string*/
        $ErrorMessage;

    /**
     * Number of previous delivery attempts
     */
    public /*string*/
        $RetryCount;

}

/**
 * Detailed information about existing money transfers.
 */
class Payment
{
    /**
     * Date in YYYY-MM-DDThh:ii:ss format
     */
    public /*DateTime*/
        $Date;

    /**
     * Amount of money in transaction
     */
    public /*decimal*/
        $Amount;

    /**
     * Source of URL of payment
     */
    public /*string*/
        $Source;

}

/**
 *
 * Enum class
 */
abstract class QuestionType
{
    /**
     *
     */
    const RadioButtons = 1;

    /**
     *
     */
    const DropdownMenu = 2;

    /**
     *
     */
    const Checkboxes = 3;

    /**
     *
     */
    const LongAnswer = 4;

    /**
     *
     */
    const Textbox = 5;

    /**
     * Date in YYYY-MM-DDThh:ii:ss format
     */
    const Date = 6;

}

/**
 * Detailed information about message recipient
 */
class Recipient
{
    /**
     * True, if message is SMS. Otherwise, false
     */
    public /*bool*/
        $IsSms;

    /**
     * ID number of selected message.
     */
    public /*string*/
        $MsgID;

    /**
     * Ending date for search in YYYY-MM-DDThh:mm:ss format.
     */
    public /*string*/
        $To;

    /**
     * Name of status: Active, Engaged, Inactive, Abuse, Bounced, Unsubscribed.
     */
    public /*string*/
        $Status;

    /**
     * Name of selected Channel.
     */
    public /*string*/
        $Channel;

    /**
     * Date in YYYY-MM-DDThh:ii:ss format
     */
    public /*string*/
        $Date;

    /**
     * Content of message, HTML encoded
     */
    public /*string*/
        $Message;

    /**
     * True, if message category should be shown. Otherwise, false
     */
    public /*bool*/
        $ShowCategory;

    /**
     * ID of message category
     */
    public /*string*/
        $MessageCategory;

    /**
     * Date of last status change.
     */
    public /*string*/
        $StatusChangeDate;

    /**
     * Date of next try
     */
    public /*string*/
        $NextTryOn;

    /**
     * Default subject of email.
     */
    public /*string*/
        $Subject;

    /**
     * Default From: email address.
     */
    public /*string*/
        $FromEmail;

    /**
     * ID of certain mail job
     */
    public /*string*/
        $JobID;

    /**
     * True, if message is a SMS and status is not yet confirmed. Otherwise, false
     */
    public /*bool*/
        $SmsUpdateRequired;

    /**
     * Content of message
     */
    public /*string*/
        $TextMessage;

    /**
     * Comma separated ID numbers of messages.
     */
    public /*string*/
        $MessageSid;

}

/**
 * Referral details for this account.
 */
class Referral
{
    /**
     * Current amount of dolars you have from referring.
     */
    public /*decimal*/
        $CurrentReferralCredit;

    /**
     * Number of active referrals.
     */
    public /*long*/
        $CurrentReferralCount;

}

/**
 * Detailed sending reputation of your account.
 */
class ReputationDetail
{
    /**
     * Overall reputation impact, based on the most important factors.
     */
    public /*ApiTypes\ReputationImpact*/
        $Impact;

    /**
     * Percent of Complaining users - those, who do not want to receive email from you.
     */
    public /*double*/
        $AbusePercent;

    /**
     * Percent of Unknown users - users that couldn't be found
     */
    public /*double*/
        $UnknownUsersPercent;

    /**
     * Penalty from messages marked as spam.
     */
    public /*double*/
        $AverageSpamScore;

    /**
     * Percent of Bounced users
     */
    public /*double*/
        $FailedSpamPercent;

    /**
     * Points from quantity of your emails.
     */
    public /*double*/
        $RepEmailsSent;

    /**
     * Average reputation.
     */
    public /*double*/
        $AverageReputation;

    /**
     * Actual price level.
     */
    public /*double*/
        $PriceLevelReputation;

    /**
     * Reputation needed to change pricing.
     */
    public /*double*/
        $NextPriceLevelReputation;

    /**
     * Amount of emails sent from this account
     */
    public /*string*/
        $PriceLevel;

    /**
     * True, if tracking domain is correctly configured. Otherwise, false.
     */
    public /*bool*/
        $TrackingDomainValid;

    /**
     * True, if sending domain is correctly configured. Otherwise, false.
     */
    public /*bool*/
        $SenderDomainValid;

}

/**
 * Reputation history of your account.
 */
class ReputationHistory
{
    /**
     * Creation date.
     */
    public /*string*/
        $DateCreated;

    /**
     * Percent of Complaining users - those, who do not want to receive email from you.
     */
    public /*double*/
        $AbusePercent;

    /**
     * Percent of Unknown users - users that couldn't be found
     */
    public /*double*/
        $UnknownUsersPercent;

    /**
     * Penalty from messages marked as spam.
     */
    public /*double*/
        $AverageSpamScore;

    /**
     * Points from proper setup of your account
     */
    public /*double*/
        $SetupScore;

    /**
     * Points from quantity of your emails.
     */
    public /*double*/
        $RepEmailsSent;

    /**
     * Numeric reputation
     */
    public /*double*/
        $Reputation;

}

/**
 * Overall reputation impact, based on the most important factors.
 */
class ReputationImpact
{
    /**
     * Abuses - mails sent to user without their consent
     */
    public /*double*/
        $Abuse;

    /**
     * Users, that could not be reached.
     */
    public /*double*/
        $UnknownUsers;

    /**
     * Penalty from messages marked as spam.
     */
    public /*double*/
        $AverageSpamScore;

    /**
     * Content analysis.
     */
    public /*double*/
        $ServerFilter;

    /**
     * Total emails sent.
     */
    public /*double*/
        $TotalEmailSent;

    /**
     * Tracking domain.
     */
    public /*double*/
        $TrackingDomain;

    /**
     * Sending domain.
     */
    public /*double*/
        $SenderDomain;

}

/**
 * Information about Contact Segment, selected by RULE.
 */
class Segment
{
    /**
     * ID number of your segment.
     */
    public /*int*/
        $SegmentID;

    /**
     * ID of selected account.
     */
    public /*int*/
        $AccountID;

    /**
     * Filename
     */
    public /*string*/
        $Name;

    /**
     * Query used for filtering.
     */
    public /*string*/
        $Rule;

    /**
     * Number of items from last check.
     */
    public /*long*/
        $LastCount;

    /**
     * History of segment information.
     */
    public /*Array<ApiTypes\SegmentHistory>*/
        $History;

}

/**
 * Segment History
 */
class SegmentHistory
{
    /**
     * ID number of history.
     */
    public /*int*/
        $SegmentHistoryID;

    /**
     * ID number of your segment.
     */
    public /*int*/
        $SegmentID;

    /**
     * ID of selected account.
     */
    public /*int*/
        $AccountID;

    /**
     * Date in YYYY-MM-DD format
     */
    public /*int*/
        $Day;

    /**
     * Number of items.
     */
    public /*long*/
        $Count;

}

/**
 *
 * Enum class
 */
abstract class SendingPermission
{
    /**
     * Sending not allowed.
     */
    const None = 0;

    /**
     * Allow sending via SMTP only.
     */
    const Smtp = 1;

    /**
     * Allow sending via HTTP API only.
     */
    const HttpApi = 2;

    /**
     * Allow sending via SMTP and HTTP API.
     */
    const SmtpAndHttpApi = 3;

    /**
     * Allow sending via the website interface only.
     */
    const EEInterface = 4;

    /**
     * Allow sending via SMTP and the website interface.
     */
    const SmtpAndInterface = 5;

    /**
     * Allow sendnig via HTTP API and the website interface.
     */
    const HttpApiAndInterface = 6;

    /**
     * Sending allowed via SMTP, HTTP API and the website interface.
     */
    const All = 255;

}

/**
 * Spam check of specified message.
 */
class SpamCheck
{
    /**
     * Total spam score from
     */
    public /*string*/
        $TotalScore;

    /**
     * Date in YYYY-MM-DDThh:ii:ss format
     */
    public /*string*/
        $Date;

    /**
     * Default subject of email.
     */
    public /*string*/
        $Subject;

    /**
     * Default From: email address.
     */
    public /*string*/
        $FromEmail;

    /**
     * ID number of selected message.
     */
    public /*string*/
        $MsgID;

    /**
     * Name of selected channel.
     */
    public /*string*/
        $ChannelName;

    /**
     *
     */
    public /*Array<ApiTypes\SpamRule>*/
        $Rules;

}

/**
 * Single spam score
 */
class SpamRule
{
    /**
     * Spam score
     */
    public /*string*/
        $Score;

    /**
     * Name of rule
     */
    public /*string*/
        $Key;

    /**
     * Description of rule.
     */
    public /*string*/
        $Description;

}

/**
 *
 * Enum class
 */
abstract class SplitOptimization
{
    /**
     * Number of opened messages
     */
    const Opened = 0;

    /**
     * Number of clicked messages
     */
    const Clicked = 1;

}

/**
 * Subaccount. Contains detailed data of your Subaccount.
 */
class SubAccount
{
    /**
     * ID of selected account.
     */
    public /*string*/
        $AccountID;

    /**
     * Public key for limited access to your account such as contact/add so you can use it safely on public websites.
     */
    public /*string*/
        $PublicAccountID;

    /**
     * ApiKey that gives you access to our SMTP and HTTP API's.
     */
    public /*string*/
        $ApiKey;

    /**
     * Proper email address.
     */
    public /*string*/
        $Email;

    /**
     * ID number of mailer
     */
    public /*string*/
        $MailerID;

    /**
     * Type of account: 1 for Transactional Email, 2 for Marketing Email.
     */
    public /*ApiTypes\AccountType*/
        $AccountType;

    /**
     * Date of last activity on account
     */
    public /*string*/
        $LastActivity;

    /**
     * Amount of email credits
     */
    public /*string*/
        $EmailCredits;

    /**
     * True, if account needs credits to send emails. Otherwise, false
     */
    public /*bool*/
        $RequiresEmailCredits;

    /**
     * Amount of credits added to account automatically
     */
    public /*double*/
        $MonthlyRefillCredits;

    /**
     * True, if account needs credits to buy templates. Otherwise, false
     */
    public /*bool*/
        $RequiresTemplateCredits;

    /**
     * Amount of Litmus credits
     */
    public /*decimal*/
        $LitmusCredits;

    /**
     * True, if account is able to send template tests to Litmus. Otherwise, false
     */
    public /*bool*/
        $EnableLitmusTest;

    /**
     * True, if account needs credits to send emails. Otherwise, false
     */
    public /*bool*/
        $RequiresLitmusCredits;

    /**
     * True, if account can buy templates on its own. Otherwise, false
     */
    public /*bool*/
        $EnablePremiumTemplates;

    /**
     * True, if account can request for private IP on its own. Otherwise, false
     */
    public /*bool*/
        $EnablePrivateIPRequest;

    /**
     * Amount of emails sent from this account
     */
    public /*long*/
        $TotalEmailsSent;

    /**
     * Percent of Unknown users - users that couldn't be found
     */
    public /*double*/
        $UnknownUsersPercent;

    /**
     * Percent of Complaining users - those, who do not want to receive email from you.
     */
    public /*double*/
        $AbusePercent;

    /**
     * Percent of Bounced users
     */
    public /*double*/
        $FailedSpamPercent;

    /**
     * Numeric reputation
     */
    public /*double*/
        $Reputation;

    /**
     * Amount of emails account can send daily
     */
    public /*long*/
        $DailySendLimit;

    /**
     * Name of status: Active, Engaged, Inactive, Abuse, Bounced, Unsubscribed.
     */
    public /*string*/
        $Status;

}

/**
 * Detailed account settings.
 */
class SubAccountSettings
{
    /**
     * Proper email address.
     */
    public /*string*/
        $Email;

    /**
     * True, if account needs credits to send emails. Otherwise, false
     */
    public /*bool*/
        $RequiresEmailCredits;

    /**
     * True, if account needs credits to buy templates. Otherwise, false
     */
    public /*bool*/
        $RequiresTemplateCredits;

    /**
     * Amount of credits added to account automatically
     */
    public /*double*/
        $MonthlyRefillCredits;

    /**
     * Amount of Litmus credits
     */
    public /*decimal*/
        $LitmusCredits;

    /**
     * True, if account is able to send template tests to Litmus. Otherwise, false
     */
    public /*bool*/
        $EnableLitmusTest;

    /**
     * True, if account needs credits to send emails. Otherwise, false
     */
    public /*bool*/
        $RequiresLitmusCredits;

    /**
     * Maximum size of email including attachments in MB's
     */
    public /*int*/
        $EmailSizeLimit;

    /**
     * Amount of emails account can send daily
     */
    public /*int*/
        $DailySendLimit;

    /**
     * Maximum number of contacts the account can havelkd
     */
    public /*int*/
        $MaxContacts;

    /**
     * True, if account can request for private IP on its own. Otherwise, false
     */
    public /*bool*/
        $EnablePrivateIPRequest;

    /**
     * True, if you want to use Advanced Tools.  Otherwise, false
     */
    public /*bool*/
        $EnableContactFeatures;

    /**
     * Sending permission setting for account
     */
    public /*ApiTypes\SendingPermission*/
        $SendingPermission;

}

/**
 * A survey object
 */
class Survey
{
    /**
     * Survey identifier
     */
    public /*Guid*/
        $PublicSurveyID;

    /**
     * Creation date.
     */
    public /*DateTime*/
        $DateCreated;

    /**
     * Last change date
     */
    public /*?DateTime*/
        $DateUpdated;

    /**
     * Filename
     */
    public /*string*/
        $Name;

    /**
     * Activate, delete, or pause your survey
     */
    public /*ApiTypes\SurveyStatus*/
        $Status;

    /**
     * Number of results count
     */
    public /*int*/
        $ResultCount;

    /**
     * Survey's steps info
     */
    public /*Array<ApiTypes\SurveyStep>*/
        $SurveyStep;

    /**
     * URL of the survey
     */
    public /*string*/
        $SurveyLink;

}

/**
 * Object with the single answer's data
 */
class SurveyResultAnswerInfo
{
    /**
     * Answer's content
     */
    public /*string*/
        $content;

    /**
     * Identifier of the step
     */
    public /*int*/
        $surveystepid;

    /**
     * Identifier of the answer of the step
     */
    public /*string*/
        $surveystepanswerid;

}

/**
 * Single answer's data with user's specific info
 */
class SurveyResultInfo
{
    /**
     * Identifier of the result
     */
    public /*string*/
        $SurveyResultID;

    /**
     * IP address
     */
    public /*string*/
        $CreatedFromIP;

    /**
     * Completion date
     */
    public /*DateTime*/
        $DateCompleted;

    /**
     * Start date
     */
    public /*DateTime*/
        $DateStart;

    /**
     * Answers for the survey
     */
    public /*Array<ApiTypes\SurveyResultAnswerInfo>*/
        $SurveyResultAnswers;

}

/**
 * Summary with all the answers
 */
class SurveyResultsSummary
{
    /**
     * Answers' statistics
     */
    public /*array<string, int>*/
        $Answers;

    /**
     * Open answers for the question
     */
    public /*Array<string>*/
        $OpenAnswers;

}

/**
 * Data on the survey's result
 */
class SurveyResultsSummaryInfo
{
    /**
     * Number of items.
     */
    public /*int*/
        $Count;

    /**
     * Summary statistics
     */
    public /*array<int, ApiTypes\SurveyResultsSummary>*/
        $Summary;

}

/**
 *
 * Enum class
 */
abstract class SurveyStatus
{
    /**
     * The survey is deleted
     */
    const Deleted = -1;

    /**
     * The survey is not receiving result for now
     */
    const Paused = 0;

    /**
     * The survey is active and receiving answers
     */
    const Active = 1;

}

/**
 * Survey's single step info with the answers
 */
class SurveyStep
{
    /**
     * Identifier of the step
     */
    public /*int*/
        $SurveyStepID;

    /**
     * Type of the step
     */
    public /*ApiTypes\SurveyStepType*/
        $SurveyStepType;

    /**
     * Type of the question
     */
    public /*ApiTypes\QuestionType*/
        $QuestionType;

    /**
     * Answer's content
     */
    public /*string*/
        $Content;

    /**
     * Is the answer required
     */
    public /*bool*/
        $Required;

    /**
     * Sequence of the answers
     */
    public /*int*/
        $Sequence;

    /**
     * Answer object of the step
     */
    public /*Array<ApiTypes\SurveyStepAnswer>*/
        $SurveyStepAnswer;

}

/**
 * Single step's answer object
 */
class SurveyStepAnswer
{
    /**
     * Identifier of the answer of the step
     */
    public /*string*/
        $SurveyStepAnswerID;

    /**
     * Answer's content
     */
    public /*string*/
        $Content;

    /**
     * Sequence of the answers
     */
    public /*int*/
        $Sequence;

}

/**
 *
 * Enum class
 */
abstract class SurveyStepType
{
    /**
     *
     */
    const PageBreak = 1;

    /**
     *
     */
    const Question = 2;

    /**
     *
     */
    const TextMedia = 3;

    /**
     *
     */
    const ConfirmationPage = 4;

    /**
     *
     */
    const ExpiredPage = 5;

}

/**
 * Template
 */
class Template
{
    /**
     * ID number of template.
     */
    public /*int*/
        $TemplateID;

    /**
     * 0 for API connections
     */
    public /*ApiTypes\TemplateType*/
        $TemplateType;

    /**
     * Filename
     */
    public /*string*/
        $Name;

    /**
     * Date of creation in YYYY-MM-DDThh:ii:ss format
     */
    public /*DateTime*/
        $DateAdded;

    /**
     * CSS style
     */
    public /*string*/
        $Css;

    /**
     * Default subject of email.
     */
    public /*string*/
        $Subject;

    /**
     * Default From: email address.
     */
    public /*string*/
        $FromEmail;

    /**
     * Default From: name.
     */
    public /*string*/
        $FromName;

    /**
     * HTML code of email (needs escaping).
     */
    public /*string*/
        $BodyHtml;

    /**
     * Text body of email.
     */
    public /*string*/
        $BodyText;

    /**
     * ID number of original template.
     */
    public /*int*/
        $OriginalTemplateID;

    /**
     * Enum: 0 - private, 1 - public, 2 - mockup
     */
    public /*ApiTypes\TemplateScope*/
        $TemplateScope;

}

/**
 * List of templates
 */
class TemplateList
{
}

/**
 *
 * Enum class
 */
abstract class TemplateScope
{
    /**
     * Template is available for this account only.
     */
    const EEPrivate = 0;

    /**
     * Template is available for this account and it's sub-accounts.
     */
    const EEPublic = 1;

}

/**
 *
 * Enum class
 */
abstract class TemplateType
{
    /**
     * Template supports any valid HTML
     */
    const RawHTML = 0;

    /**
     * Template is created and can only be modified in drag and drop editor
     */
    const DragDropEditor = 1;

}

/**
 * Information about tracking link and its clicks.
 */
class TrackedLink
{
    /**
     * URL clicked
     */
    public /*string*/
        $Link;

    /**
     * Number of clicks
     */
    public /*string*/
        $Clicks;

    /**
     * Percent of clicks
     */
    public /*string*/
        $Percent;

}

/**
 * Account usage
 */
class Usage
{
}

