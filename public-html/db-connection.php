<?php

 require 'db-conn.inc.php';

 echo '<table border="1">';
 foreach($connection->query('select * from movies') as $record){
     //print_r($record);
     echo '<tr>';
     echo '<td>' . $record['id'] . '</td>';
     echo '<td>' . $record['title'] . '</td>';
     echo '<td>' . $record['length'] . '</td>';
     echo '<td>' . $record['genre'] . '</td>';
     echo '<td>' . $record['actor'] . '</td>';
     echo '</tr>';
 }
 echo '</table>';

?>