<?php
class UserDAO extends Database {

	function incrementVideoViews($id) {
		$views = $this->getVideoViews($id);
		if($views == null) {
			$views = 0;
		}
		$views++;
		$this->setVideoViews($id, $views);
	}
	
	function getVideoViews($id) {
		$query = sprintf(GET_VIDEO_VIEWS, $id);
		$result = $this->sql_query($query);
		$row = $result->fetch_assoc();
		return $row['views'];
	}
	
	function setVideoViews($id, $views) {
		$query = sprintf(INSERT_UPDATE_VIDEO_VIEWS, $id, $views, $views);
		$this->sql_query($query);
	}
	
	function getGenres() {
		$result = $this->sql_query(GET_GENRES);
		$genres = array();
		while ($row = $result->fetch_assoc()) {
			$genre = new Genre();
			$genre->setId($row['id']);
			$genre->setName($row['name']);
			$genres[] = $genre;
		}
		$result->close();
		return $genres;
	}
	
	function getMostViewedVideoDetails($start, $end) {
		$query = sprintf(GET_MOST_VIEWED_VIDEOS, $start, $end);
		return $this->createVideoDetails($query);
	}
	
	function getNewlyAddedVideoDetails($start, $end) {
		$query = sprintf(GET_RECENT_VIDEOS, $start, $end);
		return $this->createVideoDetails($query);
	}
	
	function getMostViewedVideoDetailsByGenre($genre, $start, $end) {
		$query = sprintf(GET_MOST_VIEWED_VIDEOS_BY_GENRE, $genre, $start, $end);
		return $this->createVideoDetails($query);
	}
	
	function searchByName($name, $partial, $start, $end) {
		$videoName = $name;
		$sign = "=";
		if($partial) {
			$videoName = '%' . $name . '%';
			$sign = " like ";
		}
		$query = sprintf(SEARCH_NAMES, $sign, $videoName, $start, $end);
		return $this->createVideoDetails($query);
	}
	
	function searchByNameGenre($name, $partial, $genre, $start, $end) {
		$videoName = $name;
		$sign = "=";
		if($partial) {
			$videoName = '%' . $name . '%';
			$sign = " like ";
		}
		$query = sprintf(SEARCH_NAMES_GENRE, $genre, $sign, $videoName, $start, $end);
		return $this->createVideoDetails($query);
	}
	
	function getTotalVideosByGenre($genre) {
		$query = sprintf(VIDEO_COUNT_BY_GENRE, $genre);
		$result = $this->sql_query($query);
		$row = $result->fetch_assoc();
		return $row['total_videos'];
	}
	
	function getTotalVideos() {
		$result = $this->sql_query(VIDEO_COUNT);
		$row = $result->fetch_assoc();
		return $row['total_videos'];
	}
	
	function getTotalSearchVideos($name, $partial) {
		$videoName = $name;
		$sign = "=";
		if($partial) {
			$videoName = '%' . $name . '%';
			$sign = " like ";
		}
		$query = sprintf(SEARCH_NAMES_SIZE, $sign, $videoName);
		$result = $this->sql_query($query);
		$row = $result->fetch_assoc();
		return $row['total_videos'];
	}
	
	function getTotalSearchVideosByGenre($name, $partial, $genre) {
		$videoName = $name;
		$sign = "=";
		if($partial) {
			$videoName = '%' . $name . '%';
			$sign = " like ";
		}
		$query = sprintf(SEARCH_NAMES_SIZE_GENRE, $genre, $sign, $videoName);
		$result = $this->sql_query($query);
		$row = $result->fetch_assoc();
		return $row['total_videos'];
	}
	
	function getVideoDetails($id) {
		$query = sprintf(GET_VIDEO_DETAILS, $id);
		$result = $this->sql_query($query);
		$row = $result->fetch_assoc();
		
		$videoDetail = new VideoDetails();
		$videoDetail->setId($row['id']);
		$videoDetail->setDescription($row['description']);
		$videoDetail->setLength($row['length']);
		$videoDetail->setName($row['name']);
		$videoDetail->setGenreId($row['genre_id']);
		$videoDetail->setFileName($row['file_name']);
		$videoDetail->setAddedDate($row['added_date']);
		$videoDetail->setViews($row['views']);
		
		return $videoDetail;
	}

	public function getSimilarVideos($pattern, $genre, $size) {
		$query = sprintf(SEARCH_NAMES_GENRE, $genre, " like", $pattern . '%', 0, $size);
		return $this->createVideoDetails($query);
	}
	
	public function getComments($id) {
		$query = sprintf(SELECT_COMMENTS, $id);
		$result = $this->sql_query($query);
		$comments = array();
		while ($row = $result->fetch_assoc()) {
			$comment = new Comment();
			$comment->setId($row['id']);
			$comment->setName($row['name']);
			$comment->setEmail($row['email']);
			$comment->setComment($row['comment']);
			$comment->setVideoId($row['video_id']);
			$comment->setDate($row['date']);
			$comments[] = $comment;
		}
		$result->close();
		return $comments;
	}

	public function addComment($comment) {
		$query = sprintf(INSERT_COMMENT, $comment->getName(), $comment->getEmail(), $comment->getComment(), $comment->getVideoId());
		$this->sql_query($query);
	}
	
	public function deleteComment($id) {
		$query = sprintf(DELETE_COMMENT, $id);
		$this->sql_query($query);
	}
	
	public function getRating($id) {
		$query = sprintf(SELECT_RATING, $id);
		$result = $this->sql_query($query);
		$rating = new Rating();
		while ($row = $result->fetch_assoc()) {
			$rating->setAverageRating($row['average_rating']);
			$rating->setTotalRating($row['total_voted']);
		}
		$rating->setId($id);
		return $rating;
	}
	
	public function setRating($rating) {
		$query = sprintf(INSERT_RATING, $rating->getId(), $rating->getTotalRating(), $rating->getAverageRating(), $rating->getTotalRating(), $rating->getAverageRating());
		$this->sql_query($query);
	}
	
	private function createVideoDetails($query) {
		$result = $this->sql_query($query);
		$videoDetails = array();
		while ($row = $result->fetch_assoc()) {
			$videoDetail = new VideoDetails();
			$videoDetail->setId($row['id']);
			$videoDetail->setDescription($row['description']);
			$videoDetail->setLength($row['length']);
			$videoDetail->setName($row['name']);
			$videoDetail->setGenreId($row['genre_id']);
			$videoDetail->setFileName($row['file_name']);
			$videoDetail->setAddedDate($row['added_date']);
			$videoDetail->setViews($row['views']);
			$videoDetails[] = $videoDetail;
		}
		$result->close();
		return $videoDetails;
	}
}
?>