<?php

/*

KuzuhaScriptPHP ver0.0.7alpha (13:04 2003/02/18)
Admin mode module

*/

if(!defined("INCLUDED_FROM_BBS")) {
    header ("Location: ../bbs.php");
    exit();
}



/**
 * Admin mode module
 *
 *
 *
 * @package strangeworld.cnscript
 * @access  public
 */
class Bbsadmin extends Webapp {

    var $bbs;

    /**
     * Constructor
     *
     */
    function __construct() {
        parent::__construct();
        if (func_num_args() > 0) {
            $this->bbs = func_get_arg(0);
            $this->c = &$this->bbs->c;
            $this->f = &$this->bbs->f;
            $this->t = &$this->bbs->t;
        }
        $this->t->readTemplatesFromFile($this->c['TEMPLATE_ADMIN']);
    }


    /**
     * Main process
     */
    function main() {

        if (!defined('BBS_ACTIVATED')) {

            # Start measuring execution time
            $this->setstarttime();

            # Form acquisition preprocessing
            $this->procForm();

            # Reflect user settings
            $this->refcustom();
            $this->setusersession();

            # gzip compressed transfer
            if ($this->c['GZIPU']) {
                ob_start("ob_gzhandler");
            }
        }

        # Log file viewer
        if (@$this->f['ad'] == 'l') {
            $this->prtlogview(TRUE);
        }
        # Message deletion mode
        else if (@$this->f['ad'] == 'k') {
            $this->prtkilllist();
        }
        # Message deletion process
        else if (@$this->f['ad'] == 'x') {
            if (isset($this->f['x'])) {
                $this->killmessage($this->f['x']);
            }
            $this->prtkilllist();
        }
        # Encrypted password generation page
        else if (@$this->f['ad'] == 'p') {
            $this->prtsetpass();
        }
        # Encrypted password generation & display
        else if (@$this->f['ad'] == 'ps') {
            $this->prtpass(@$this->f['ps']);
        }
        # Display server PHP configuration information
        else if (@$this->f['ad'] == 'phpinfo') {
            phpinfo();
        }
        # Admin menu page
        else {
            $this->prtadminmenu();
        }


        if (!defined('BBS_ACTIVATED') and $this->c['GZIPU']) {
            ob_end_flush();
        }
    }





    /**
     * Admin menu page
     *
     */
    function prtadminmenu() {

        $this->t->addVar('adminmenu', 'V', trim($this->f['v']));

        $this->sethttpheader();
        print $this->prthtmlhead ($this->c['BBSTITLE'] . ' Administration menu');
        $this->t->displayParsedTemplate('adminmenu');
        print $this->prthtmlfoot ();

    }





    /**
     * Message deletion mode main page display
     *
     */
    function prtkilllist() {

        if (!file_exists($this->c['LOGFILENAME'])) {
            $this->prterror('Failed to load message');
        }
        $logdata = file($this->c['LOGFILENAME']);

        $this->t->addVar('killlist', 'V', trim($this->f['v']));

        $messages = array();
        foreach ($logdata as $logline) {
            $message = $this->getmessage($logline);
            $message['MSG'] = preg_replace("/<a href=[^>]+>Reference: [^<]+<\/a>/i", "", $message['MSG'], 1);
            $message['MSG'] = preg_replace("/<[^>]+>/", "", ltrim($message['MSG']));
            $msgsplit = explode("\r", $message['MSG']);
            $message['MSGDIGEST'] = $msgsplit[0];
            $index = 1;
            while ($index < count($msgsplit) - 1 and strlen($message['MSGDIGEST'] . $msgsplit[$index]) < 50) {
                $message['MSGDIGEST'] .= $msgsplit[$index];
                $index++;
            }
            $message['WDATE'] = Func::getdatestr($message['NDATE']);
            $message['USER_NOTAG'] = preg_replace("/<[^>]*>/", '', $message['USER']);
            $messages[] = $message;
        }

        $this->t->addRows('killmessage', $messages);

        $this->sethttpheader();
        print $this->prthtmlhead ($this->c['BBSTITLE'] . ' Message deletion mode');
        $this->t->displayParsedTemplate('killlist');
        print $this->prthtmlfoot ();
    }





