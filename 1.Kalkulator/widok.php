<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>1.Kalkulator</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <form action="<?=skrypt;?>" method="POST">
            <table class="styl">
                <thead>
                    <tr>
                        <td colspan="2">
                            1.Kalkulator
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Kwota kredytu:
                        </td>
                        <td>
                            <input type="number" name="kwota" class="styl" placeholder="np: 2000.00" min="0" stage="0.01" value="<?php if(isset($_POST['kwota']))echo$_POST['kwota'];?>"> zł
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Ilość lat spłaty:
                        </td>
                        <td>
                            <input type="number" name="lat" class="styl" placeholder="np: 5" min="1" value="<?php if(isset($_POST['lat']))echo$_POST['lat'];?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Oprocentowanie:
                        </td>
                        <td>
                            <select name="procent" class="styl" id="procent">
                                <option <?php if(isset($_POST['procent']) && $_POST['procent'] == "3.5 %") echo "selected";?>>3.5 %</option>
                                <option <?php if(isset($_POST['procent']) && $_POST['procent'] == "5 %") echo "selected";?>>5 %</option>
                                <option <?php if(isset($_POST['procent']) && $_POST['procent'] == "8 %") echo "selected";?>>8 %</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" class="styl" name="oblicz" value="Oblicz">
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">
                            <?php if(isset($_POST['oblicz']) && isset($text)){
                                echo "<span class='blad'>";
                                foreach($text as $elm) 
                                    echo $elm."<br>";
                                echo "</span>";
                            } else if(isset($rata)){
                                echo "<span class='poprawnie' title='bez oprocentowania: $kwota_wolna zł/m'>$rata zł miesięcznie</span>";
                            } else echo "Wpisz wartości i kliknij oblicz"; ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    </body>
</html>