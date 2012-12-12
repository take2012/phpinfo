<?php


$url = "http://takelab.sub.jp/airlog/?feed=rss2";
$result = simplexml_load_file($url); //XMLを扱う関数の一つ。シンプルで使いやすい

$i = 0;

if(isset($result->channel->item)){
  foreach ($result->channel->item as $v){

		if($v->location != ""){		
  		$creator[$i] = $v->children("dc",true)->creator;		
  		$title[$i] = $v->title;
  		$desc[$i] = $v->description;
  		$loc[$i] =  $v->location;
	  	$homepage[$i] = $v->link;
  		$iconthumb[$i] = $v->image;
		  $mainresource[$i] = "";
		  //$homepage[$i] = urlencode($homepage[$i]);//URLに日本語が含まれている場合、URLエンコードしないとiPhoneだとウェブに飛べないので、その場合はこのようなコードでエンコードする。ハマ経は今のところ大丈夫
	  	$route[$i] = "true";
  		$mail[$i] = "";
  		$phone[$i] = "";
      }
$i++;
  }
}

$j=1;
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<results>";

//for($i=0;$i < count( $title );$i++) => for($i=0;$i < count( $loc );$i++)

for($i=0;$i < count( $loc ); $i++){//$locの数だけPOIを生成する。今回はjunaioのphpライブラリを使用せず、直接junaio規定のXMLを生成している
  if($creator[$i] =="re_take21"){
echo "
   <poi id=\"".$j."\" interactionfeedback=\"none\">
    <name>" . $title[$i] . "</name> 
    <description>". $desc[$i] ."</description>  
    <l>" .$loc[$i]. "</l>
    <o>0,0,0</o>
    " . $mainresource[$i] . "
    <mime-type>" . $mimetype[$i] . "</mime-type>
    " . $homepage[$i] . "
    <route>". $route[$i] . "</route>
    <icon>". $iconthumb[$i] ."</icon>
    <thumbnail>". $iconthumb[$i] ."</thumbnail>
    </poi>    
";
$j++;
  }
}
echo "</results>";
?>
>
