<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateInterval;

class MetricsBuilder
{

	private $dateStart;
	private $dateEnd;
	private $table;
	private $columns;
	private $relation;
	private $relationId;
	private $relationRelatedId;
	private $interval;
	private $format;
	private $labels;
	private $dateColumn;
	private $group;
	private $duration;
	private $restrictive;

	/**
	 * Create a new MetricsBuilder instance
	 *
	 * @return void
	 */
	public function __construct($dateStart, $dateEnd, $table)
	{
		$this->dateStart = new DateTime($dateStart);
		$this->dateEnd = new DateTime($dateEnd);
		$this->table = $table;
		$this->labels = [];
		$this->dateColumn = "created_at";
		$this->columns = '*';
		$this->restrictive = true;
	}

	/**
	 * Set the column used for grouping
	 *
	 * @param string $group
	 * @return MetricsBuilder
	 */
	public function groupBy($group)
	{
		$this->group = $group;
		return $this;
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
	 * Set the selected columns, passed to selectRaw()
	 *
	 * @param $columns
	 * @return MetricsBuilder
	 */
	public function select($columns)
	{
		$this->columns = $columns;
		return $this;
	}

	/**
	 * Set the selected columns, passed to selectRaw()
	 *
	 * @param $columns
	 * @return MetricsBuilder
	 */
	public function duration($limitColumn)
	{
		$this->duration = $limitColumn;
		return $this;
	}

	/**
	 * Add a relation to be included
	 *
	 * @param string $relation
	 * @return MetricsBuilder
	 */
	public function with($relation, $id, $relatedId)
	{
		$this->relation = $relation;
		$this->relationId = $id;
		$this->relationRelatedId = $relatedId;
		return $this;
	}

	/**
	 * Set if the metrics must be restrictive or not. Restrictive metrics will not count records fully between two units.
	 *
	 * @param boolean $restrictive
	 * @return MetricsBuilder
	 */
	public function restrictive($restrictive)
	{
		$this->restrictive = $restrictive;
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

		$queries = [];
		$datesStart = [];
		$datesEnd = [];
		$datesStart[] = clone $this->dateStart;
		$datesEnd[] = clone $this->dateStart;
		$index = 0;
		$doneLast = 0;
		$doneFirst = false;
		$data = [];

		if($this->dateStart == $this->dateEnd)
			$this->dateEnd->add(new DateInterval('P1D'));

		$datesEnd[$index]->add($this->interval);

		while($datesEnd[$index] <= $this->dateEnd && $doneLast < 2)
		{
			$this->labels[] = $datesStart[$index]->format($this->format);

			$queries[] = DB::table($this->table)->selectRaw($this->columns);
			$last = $queries[$index];

			if($this->relation != null)
			{
				$last->leftJoin($this->relation, function($join) use ($datesStart , $datesEnd, $index)
                         {
                             $join->on($this->relationId, '=', $this->relationRelatedId);

                             if($this->duration != null)
                             {

                             	if($this->restrictive)
                             	{
	                             	$join->on($this->dateColumn, '<=', DB::raw("'".$datesStart[$index]->format('Y-m-d H:i:s')."'"));
	                             	$join->on($this->duration, '>=', DB::raw("'".$datesStart[$index]->format('Y-m-d H:i:s')."'"));
	                             	$join->on($this->duration, '>=', DB::raw("'".$datesEnd[$index]->format('Y-m-d H:i:s')."'"));	
                             	}
                             	else 
                             	{
                             		$join->on($this->dateColumn, '<=', DB::raw("'".$datesStart[$index]->format('Y-m-d H:i:s')."'"));
                             		$join->on($this->dateColumn, '<=', DB::raw("'".$datesEnd[$index]->format('Y-m-d H:i:s')."'"));

	                             	$join->on($this->duration, '>=', DB::raw("'".$datesStart[$index]->format('Y-m-d H:i:s')."'"));	
                             	}

                             }
                             else
                             {
                             	$join->on($this->dateColumn, '>=', DB::raw("'".$datesStart[$index]->format('Y-m-d H:i:s')."'"));
                             	$join->on($this->dateColumn, '<=', DB::raw("'".$datesEnd[$index]->format('Y-m-d H:i:s')."'"));
                             }
                         });
			} 
			else
			{
				if($this->duration != null)
                {
                	if($this->restrictive)
                	{
	                	$last->where([
	                		[$this->dateColumn, '<=', DB::raw("'".$datesStart[$index]->format('Y-m-d H:i:s')."'")],
	                		[$this->duration, '>=', DB::raw("'".$datesStart[$index]->format('Y-m-d H:i:s')."'")],
	                		[$this->duration, '>=', DB::raw("'".$datesEnd[$index]->format('Y-m-d H:i:s')."'")]
	                	]);
                	}
                	else
                	{

                		$last->where(function ($query) use ($datesStart, $datesEnd, $index) {
						    $query->where($this->dateColumn, '<=', DB::raw("'".$datesStart[$index]->format('Y-m-d H:i:s')."'"))
						        ->orWhere($this->dateColumn, '<=', DB::raw("'".$datesEnd[$index]->format('Y-m-d H:i:s')."'"));
						})->where($this->duration, '>=', DB::raw("'".$datesStart[$index]->format('Y-m-d H:i:s')."'"));
                	}

                }
                else
                {
                	$last->where([
                		[$this->dateColumn, '>=', DB::raw("'".$datesStart[$index]->format('Y-m-d H:i:s')."'")],
                		[$this->dateColumn, '<=', DB::raw("'".$datesEnd[$index]->format('Y-m-d H:i:s')."'")]
                	]);
                }
			}

			if($this->group != null)
				$last->groupBy($this->group);

			$res = $last->get();

			if(!$doneFirst)
			{
				foreach ($res as $value) {
					$data[] = ["label" => $value->name , "data" => [$value->count]];
				}
			}
			else
			{
				$i = 0;
				foreach ($res as $value) {
					$data[$i++]['data'][] = $value->count;
				}
			}

			$datesStart[] = clone $datesStart[$index];
			$datesEnd[] = clone $datesEnd[$index];
			$index++;

			$datesStart[$index]->add($this->interval);
			$datesEnd[$index]->add($this->interval);

			if($datesEnd[$index] > $this->dateEnd)
			{
				$datesEnd[$index] = $this->dateEnd;
				$doneLast++;
			}
			$doneFirst = true;
		}

		return $data;
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