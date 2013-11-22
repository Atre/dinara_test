<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
</head>
<body>
<span>Дата рождения:</span>
<input id="datepicker" type="text" readonly>
<br />
<span>Знак зодиака:</span>
<select id="signs">
    <option value="1">Овен</option>
    <option value="2">Телец</option>
    <option value="3">Близнецы</option>
    <option value="4">Рак</option>
    <option value="5">Лев</option>
    <option value="6">Дева</option>
    <option value="7">Весы</option>
    <option value="8">Скорпион</option>
    <option value="9">Стрелец</option>
    <option value="10">Козерог</option>
    <option value="11">Водолей</option>
    <option value="12">Рыбы</option>
</select>
<div>
    <div class="sign" id="s1"></div>
    <div class="sign" id="s2"></div>
    <div class="sign" id="s3"></div>
    <div class="sign" id="s4"></div>
    <div class="sign" id="s5"></div>
    <div class="sign" id="s6"></div>
    <div class="sign" id="s7"></div>
    <div class="sign" id="s8"></div>
    <div class="sign" id="s9"></div>
    <div class="sign" id="s10"></div>
    <div class="sign" id="s11"></div>
    <div class="sign" id="s12"></div>
</div>
<br />
<br />
<p>Берем гороскоп по API или из базы:</p>
<span id="span"></span> <br />
<p>Парсим orakul.ua:</p>
<span id="parse"></span>
<br />
<br />
<p>Ссылка на сохраненную страницу с гороскопом:</p>
<a href="#" id="link"></a>

<script>
    $(".sign").hide();

    $(function(){
        $.datepicker.setDefaults(
            $.extend($.datepicker.regional[""])
        );
        $("#datepicker").datepicker();
    });

    $("#datepicker").bind('change', function() {
        $.get( "ajax.php", { date: $(this).val() })
            .success(function(data){
                $("#signs option[value=" + data + "]").attr('selected', 'selected');
                $("#signs").change();
            });
    });

    $("#signs").bind('change', function() {
        $.get( "ajax.php", { sign: $(this).find('option:selected').attr('value') })
            .success(function(data){
                var arr = JSON.parse(data);
                $("#span").text(arr.text[0]);
                $("#link").attr("href", arr.link);
                $("#link").text(arr.link);
                $("#parse").text(arr.parse);
            });
        $(".sign").hide();
        $("#s" + $(this).find('option:selected').attr('value')).show();
    });
</script>

<?php
session_start();
require('Database.php');
if(isset($_GET['h'])) {
    $id = intval($_GET['h']);
    $text = Database::getInstance()->takeFromDb($id);
    $_SESSION['message'] = $text;
    header('Location: upage.php');
}
?>

</body>
</html>