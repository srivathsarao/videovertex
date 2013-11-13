<?php
class AdminFunctions {
	private $videoFileUtility;
	private $adminDAO;
	
	public function __construct() {
		$this->videoFileUtility = new VideoFileUtility();
		$this->adminDAO = new AdminDAO();
	}

	public function createGenre($genre) {
		$this->adminDAO->createGenre($genre);
	}
 
	public function deleteGenres($genre){
		$this->adminDAO->deleteGenre($genre);
	}
	
	public function editGenres($genre){
		$this->adminDAO->editGenre($genre);
	}
	
	public function getNewVideos() {
		$newFiles = $this->videoFileUtility->getNewFiles();
		$date = date('Y-m-d', strtotime(str_replace('-', '/', time())));
		$videoDetails = array();
		$i = 0;
		foreach ($newFiles as $newFile) {
			$videoDetail = new VideoDetails();
			$length = $this->videoFileUtility->getLength($newFile);
			
			$this->videoFileUtility->createThumbnail($newFile, $length);
			$thumbnail = $this->videoFileUtility->getThumbnail($newFile);
			
			$videoDetail->setId($i);
			$videoDetail->setLength($length);
			$videoDetail->setThumbnail($thumbnail);
			$videoDetail->setAddedDate($date);
			$videoDetail->setFileName($newFile);
			$i++;
			
			$videoDetails[] = $videoDetail;
		}
		return $videoDetails;
	}
	
	public function createVideos($videoDetails) {
		$this->adminDAO->createVideo($videoDetails);
	}
	
	public function saveVideo($videoDetail) {
		$this->adminDAO->editVideo($videoDetail);
	}
	
	public function deleteVideo($videoDetail) {
		$this->videoFileUtility->deleteVideo($videoDetail->getFileName());
		$this->adminDAO->deleteVideo($videoDetail);
	}
	
	public function deleteComment($id) {
		$this->adminDAO->deleteComment($id);
	}
}
?>