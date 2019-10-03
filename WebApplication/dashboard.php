<?php
include('php/session.php');
?>

<!DOCTYPE html>
<html>
<head>
	<!--                greenLab               -->    
	<!--                NAG  IoE               --> 
	<!--   A.Kubicek    V.Kaniok    M.Bernat   --> 
	<meta charset="utf-8">
	<title>greenLab - Dashboard</title>

	<!-- CSS links --> 
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
	<link rel="stylesheet" type="text/css" href="css/timepicker.min.css">
	<link rel="stylesheet" type="text/css" href="css/plugin.css">

	<!-- JS --> 
	<script src="js/plugin.js" type="text/JavaScript"></script>
	<script src="js/timepicker.js" type="text/JavaScript"></script>	
	<!-- AJAX functions --> 
	<script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>

	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>

	<script type="text/javascript">

	function send_mail_ajax(box, value) {
		var mail_ajax; 
               
        try {
            mail_ajax = new XMLHttpRequest();
        } catch (e) {
            try {
                mail_ajax = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    mail_ajax = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {
                    alert("Your browser broke!");
                    return false;
                }
            }
        }

        var mail_query = "?box=" + box +  "&value=" + value;
        mail_ajax.open("GET", "php/mail_alert.php" + mail_query, true);
        mail_ajax.send(null); 
	} 

	function updateValues(){
		$.ajax({                                      
	      url: 'php/data_toWeb.php',        
	      data: "",
	      dataType: 'json',    
	      success: function(data)
	      {
	        var temp = data[0];
	        var hum_out = data[1];
	        var hum_in = data[2];
	        var lux = data[3];

	        temp = parseInt(temp);
	        hum_out = parseInt(hum_out);
	        hum_in = parseInt(hum_in);
	        lux = parseInt(lux);

	        temp = temp/10;
	        hum_out = hum_out/10;

	        temperature.innerHTML = temp + " °C";
	        humidity_out.innerHTML = hum_out + " %";
	        humidity_in.innerHTML = hum_in + " %";
	        lux_light.innerHTML = lux + " lux";  

	        if (temp > 25.0) {
	        	document.getElementById("temp_box").style.backgroundColor = "#d95459";
	        	document.getElementById("temp_box").style.backgroundImage = "url('../img/warning_box.png')";

	        	//send_mail_ajax("Teplota", temp);
	        } else {
	        	document.getElementById("temp_box").style.backgroundColor = "#eeeeee";
	        	document.getElementById("temp_box").style.backgroundImage = "none";
	        }

	        if (hum_out > 50.0) {
	        	document.getElementById("humOut_box").style.backgroundColor = "#9a569a";
	        	document.getElementById("humOut_box").style.backgroundImage = "url('../img/warning_box.png')";

	        	//send_mail_ajax("Vlhkost_okoli", temp);
	        } else {
	        	document.getElementById("humOut_box").style.backgroundColor = "#eeeeee";
	        	document.getElementById("humOut_box").style.backgroundImage = "none";
	        }

	        if (hum_in < 40.0) {
	        	document.getElementById("humIn_box").style.backgroundColor = "#bda99f";
	        	document.getElementById("humIn_box").style.backgroundImage = "url('../img/warning_box.png')";

	        	//send_mail_ajax("Vlhkost_pudy", temp);
	        } else {
	        	document.getElementById("humIn_box").style.backgroundColor = "#eeeeee";
	        	document.getElementById("humIn_box").style.backgroundImage = "none";
	        }

	        if (lux < 50.0) {
	        	document.getElementById("light_box").style.backgroundColor = "#456c80";
	        	document.getElementById("light_icon_change").src = "img/moon_icon.png";
	        } else {
	        	document.getElementById("light_box").style.backgroundColor = "#eeeeee";
	        	document.getElementById("light_icon_change").src = "img/light_icon.png";
	        }

	      } 
	    });
	}

	setInterval(updateValues, 1000);

	function ajaxRGB(rToSQL, gToSQL, bToSQL) {
               var ajaxRGB_req; 
               
               try {
                  ajaxRGB_req = new XMLHttpRequest();
               }catch (e) {
                  try {
                     ajaxRGB_req = new ActiveXObject("Msxml2.XMLHTTP");
                  }catch (e) {
                     try{
                        ajaxRGB_req = new ActiveXObject("Microsoft.XMLHTTP");
                     }catch (e){
                        alert("Your browser broke!");
                        return false;
                     }
                  }
               }

               var queryRGB = "?red=" + rToSQL +  "&green=" + gToSQL + "&blue=" + bToSQL;
               ajaxRGB_req.open("GET", "php/rgb_sqlUpdate.php" + queryRGB, true);
               ajaxRGB_req.send(null); 
    }

    function ajaxHumidity(humToSQL) {
               var ajaxHum_req; 
               
               try {
                  ajaxHum_req = new XMLHttpRequest();
               }catch (e) {
                  try {
                     ajaxHum_req = new ActiveXObject("Msxml2.XMLHTTP");
                  }catch (e) {
                     try{
                        ajaxHum_req = new ActiveXObject("Microsoft.XMLHTTP");
                     }catch (e){
                        alert("Your browser broke!");
                        return false;
                     }
                  }
               }

               var queryHum = "?humidity=" + humToSQL;
               ajaxHum_req.open("GET", "php/humidity_sqlUpdate.php" + queryHum, true);
               ajaxHum_req.send(null); 
    }

    function ajaxLux(luxToSQL) {
               var ajaxLux_req; 
               
               try {
                  ajaxLux_req = new XMLHttpRequest();
               }catch (e) {
                  try {
                     ajaxLux_req = new ActiveXObject("Msxml2.XMLHTTP");
                  }catch (e) {
                     try{
                        ajaxLux_req = new ActiveXObject("Microsoft.XMLHTTP");
                     }catch (e){
                        alert("Your browser broke!");
                        return false;
                     }
                  }
               }

               var queryLux = "?lux=" + luxToSQL;
               ajaxLux_req.open("GET", "php/lux_sqlUpdate.php" + queryLux, true);
               ajaxLux_req.send(null); 
    }

    function ajaxLight(switchToSQL, timeFromToSQL, timeToToSQL) {
               var ajaxLight_req; 
               
               try {
                  ajaxLight_req = new XMLHttpRequest();
               }catch (e) {
                  try {
                     ajaxLight_req = new ActiveXObject("Msxml2.XMLHTTP");
                  }catch (e) {
                     try{
                        ajaxLight_req = new ActiveXObject("Microsoft.XMLHTTP");
                     }catch (e){
                        alert("Your browser broke!");
                        return false;
                     }
                  }
               }

               var queryLight = "?switch=" + switchToSQL +  "&timeFrom=" + timeFromToSQL + "&timeTo=" + timeToToSQL;
               ajaxLight_req.open("GET", "php/light_sqlUpdate.php" + queryLight, true);
               ajaxLight_req.send(null); 
    }

    RGBToHexTest = function(r,g,b){
			    var bin = r << 16 | g << 8 | b;
			    return (function(h){
			        return new Array(7-h.length).join("0")+h
			    })(bin.toString(16).toUpperCase())
			}

    $(function () {

    $.ajax({                                      
      url: 'php/onLoad_updateFields.php',        
      data: "",
      dataType: 'json',    
      success: function(data)
      {
        var r_fromDB = data[0];
        var g_fromDB = data[1];
        var b_fromDB = data[2];
        var hum_fromDB = data[3];
        var lux_fromDB = data[4];
        var switch_fromDB = data[5];
        var timeFrom_fromDB = data[6];
        var timeTo_fromDB = data[7];

        document.getElementById('red').value = r_fromDB;
        document.getElementById('green').value = g_fromDB;
        document.getElementById('blue').value = b_fromDB;

	    r_fromDB = parseInt(r_fromDB);
        g_fromDB = parseInt(g_fromDB);
        b_fromDB = parseInt(b_fromDB);

        var testHex = RGBToHexTest(r_fromDB,g_fromDB,b_fromDB);
       	loadedHex = testHex;

       	document.getElementById('colorbox').style.backgroundColor='#'+testHex;

        document.getElementById('humidity_input').value = hum_fromDB;
        document.getElementById('lux_input').value = lux_fromDB;
        if (switch_fromDB > 0) {
        	document.getElementById('light_switch_inp').checked = true;
        } else {
			document.getElementById('light_switch_inp').checked = false;
        }
        document.getElementById('timeFrom').value = timeFrom_fromDB;
        document.getElementById('timeTo').value = timeTo_fromDB;       
      } 
    });

    });



	</script>
    
