<style>
a:link	{color: #66b70f; text-decoration: none;}
a:active	{color: #66b70f; text-decoration: none;}
a:visited	{color: #66b70f; text-decoration: none;}
a:hover	{color: #ffffff; text-decoration: underline;}

   body{
    background-color: #555555; /* Цвет фона веб-страницы */
    
   } 
*{
font-family: "Verdana", "Lucida Grande", Sans-Serif;
font-size: 12px;
}

table {
font-family: "Verdana", "Lucida Grande", Sans-Serif;
font-size: 14px;
color: #dddddd;
border-collapse: collapse;
text-align: center;
}
th, td:first-child {
padding: 10px 10px;
}
th, td {
border-style: solid;
/*border-width: 0 1px 1px 0;*/
border-color: #444444;
}

h1 {
  color: #66b70f;
  color: #66b70f; margin-top: 5px;
  font: 26px 'Russo One', sans-serif;
}

progress {

    display: block;
        width: 60px;
    border-radius : 3px;
    background: #fff;
    padding: 0;
    border: 0;
    text-align: center;
    height: 10px;
    box-shadow: 1px 2px rgba(0,0,0,.3) inset, 0 0 0 1px rgba(0,0,0,.5);
    overflow:hidden;
    background: -o-linear-gradient(#396707, #66b70f 50%, #396707); 

}

progress::-moz-progress-bar {
   background: -moz-linear-gradient(#396707, #66b70f 50%, #396707); 
    border-radius: 3px;
}
progress::-webkit-progress-bar {
    background: #fff;
    box-shadow: 1px 2px rgba(0,0,0,.3) inset, 0 0 0 1px rgba(0,0,0,.5);

}
progress::-webkit-progress-value {
  /*   background: -webkit-linear-gradient(#4c4, #8f8 50%, #4c4); */
  background: -webkit-linear-gradient(#396707, #66b70f 50%, #396707);
    border-radius: 1px;
}

.progress2 {

    display: block;
        width: 60px;
    border-radius : 3px;
    background: #fff;
    padding: 0;
    border: 0;
    text-align: center;
    height: 10px;
    box-shadow: 1px 2px rgba(0,0,0,.3) inset, 0 0 0 1px rgba(0,0,0,.5);
    overflow:hidden;
    background: -o-linear-gradient(#0f71b7, #1794ec 50%, #0f71b7); 
}

.progress2::-moz-progress-bar {
   background: -moz-linear-gradient(#0f71b7, #1794ec 50%, #0f71b7); 
    border-radius: 3px;
}
.progress2::-webkit-progress-bar {
    background: #fff;
    box-shadow: 1px 2px rgba(0,0,0,.3) inset, 0 0 0 1px rgba(0,0,0,.5);
}
.progress2::-webkit-progress-value {
  background: -webkit-linear-gradient(#555555, #888888 50%, #333333);
    border-radius: 1px;
}

</style>

<?php
$my_web_site = "http://ankondyurin.github.io"; // АДРЕС ВАШЕГО САЙТА "http://site.ru"; !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// ХОСТИНГ https://sprinthost.ru/s4569

$today = date("Y.m.d H:i:s"); //получаем текущие дату и время
if (isset($_GET['d'])) {
$d = $_GET['d'];
//echo "Пишем $d";
$file = fopen("track.txt","a+"); 
$text = "$today|$d \r\n";
flock($file, LOCK_EX);
fwrite($file,$text);
flock($file, LOCK_UN);
fclose($file);
}

// https://geocode-maps.yandex.ru/1.x/?apikey=d2dc6cdf-66ab-406e-ae7a-569ae601dcd9&geocode=37.571541,54.148221
echo "<h1>GSM/GPS TRACKER ХУЕКЕР</h1>";
?>
[ <a href=track.php?delete_all onClick="return confirm('Оно тебе надо?')">Очистить базу</a>
<?php


echo "
 |
<a href=track.php?table>Таблица координат</a> | 
<a href=track.php?poslednie>Последние координаты</a> | 
<a href=track.php?track>Маршрут</a> ] <br>";


// Считаем время работы (Разница первой и последней даты)
$file = file("$my_web_site/track.txt");
$kusok = explode("|", $file[0]);
$on = "$kusok[0]";
$strok = count($file) -1;
$kusok = explode("|", $file[$strok]);
$off = "$kusok[0]";
echo " <font color='#FFFFFF'> Аптайм: ";
$now = new DateTime(); // текущее время на сервере
$now = $date = DateTime::createFromFormat("Y.m.d H:i:s", $on);
$date = DateTime::createFromFormat("Y.m.d H:i:s", $off); // задаем дату в любом формате
$interval = $now->diff($date); // получаем разницу в виде объекта DateInterval
//echo $interval->y, " Лет \n"; // кол-во лет
echo $interval->d, " Дней\n"; // кол-во дней
echo $interval->h, " Часов \n"; // кол-во часов
echo $interval->i, " Минут \n"; // кол-во минут
//echo $interval->s, " Секунд \n"; // кол-во минут

echo "</font><br><br>";


//if (isset($_GET['show'])) {
$file = file("$my_web_site/track.txt");


if (isset($_GET['table'])) {

echo"
<table border=1px cellpadding=5 width='100%' align=center>
<tr align=center>
<td align=center width='30px'>Источник</td><td align=center>Дата</td><td>Широта</td><td>Долгота</td><td>Аккум</td><td>Сеть</td><td>На карте</td><td>Удалить</td>
</tr>
";
for($i=0;$i<count($file);$i++)
{
$kusok = explode("|", $file[$i]);
if($kusok['5'] == "GPS"){$color = "#333333"; $img = "https://denizati-hv.com/assets/images/iconGps.png";}
if($kusok['5'] == "GSM"){$color = "#393939"; $img = "https://lh3.ggpht.com/eV99vlmgMYVYDaKkoTW_F4Wdc25UVH_WNce3RREbEvEcrvMCCBWdE4sT8mkSZ9Vbb_2Y=w80";}





echo ("<tr align='center' bgcolor='$color'><td align='center'><img src='$img' width='20px'> </td><td align='center'>$kusok[0]</td><td>$kusok[1]</td><td>$kusok[2]</td><td>

");

// Считаем процент заряда кккумулятора.
$value = $kusok[3];
$min = "390"; // Заряд аккума, при котором выключился трекер (сел аккум) Указываем без точек!!!!
$max = "450"; // Полный заряд аккума.
$value = str_replace(".", "", $value);
$max = $max - $min;
$value = $value - $min;
$bat_procent = floor(($value / $max) * 100);
// <progress title='$kusok[3]v | $bat_procent %' value='$bat_procent' max='100'>s</progress>


//<p title='$kusok[3]v'>$bat_procent %</p>
echo "
<progress title='$bat_procent% - $kusok[3]v' value='$bat_procent' max='100'>s</progress>
";



echo ("
</td><td>

<progress class='progress2'  id='progress2' title='$kusok[4]%' value='$kusok[4]' max='100'>s</progress>

</td>     <td>  [<a href=track.php?lat=$kusok[1]&lon=$kusok[2]&map>MAP</a>]   </td> <td>[<a href='track.php?del=$i'>X</a>]</td> </tr>");
 }
 
echo"</table>";
//}
}


if (!isset($_GET['d']) && !isset($_GET['del']) && !isset($_GET['track']) && !isset($_GET['poslednie']) && !isset($_GET['table']) && !isset($_GET['lat'])) {echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"0; URL=track.php?table\">";}


if (isset($_GET['track'])) {




echo "Track


<script src='https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=d2dc6cdf-66ab-406e-ae7a-569ae601dcd9' type='text/javascript'></script>
<div id='map' style='width:100%;height:100%'></div>

<script type='text/javascript'>
ymaps.ready(function () {
    var myMap = new ymaps.Map('map', {
        center: 
";
$file = file("$my_web_site/track.txt");

for($i=0;$i<count($file);$i++)
{
$strok = count($file) -1;
//echo "$strok";
$kusok = explode("|", $file[$i]);

if($i == "$strok"){
//echo ("123 $kusok[1]");
$lat = $kusok[1];
$lon =  $kusok[2];
}

 }
 
echo "[$lat, $lon],


  
      //  [54.148197, 37.571418],
        zoom: 15,
        controls: []
    });

    // Построение маршрута.
   // var multiRoute = new ymaps.multiRouter.MultiRoute({
       var multiRoute = new ymaps.multiRouter.MultiRoute({
        referencePoints: [

";
$file = file("$my_web_site/track.txt");
$strok = count($file) -1;
$strok2 = $strok - 50;

for($i=$strok2;$i<=$strok;$i++)
{
//echo "$file[$i] <br>";
$kusok = explode("|", $file[$i]);
if($kusok[5] == "GPS")
{
echo ("[$kusok[1], $kusok[2]],");
}


 }
Echo"    
        ]
    });
    // Добавление маршрута на карту.
    myMap.geoObjects.add(multiRoute);

    // Подписка на событие готовности маршрута.
    multiRoute.model.events.add('requestsuccess', function() {
        // Получение ссылки на активный маршрут.
        var activeRoute = multiRoute.getActiveRoute();
        // Получение коллекции путей активного маршрута.
        var activeRoutePaths = activeRoute.getPaths(); 
        // Проход по коллекции путей.
        activeRoutePaths.each(function(path) {
            console.log('Длина пути: ' + path.properties.get('distance').text);
            console.log('Время прохождения пути: ' + path.properties.get('duration').text);
        });
    }); 
    // Добавление маршрута на карту.
    myMap.geoObjects.add(multiRoute);    
});   
</script>
";

}





if (isset($_GET['poslednie'])) {
echo "Последние координаты: ";
$file = file("$my_web_site/track.txt");
$strok = count($file) -1;
$kusok = explode("|", $file[$strok]);
for($i=$strok;$i>0;$i--)
{
$kusok = explode("|", $file[$i]);
if($kusok[5] == "GPS"){echo "$kusok[0] \ $kusok[1] \ $kusok[2] \ $kusok[3] \ $kusok[4] \ $kusok[5] "; break;}


}



$lat = $kusok[1];
$lon =  $kusok[2];
$coord =  $kusok[5];


echo "
<meta http-equiv='Refresh' content='60' />
<div id='map' style='width: 100%; height:100%'></div>

<script src='https://api-maps.yandex.ru/2.1/?lang=ru_RU' type='text/javascript'></script>
<script type='text/javascript'>

ymaps.ready(init);
function init() {
 
    var myMap = new ymaps.Map('map', {
        center: [$lat, $lon],
        zoom: 17,
    });
    var placemark2 = new ymaps.Placemark([$lat, $lon], {
        hintContent: '+',
    }, {
        'preset': 'islands#redCircleDotIcon'
    });
    myMap.geoObjects.add(placemark2);
    var placemark3 = new ymaps.Placemark([$lat, $lon], {
        hintContent: 'Тута!',
        iconContent: 'Последние GPS координаты $lat - $lon'
    }, {
        'preset': 'islands#greenStretchyIcon'
    });
    myMap.geoObjects.add(placemark3);
}
</script> 
";

}



if (isset($_GET['lat'])) {


if (isset($_GET['lat'])) {
$lat = $_GET['lat'];
}

if (isset($_GET['lon'])) {
$lon = $_GET['lon'];
}


$xml = file_get_contents("http://geocode-maps.yandex.ru/1.x/?apikey=d2dc6cdf-66ab-406e-ae7a-569ae601dcd9&geocode=$lon,$lat");
$adr = explode("<text>", $xml);
$adr2 = explode("</text>", $adr[1]);
echo "- $adr2[0] -";



echo "$lat $lon";
echo "
<meta http-equiv='Refresh' content='100' />
<div id='map' style='width: 100%; height:80%'></div>

<script src='https://api-maps.yandex.ru/2.1/?lang=ru_RU' type='text/javascript'></script>
<script type='text/javascript'>

ymaps.ready(init);
function init() {
 
    var myMap = new ymaps.Map('map', {
        center: [$lat, $lon],
        zoom: 17,
    });
    var placemark2 = new ymaps.Placemark([$lat, $lon], {
        hintContent: '+',
    }, {
        'preset': 'islands#redCircleDotIcon'
    });
    myMap.geoObjects.add(placemark2);
    var placemark3 = new ymaps.Placemark([$lat, $lon], {
        hintContent: 'Тута!',
        iconContent: '$adr2[0]'
    }, {
        'preset': 'islands#greenStretchyIcon'
    });
    myMap.geoObjects.add(placemark3);
}
</script> 
";
}


if (isset($_GET['delete_all'])) {
$myFile = "track.txt";
$fh = fopen($myFile, 'w');
fclose($fh);
//echo "delete_all";
echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"0; URL=track.php?table\">";
header('Location: track.php?table');

}


if (isset($_GET['del'])) {
$del = $_GET['del'];
echo "Удаляю строку $del";


if ($del != "") {
	$file=file("track.txt"); 

	for($i=0;$i<sizeof($file);$i++)
		if($i==$del) unset($file[$i]); 

	$fp=fopen("track.txt","w"); 
	fputs($fp,implode("",$file)); 
	fclose($fp);
	}

echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"0; URL=track.php?table\">";
header('Location: track.php?table');
}

?>
