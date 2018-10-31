<?php

  $cams = get_cams();

  $session_key = file_get_contents('key.txt');


  foreach ($cams as $cam => $id) {
    switch ($pid = pcntl_fork()) {
      case -1:
         // @fail
         die('Fork failed');
         break;

      case 0:
        //Дочерний процесс
        start_catch($id, $cam, $session_key);
         break;

      default:
          //Главный процесс
          sleep(1);
          echo "... \n";
        break;
   }
  }
 
  function start_catch($id, $cam, $session_key) {
    $count = 0;
      while(1) {
      $count++;
      $url = 'http://video.kanrit.com.ua:8081/live/' . $id . '/chunks.m3u8?' . $session_key;
      $command = 'ffmpeg -i "' . $url . '" -t 00:10:00.0 -c:a copy -c:v copy video/' . $cam . '/video' . $count . '.mkv &';
      exec($command);
    }
  }

  function get_cams() {
    $cams_content = file_get_contents('cams.json');
    $cams = json_decode($cams_content);
    return $cams;
  }



?>