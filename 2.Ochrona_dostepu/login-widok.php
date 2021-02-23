<?php if(!defined('skrypt')) header("Location: index.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>2.Ochrona_dostepu</title>
        <link rel="stylesheet" href="https://unpkg.com/purecss@2.0.5/build/pure-min.css" integrity="sha384-LTIDeidl25h2dPxrB2Ekgc9c7sEC3CWGM6HeFmuDNUjX76Ert4Z4IY714dhZHPLd" crossorigin="anonymous">
        <link rel="stylesheet" href="app/style.css">
    </head>
    <body style="padding: 10px;">
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
    </body>
</html>