<?php

  # Items marked "*" need to be changed or confirmed

/* Common settings */
$CONF = array(

  #------------------------- URLs, etc. -------------------------

  'CGIURL' => './index.php',      # * URL for the bulletin board script (Relative paths are acceptable)
  'REFCHECKURL' => '',      # URL for the bulletin board script (Describes the full URL for referer checking. If empty, it will not be checked)
  'BBSHOST' => '',      # Host address where the script will be installed (For caller checking. If empty, it will not be checked)

  #------------------------- Files and directories -------------------------

  'LOGFILENAME' => './bbs.log',   # Log file name
  'OLDLOGFILEDIR' => './log/',    # Name of the directory for storing logs (Please put a / at the end. If empty, logs will not be saved)
  'ZIPDIR' => '',       # ZIP archive directory for past log files (Please put a / at the end. If empty, or if gzcompress is unavailable, ZIP archives will not be created)

  # ----HTML template file names----
  'TEMPLATE' => './sub/template.html',
  'TEMPLATE_ADMIN' => './sub/tmpladmin.html',
  'TEMPLATE_LOG' => './sub/tmpllog.html',
  'TEMPLATE_TREEVIEW' => './sub/tmpltree.html',

  #------------------------- Bulletin board name, etc. -------------------------

  'BBSTITLE' => 'StrangeWorld@PleaseChange',           # * Bulletin board name
  ## TL note: Ayashii World titles usually take the form of "AyashiiWorld@[web host name]
  'INFOPAGE' => '/',   # * URL for the Public Relations Office (home/information page)

  #------------------------- Administrator settings -------------------------

  'ADMINNAME' => 'Administrator',                               # * Administrator name
  'ADMINMAIL' => 'mail@example.com',                # * Administrator email address
  'ADMINPOST' => '',   # * Administor password (Encrypted password. Please leave this empty at first)
  'ADMINKEY' => '',         # * The keyword for entering administrator mode (regular alphanumeric characters are recommended. If empty, administrator mode will be unavailable)

  ## TL note: To enter admin mode after the bulletin board is up and running, put the adminkey (and only the adminkey) into the name and contents fields of the post form, then hit send.
  ## Putting the adminkey (and only the adminkey) into the name field alone will display the admin capcode on your post.

  #------------------------- Search engine -------------------------

  # Gives search engines an overview of the bulletin board. Keep it short and sweet
  'META_DESCRIPTION' => 'This is the "StrangeWorld@PleaseChange" bulletin board',

  # Enter some words related to the bulletin board, seperated by commas. If there's too many, you may be penalized by search engines
  'META_KEYWORDS' => 'AyashiiWorld,AyaWa,StrangeWorld,Ayashii,ᵃʸᵃˢʰⁱⁱ,strange,bulletin,board,BBS',

  # Please specify the language of the content. Typically you'd use Japanese (ja)
  ## TL note: Ayashii World-style AA (ASCII art) may not render correctly using English (en) without some additional CSS to change the font to MS Gothic or another compatible font
  # Japanese : ja
  # English : en
  'META_LANGUAGE' => 'ja',

  #------------------------- Operation settings -------------------------

  # Halt the posting functionality on the bulletin board
  # (You will be able to read the logs, but be unable to post anything)
  #   0 : Disabled
  #   1 : Enabled
  'RUNMODE' => 0,

  # Image upload function.
  #   0 : Disabled
  #   1 : Enabled
  'BBSMODE_IMAGE' => 0,

  # Administrator-only post mode (for diary purposes)
  #   0 : Disabled
  #   1 : Only the administrator is allowed to make new posts, follow-up posts are not allowed
  #   2 : Only the administrator is allowed to make new posts, follow-up posts are allowed
  'BBSMODE_ADMINONLY' => 0,

  # UNDO function usage (a function that allows you to delete your most recent post)
  #   0 : Disabled
  #   1 : Enabled
  'ALLOW_UNDO' => 1,

  # Display the [0] and [Unread] buttons
  # (If the bulletin board doesn't receive much post activity, this won't be necessary)
  #   0 : Do not display
  #   1 : Display
  'SHOW_READNEWBTN' => 1,

  # Default value for gzip compression
  # (Speeds up page rendering)
  #   0 : No compression
  #   1 : Compression
  'GZIPU' => 1,

  # Number of messages stored
  'LOGSAVE' => 1000,

  # Number of messages displayed on a single page
  'MSGDISP' => 40,

  # Number of posts to check for duplicate entries
  'CHECKCOUNT' => 20,

  # Maximum number of characters in a single message
  'MAXMSGCOL' => 250,

  # Maximum number of lines in a single message
  'MAXMSGLINE' => 120,

  # Maximum number of characters in the name field
  'MAXNAMELENGTH' => 128,

  # Maximum number of characters in the email field
  'MAXMAILLENGTH' => 256,

  # Maximum number of characters in the title field
  'MAXTITLELENGTH' => 128,

  # Maximum size of a single message (bytes)
  'MAXMSGSIZE' => 9000,

  # Minimum posting interval (seconds)
  'MINPOSTSEC' => 2,

  # Maximum posting interval (seconds)
  'MAXPOSTSEC' => 1,

  # Default value for the automatic link function
  #   0 : Disabled
  #   1 : Enabled
  'AUTOLINK' => 1,

  # Follow-up post screen display
  #   0 : Open and display a new window (Rebirth)
  #   1 : Display on the same screen (Honten)
  'FOLLOWWIN' => 0,

  # Record user IP addresses
  #   0 : Do not record
  #   1 : Only record anonymous proxies
  #   2 : Record all
  'IPREC' => 2,

  # Record User Agent (browser name)
  #   0 : Disabled
  #   1 : Enabled
  'UAREC' => 1,

  # Display user IP addresses (not recommended)
  # (User IP address recording must be enabled)
  #   0 : Disabled
  #   1 : Enabled
  'IPPRINT' => 0,

  # Display User Agent (browser name)
  # (User Agent recording must be enabled)
  #   0 : Disabled
  #   1 : Enabled
  'UAPRINT' => 0,

  # Time in which posts from the same IP address will be rejected (seconds)
  # (User IP address recording must be enabled
  #   If set to 0, users will be limited by the minpostsec setting)
  'SPTIME' => 0,

  # Use cookies to remember name/email address
  #   0 : Disabled
  #   1 : Enabled
  'COOKIE' => 1,

  # Use a simple self-replying prevention function
  # (If the IP addresses of the replier and reply recipient are the same, the reply will display (self-reply) in the name field
  #   User IP address recording must be enabled)
  #   0 : Disabled
  #   1 : Enabled
  'SHOW_SELFFOLLOW' => 1,

  #------------------------- Counters, etc. -------------------------

  # * Counter start date
  'COUNTDATE' => '2024/07/10',

  # First part of the counter's file name
  'COUNTFILE' => './count/count',

  # Counter breakage resistance level
  # (Values between 3-5 are recommended. The larger the value, the less likely the counter will be erroneous, but the greater the server load)
  'COUNTLEVEL' => 5,

  # File name for real-time participant counting
  #  (Leave it empty if you don't want to use the real-tim participant counting function)
  'CNTFILENAME' => './bbs.cnt',

  # Real-time participant count interval (seconds)
  # (Participants who have exceeded this length of time since their last page view will be excluded from the tally)
  'CNTLIMIT' => 300,

  #------------------------- Time -------------------------

  # Time difference between the location of the host server and Japan (or your own country)
  #   Japan               : 0
  #   Greenwich Mean Time : -9
  #   America             : -14 (Washington)
  #                       : -20 (Midway Islands)
  #   New Zealand         : 3
  'DIFFTIME' => 0,

  # Time difference in seconds (For fine adjustment. Negative values allowed)
  'DIFFSEC' => 0,

  #------------------------- Color settings (hex), etc. -------------------------

  # Background color
  # Classic：007f7f (teal)
  # REBIRTH lineage：004040 (blackboard)
  # Honten：303c6d (indigo)
  'C_BACKGROUND' => '004040',

  'C_TEXT' => 'efefef',  # Text color

  # Link color
  'C_A_COLOR' => 'cfe',    # Normal
  'C_A_VISITED' => 'ddd',  # Visited
  'C_A_ACTIVE' => 'f00',   # Active
  'C_A_HOVER' => '1ee',    # Hover (mouseover)

  'C_SUBJ' => 'fffffe',   # Title color
  'C_QMSG' => 'ccc',   # Quote message color (Leave empty if you don't want the color to change)
  'C_ERROR' => 'f00',  # Error message color

  'TXTFOLLOW' => '■',    # Text to be displayed on the follow-up post screen button
  'TXTAUTHOR' => '★',    # Text to be displayed on the user search button
  'TXTTHREAD' => '◆',    # Text to be displayed on the thread view button
  'TXTTREE' => '木',      # Text to be displayed on the tree view button
  'TXTUNDO' => 'Undo',      # Text to be displayed on the UNDO (Delete only the last post you posted) button

  'FSUBJ' => '',          # Text to be added to the other user's name when making a follow-up post (on a typical bulletin board it's best to use "-san" or something similar)
  'ANONY_NAME' => '　',   # Anonymous username (on a typical bulletin board it's best to use "Anonymous", "Nameless", etc.)

  #------------------------- Message logs -------------------------

  # Save format for message logs
  # (Past log search will not be available if you use HTML format)
  #   0 : HTML format
  #   1 : Binary format
  'OLDLOGFMT' => 1,

  # Search for follow-up posts and usernames in the message logs
  # (Only enabled if message logs are in binary format)
  #   0 : Not allowed
  #   1 : Allowed
  'OLDLOGBTN' => 1,

  # How to save message logs
  #   0 : Daily
  #   1 : Monthly
  'OLDLOGSAVESW' => 1,

  # Number of days to keep message logs
  #  (Only available if message logs are saved daily)
  'OLDLOGSAVEDAY' => 12,

  # Maximum file size for message logs
  'MAXOLDLOGSIZE' => 4 * 1024 * 1024,

  #------------------------- Display templates, etc. -------------------------

  # * Links line
  'BBSLINK' => '
<!-- Example:  |  <a href="http://strange.egoism.jp/script/" target="_blank">くずはすくりぷとPHP</a> -->
|| <a href="https://example.com/" target="_blank">example.com</a> | <a href="https://example.net/" target="_blank">example.net</a>
',

  # Message template
#  'TMPL_MSG' => '
#<div class="m" id="m{val postid}">
#  {val postid}<span class="nw"><span class="ms">{val title}</span>&nbsp;&nbsp;<span class="mu">User: <span class="mun">{val user}</span></span>&nbsp;
#  &nbsp;<span class="md">Post date: {val wdate}<a id="a{val postid}">&nbsp;</a>
#  {val btn}</span></span>
#  <blockquote>
#    <pre>{val msg}</pre>
#  </blockquote>
#{val envlist}</div>
#
#<hr /><!--  -->
#',

  # Preferences display template
#  'TMPL_ENVLIST' => "<div class=\"env\">{val envaddr}{val envbr}{val envua}</div>\n",

  #------------------------- Access restrictions, etc. -------------------------

  # List of hostname patterns prohibited from posting (Perl5 compatible regular expression)
  'HOSTNAME_POSTDENIED' => array(
    #Example: 'npa\.go\.jp$', */
      '.example.com',
      '.example.net'
  ),

  # List of hostname patterns prohibited from access (Perl5 compatible regular expression)
  'HOSTNAME_BANNED' => array(
    #Example: '\.npa\.go\.jp$',
  ),

  # アクセス禁止エージェント名パターンリスト(Perl5互換正規表現) 20230818 猫・新規追加
  'HOSTAGENT_BANNED' => array(
    #例# 'iPad$',
  'dummy',
  ),

  # Prohibited words
  'NGWORD' => array(
  # Example: 'Viagra','casino'
  'viagra',
  'Viagra',
  'スーパーコピー'
  ),

  # Whether or not to restrict posting from the mobile module by the IP of the mobile device
  # Since the posting function of the mobile version does not check the same IP address for the protect code,
  # it's recommended to restrict by the IP address of the mobile device.
  # (Because the IP address changes every time it accesses the site in i-mode, etc.)
  'RESTRICT_MOBILEIP' => 0,

  #------------------------- Fixed handle names -------------------------

  # Please list the desired handle names and passwords in the order of 'handle name' => 'password'.
  # Please enter the password exactly how it is.
  # If you then put this password into the username field and post, it will get converted to your handle name.
  # If you attempt to write the handle name into the username field, "(fraudster)" will be added to the post.
  'HANDLENAMES' => array(
    'Shiba' => 'Shiba',
    'Fraudster' => 'Administrator'
  ),

  #------------------------- Advanced settings (usually don't require changing) -------------------------

  'SHOW_COUNTER' => 1,  # Determines whether the counter is displayed or not
  'DATEFORMAT' => '',  # Time display format

  #------------------------- Debugging -------------------------

  'SHOW_PRCTIME' => 1,  # Show processing time
);
?>
