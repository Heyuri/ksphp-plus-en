# KuzuhaScriptPHP+ (くずはすくりぷとPHP+)
An improved version of the PHP port of KuzuhaScript (くずはすくりぷと).
To my knowledge, it works with PHP version 4.1.0 and above.

[https://hiru.coresv.com/ksphp-plus/](https://hiru.coresv.com/ksphp-plus/)


This program is based on the 2005/04/01 modified version of KuzuhaScriptPHP (くずはすくりぷとPHP) by cion (しおん).

[KuzuhaScriptPHP (mirror)](http://qptn.x.fc2.com/up/dauso0059.zip)  
[2005/04/01 modified version](http://qptn.x.fc2.com/up/dauso0073.zip)

## Maintainer information
### ヶ
* [https://hiru.coresv.com/](https://hiru.coresv.com/)
* [strangeworld@vivaldi.net](mailto:strangeworld@vivaldi.net)

### ＠Links
* [https://prev.strangeworld.icu/](https://prev.strangeworld.icu/)
* [linksh@outlook.jp](mailto:linksh@outlook.jp)

## Installation process (for reference only)
1. Unzip the downloaded ZIP file
2. Open and configure conf.php
4. Upload the files to the server using an FTP client or similar
5. Set the permissions as described in readme.md
6. Open a web browser, access bbs.php, and set the administrator password
7. Open your local conf.php file, paste the admin password generated in step 6 to 'ADMINPOST' => 'here' on line 36, then upload the file using your FTP client to overwrite it
8. Open your web browser, go to bbs.php, and see if you can post
9. Access the URL where the log file and such are located, and check if you can see it (if you can see it, please hide it with .htaccess, etc.)

## Recommended permission settings
Incorrect permissions can cause problems and data leaks (such as a post's IP address or remote host), so please make sure that they are set correctly.

```
[File structure]
|-- bbs.php   644 (read-only)     Main bulletin board script
|-- conf.php  644 (read-only)     For configuration
|-- bbs.log   606 (writable)      Log file (empty text file)
|-- bbs.cnt   606 (writable)      Participant list record file (empty text file)
|
|-- vanish.js                     Script for word filtering
|
|-- index.html                    HTML for PR Office, etc.
|-- favicon.ico                   Icon for bookmarks, etc.
|
+-- archive/  707 (writable)      ZIP archive storage directory
+-- count/    707 (writable)      Counter output directory
+-- log/      707 (writable)      Message log files (raw logs) storage directory
+-- sub/      755 (read-only)     Submodule storage directory
    |
    |-- bbsadmin.php    644 (read-only)     Administration module
    |-- bbslog.php      644 (read-only)     Log viewer module
    |-- bbstree.php     644 (read-only)     Tree view module
    |-- phpzip.inc.php  644 (read-only)     ZIP file creation library
```

If PHP runs as an Apache module, bbs.php will run as read-only, 
but if it runs as CGI, bbs.php needs to be set to 755 (executable).

## Memo:
### List of bbs.php?m=* meanings
m=g     Message log search
m=ad    Administrator mode
m=tree  Tree view
m=p     Post/reload
m=c     Settings
m=f     Follow screen
m=t     Thread display
m=s     Search by user
m=u     Execute UNDO

## History
### Cion (しおん) version
* 2003/01/21 work began
* 2003/01/31 0.0.1alpha
* 2003/02/03 0.0.2alpha
* 2003/02/11 0.0.3alpha
* 2003/02/13 0.0.4alpha
* 2003/02/14 0.0.5alpha
* 2003/02/16 0.0.6alpha
* 2003/02/18 0.0.7alpha

### Unofficial
* 2005/04/01 0.0.8alpha(Unofficial) A modified version released by a volunteer (http://www.freak.ne.jp/~lunatica/home/up/freak/dauso0073.zip)

### Unknown dates (Hirugatake (蛭ヶ岳) version)
* Fixed UI, easier to use on smartphones etc.
* Switched to UTF-8 (＠Links)
* Update PHPZip to v1.2
* Various other fixes (not recorded)

### Unknown dates
* Slight change in coding style
* Fixed bug in follow-up posts
* Removed jcode-LE
* Fixed problem where user settings weren't reflected(?)
* Templates are no longer a concern
* Solved mysterious implementation of the func class (incomplete)
* Preperation for PHP7.x support

### 2018/10/12
* Changed name to "KuzuhaScriptPHP+"(くずはすくりぷとPHP+)
* Missing form data invalidated due to faulty checking
* Minor UI changes

### 2018/11/18
* Applied Gikoneko(擬古猫)'s tree view corrections
* Built-in vanish.js

### 2019/11/02
* Removed EZweb view (HDML)
* Removed imode view

### 2019/11/02
* Removed EZweb view (HDML)
* Removed imode view

### 2020/02/11
* Applied Gikoneko(擬古猫)'s tree view bugfixes

### 2020/03/15
* Seperated counters with commas

### 2020/03/29
* Added Gikoneko(擬古猫)'s YouTube embedding function

### 2021/03/08
* Design changes (text boxes, etc.)
* conf.php (changed expressions and default values)

### 2021/07/03
* Added Gikoneko(擬古猫)'s 2chtrip(20210625)
* Removed bbs.cgi

### 2021/07/27
* Fixed an issue where the admin password leaked when using both admin password and trip (Gikoneko(擬古猫))
* Maximum number of characters for Name, Email, and Title can now be set in conf.php
* Moved description in bbs.php to readme.md

## Todo:
* View posts by thread
* Improve speed of unread on tree view
* Setting for whether or not to use tree view
* Setting for whether or not to use the mobile module
* Improve link target
* Form does not appear on the new post screen
* "Record only anonymous proxies" setting
* Proper use of multi-byte functions and jcode
* Setting for UNDO expiration date
* Checkbox for automatic line breaking

## Known Bugs:
* Large number of \&nbsp; appearances when searching logs
* When deleting your own post, sometimes you get a "this post could not be found" error instead of "deletion complete"
