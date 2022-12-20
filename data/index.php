<?php 

//Mostrar a data atual em timestamp
echo "<p>Data atual em timestamp: ". time() . "</p>";

//Transformar timestamp em data atual
echo "<p>Transformar timestamp em data atual: ". date("d/m/Y", time()) . "</p>";

//Transformar data atual em timestamp
echo "<p>Transformar data atual em timestamp: ". strtotime('2021=02-05') . "</p>";

//Somar 100 dias em uma data
$data = '2021-02-05';
$nova_data = strtotime($data) + (86400 * 100);
//86400 = quantidade de segundos por dia
echo "<p>Somar 100 dias em uma data: ". date('d/m/Y', $nova_data) . "</p>";

//Subtrair 10 dias em uma data
$data = '2021-02-05';
$nova_data = strtotime($data) - (86400 * 100);
//86400 = quantidade de segundos por dia
echo "<p>Subtrair 10 dias em uma data: ". date('d/m/Y', $nova_data) . "</p>";

//Convertendo o timestamp pro banco de dados
echo "<p>Convertendo o timestamp pro banco de dados: ". date('Y-m-d H:i:s',time()) . "</p>";

//Descobrir dia da semana de uma data

echo "<p>Descobrir dia da semana de uma data: ". date('D', $nova_data) . "</p>";