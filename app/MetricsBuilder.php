<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use DateInterval;

class MetricsBuilder
{

	private $dateStart;
	private $dateEnd;
	private $model;
	private $columns;
	private $relations;
	private $interval;
	private $format;
	private $labels;
	private $dateColumn;

	/**
	 * Create a new MetricsBuilder instance
	 *
	 * @return void
	 */
	public function __construct($dateStart, $dateEnd, $model)
	{
		$this->dateStart = new DateTime($dateStart);
		$this->dateEnd = new DateTime($dateEnd);
		$this->model = $model;
		$this->relations = [];
		$this->labels = [];
		$this->dateColumn = "created_at";
	}

	/**
	 * Set the column used for date comparisons
	 *
	 * @param string $column
	 * @return MetricsBuilder
	 */
	public function column($dateColumn)
	{
		$this->dateColumn = $dateColumn;
		return $this;
	}

	/**
	 * Set the selected columns
	 *
	 * @param array $columns
	 * @return MetricsBuilder
	 */
	public function select(array $columns)
	{
		$this->columns = $columns;
		return $this;
	}

	/**
	 * Add a relation to be included
	 *
	 * @param string $relation
	 * @return MetricsBuilder
	 */
	public function with($relation)
	{
		$this->relations[] = $relation;
		return $this;
	}

	private function calculateInterval()
	{
		$diff = $this->dateStart->diff($this->dateEnd, true);

		if($diff->days > 730) //More than 2 years, show in years
		{
			$this->interval = new DateInterval('P1Y');
			$this->format = 'Y';
		}
		else if($diff->days >= 365 ) //between 1 and 2 years, show in months 
		{
			$this->interval = new DateInterval('P1M');
			$this->format = 'm/Y';
		}
		else if($diff->days > 31) //More than one month, show in weeks
		{
			$this->interval = new DateInterval('P1W');
			$this->format = 'd/m/Y';
		}
		else if($diff->days > 0) //One month or less, show in days
		{
			$this->interval = new DateInterval('P1D');
			$this->format = 'd/m/Y';
		}
		else //Same day, show in hours
		{
			$this->interval = new DateInterval('PT1H');
			$this->format = 'H:00';
		}
	}

	/**
	 * Executes the queries and returns the result.
	 *
	 * @return Collection
	 */
	public function getData()
	{
		$this->calculateInterval();

		$relationCount = count($this->relations);
		$queries = [];
		$datesStart = [];
		$datesEnd = [];
		$datesStart[] = clone $this->dateStart;
		$datesEnd[] = clone $this->dateStart;
		$index = 0;
		$doneLast = false;

		if($this->dateStart == $this->dateEnd)
			$this->dateEnd->add(new DateInterval('P1D'));

		$datesEnd[$index]->add($this->interval);

		while($datesEnd[$index] <= $this->dateEnd && !$doneLast)
		{
			$this->labels[] = $datesStart[$index]->format($this->format);
			$queries[] = $this->model::whereDate($this->dateColumn, '>=', $datesStart[$index])->whereDate($this->dateColumn, '<=', $datesEnd[$index]);
			$last = $queries[$index];
			
			if($relationCount > 0)
				$last->with($this->relations);

			if($this->columns != null)
				$last->select($this->columns);

			$datesStart[] = clone $datesStart[$index];
			$datesEnd[] = clone $datesEnd[$index];
			$index++;

			$datesStart[$index]->add($this->interval);
			$datesEnd[$index]->add($this->interval);

			if($datesEnd[$index] > $this->dateEnd)
			{
				$datesEnd[$index] = $this->dateEnd;
				$doneLast = true;
			}
		}

		$first = $queries[count($queries)-1];

		for ($i = count($queries)-2; $i >= 0 ; $i--) { 
			$query = $queries[$i];
			if($query != $first)
				$first->union($query);
		}

		return $last->get();
	}

	/**
	 * Get the labels, must be called after getData().
	 *
	 * @return array
	 */
	public function getLabels()
	{
		return $this->labels;
	}

}