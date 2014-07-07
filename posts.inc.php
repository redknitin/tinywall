<?php
class PostEntity {
    public $id;
    public $title;
    public $content;
    public $date;
    public $author;
}

class PostController {
    static $is_debug = false;
    static function add_post($post) {
        if (file_exists('posts.dat')) {
            if (PostController::$is_debug) {
                echo '<p>DEBUG '.__LINE__.': Posts file found</p>';
            }
            $list = unserialize(file_get_contents('posts.dat'));            
        } else {
            if (PostController::$is_debug) {
                echo '<p>DEBUG '.__LINE__.': Posts file NOT found</p>';
            }
            $list = array();
        }
        $post->id = uniqid(dechex(rand()));
        $post->date = time();
        $post->author = $_SESSION['name'];
        array_push($list, $post);
        $qty = file_put_contents('posts.dat', serialize($list));
        if (PostController::$is_debug) {
            echo '<p>DEBUG '.__LINE__.': '.$qty.' Post inserted '.$post->id.'</p>';
        }
    }
    static function list_posts($count=5, $start=0) {
        if (file_exists('posts.dat')) {
            if (PostController::$is_debug) {
                echo '<p>DEBUG '.__LINE__.': Posts file found</p>';
            }
            $list = unserialize(file_get_contents('posts.dat'));
            if ($list == null) return null;
            
            if (PostController::$is_debug) {
                if ($list == null) {
                    echo '<p>DEBUG '.__LINE__.': Posts list NULL</p>';
                } else {
                    echo '<p>DEBUG '.__LINE__.': Found '.count($list).' posts</p>';
                }
            }
            $list = array_reverse($list);
            if (count($list)<$start) {
                return null;
            } else {
                $retval = array();
                for ($i=$start; $i<$start+$count; $i++) {
                    if (count($list)<=$i) break;
                    array_push($retval, $list[$i]);
                }
                if (PostController::$is_debug) {
                    echo '<p>DEBUG '.__LINE__.': ';
                    print_r($list);
                    echo '</p>';
                }
                return $retval;
            }
        } else {
            if (PostController::$is_debug) {
                echo '<p>DEBUG '.__LINE__.': Posts file NOT found</p>';
            }
            return null;
        }
    }
}

class PostBoundary {
    static function process_form_new_post() {
        if (isset($_REQUEST['op']) && $_REQUEST['op']=='newpost') {
            $p1 = new PostEntity();
            $p1->title = $_REQUEST['title'];
            $p1->content = $_REQUEST['content'];
            PostController::add_post($p1);
        }
    }
}
?>