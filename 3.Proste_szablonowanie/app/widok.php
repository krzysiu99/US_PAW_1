<?php if(!defined('skrypt')) header("Location: ../index.php"); 

    include_once("widok-head.php");
?>
        <form action="<?=skrypt;?>" method="POST">
            zalogowany użytkownik: <?=$user;?>
            <input type="submit" class="pure-button" name="wyloguj" value="Wyloguj się">
        </form>
        <hr>
        <br>

        <form action="<?=skrypt;?>" method="POST" class="pure-form pure-form-stacked">
            <fieldset>
                <legend>Kalkulator kredytowy</legend>
                <div class="pure-g">
                    <div class="pure-u-1">
                        <label for="kwota">Kwota kredytu:</label>
                        <input type="number" name="kwota" id="kwota" class="pure-u-23-24" placeholder="np: 2000.00" min="0" step="0.01" value="<?php if(isset($_POST['kwota']))echo$_POST['kwota'];?>">
                    </div>
                    <div class="pure-u-1">
                        <label for="lat">Ilość lat spłaty:</label>
                        <input type="number" name="lat" id="lat" class="pure-u-23-24" placeholder="np: 5" min="1" value="<?php if(isset($_POST['lat']))echo$_POST['lat'];?>">
                    </div>
                    <div class="pure-u-1">
                        <label for="procent">Oprocentowanie:</label>
                        <select name="procent" class="styl" id="procent" class="pure-input-1-2">
                            <option <?php if(isset($_POST['procent']) && $_POST['procent'] == "3.5 %") echo "selected";?>>3.5 %</option>
                            <option <?php if(isset($_POST['procent']) && $_POST['procent'] == "5 %") echo "selected";?>>5 %</option>
                            <option <?php if(isset($_POST['procent']) && $_POST['procent'] == "8 %") echo "selected";?>>8 %</option>
                        </select>
                    </div>
                </div>
                <input type="submit" class="pure-button pure-button-primary" name="oblicz" value="Oblicz">
            <fieldset>
        </form>
        <?php if(isset($_POST['oblicz']) && isset($text)){
            echo "<span class='blad' style='width: 500px;padding: 10px;margin-top: 10px;'>>";
            foreach($text as $elm) 
                echo $elm."<br>";
            echo "</span>";
        } else if(isset($rata)){
            echo "<span class='poprawnie' style='width: 500px;padding: 10px;margin-top: 10px;' title='bez oprocentowania: $kwota_wolna zł/m'>$rata zł miesięcznie</span>";
        } else echo "Wpisz wartości i kliknij oblicz"; ?>

<?php include_once("widok-footer.php"); ?>