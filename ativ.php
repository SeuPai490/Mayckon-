<?php

require 'vendor/autoload.php';

$host = 'localhost';
$dbname = 'biblioteca';
$username = 'root';
$password = 'HORTETEC_115';

try{
   $pdo = new PDO('mysql:host='.$hostname.';dbname='.$dbname.';chaeset=utf8',$username,$password);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=ut8" , $username, $password );
$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = "select * from livro";
$stmt = $pdo->prepare($query);
$stmt->execute();

$livros = $stmt-fetchAll(PDO::FETCH_ASSOC);

$mpdf = new \Mpdf\Mpdf();


$html = '<h1>lista de livros</h1>';
$html .= '<table border="1" cellpadding = "10" cellspacing = "10" width = "100%">';
$html .='<tr>
            <td>Título</td> 
            <td>Autor</td>
            <td>Ano de Publicação</td>
            <td>Resumo</td>
    </tr>';

foreach ($livros as $livro) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars( $livro['titulo']) . '</td>';
    $html .= '<td>' . htmlspecialchars( $livro['autor']) . '</td>';
    $html .= '<td>' . htmlspecialchars( $livro['ano_publicacao']) . '</td>';
    $html .= '<td>' . htmlspecialchars( $livro['resumo']) . '</td>';
    $html .= '</tr>';
}

$html .= '</table>';

$mpdf->WriteHTML( $html);

$mpdf->Output( 'lista_de_livro.pdf', \Mpdf\Output\Destination::DOWLOAD);

} catch (PDOExeception $e) {
    echo "Erro na conexão com o banco de dados: " . $e->getMessagen();
} catch (\Mpdf\MpdfException $e) {
     echo "Erro ao gerar o PDF: " . $e->getMessage();
}