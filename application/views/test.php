<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Nama Hari</title>
<script>
function nama_hari(str){
 str=parseInt(str);
 switch(str){
  case 0:
    text='Minggu';break;
  case 1:
    text='Senin';break;
  case 2:
    text='Selasa';break;
  case 3:
    text='Rabu';break;
  case 4:
    text='Kamis';break;
  case 5:
    text='Jumat';break;
  case 6:
    text='Sabtu';break;
}
document.write(text);
}
</script>
</head>

<body>
Sekarang adalah hari: 
<script>
	window.nama_hari("<?php echo date("w");?>")
</script>
</body>
</html>