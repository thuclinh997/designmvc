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
        <h2>Register</h2>
        <form action="<?php echo URLROOT; ?>/users/register" method="post" autocomplete="off">
            <input type="text" placeholder="user name *" name="username" required value="">
            <span class="invalidFeedback">
                <?php echo $data['userNameError']; ?>
            </span>
            <input type="email" placeholder="email *" name="email" required value="">
            <span class="invalidFeedback">
                <?php echo $data['emailError']; ?>
            </span>
            <input type="password" placeholder="password *" name="password" required>
            <span class="invalidFeedback">
                <?php echo $data['passwordError']; ?>
            </span>
            <input type="password" placeholder="Confirm password *" name="confirmPassword" required autocomplete="off">
            <span class="invalidFeedback">
                <?php echo $data['confirmPasswordError']; ?>
            </span>
            <div>
                <button type="submit" id="submit" value="submit">Submit</button>
            </div>
            <p class="options" value="">do you have an account?  <a href="<?php echo URLROOT; ?>users/login">log in now</a></p>
        </form>
    </div>
</div>