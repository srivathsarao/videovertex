<?php
class AdminDAO extends Database {

	function createVideo($videoDetails) {
		$query = sprintf(INSERT_VIDEO, $videoDetails->getDescription(), $videoDetails->getLength(), $videoDetails->getName(), $videoDetails->getGenreId(), $videoDetails->getFileName());
		$this->sql_query($query);
	}
	
	function editVideo($videoDetails) {
		$query = sprintf(UPDATE_VIDEO, $videoDetails->getDescription(), $videoDetails->getName(), $videoDetails->getGenreId(), $videoDetails->getId());
		$this->sql_query($query);
	}

	function deleteVideo($videoDetails) {
		$query = sprintf(DELETE_VIDEO, $videoDetails->getId());
		$this->sql_query($query);
	}

	function createGenre($genre) {
		$query = sprintf(INSERT_GENRE, $genre->getName());
		$this->sql_query($query);
	}
	
	function editGenre($genre) {
		$query = sprintf(UPDATE_GENRE, $genre->getName(), $genre->getId());
		$this->sql_query($query);
	}

	function deleteGenre($genre) {
		$query = sprintf(DELETE_GENRE, $genre->getId());
		$this->sql_query($query);
	}
	
	function deleteComment($id) {
		$query = sprintf(DELETE_COMMENT, $id);
		$this->sql_query($query);
	}

	function getNewFileNames($allFiles) {
		$newFiles = array();
		if (count($allFiles) == 0) {
			return $newFiles;
		}

		foreach ($allFiles as $file) {
			$result = $this->sql_query("select file_name from video_detail where file_name='$file'");
			if(!$result) {
				$newFiles[] = $file;
				continue;
			}
			while ($row = $result->fetch_row()) { }
			$size = $result->num_rows;
			if($size == 0) {
				$newFiles[] = $file;
			}
		}
		
// 		$this->sql_query(DROP_TEMP_TABLE);
// 		$this->sql_query(CREATE_TEMP_TABLE);
// 		$returnString = "";
// 		foreach ($allFiles as $file) {
// 			$insertStatement = sprintf(INSERT_TEMP_TABLE, $file);
// 			$returnString = $returnString . $insertStatement . "\n";
// 		}
// 		$this->sql_query($returnString);
// 		$result = $this->sql_query(GET_NEW_FILES_QUERY);

// 		$newFileNames = array();

// 		while ($row = $result->fetch_assoc()) {
// 			$newFileNames[] = $row[FILE_NAME];
// 		}
		
// 		$result->close();
// 		$this->sql_query(DROP_TEMP_TABLE);

		return $newFiles;
	}
}
?>