<?php
class RequestController {
    function allow_crosssite() {
        header('X-XSS-Protection: 0');
    }
    function make_cacheable() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET'||$_SERVER['REQUEST_METHOD'] == 'HEAD') {
            $seconds_to_cache = 120;
            
            if (file_exists('posts.dat')) {
                $modtime = filemtime('posts.dat');
                
                if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
                    $sincewhen = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
                    if ($sincewhen <= $modtime) {
                        header('HTTP/1.1 304 Not Modified');
                        exit();
                    } else {
                        header("DEBUGText: $sincewhen >= $modtime");
                    }
                }

                $filets = gmdate("D, d M Y H:i:s", $modtime) . " GMT";
                header("Last-Modified: $filets");
                header('ETag: "'.md5($filets).'"');
            }
            
            $ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
            header("Expires: $ts");
            header("Pragma: cache");
            header("Cache-Control: max-age=$seconds_to_cache");            
        }
    }
    function never_cache() {
        $ts = gmdate("D, d M Y H:i:s") . " GMT";
	header("Expires: $ts");
	header("Last-Modified: $ts");
	header("Pragma: no-cache");
	header("Cache-Control: no-store, no-cache, must-revalidate");
        header('Cache-Control: post-check=0, pre-check=0', false);
    }
}
?>