    /**
     * Message deletion process
     *
     */
    function killmessage($killids) {

        if (!$killids) {
            return;
        }
        if (!is_array($killids)) {
            $tmp = $killids;
            $killids = array();
            $killids[] = $tmp;
        }

        $fh = @fopen($this->c['LOGFILENAME'], "r+");
        if (!$fh) {
            $this->prterror ( 'Failed to load message' );
        }
        flock ($fh, 2);
        fseek ($fh, 0, 0);

        $logdata = array();
        while (($logline = Func::fgetline($fh)) !== FALSE) {
             $logdata[] = $logline;
        }

        $killntimes = array();
        $killlogdata = array();
        $newlogdata = array();
        $i = 0;
        while ($i < count($logdata)) {
            $items = explode(',', $logdata[$i], 3);
            if (count($items) > 2 and array_search($items[1], $killids) !== FALSE) {
                $killntimes[$items[1]] = $items[0];
                $killlogdata[] = $logdata[$i];
            }
            else {
                $newlogdata[] = $logdata[$i];
            }
            $i++;
        }
        {
            fseek ($fh, 0, 0);
            ftruncate ($fh, 0);
            fwrite ($fh, implode ('', $newlogdata));
        }
        flock ($fh, 3);
        fclose ($fh);

        # Image deletion
        foreach ($killlogdata as $eachlogdata) {
            if (preg_match("/<img [^>]*?src=\"([^\"]+)\"[^>]+>/i", $eachlogdata, $matches) and file_exists($matches[1])) {
                unlink ($matches[1]);
            }
        }

        # Message log line deletion
        if ($this->c['OLDLOGFILEDIR']) {
            foreach (array_keys($killntimes) as $killid) {
                $oldlogfilename = '';
                if ($this->c['OLDLOGFMT']) {
                    $oldlogext = 'dat';
                }
                else {
                    $oldlogext = 'html';
                }
                if ($this->c['OLDLOGSAVESW']) {
                    $oldlogfilename = date("Ym", $killntimes[$killid]) . ".$oldlogext";
                }
                else {
                    $oldlogfilename = date("Ymd", $killntimes[$killid]) . ".$oldlogext";
                }
                $fh = @fopen($this->c['OLDLOGFILEDIR'] . $oldlogfilename, "r+");
                if ($fh) {
                    flock ($fh, 2);
                    fseek ($fh, 0, 0);

                    $newlogdata = array();
                    $hit = FALSE;

                    if ($this->c['OLDLOGFMT']) {
                        $needle = $killntimes[$killid] . "," . $killid . ",";
                        while (($logline = Func::fgetline($fh)) !== FALSE) {
                            if (!$hit and strpos($logline, $needle) !== FALSE and strpos($logline, $needle) == 0) {
                                $hit = TRUE;
                            }
                            else {
                                $newlogdata[] = $logline;
                            }
                        }
                    }
                    else {
                        $needle = "<div class=\"m\" id=\"m{$killid}\">";
                        $flgbuffer = FALSE;
                        while (($htmlline = Func::fgetline($fh)) !== FALSE) {

                            # Start of message
                            if (!$hit and strpos($htmlline, $needle) !== FALSE) {
                                $hit = TRUE;
                                $flgbuffer = TRUE;
                            }
                            # End of message
                            else if ($flgbuffer and strpos($htmlline, "<hr") !== FALSE) {
                                $flgbuffer = FALSE;
                            }
                            # Inside message
                            else if ($flgbuffer) {
                            }
                            else {
                                $newlogdata[] = $htmlline;
                            }
                        }
                    }

                    {
                        fseek ($fh, 0, 0);
                        ftruncate ($fh, 0);
                        fwrite ($fh, implode ('', $newlogdata));
                    }
                    flock ($fh, 3);
                    fclose ($fh);
                }
                else {
                    #$this->prterror ( 'Failed to load message log' );
                }
            }
        }

    }





    /**
     * Encrypted password generation screen display
     *
     */
    function prtsetpass() {

        $this->t->addVar('setpass', 'V', trim($this->f['v']));

        $this->sethttpheader();
        print $this->prthtmlhead ($this->c['BBSTITLE'] . ' Password settings page');
        $this->t->displayParsedTemplate('setpass');
        print $this->prthtmlfoot ();
    }





    /**
     * Encrypted password generation & display
     *
     */
    function prtpass($inputpass) {

        if (!@$inputpass) {
            $this->prterror ('No password has been set.');
        }

        $salt = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 2);
        $cryptpass = crypt($inputpass, $salt);
        $inputsize = strlen($cryptpass) + 10;

        $this->t->addVars('pass', array(
            'CRYPTPASS' => $cryptpass,
            'INPUTSIZE' => $inputsize,
        ));

        $this->sethttpheader();
        print $this->prthtmlhead ($this->c['BBSTITLE'] . ' Password settings page');
        $this->t->displayParsedTemplate('pass');
        print $this->prthtmlfoot ();
    }





    /**
     * Log file display
     *
     */
    function prtlogview($htmlescape = FALSE) {
        if ($htmlescape) {
            header ("Content-type: text/html");
            $logdata = file ($this->c['LOGFILENAME']);
            print "<html><head><title>{$this->c['LOGFILENAME']}</title></head><body><pre>\n";
            foreach ($logdata as $logline) {
                if (!preg_match("/^\w+$/", $logline)) {
                    #$value_euc = JcodeConvert($logline, 2, 1);
                    #$value_euc = htmlentities($value_euc, ENT_QUOTES, 'EUC-JP');
                    #$logline = JcodeConvert($value_euc, 1, 2);
                    $logline = htmlspecialchars($logline, ENT_QUOTES);
                }
                $logline = str_replace("&#44;", ",", $logline);
                print $logline;
            }
            print "\n</pre></body></html>";
        }
        else {
            header ("Content-type: text/plain");
            readfile ($this->c['LOGFILENAME']);
        }
    }






}



?>
