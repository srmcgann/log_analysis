<!DOCTYPE html>
<html>
  <head>
    <style>
      body,html{
        background:#001;
        color:#1f8;
        font-family:arial,tahoma;
      }
      .results{
        font-size:20px;
        width:300px;
        margin-left:auto;
        margin-right:auto;
      }
      .header{
        width:100%;
        text-align:center;
        color:#f18;
        font-size:24px;
        color:#fff;
      }
      .bold{
        font-size:55px;
      }
    </style>
  </head>
  <body>
    <div class="header">
      Average Comment Lengths for the Most Active Users (>1.5k lines)<br>
      <span class="bold">##frontend on freenode</span><br><br>
    </div>
    <div class="results">
      <?
        $h=fopen("##frontend.freenode.log","r");
        $names = Array();
        while(!feof($h)){
          $line=fgets($h);
          if(($start=strpos($line,"<")) !==false && ($finish=strpos($line,">")) !==false){
            $name=substr($line,$start+1,$finish-$start-1);
            
            if(isset($names[$name])){
              $names[$name]['linecount']++;
              $names[$name]['totalchars']+=strlen(substr($line,$finish+1));
            }else{
              $names[$name]=Array();
              $names[$name]['linecount']=1;
              $names[$name]['totalchars']=substr($line,$finish+1);
            }
          }
        }
        foreach($names as &$val){
          if($val['linecount']<1500){
            unset($val);
          }else{
            $val['average']=$val['totalchars']/$val['linecount'];
          }
        }
        uasort($names, function ($a, $b) {
            return $b['average'] <=> $a['average'];
        });
        foreach($names as $key=>$val){
          if($val['average'])echo $key." = ".round($val['average'],2)."<br>";
        }
      ?>
    </div>
  </body>
</html>