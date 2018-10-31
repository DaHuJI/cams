<?php

//повесить скрипт на крон раз в сутки

$video_dir = __DIR__.'/video/';
$video_subdirs = scandir($video_dir);

foreach ($video_subdirs as $video_subdir) {
	if (is_directory($video_subdir)) {
		$files = scandir($video_dir . $video_subdir);
		foreach ($files as $file) {
			check_and_delete_file($video_dir . $video_subdir . '/' . $file);
		}
	}
}


function is_directory($dir) {
	return $dir != '.' and $dir != '..';
}

function check_and_delete_file($file) {
	if (is_file($file)) {
		var_dump($file);
		if (time() - filemtime($file) >= 60 * 60 * 24 * 3) {
		    unlink($file);
		    echo 'Файл удалён';
		} else {
			echo "Файл " . $file . " не старше 3х дней \n";
		}
	}
} 

?>