</head>

<body>
	<header>
		<img src="img/greenLab_logo.png" class="header_logo">
		<h1 class="dashboard_title">CHYTRÝ KVĚTINÁČ</h1>
		<ul class="right_menu">
			<li><img src="img/user_icon.png"></li>
			<li><?php echo $login_session; ?></li>
			<li><a href="php/logout.php"><img src="img/logout_icon.png"></a></li>
		</ul>
	</header>
	<div class="section_title">SENZORY:</div>
	<div class="section_underline"></div>

	<section class="sensor_center">

		<div class="sensor_box" id="temp_box">
			<img src="img/temperature_icon.png" class="box_icon">
			<p class="box_title">TEPLOTA</p>
			<div class="box_underline"></div>
			<p class="box_value" id="temperature"></p>
		</div>

		<div class="sensor_box" id="humOut_box">
			<img src="img/humidityOut_icon.png" class="box_icon">
			<p class="box_title">VLHKOST OKOLÍ</p>
			<div class="box_underline"></div>
			<div class="box_value" id="humidity_out"></div>
		</div>

		<div class="sensor_box" id="humIn_box">
			<img src="img/humidityIn_icon.png" class="box_icon">
			<p class="box_title">VLHKOST PŮDY</p>
			<div class="box_underline"></div>
			<div class="box_value" id="humidity_in"></div>
		</div>

		<div class="sensor_box" id="light_box">
			<img src="img/light_icon.png" class="box_icon" id="light_icon_change">
			<p class="box_title">OKOLNÍ SVĚTLO</p>
			<div class="box_underline"></div>
			<div class="box_value" id="lux_light"></div>
		</div>

	</section>

	<div class="section_title">OVLÁDÁNÍ:</div>
	<div class="section_underline"></div>

	<section class="control_center">

	<div class="control_box">
		<img src="img/lamp_icon.png" class="box_icon">
		<p class="box_title">BARVA OSVĚTLENÍ</p>
		<div id="plugin">
		 	<div id="plugHEX" onmousedown="stop=0; setTimeout('stop=1',100);">F1FFCC</div><br>
		 	<div id="SV" onmousedown="HSVslide('SVslide','plugin',event)">
		  		<div id="SVslide" style="TOP: -4px; LEFT: -4px;"><br /></div>
		 	</div>
			<form id="H" onmousedown="HSVslide('Hslide','plugin',event)" >
		  		<div id="Hslide" style="TOP: -7px; LEFT: -8px;"><br /></div>
		  		<div id="Hmodel"></div>
		 	</form>
		</div>

		<input type="label" id="red" class="input_rgb"></input>
		<input type="label" id="green" class="input_rgb"></input>
		<input type="label" id="blue" class="input_rgb"></input>

		<p class="input_desc" id="r_desc">R:</p>
		<p class="input_desc" id="g_desc">G:</p>
		<p class="input_desc" id="b_desc">B:</p>

		<div id="colorbox">

		<script type="text/javascript">

			function hexToRgb(hex) {
			    var bigint = parseInt(hex, 16);
			    var r = (bigint >> 16) & 255;
			    var g = (bigint >> 8) & 255;
			    var b = bigint & 255;
			    return [r, g, b];
			}

			RGBToHex = function(r,g,b){
			    var bin = r << 16 | g << 8 | b;
			    return (function(h){
			        return new Array(7-h.length).join("0")+h
			    })(bin.toString(16).toUpperCase())
			}


			document.getElementById('red').onchange=function(){
				if (document.getElementById('red').value > 255) {
					document.getElementById('red').value = 255;
				} 

				if (document.getElementById('red').value < 0) {
					document.getElementById('red').value = 0;
				} 

				ajaxRGB(document.getElementById('red').value,document.getElementById('green').value,document.getElementById('blue').value);
				updateH(RGBToHex(document.getElementById('red').value,document.getElementById('green').value,document.getElementById('blue').value));
				document.getElementById('colorbox').style.backgroundColor='#'+RGBToHex(document.getElementById('red').value,document.getElementById('green').value,document.getElementById('blue').value);
			};

			document.getElementById('green').onchange=function(){
				if (document.getElementById('green').value > 255) {
					document.getElementById('green').value = 255;
				} 

				if (document.getElementById('green').value < 0) {
					document.getElementById('green').value = 0;
				} 

				ajaxRGB(document.getElementById('red').value,document.getElementById('green').value,document.getElementById('blue').value);
				updateH(RGBToHex(document.getElementById('red').value,document.getElementById('green').value,document.getElementById('blue').value));
				document.getElementById('colorbox').style.backgroundColor='#'+RGBToHex(document.getElementById('red').value,document.getElementById('green').value,document.getElementById('blue').value);
			};

			document.getElementById('blue').onchange=function(){
				if (document.getElementById('blue').value > 255) {
					document.getElementById('blue').value = 255;
				} 

				if (document.getElementById('blue').value < 0) {
					document.getElementById('blue').value = 0;
				} 

				ajaxRGB(document.getElementById('red').value,document.getElementById('green').value,document.getElementById('blue').value);
				updateH(RGBToHex(document.getElementById('red').value,document.getElementById('green').value,document.getElementById('blue').value));
				document.getElementById('colorbox').style.backgroundColor='#'+RGBToHex(document.getElementById('red').value,document.getElementById('green').value,document.getElementById('blue').value);
			};

			function mkColor(v){

				var rgb = hexToRgb(v);
				var red = rgb[0];
				var green = rgb[1];
				var blue = rgb[2];

				document.getElementById('red').value = red;
				document.getElementById('green').value = green;
				document.getElementById('blue').value = blue;

				ajaxRGB(red, green, blue);

				document.getElementById('colorbox').style.backgroundColor='#'+v;
			}
			
			setTimeout(function() { loadSV(); updateH(loadedHex);	},1500)
					

		</script>

		</div>
	</div>

	<div class="control_box">
		<img src="img/pump_icon.png" class="box_icon">

		<p class="box_title">AUTOMATICKÝ REŽIM</p>

		<div id="control_humidity">
			<p class="box_title">Udržování vlhkosti</p>
			<input id="humidity_input">
			<p class="unit">%</p>
		</div>

		<div id="control_autoLight">
			<p class="box_title">Automatické osvětlení</p>
			<label class="light_switch">
				<input id="light_switch_inp" class="light_switch_input" type="checkbox"/>
				<span class="light_switch_label" data-on="Zap" data-off="Vyp"></span> 
				<span class="light_switch_handle"></span> 
			</label>
		</div>

		<div id="automated_light">
			<div id="arrow_top"></div>

			<div id="fromTime">
				<p class="timeMark">OD: </p>
				<input id="timeFrom" class="timeInput" type="text" name="timepicker" data-toggle="timepicker" value="8:00">
			</div>

			<div id="toTime">
				<p class="timeMark">DO: </p>
				<input id="timeTo" class="timeInput" type="text" name="timepicker" data-toggle="timepicker" value="18:00">
			</div>
					
			<script type="text/javascript">
				document.getElementById('light_switch_inp').onchange=function(){
					if (document.getElementById('light_switch_inp').checked == true) {
						ajaxLight(1, document.getElementById('timeFrom').value, document.getElementById('timeTo').value);						
					} else {
						ajaxLight(0, document.getElementById('timeFrom').value, document.getElementById('timeTo').value);
					}
				};

				document.addEventListener("DOMContentLoaded", function(event) {
				    timepicker.load({
				        interval: 15,
				    });
				});
			</script>

			<div id="control_lux">
				<p id="lux_title">Aktivovat při poklesu pod:</p>
				<input id="lux_input">
				<p class="unit">lx</p>
			</div>
			
		</div>

		<script type="text/javascript">
		
		document.getElementById('lux_input').onchange=function(){
			if (document.getElementById('lux_input').value >= 0 && document.getElementById('lux_input').value <= 60000) {
				document.getElementById('lux_input').style.border = '3px solid #1eca6b';
				ajaxLux(document.getElementById('lux_input').value);
			} else {
				document.getElementById('lux_input').style.border = '3px solid #d95459';
			}
		};

		document.getElementById('humidity_input').onchange=function(){
			if (document.getElementById('humidity_input').value >= 0 && document.getElementById('humidity_input').value <= 100) {
				document.getElementById('humidity_input').style.border = '3px solid #1eca6b';
				ajaxHumidity(document.getElementById('humidity_input').value);
			} else {
				document.getElementById('humidity_input').style.border = '3px solid #d95459';
			}
		};

		</script>

	</div>

