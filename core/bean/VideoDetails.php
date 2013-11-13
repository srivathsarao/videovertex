<?php
class VideoDetails {
	private $id;
	private $description;
	private $length;
	private $name;
	private $fileName;
	private $genreId;
	private $addedDate;
	private $thumbnail;
	private $views;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getLength() {
		return $this->length;
	}

	public function setLength($length) {
		$this->length = $length;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getFileName() {
		return $this->fileName;
	}

	public function setFileName($fileName) {
		$this->fileName = $fileName;
	}

	public function getGenreId() {
		return $this->genreId;
	}

	public function setGenreId($genreId) {
		$this->genreId = $genreId;
	}

	public function getAddedDate() {
		return $this->addedDate;
	}

	public function setAddedDate($addedDate) {
		$this->addedDate = $addedDate;
	}

	public function getViews() {
		return $this->views;
	}

	public function setViews($views) {
		$this->views = $views;
	}

	public function getThumbnail() {
		return $this->thumbnail;
	}

	public function setThumbnail($thumbnail) {
		$this->thumbnail = $thumbnail;
	}
}
?>