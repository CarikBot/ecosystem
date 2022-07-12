<?php
/**
 *
 * $parser = new HTTPClient();
 *
 **/
#namespace Library\ Parser;
define( '_IERR_HTTP', 901 );

class HTTPClient
{
    public $cookiesFile;

    public function __construct( )
    {
        //parent::__construct();
        //$this->Headers = Array();
        $this->cookiesFile = sys_get_temp_dir( ).'/cookies.txt';
        //$this->cookiesFile = './tmp/cookies.txt';
    }

    /**
     * function httpGET
     * @usage
     *   $args[ "url"] = "http://__________________";
     *   $args[ "referer"] = "....";//optional
     *   $_result = $some->httpGet( $args);
     **/
    public function httpGET( $args = null, $Headers = array() )
    {
        $_Referer = @$_SERVER['HTTP_HOST'];
        $_Referer = 'http://referer.com/';
        $_Referer = @$args['referer'];
        $_UserAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:41.0) Gecko/20100101 Firefox/41.0 ';
        $psURL = $args["url"];
        $_iTimeOut = isset( $args['timeout'] ) ? $args['timeout'] : 10000;
        $sslVersion = isset( $args['ssl'] ) ? $args['ssl'] : 4;
        $sslDefault = isset( $args['sslDefault'] ) ? $args['sslDefault'] : false;

        //--- start time
        $mtime = explode( " ", microtime( ) );
        $_LoadStart = $mtime[1] + $mtime[0];
        $_aReturn["err"] = 0;
        $_aReturn["url"] = $psURL;
        $curl = curl_init( );
        curl_setopt( $curl, CURLOPT_URL, $psURL );
        curl_setopt( $curl, CURLOPT_TIMEOUT, $_iTimeOut );
        curl_setopt( $curl, CURLOPT_REFERER, $_Referer );
        curl_setopt( $curl, CURLOPT_USERAGENT, $_UserAgent );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl, CURLOPT_ENCODING, "" );
        curl_setopt( $curl, CURLOPT_COOKIEJAR, $this->cookiesFile );
        curl_setopt( $curl, CURLOPT_COOKIEFILE, $this->cookiesFile );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 0 );
        if (!$sslDefault){
            curl_setopt( $curl, CURLOPT_SSLVERSION, $sslVersion );
            //curl_setopt( $curl, CURLOPT_SSL_CIPHER_LIST, 'SSLv3');
        }
        curl_setopt( $curl, CURLOPT_VERBOSE, false );

        //curl_setopt($curl, CURLOPT_SSLVERSION, 3);
        curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 30 );
        curl_setopt( $curl, CURLOPT_HEADER, 0 );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, $Headers);
        $html = curl_exec( $curl );
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ( $error = curl_error( $curl ) ) {
            $lsErr = curl_error( $curl ).":".$error;
            $html = "ERR: $lsErr\n";
            $_aReturn["err"] = _IERR_HTTP;
            $_aReturn["errmsg"] = $error;
        }
        if($httpCode != 200) {
            //$_aReturn["err"] = $httpCode;
            $_aReturn["errmsg"] = $httpCode;
        }
        curl_close( $curl );

        //--- stop time
        $mtime = explode( " ", microtime( ) );
        $_LoadStop = $mtime[1] + $mtime[0];
        $_LoadTime = ( $_LoadStop - $_LoadStart );
        $_aReturn["loadtime"] = $_LoadTime;
        $_aReturn["content"] = $html;
        return $_aReturn;
    }

    //- httpPOST
    /**
     * function httpPOST
     * @usage
     *   $some = new HTTPClient();
     *   $args[ "url"] = "http://localhost/echo.php?a=b";
     *   $args[ "data"] = array(
     *     "satu"=>"siji",
     *     "dua"=>"loro",
     *   );
     *   $_result = $some->httpPOST( $args);
     *
     * @params $args = null
     * @return
     **/
    public function httpPOST( $args = null, $Headers = array())
    {
        $_Referer = @$_SERVER['HTTP_HOST'];
        $_Referer = @$args['referer'];
        $lsUserAgent = "KiOSS/0.02 (Me/MiDP; KiOSS Browser/0.02; U; en) KiOSS/0.02";
        $lsUserAgent = "Opera/9.80 (Windows NT 6.1; U; en) Presto/2.6.30 Version/10.60";
        $lsUserAgent = "Opera/9.60 (J2ME/MIDP; Opera Mini/4.2.1216/608; U; en) Presto/2.2.0";
        $psURL = $args["url"];
        $psData = @$args["data"];
        if ( is_array( $psData ) ) {
            $lsS = "";
            foreach ( $psData as $key => $value ) {
                $lsS .= "$key=$value&";
            }
            $psData = $lsS;
        }
        $piTimeOut = isset( $args['timeout'] ) ? $args['timeout'] : 10000;

        //--- start time
        $mtime = explode( " ", microtime( ) );
        $LoadStart = $mtime[1] + $mtime[0];
        $_aReturn["err"] = 0;
        $_aReturn["url"] = $psURL;
        $curl = curl_init( );
        curl_setopt( $curl, CURLOPT_URL, $psURL );
        curl_setopt( $curl, CURLOPT_TIMEOUT, $piTimeOut );
        curl_setopt( $curl, CURLOPT_REFERER, $_Referer );
        curl_setopt( $curl, CURLOPT_USERAGENT, $lsUserAgent );
        curl_setopt( $curl, CURLOPT_POSTFIELDS, $psData );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl, CURLOPT_POST, 1 );
        curl_setopt( $curl, CURLOPT_ENCODING, "" );
        curl_setopt( $curl, CURLOPT_COOKIEJAR, $this->cookiesFile );
        curl_setopt( $curl, CURLOPT_COOKIEFILE, $this->cookiesFile );

        //curl_setopt( $curl, CURLOPT_SSLVERSION, 4 );
        //curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 2 );
        //curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );

        curl_setopt( $curl, CURLOPT_SSLVERSION, 1);
		curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false);

        //curl_setopt( $curl, CURLOPT_SSL_CIPHER_LIST, 'SSLv3');
        curl_setopt( $curl, CURLOPT_VERBOSE, false );

        //  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 60 );
        //curl_setopt( $curl, CURLOPT_HEADER, 0 );

        // Header
        curl_setopt( $curl, CURLOPT_HTTPHEADER, $Headers);

        $_sResult = curl_exec( $curl );
        if ( $error = curl_error( $curl ) ) {
            $lsErr = curl_error( $curl ).":".$error;
            $_sResult = "ERR: $error\n";
            $_aReturn["err"] = _IERR_HTTP;
            $_aReturn["errmsg"] = $error;
        }
        curl_close( $curl );

        //--- stop time
        $mtime = explode( " ", microtime( ) );
        $LoadStop = $mtime[1] + $mtime[0];
        $LoadTime = ( $LoadStop - $LoadStart );
        $_aReturn["loadtime"] = $LoadTime;
        $_aReturn["content"] = $_sResult;
        return $_aReturn;
    }

    //- httpPOST
    /* -end- */
}
