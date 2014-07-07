<?php
include('config.php');

session_start();

if (isset($_REQUEST['username']) && $_REQUEST['username']==$login && $_REQUEST['password']==$pass) {
    $_SESSION['name'] = $_REQUEST['username'];
} else {
    if (isset($_REQUEST['username']))
        $flash = 'invalid credentials';
}

if (!isset($_SESSION['name'])):
?>
<!doctype html><html>
    <head><title></title></head>
    <body>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label>Username</label>
            <input type="text" name="username" />
            <br class="breaker" />
            <label>Password</label>
            <input type="password" name="password" />
            <br class="breaker" />
            <input type="submit" />
        </form>
        <?php if (isset($flash)) { echo "<p>$flash</p>"; } ?>
    </body>
</html>
<?php
else:
    if ($_REQUEST['logout']==1) {
        unset($_SESSION['name']);
    }
    header('Location: index.php');
endif;
?>