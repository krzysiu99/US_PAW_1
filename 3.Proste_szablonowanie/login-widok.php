<?php if(!defined('skrypt')) header("Location: index.php"); 

    include_once("widok-head.php");
?>
        <form class="pure-form pure-form-stacked" action="<?=skrypt;?>" method="post">
            <fieldset>
                <legend>Zaloguj się</legend>
                <label for="stacked-email">Login</label>
                <input type="text" id="stacked-email" placeholder="login" name="login" value="<?php if(isset($login))echo$login;?>" />
                <label for="stacked-password">Hasło</label>
                <input type="password" id="stacked-password" placeholder="hasło" name="haslo" value="<?php if(isset($haslo))echo$haslo;?>" />
                <label for="stacked-remember" class="pure-checkbox">
                <button type="submit" class="pure-button pure-button-primary" name="zaloguj">Zaloguj się</button>

                <?php
                    if(isset($textLogin)){
                        echo "<span class='blad' style='width: 500px;padding: 10px;margin-top: 10px;'>";
                        foreach($textLogin as $elm) echo $elm."<br>";
                        echo "</span>";
                    }
                ?>
            </fieldset>
        </form>
        <p>login: admin, hasło: 12345</p>
<?php include_once("widok-footer.php"); ?>