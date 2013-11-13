<?php
class UserFunctions {
	private $dao;
	private $videoFileUtility;

	public function __construct() {
		$this->dao = new UserDAO();
		$this->videoFileUtility = new VideoFileUtility();
	}

	public function getGenres() {
		return $this->dao->getGenres();
	}

	public function increaseVideoViews($id) {
		$this->dao->incrementVideoViews($id);
	}

	public function getMostViewedVideos($start, $end) {
		$videoDetails = $this->dao->getMostViewedVideoDetails($start, $end);
		$videoDetails = $this->setVideoProperties($videoDetails);
		return $videoDetails;
	}

	public function getRecentlyAddedVideos($start, $end) {
		$videoDetails = $this->dao->getNewlyAddedVideoDetails($start, $end);
		$videoDetails = $this->setVideoProperties($videoDetails);
		return $videoDetails;
	}

	public function getMostViewedVideoDetailsByGenre($genre, $start, $end) {
		$videoDetails = $this->dao->getMostViewedVideoDetailsByGenre($genre, $start, $end);
		$videoDetails = $this->setVideoProperties($videoDetails);
		return $videoDetails;
	}
	
	public function getTotalSearchVideo($name, $partial, $genre) {
		if($genre == "all") {
			return $this->dao->getTotalSearchVideos($name, $partial);
		}
		return $this->dao->getTotalSearchVideosByGenre($name, $partial, $genre);
	}
	
	public function getSearchVideos($name, $partial, $genre, $start, $end) {
		if($genre == "all") {
			$videoDetails = $this->dao->searchByName($name, $partial, $start, $end);
			return $this->setVideoProperties($videoDetails);
		}
		$videoDetails = $this->dao->searchByNameGenre($name, $partial, $genre, $start, $end);
		return $this->setVideoProperties($videoDetails);
	}

	public function getSimilarVideos($name, $genre, $size) {
		$patterns = $this->videoFileUtility->getPartialMatchPatterns($name, null);
		$videoDetails = array();
		foreach($patterns as $pattern) {
			$videoDetailsSubArray = $this->dao->getSimilarVideos($pattern, $genre, $size);
			foreach($videoDetailsSubArray as $subArrayDetail) {
				$contains = false;
				foreach($videoDetails as $videoDetail) {
					if($subArrayDetail->getId() == $videoDetail->getId()) {
						$contains = true;
					}
				}
				if(sizeof($videoDetails) >= $size) {
					return $this->setVideoProperties($videoDetails);
				}
				if(!$contains) {
					$videoDetails[] = $subArrayDetail;
				}
			}
		}
		return $this->setVideoProperties($videoDetails);
	}
	
	public function getGenreName($id) {
		$genres = $this->dao->getGenres();
		foreach ($genres as $genre) {
			if ($genre->getId() == $id) {
				return $genre->getName();
			}
		}
		return null;
	}

	public function getTotalVideos() {
		return $this->dao->getTotalVideos();
	}

	public function getTotalVideosByGenre($genre) {
		return $this->dao->getTotalVideosByGenre($genre);
	}

	public function getVideoDetails($id) {
		$videoDetail = $this->dao->getVideoDetails($id);

		$fileName = $videoDetail->getFileName();
		$thumbnail = $this->videoFileUtility->getThumbnail($fileName);
		$videoDetail->setThumbnail($thumbnail);
		if ($videoDetail->getViews() == null) {
			$videoDetail->setViews(0);
		}
		return $videoDetail;
	}

	private function setVideoProperties($videoDetails) {
		foreach ($videoDetails as $videoDetail) {
			$fileName = $videoDetail->getFileName();
			$thumbnail = $this->videoFileUtility->getThumbnail($fileName);
			$videoDetail->setThumbnail($thumbnail);
			if ($videoDetail->getViews() == null) {
				$videoDetail->setViews(0);
			}
		}
		return $videoDetails;
	}

	public function getComments($id) {
		return $this->dao->getComments($id);
	}
	
	public function addComment($comment) {
		$this->dao->addComment($comment);
	}
	
	public function getRating($id) {
		$rating = $this->dao->getRating($id);
		if($rating->getAverageRating() == null) {
			$rating->setAverageRating(0);
		}
		if($rating->getTotalRating() == null) {
			$rating->setTotalRating(0);
		}
		return $rating;
	}
	
	public function setRating($id, $rating) {
		$oldRating = $this->getRating($id);
		$averageRating = $rating;
		if($oldRating->getTotalRating() != 0) {
			$averageRating = (($oldRating->getAverageRating() * $oldRating->getTotalRating()) + $rating)/($oldRating->getTotalRating() + 1);
		}
		$oldRating->setTotalRating($oldRating->getTotalRating() + 1);
		$oldRating->setAverageRating($averageRating);
		$this->dao->setRating($oldRating);
	}
	
	public function selfURL() {
		$url =(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]=="on") ? "https://" : "http://";
		$url = $url . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		$url = $this->removeQuerystringVar($url, "page");
		if (parse_url($url, PHP_URL_QUERY)) {
			return $url . '&';
		} else { 
			return $url . '?';
		}
	}
	
	private function removeQuerystringVar($url, $key) {
		$url = preg_replace('/(.*)(?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&');
		$url = substr($url, 0, -1);
		return $url;
	}
}
?>