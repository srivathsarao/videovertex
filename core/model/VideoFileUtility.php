<?php
class VideoFileUtility {
	private $directory = "../videos/";
	//private $imageDirectory = "../../images/thumbnails/";
	private $imageDirectory = "../images/thumbnails/";

	function createThumbnail($videoBaseName, $length) {
		$fullPath = $this->getFullPath($videoBaseName);
		$file = basename($fullPath, ".flv");

		$imageFullPath = realpath($this->imageDirectory);
		$imageFile = $imageFullPath . DIRECTORY_SEPARATOR . $file . ".jpg";
		
		if(!file_exists($imageFile)) {

			$values = preg_split('/[:]/', $length);
			$hour   = $values[0];
			$minute = $values[1];
			$second = $values[2];
			$value = ($hour*60*60) + ($minute*60) + $second;
			$value = $value/2;
			
			ini_set('max_execution_time', 600);
			//echo "ffmpeg -i \"" . $fullPath . "\" -an -ss $length -an -r 5000 -vframes 1 -s 192x94 -y \"" . $imageFile . "\"";
			//shell_exec("ffmpeg -i \"" . $fullPath . "\" -an -ss $length -an -r 5000 -vframes 1 -s 192x94 -y \"" . $imageFile . "\"");
			shell_exec("ffmpeg -ss $value -i \"" . $fullPath . "\" \"" . $imageFile . "\" -s 192x94 -r 1 -vframes 1 -an -vcodec mjpeg");
		}
	}
	
	function getLength($videoBaseName) {
		$fullPath = $this->getFullPath($videoBaseName);

		$cmd = "ffmpeg -i \"" . $fullPath . "\" 2>&1";
		$result = shell_exec($cmd);

		if (preg_match('/Duration: ((\d+):(\d+):(\d+))/s', $result, $time)) {
			$total = ($time[2] * 3600) + ($time[3] * 60) + $time[4];
		}

		return $time[1];
	}

	function getFullPath($video) {
		$relativePath = $this->directory . $video;
		$fullPath = realpath($relativePath);
		return $fullPath;
	}

	function getImageFullPath($thumbnail) {
		$relativePath = $this->imageDirectory . $thumbnail;
		echo $fullPath = realpath($relativePath);
		//return $fullPath;
		return $relativePath;
	}

	function getNewFiles() {
		$videoBaseNames = $this->getAllFileNames();
		$dao = new AdminDAO();
		return $dao->getNewFileNames($videoBaseNames);
	}

	function getAllFileNames() {
		//get all image files with a .jpg extension.
		$videos = glob($this->directory . "*.flv");

		$videoBaseNames = array();
		//print each file name
		foreach ($videos as $video) {
			array_push($videoBaseNames, basename($video));
		}
		return $videoBaseNames;
	}

	function getThumbnail($videoFileName) {
		$file = basename($videoFileName, ".flv");
		$file = $file . ".jpg";
		return $file;
	}

	function deleteVideo($fileName) {

		$fullPath = $this->getFullPath($fileName);

		$file = basename($fullPath, ".flv");

		$fullImagePath = $this->getImageFullPath($file . ".jpg");

		if (is_readable($fullPath)) {
			unlink($fullPath);
		}

		if (is_readable($fullImagePath)) {
			unlink($fullImagePath);
		}
	}

	function getPartialMatchPatterns($pattern, $array) {
		if ($array == null) {
			$array = array();
		}
		$pieces = preg_split("/\s+(?=\S*+$)/", $pattern);
		if(sizeof($pieces) >= 1) {
			$array[] = $pieces[0];
			if(sizeof($pieces) == 2) {
				$this->getPartialMatchPatterns($pieces[0], $array);
			}
		}
		return $array;
	}
}
?>