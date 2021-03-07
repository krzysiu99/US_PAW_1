<!DOCTYPE html>
<html>
	<head>
		<title>Szachy online</title>
		<meta charset="utf-8">
		<link rel="Stylesheet" type="text/css" href="<?=$config->folder;?>/css/style.css">
		<script src="<?=$config->folder;?>/js/jquery.min.js"></script>
        <script src="<?=$config->folder;?>/js/jquery-ui.min.js" type="text/javascript"></script>
	</head>
    <body>
        <table>
            <thead>
                <tr>
                    <th colspan="9">Gracz1 vs Gracz2</th>
                </tr>
            </thead>
            <tbody>
                <?php for($linia=8;$linia>=1;$linia--){ ?>
                    <tr>
                        <?php for($kolumna=1;$kolumna<=8;$kolumna++){ ?>
                            <td <?php if($kolumna+$linia%2==1) echo 'class="b"';?>>
                                <?=$this->pokazFigure($linia,$kolumna); ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </body>
</html>