</section>

	<div class="section_title">GRAFY:</div>
	<div class="section_underline"></div>

	<section class="graf_center">
		<div class="graf_box">
			<div id="graph_temperature"></div>
		</div>

		<div class="graf_box">
			<div id="graph_humidity"></div>
		</div>

		<div class="graf_box">
			<div id="graph_lux"></div>
		</div>

		<div class="graf_box">
			<p class="watering_title">Zalévání květináče</p>
			<p class="watering_subtitle">greenLab</p>
			<?php 

           $dbhost = "innodb.endora.cz";
		   $dbuser = "";
		   $dbpass = "";
		   $dbname = "";
		   
		   $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

		   $water_result = mysqli_query($connection, "SELECT logTime FROM watering_log ORDER BY logTime DESC");

		   while( $water_row = mysqli_fetch_array( $water_result)){
		    $water_array[] = $water_row[0];
		}



		$water = array_slice($water_array, 0, 20);

		for ($i=0; $i < 19; $i++) { 
			$year_str = substr($water[$i], 0, -15);
			$month_str = substr($water[$i], 5, -12);
			$day_str = substr($water[$i], 8, -9);
			$hour_str = substr($water[$i], 11, -6);
			$minute_str = substr($water[$i], 14, -3);

			$year = (int)$year_str;
			$month = (int)$month_str;
			$day = (int)$day_str;
			$hour = (int)$hour_str;
			$minute = (int)$minute_str;

			$pre = $i - 1;
			$pre_year = substr($water[$pre], 0, -15);
			$pre_month = substr($water[$pre], 5, -12);
			$pre_day = substr($water[$pre], 8, -9);
			$pre_hour = substr($water[$pre], 11, -6);
			$pre_minute = substr($water[$pre], 14, -3);

			$pre_year = (int)$pre_year;
			$pre_month = (int)$pre_month;
			$pre_day = (int)$pre_day;
			$pre_hour = (int)$pre_hour;
			$pre_minute = (int)$pre_minute;

			$rangeMIN = $pre_minute - 3;
			$rangeMAX = $pre_minute + 3;

			if ($pre >= 0 && $year==$pre_year && $month==$pre_month && $day==$pre_day) {
				
				if ($hour == $pre_hour && $minute > $rangeMIN && $minute < $rangeMAX) {
					$counter++;
					if ($i == 18) {
						echo "   ";
						echo $counter;
						echo "x";
					}
				} else {
					echo "   ";
					echo $counter;
					echo "x";
					echo "</p>";
					echo "<br>";
					echo "<p class='watering_time'>";
					echo $hour;
					echo ":";
					echo $minute_str;
					$counter = 1;
				}
			} else {
				if ($i > 0) {
					echo "   ";
					echo $counter;
					echo "x";
					echo "</p>";
				} 
				echo "<br><br>";
				echo "<p class='watering_date'>";
					echo $day;
					echo ". ";
					echo $month;
					echo ". ";
					echo $year;
				echo "</p>";
				echo "<br>";

				echo "<p class='watering_time'>";
				echo $hour;
				echo ":";
				echo $minute_str;
				$counter = 1;			
				
			}
		}
		?> 		
		</div>

	</section>

	<a class="button_download" href="php/export_csv.php" target="_blank">Stáhnout historii</a>

	<footer>
		NAG IoE 2017 - A. Kubiček | V. Kaniok | M. Bernát
	</footer>


	<script type="text/javascript">

		
		Highcharts.chart('graph_temperature', {
    chart: {
    	backgroundColor: '#eeeeee',
        type: 'spline'
    },
    title: {
        text: 'Teplota okolí'
    },
    subtitle: {
        text: 'greenLab'
    },
    
    credits: {
    	enabled: false
    },
    
    xAxis: {
        type: 'datetime',
    },
    yAxis: {
        title: {
            text: 'Teplota [°C]'
        },
        min: 0
    },
    tooltip: {
        headerFormat: '<b>{series.name}</b><br>',
        pointFormat: '{point.x:%H:%M}: {point.y:.1f} °C'
    },

    plotOptions: {
        spline: {
            marker: {
                enabled: false
            }
        }
    },

    exporting: { enabled: false },

    series: [{
        name: 'Teplota',
        color: '#BB0A0A',
        data: [

        	<?php 

           $dbhost = "innodb.endora.cz";
		   $dbuser = "";
		   $dbpass = "";
		   $dbname = "";
		   
		   $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

		   $temp_result = mysqli_query($connection, "SELECT temp FROM graphLog_web ORDER BY DateTime DESC");

		   $time_result = mysqli_query($connection, "SELECT DateTime FROM graphLog_web ORDER BY DateTime DESC");

		   while( $temp_row = mysqli_fetch_array( $temp_result)){
		    $temp_array[] = $temp_row[0];
		}

		while( $time_row = mysqli_fetch_array( $time_result)){
		    $time_array[] = $time_row[0];
		}



		$temperature = array_slice($temp_array, 0, 200);

		$time = array_slice($time_array, 0, 200);


		for ($i=0; $i < 71; $i++) { 
			$year = substr($time[$i], 0, -15);
			$month = substr($time[$i], 5, -12);
			$day = substr($time[$i], 8, -9);
			$hour = substr($time[$i], 11, -6);
			$minute = substr($time[$i], 14, -3);
			echo "[Date.UTC(";
			echo $year;
			echo ", ";
			echo $month;
			echo ", ";
			echo $day;
			echo ", ";
			echo $hour;
			echo ", ";
			echo $minute;
			echo "), ";
			echo $temperature[$i]/10;
			echo "],";
		}
		?> 
        ]
    }]
});


		Highcharts.chart('graph_humidity', {
    chart: {
    backgroundColor: '#eeeeee',
        type: 'areaspline'
    },
    title: {
        text: 'Vlhkost okolí a půdy'
    },
    
    subtitle: {
        text: 'greenLab'
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        verticalAlign: 'top',
        x: 50,
        y: 50,
        floating: true,
        borderWidth: 0,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#eeeeee'
    },
    xAxis: {
        type: 'datetime',
    },
    yAxis: {
        title: {
            text: 'Vlhkost [%]'
        }
    },
    tooltip: {
    	xDateFormat: '%H:%M',
        shared: true,
        valueSuffix: ' %',
        //pointFormat: '{point.x:%H:%M}: {point.y:.1f} %'
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        areaspline: {
            fillOpacity: 0.5
        }
    },
    exporting: { enabled: false },
    series: [{
        name: 'Vlhkost půdy',
        data: [
        		<?php 

           $dbhost = "innodb.endora.cz";
		   $dbuser = "";
		   $dbpass = "";
		   $dbname = "";
		   
		   $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

		   $hum_in_result = mysqli_query($connection, "SELECT hum_in FROM graphLog_web ORDER BY DateTime DESC");

		   $time_hum_in_result = mysqli_query($connection, "SELECT DateTime FROM graphLog_web ORDER BY DateTime DESC");

		   while( $hum_in_row = mysqli_fetch_array( $hum_in_result)){
		    $hum_in_array[] = $hum_in_row[0];
		}

		while( $time_hum_in_row = mysqli_fetch_array( $time_hum_in_result)){
		    $time_hum_in_array[] = $time_hum_in_row[0];
		}



		$hum_in = array_slice($hum_in_array, 0, 200);

		$time_hum_in = array_slice($time_hum_in_array, 0, 200);


		for ($i=0; $i < 71; $i++) { 
			$year = substr($time_hum_in[$i], 0, -15);
			$month = substr($time_hum_in[$i], 5, -12);
			$day = substr($time_hum_in[$i], 8, -9);
			$hour = substr($time_hum_in[$i], 11, -6);
			$minute = substr($time_hum_in[$i], 14, -3);
			echo "[Date.UTC(";
			echo $year;
			echo ", ";
			echo $month;
			echo ", ";
			echo $day;
			echo ", ";
			echo $hour;
			echo ", ";
			echo $minute;
			echo "), ";
			echo $hum_in[$i];
			echo "],";
		}
		?> 
        
            ]
    }, {
        name: 'Vlhkost okolí',
        data: [
        <?php 

           $dbhost = "innodb.endora.cz";
		   $dbuser = "";
		   $dbpass = "";
		   $dbname = "";
		   
		   $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

		   $hum_out_result = mysqli_query($connection, "SELECT hum_out FROM graphLog_web ORDER BY DateTime DESC");

		   $time_hum_result = mysqli_query($connection, "SELECT DateTime FROM graphLog_web ORDER BY DateTime DESC");

		   while( $hum_out_row = mysqli_fetch_array( $hum_out_result)){
		    $hum_out_array[] = $hum_out_row[0];
		}

		while( $time_hum_out_row = mysqli_fetch_array( $time_hum_result)){
		    $time_hum_out_array[] = $time_hum_out_row[0];
		}



		$hum_out = array_slice($hum_out_array, 0, 200);

		$time_hum_out = array_slice($time_hum_out_array, 0, 200);


		for ($i=0; $i < 71; $i++) { 
			$year = substr($time_hum_out[$i], 0, -15);
			$month = substr($time_hum_out[$i], 5, -12);
			$day = substr($time_hum_out[$i], 8, -9);
			$hour = substr($time_hum_out[$i], 11, -6);
			$minute = substr($time_hum_out[$i], 14, -3);
			echo "[Date.UTC(";
			echo $year;
			echo ", ";
			echo $month;
			echo ", ";
			echo $day;
			echo ", ";
			echo $hour;
			echo ", ";
			echo $minute;
			echo "), ";
			echo $hum_out[$i]/10;
			echo "],";
		}
		?> 

            ]
    }]
});

		Highcharts.chart('graph_lux', {
    chart: {
    	backgroundColor: '#eeeeee',
        type: 'spline'
    },
    title: {
        text: 'Intenzita osvětlení'
    },
    subtitle: {
        text: 'greenLab'
    },
    
    credits: {
    	enabled: false
    },
    
    xAxis: {
        type: 'datetime',
    },
    yAxis: {
        title: {
            text: 'Intenzita osvětlení [lux]'
        },
        min: 0
    },
    tooltip: {
        headerFormat: '<b>{series.name}</b><br>',
        pointFormat: '{point.x:%H:%M}: {point.y:.0f} lux'
    },

    plotOptions: {
        spline: {
            marker: {
                enabled: false
            }
        }
    },

    exporting: { enabled: false },

    series: [{
        name: 'Intenzita osvětlení',
        color: '#f5c10e',
        data: [

        	<?php 

           $dbhost = "innodb.endora.cz";
		   $dbuser = "";
		   $dbpass = "";
		   $dbname = "";
		   
		   $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

		   $lux_result = mysqli_query($connection, "SELECT lux FROM graphLog_web ORDER BY DateTime DESC");

		   $time_lux_result = mysqli_query($connection, "SELECT DateTime FROM graphLog_web ORDER BY DateTime DESC");

		   while( $lux_row = mysqli_fetch_array( $lux_result)){
		    $lux_array[] = $lux_row[0];
		}

		while( $time_lux_row = mysqli_fetch_array( $time_lux_result)){
		    $time_lux_array[] = $time_lux_row[0];
		}



		$lux = array_slice($lux_array, 0, 200);

		$time_lux = array_slice($time_lux_array, 0, 200);


		for ($i=0; $i < 71; $i++) { 
			$year = substr($time_lux[$i], 0, -15);
			$month = substr($time_lux[$i], 5, -12);
			$day = substr($time_lux[$i], 8, -9);
			$hour = substr($time_lux[$i], 11, -6);
			$minute = substr($time_lux[$i], 14, -3);
			echo "[Date.UTC(";
			echo $year;
			echo ", ";
			echo $month;
			echo ", ";
			echo $day;
			echo ", ";
			echo $hour;
			echo ", ";
			echo $minute;
			echo "), ";
			echo $lux[$i];
			echo "],";
		}
		?> 
        ]
    }]
});
	</script>



</body>
</html>