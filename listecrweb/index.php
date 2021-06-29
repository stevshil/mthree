<html>
<head>
  <style>
  table, th, td {
    border-bottom: 1px solid black;
  }
  </style>
</head>
<h1>Docker Repository Images from $ECRREPO</h1>
<table>
<tr><th>Project</th><th>Images</th></tr>
<?php
  $output=shell_exec("aws ecr describe-images --repository-name $ECRREPO --query 'imageDetails[].imageTags[]'| sed -e 's/\"//g' -e 's/  *//g' | sort -rn");
  $list=explode("\n",$output);
  $lastproject="";
  $count=0;
  foreach($list as $image) {
    $image=str_replace("\r","",$image);
    $image=str_replace("\n","",$image);
    $image=str_replace("[","",$image);
    $image=str_replace("]","",$image);
    $image=str_replace(",","",$image);
    if ( strcmp($image,"") == 0 ) {
      continue;
    }
    # Get project name
    $project=explode("-",$image);
    if ( strcmp($project[0],$lastproject) !== 0 ) {
      if ( $count !== 0 ) {
        echo "</td></tr>";
      }
      echo "<tr><td>$project[0]</td><td>";
    }
    if ( strcmp($image,"") !== 0 ) {
      echo "<tr><td>&nbsp;</td><td>$image</td></tr>\n";
    }
    $lastproject=$project[0];
    $count+=1;
  }
?>
</table>
</html>
