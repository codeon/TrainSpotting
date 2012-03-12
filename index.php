<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');
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
$srcl=strtoupper($_GET['src']);
$destl=strtoupper($_GET['dest']);


$src = "http://www.trainenquiry.com/Departure_Display.aspx?sel_val=". $srcl ."+&queryDisplay=MATHURA+JN%2c+MTJ+&time=24&name=&code=";
$dest = "http://www.trainenquiry.com/Departure_Display.aspx?sel_val=". $destl ."+&queryDisplay=M%2c+MTJ+&time=48&name=&code=";
//echo $src;
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
					//echo $col;
					$newarray[] = $number;
				    }
				    $c++;
					
				}
	//			echo $counter;
				$mainarray[] =  $newarray;
			}
			$cnt++;
			}
		}
$raw2 = file_get_html($dest);
$mainarray2=array();
foreach($raw2->find('div#pnlGrid') as $element) 
       {
		   $cnt=0;
			foreach($element->find('tr') as $row)
			{
				if ($cnt!=0)
				{
				$newarray2 = array();
				$c=0;
				foreach($row->find('td') as $col)
				{   
					if ($c==1 || $c==2 || $c==14)
					{
					$number= $col->plaintext;
					//echo $col;
					$newarray2[] = $number;
				    }
				    $c++;
					
				}
	//			echo $counter;
				$mainarray2[] =  $newarray2;
			}
			$cnt++;
			}
		}
		

/*
		print_r($mainarray);
		echo "new<br/>";
		print_r($mainarray2);
*/


foreach($mainarray as $value)
{
	foreach($mainarray2 as $value2)
	    {
	    if($value[0]==$value2[0])
	    {
	         print_r( $value);
		     break;
		 }
		 
		 }
}		
		
		
?>
