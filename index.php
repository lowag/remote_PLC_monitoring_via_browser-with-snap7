<?php
if (isset($_GET['page']) && in_array($_GET['page'],array("estop","unwinder","edgeguide","splicing","knifesystem","rewinder_stripper","trolley","run_jog_stop","hydraulics","recipe","alarms")))
{
$json=file_get_contents("/var/www/json_dicts/".$_GET['page'].".json");

$json_data=exec("python3.10 get_data.py '".$json."'");
}
else if (isset($_GET['page']))
die("Invalid GET request!");
//$json_enc=json_decode($json,true);
$datatypes = array("dig_input" => gettext("Digital inputs"),"dig_output" => gettext("Digital outputs"),"marker" => gettext("Markers"), "db"=>gettext("Database elements"));

?>

<html>
  <head>
    <title>Machine</title>
<style>
<?php

include("styles/style.css");
?>
</style>
 </head>
  <body>
<div id="page">
    <h1></h1>

<div id="left-panel">
<?php
echo "<h1>".gettext("Machine_name")."</h1>";
echo "<div><a href=\"index.php?page=estop\" id=\"estop\">".gettext("Estop")."</a></div>\n";
echo "<div><a href=\"index.php?page=run_jog_stop\" id=\"run_jog_stop\">".gettext("Run, jog, stop")."</a></div>\n";
echo "<div><a href=\"index.php?page=hydraulics\" id=\"hydraulic\">".gettext("Hydraulics")."</a></div>\n";
echo "<div><a href=\"index.php?page=recipe\" id=\"recipe\">".gettext("Recipe")."</a></div>\n";

?>

</div>

<div id="right-panel">
<?php
if (isset($_GET['debug']))
	print_r($json_data);
if (empty($json_data))
echo gettext("No connection!");
else {
$data_array= json_decode($json_data,true);

  $i=0;

    foreach($data_array as $key=>$type)  {
        
        if ($i>0)
           echo "</table>";
        $i=1;
        echo "<h2>";
        echo $datatypes[$key];
        echo"</h2>";
        echo "<table class='tabl'>";
        foreach ($type as $addr=>$address)
        { if($i%4==1)
            echo "<tr>";

          echo "<td><strong>(".$addr."):</strong> ".$address['name']."</td>";
          if ($address['value']==true)
            echo "<td class='green'>";
          else if ($address['value']==false)
            echo "<td class='red'>";
          else
            echo "<td class='yellow'>";
          if ($key=="dig_input" or $key=="dig_output" or $key=="marker" )
            echo "  ";
          else
             echo $address['value'];
          echo "</td></div>";
          
          if ($i%4==0)
            echo "</tr>";
        $i++;
        }
if ($i%4>0)
echo "</tr>";

    }
    echo "</table>";


}
?>


</div>
</div>
  </body>
</html>
