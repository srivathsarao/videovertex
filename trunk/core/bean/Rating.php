<?php

class Rating {
	private $totalRating;
	private $averageRating;
	private $id;

	public function getTotalRating() {
		return $this->totalRating;
	}

	public function setTotalRating($totalRating) {
		$this->totalRating = $totalRating;
	}

	public function getAverageRating() {
		return $this->averageRating;
	}

	public function setAverageRating($averageRating) {
		$this->averageRating = $averageRating;
	}

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

}
?>