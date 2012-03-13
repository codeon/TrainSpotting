<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('allow_url_fopen', '1');
include('simple_html_dom.php');
/*
$auth = base64_encode('<username>:<pasword>');
$aContext = array(
    'http' => array(
        'proxy' => 'tcp://172.31.1.227:3128',
        'request_fulluri' => true,
        'header' => "Proxy-Authorization: Basic $auth",
    ),
);
$cxContext = stream_context_create($aContext);
*/
echo "<head>           
          <meta name=\"txtweb-appkey\" content=\"1f62495c-a7db-4625-bfba-969f0d25b419\">
      </head>        
     <body>";
if(isset($_GET['txtweb-message']))     $message = $_GET['txtweb-message']; 
else $message = "cnb ndls";

$input=explode(" ",$message);
if (count($input) >=2)
{
	$srcl=strtoupper($input[0]);
	$destl=strtoupper($input[1]);
	$src = "http://www.trainenquiry.com/Departure_Display.aspx?sel_val=". $srcl ."+&queryDisplay=MATHURA+JN%2c+MTJ+&time=24&name=&code=";
	$trains="http://www.trainenquiry.com/TrainsBetw2St_Display.aspx?station1=". $srcl ."+&station2=". $destl ."+&queryDisplay1=KANPUR+CENTRAL%2c+CNB+&queryDisplay2=MATHURA+JN%2c+MTJ+";
	$raw = file_get_html($src);
	$mainarray=array();
	foreach($raw->find('div#pnlGrid') as $element) 
    {
		$cnt=0;
		foreach($element->find('tr') as $row)
		{
			if ($cnt!=0)
			{
				$newarray = array();
				$c=0;
				foreach($row->find('td') as $col)
				{   
					if ($c==1 || $c==2 || $c==14)
					{
						$number= $col->plaintext;
						$newarray[] = $number;
				    }
				    $c++;
				}
				$mainarray[] =  $newarray;
			}
			$cnt++;
		}
	}
	$raw2 = file_get_html($trains);
	$mainarray2=array();
	foreach($raw2->find('div#pnlGrid') as $element) 
    {
		$cnt=0;
		foreach($element->find('tr') as $row)
		{
			if ($cnt!=0)
			{
				$c=0;
				foreach($row->find('td') as $col)
				{   
					if ($c==1)
					{
						$number= $col->plaintext;
						$mainarray2[] = $number;
				    }
					$c++;	
				}
			}
			$cnt++;
		}
	}
	print_r($mainarray2);
	foreach($mainarray as $value)
	{
		
	    if(in_array($value[0] ,$mainarray2) )
	    {
			echo $value[0]." ".$value[1]." ".$value[2]."<br/>\n";
		}
	}
}				
else
{
	echo "Source and destination station missing";
}
	echo "</body>";
		
?>
