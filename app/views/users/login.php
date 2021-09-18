<?php
require_once APPROOT . '/views/includes/head.php';
?>
<div class="navbar">
    <?php
    require_once APPROOT . '/views/includes/navigation.php';
    ?>
</div>
<div class="container-login">
    <div class="wrapper-login">
        <h2>Sign in</h2>
        <form action="<?php echo URLROOT; ?>users/login" method="post" autocomplete="off">
            <input type="text" placeholder="user name *" name="username" required>
            <span class="invalidFeedback">
                <?php echo $data['userNameError']; ?>
            </span>
            <div>
                <input type="password" placeholder="password *" name="password" required>
                <span class="invalidFeedback">
                    <?php echo $data['passwordError']; ?>
                </span>
            </div>
            <div>
                <button type="submit" id="submit" value="submit">Submit</button>
            </div>
            <p class="options" value="">Not registered yet? <a href="<?php echo URLROOT; ?>users/register">Create an account</a></p>
        </form>
    </div>
</div>