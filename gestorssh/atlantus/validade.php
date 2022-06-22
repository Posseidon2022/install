<meta name="viewport" content="width=device-width, initial-scale=1.0, max-scale=1.0">
<meta charset="UTF-8">
<html>
<style>
.inputmax
{
  padding: 11px;
  width: 90%;
  font-size: 19px;
  background: #1a121d;
  border: 0;
  color: #acacac;
  position: relative;
  top: 23px;
  border-radius: 8px;
  text-align: center;
}



.container{

}
.titulo-principal{
  font-size: 15px;
    max-width: 480px;
    text-align: center;

    font-family:'Courier New', Courier, monospace;
    color: green;
}
.titulo-principal:after{
 content: '|';
 margin-left: 5px;
 opacity: 1;
 animation: pisca .7s infinite;
}
/* Animação aplicada ao content referente a classe *.titulo-principal* resultando num efeito de cursor piscando. */

@keyframes pisca{
    0%, 100%{
        opacity: 1;
    }
    50%{
        opacity: 0;
    }
}
</style>
<body>
<center>


<label size="30px">
<?php
include '../pages/system/conecta.php';


//Criar a conexao
$conn = mysqli_connect($host, $user, $pass, $db);

$url = str_replace("/atlantus/validade.php?", "", $_SERVER["REQUEST_URI"]);

$result_gp = "SELECT login,data_validade FROM usuario_ssh WHERE login = '$url' ";
$resultado_gp = mysqli_query($conn, $result_gp);
while($row_usuario = mysqli_fetch_array($resultado_gp)){
 
    $data = '' .$row_usuario['data_validade']. '' ;
     
     ///echo $teste;
     $hoje = date('d/m/Y');

$data1 = $hoje;
$data2 = "$data";

// transforma a data do formato BR para o formato americano, ANO-MES-DIA
$data1 = implode('-', array_reverse(explode('/', $data1)));
$data2 = implode('-', array_reverse(explode('/', $data2)));

// converte as datas para o formato timestamp
$d1 = strtotime($data1); 
$d2 = strtotime($data2);

// verifica a diferença em segundos entre as duas datas e divide pelo número de segundos que um dia possui
$dataFinal = ($d2 - $d1) /86400;

// caso a data 2 seja menor que a data 1, multiplica o resultado por -1
if($dataFinal < 0)
  $dataFinal *= -1;
}
?>



<?php
$originalDate = "$data";
//original date is in format YYYY-mm-dd
$timestamp = strtotime($originalDate); 
$newDate = date("d/m/Y", $timestamp );
//echo  $newDate;


 

?>

<div class="container">
<h1 class="titulo-principal">

<?php echo " Ainda Resta   ".$dataFinal." Dias de Acesso..."; ?>
</h1></div>

 <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
 <script type="text/javascript" src="personalizado.js"></script>
<script> 
function typeWrite(elemento){
    const textoArray = elemento.innerHTML.split('');
    elemento.innerHTML = ' ';
    textoArray.forEach(function(letra, i){   
      
    setTimeout(function(){
        elemento.innerHTML += letra;
    }, 75 * i)

  });
}
const titulo = document.querySelector('.titulo-principal');
typeWrite(titulo);

</script>
</body>
</html>
