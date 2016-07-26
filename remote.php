<?php
$tihuan1 = '{"评论": ["';
$tihuan2 = '",';
//$tihuan3 = ' ';
$tihuan4 = 'https://www.douban.com/group/topic/';

@$string = $_POST["content"];
@$url = $_POST["url"];
@$filter = $_POST["filter"];
$url = "http://103.27.77.63:5000/results/dump/".$url.".txt";

$fp_output = fopen('./test.txt', 'w');
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_FILE, $fp_output);
    curl_exec($ch);
    curl_close($ch);

    exec("libreoffice ./test.txt", $out, $status);
$cfile =   "./test.txt";
$fhandle = fopen($cfile, "r");
$fstring = fread($fhandle, 11111111);

$fstring= str_replace($tihuan1,'<br>{"评论": [<br>"',$fstring);
$fstring= str_replace($tihuan2,'",<br>',$fstring);
//$fstring= str_replace($tihuan3,'<br>',$fstring);
$fstring= str_replace($tihuan4,'<br>帖子链接：https://www.douban.com/group/topic/',$fstring);

//过滤的词汇以"|"作为分隔符
$file = "./words.txt"; 
$handle = fopen($file, "r");
$contents = fread($handle, filesize ($file));


$string= str_replace($tihuan1,'<br>{"评论": [<br>"',$string);
$string= str_replace($tihuan2,'",<br>',$string);
//$string= str_replace($tihuan3,'<br>',$string);
$string= str_replace($tihuan4,'<br>帖子链接：https://www.douban.com/group/topic/',$string);

$b1 = '<span class="red">';
$b2 = '</span>';

$badwords = explode('|',$contents);

$text = str_replace($badwords,$b1.$filter.$b2,$string);
$text2 = str_replace("\n","<br>",$text);

$ftext = str_replace($badwords,$b1.$filter.$b2,$fstring);
$ftext2 = str_replace("\n","<br>",$ftext);
?>

<!DOCTYPE html><html>
<head>
<title>敏感词过滤</title>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
<script src="./jquery-2.2.4.min.js"></script>
<script src="./bootstrap/js/bootstrap.min.js"></script>
<script src="./main.js"></script>
</head>
<style type="text/css">
.red{
	color : red;
	background-color : yellow;
  font-weight: bold;
}
#direct{
	display: none;
}
.btn{
  margin: 2px;
}
p{
  margin: 5px;
  padding: 5px;
  border: 1px solid #8A8A8A;
  border-radius: 10px;
}
</style>
<body>
<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">敏感词过滤</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li><a href="#" id="btn_direct">直接输入</a></li>
        <li><a href="#" id="btn_remote">远程输入</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container" id="direct">
	<div class="row user-list">
    	<div class="col-sm-4 user">
			<form action="http://103.27.77.63/ci/" method="post">
			<h3>输入: </h3><textarea class="form-control" cols="60" rows="15" type="text" name="content"></textarea>
      <h3>过滤字符: </h3><input class="form-control" type="text" name="filter" value="***" />
      <button type="submit" value="提交" class="btn pull-right btn-primary">提交</button></form>
		</div>
		<div class="col-sm-8 user">
			<h3>过滤后：</h3>
			<p><?php echo $text2; ?></p>

		</div>
	</div>
</div>	 	 
	<div>
<div class="container" id="remote">
	<div class="row user-list">
    	<div class="col-sm-4 user">
			<form action="http://103.27.77.63/ci/remote.php" method="post">
			<h3>爬虫名称: </h3><input type="text" class="form-control" name="url" placeholder="输入名称" />
      <h3>过滤字符: </h3><input class="form-control" type="text" name="filter" value="***" />
      <button type="submit" value="提交" class="btn pull-right btn-primary">提交</button></form>
		</div>
		<div class="col-sm-8 user">
			<h3>过滤后：</h3>
			<p><?php echo $ftext2; ?></p>
		</div>
	</div>
</div>

</body>
</html>