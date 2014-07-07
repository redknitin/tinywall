<?php
//Can't use this unless using iframes
//include('request.inc.php');
//RequestController::make_cacheable(); //Cache GET requests, sent HEAD response
?>
<!doctype html>
    <html>
        <head><title></title>
        <style>
#lbltitle, #lblcontent { display: block; width: 80px; font-size: 9pt; background-color: #ddd; text-align: center; margin-top: 5px; border-radius: 3px; }
#txttitle, #txtcontent { width: 270px; }
#txtcontent { height: 80px; }
#frmpost { display: block; border: 1px solid #444; width: 280px; padding: 15px; border-radius: 8px; background-color: white; }
#frmpost h2 { margin: 0; color: #222; font-size: 15pt; text-align: center; }
.authlink a { text-decoration: none; color: #292; }
.authlink { display: block; float: right; }
div.post { border: 1px solid #444; border-radius: 8px; margin: 10px 0; padding: 15px; background-color: #eeb; width: 280px; font-size: 10pt; }
div.post h2.post-title { margin: 0; padding: 0; color: #222; font-size: 12pt; }
div.post p.date { margin: 0; padding: 0 0 10px 0px; font-size: 7pt; }
h1#logo { font-size: 18pt; }
        </style>
        </head>
        <body>
<h1 id="logo">TinyWall</h1>
<?php
include('posts.inc.php');
session_start();
//PostController::$is_debug = true;

if (isset($_SESSION['name'])) {
    PostBoundary::process_form_new_post();
?>            
            <p class="authlink"><a href="login.php?logout=1">Logout</a></p>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="frmpost">
                <h2>Add Post</h2>
                <label id="lbltitle">Title</label>
                <input type="text" id="txttitle" name="title" />
                <br class="presentation" />
                <label id="lblcontent">Content</label>
                <textarea name="content" id="txtcontent"></textarea>
                <br class="presentation" />
                <input type="hidden" name="op" value="newpost" />
                <input type="submit" id="btnsubmit" value="Post" />
            </form>
<?php
} else {
    echo '<p class="authlink"><a href="login.php">Login</a></p>';
}

$list=PostController::list_posts();
//echo '<p>Showing '.count($list).' posts.</p>';
if ($list != null) {
    foreach($list as $iterpost) {
        if (isset($iterpost->date)) {
            if (date('Y', $iterpost->date)>1970) {
                $iterpost->date = date('Y-m-d H:i:s', $iterpost->date);
            }
        }
        $iterpost->content = nl2br($iterpost->content);
        $itermarkup =<<<EOM
        <div class="post" id="post-{$iterpost->id}">
        <h2 class="post-title">{$iterpost->title}</h2>
        <p class="date">Posted on: {$iterpost->date}</p>
        {$iterpost->content}
        </div>
EOM;
        echo $itermarkup;
    }
}
?>
        </body>
    </html>
