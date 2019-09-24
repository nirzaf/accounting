<?php

/*
 * This file is part of consoletvs/charts.
 *
 * (c) Erik Campobadal <soc@erik.cat>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ConsoleTVs\Charts\Builder;

use Jenssegers\Date\Date;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

/**
 * This is the database class.
 *
 * @author Erik Campobadal <soc@erik.cat>
 */
class Database extends Chart
{
    /**
     * @var Collection
     */
    public $data;

    /**
     * Determines the date column.
     *
     * @var string
     */
    public $date_column;

    /**
     * Determines the date format.
     *
     * @var string
     */
    public $date_format = 'l dS M, Y';

    /**
     * Determines the month format.
     *
     * @var string
     */
    public $month_format = 'F, Y';

    /**
     * Determines the hour format.
     *
     * @var string
     */
    public $hour_format = 'D, M j, Y g A';

    /**
     * Determines the dates language.
     *
     * @var string
     */
    public $language;

    public $preaggregated = false;
    public $aggregate_column = null;
    public $aggregate_type = null;
    public $value_data = [];

    /**
     * Create a new database instance.
     *
     * @param Collection $data
     * @param string $type
     * @param string $library
     */
    public function __construct($data, $type = null, $library = null)
    {
        parent::__construct($type, $library);

        // Set the data
        $this->date_column = 'created_at';

        // Set the language
        $this->language = App::getLocale();

        $this->data = $data;
    }

    /**
     * @param Collection $data
     *
     * @return Database
     */
    public function data($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Set date column to filter the data.
     *
     * @param string $column
     *
     * @return Database
     */
    public function dateColumn($column)
    {
        $this->date_column = $column;

        return $this;
    }

    /**
     * Set fancy date format based on PHP date() function.
     *
     * @param string $format
     *
     * @return Database
     */
    public function dateFormat($format)
    {
        $this->date_format = $format;

        return $this;
    }

    /**
     * Set fancy month format based on PHP date() function.
     *
     * @param string $format
     *
     * @return Database
     */
    public function monthFormat($format)
    {
        $this->month_format = $format;

        return $this;
    }

    /**
     * Set fancy hour format based on PHP date() function.
     *
     * @param string $format
     *
     * @return Database
     */
    public function hourFormat($format)
    {
        $this->hour_format = $format;

        return $this;
    }

    /**
     * Set whether data is preaggregated or should be summed.
     *
     * @param bool $preaggregated
     *
     * @return Database
     */
    public function preaggregated($preaggregated)
    {
        $this->preaggregated = $preaggregated;

        return $this;
    }

    /**
     * Set the Date language that is going to be used.
     *
     * @param string $language
     *
     * @return Database
     */
    public function language($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Set the column in which this program should use to aggregate. This is useful for summing/averaging columns.
     *
     * @param string $aggregateColumn - name of the column to aggregate
     * @param string $aggregateType - type of aggregation (sum, avg, min, max, count, ...)
     *                                Must be Laravel collection commands.
     * @see Illuminate\Support\Collection
     *
     * @return Database
     */
    public function aggregateColumn($aggregateColumn, $aggregateType)
    {
        $this->aggregate_column = $aggregateColumn;
        $this->aggregate_type = $aggregateType;

        return $this;
    }

    /**
     * Group the data hourly based on the creation date.
     *
     * @param int $day
     * @param int $month
     * @param int $year
     * @param bool $fancy
     *
     * @return Database
     */
    public function groupByHour($day = null, $month = null, $year = null, $fancy = false)
    {
        $labels = [];
        $values = [];

        $day = $day ? $day : date('d');
        $month = $month ? $month : date('m');
        $year = $year ? $year : date('Y');

        for ($i = 0; $i < 24; $i++) {
            $hour = ($i < 10) ? "0$i" : "$i";

            $date_get = $fancy ? $this->hour_format : 'd-m-Y H:00:00';

            Date::setLocale($this->language);
            $label = ucfirst(Date::create($year, $month, $day, $hour)->format($date_get));

            $checkDate = "$year-$month-$day $hour:00:00";
            $value = $this->getCheckDateValue($checkDate, 'Y-m-d H:00:00', $label);

            array_push($labels, $label);
            array_push($values, $value);
        }
        $this->labels($labels);
        $this->values($values);

        return $this;
    }

    /**
     * Group the data daily based on the creation date.
     *
     * @param int $month
     * @param int $year
     * @param bool $fancy
     *
     * @return Database
     */
    public function groupByDay($month = null, $year = null, $fancy = false)
    {
        $labels = [];
        $values = [];

        $month = $month ? $month : date('m');
        $year = $year ? $year : date('Y');

        $days = date('t', strtotime("$year-$month-01"));

        Date::setLocale($this->language);

        for ($i = 1; $i <= $days; $i++) {
            $day = ($i < 10) ? "0$i" : "$i";

            $date_get = $fancy ? $this->date_format : 'd-m-Y';

            $label = ucfirst(Date::create($year, $month, $day)->format($date_get));

            $checkDate = "$year-$month-$day";
            $value = $this->getCheckDateValue($checkDate, 'Y-m-d', $label);

            array_push($labels, $label);
            array_push($values, $value);
        }
        $this->labels($labels);
        $this->values($values);

        return $this;
    }

    /**
     * Group the data monthly based on the creation date.
     *
     * @param int  $year
     * @param bool $fancy
     *
     * @return Database
     */
    public function groupByMonth($year = null, $fancy = false)
    {
        $labels = [];
        $values = [];

        $year = $year ? $year : date('Y');

        Date::setLocale($this->language);

        for ($i = 1; $i <= 12; $i++) {
            $month = ($i < 10) ? "0$i" : "$i";

            $date_get = $fancy ? $this->month_format : 'm-Y';

            $label = ucfirst(Date::create($year, $month)->format($date_get));

            array_push($labels, $label);

            $checkDate = "$year-$month";
            $value = $this->getCheckDateValue($checkDate, 'Y-m', $label);

            array_push($values, $value);
        }

        $this->labels($labels);
        $this->values($values);

        return $this;
    }

    /**
     * Group the data yearly based on the creation date.
     *
     * @param int $number
     *
     * @return Database
     */
    public function groupByYear($number = 4)
    {
        $labels = [];
        $values = [];

        for ($i = 0; $i < $number; $i++) {
            $year = ($i == 0) ? date('Y') : date('Y', strtotime('-'.$i.' Year'));

            array_push($labels, $year);

            $checkDate = $year;
            $value = $this->getCheckDateValue($checkDate, 'Y', $year);

            array_push($values, $value);
        }

        $this->labels(array_reverse($labels));
        $this->values(array_reverse($values));

        return $this;
    }

    /**
     * Group the data based on the column.
     *
     * @param string $column
     * @param string $relationColumn
     * @param array $labelsMapping
     *
     * @return Database
     */
    public function groupBy($column, $relationColumn = null, array $labelsMapping = [])
    {
        $labels = [];
        $values = [];

        if ($relationColumn && strpos($relationColumn, '.') !== false) {
            $relationColumn = explode('.', $relationColumn);
        }

        foreach ($this->data->groupBy($column) as $data) {
            $label = $data[0];

            if (is_null($relationColumn)) {
                $label = $label->$column;
            } elseif (is_array($relationColumn)) {
                foreach ($relationColumn as $boz) {
                    $label = $label->$boz;
                }
            } else {
                $label = $data[0]->$relationColumn;
            }

            array_push($labels, array_key_exists($label, $labelsMapping) ? $labelsMapping[$label] : $label);
            array_push($values, count($data));
        }

        $this->labels($labels);
        $this->values($values);

        return $this;
    }

    /**
     * Group the data based on the latest days.
     *
     * @param int  $number
     * @param bool $fancy
     *
     * @return Database
     */
    public function lastByDay($number = 7, $fancy = false)
    {
        $labels = [];
        $values = [];

        Date::setLocale($this->language);

        for ($i = 0; $i < $number; $i++) {
            $date = $i == 0 ? date('d-m-Y') : date('d-m-Y', strtotime("-$i Day"));
            $dt = strtotime($date);
            $date_f = $fancy ? ucfirst(Date::create(date('Y', $dt), date('m', $dt), date('d', $dt))->format($this->date_format)) : $date;
            array_push($labels, $date_f);
            $value = $this->getCheckDateValue($date, 'd-m-Y', $date_f);
            array_push($values, $value);
        }

        $this->labels(array_reverse($labels));
        $this->values(array_reverse($values));

        return $this;
    }

    /**
     * Group the data based on the latest months.
     *
     * @param int  $number
     * @param bool $fancy
     *
     * @return Database
     */
    public function lastByMonth($number = 6, $fancy = false)
    {
        $labels = [];
        $values = [];
        $previousDate = null;
        $day = 1;

        Date::setLocale($this->language);

        for ($i = 0; $i < $number; $i++) {
            $date = $i == 0 ? date('m-Y') : date('m-Y', strtotime("-$i Month"));

            // If the previous date equals the newly calculated date, move the interval by a day and try again.
            // @see edge case 29th of March to 29th of February and 31-03-2017 to 30-11-2016. Put a limit just in case
            // it breaks something.
            while ($date == $previousDate && $day < 4) {
                $date = $i == 0 ? date('m-Y', time() - $day * 86400) : date('m-Y', strtotime("-$i Month") - 86400 * $day);
                $day++;
            }
            $dt = strtotime("01-$date");
            $date_f = $fancy ? ucfirst(Date::create(date('Y', $dt), date('m', $dt), date('d', $dt))->format($this->month_format)) : $date;
            array_push($labels, $date_f);

            $value = $this->getCheckDateValue($date, 'm-Y', $date_f);
            array_push($values, $value);

            // Set the checks for the next round.
            $previousDate = $date;
            $day = 1;
        }

        $this->labels(array_reverse($labels));
        $this->values(array_reverse($values));

        return $this;
    }

    /**
     * Alias for groupByYear().
     *
     * @param int $number
     *
     * @return Database
     */
    public function lastByYear($number = 4)
    {
        return $this->groupByYear($number);
    }

    /**
     * This is a simple value generator for the three types of summations used in this Chart object when sorted via data.
     *
     * @param string $checkDate - a string in the format 'Y-m-d H:ii::ss' Needs to resemble up with $formatToCheck to work
     * @param string $formatToCheck - a string in the format 'Y-m-d H:ii::ss' Needs to resemble up with $checkDate to work
     * @param string $label
     * @return mixed
     */
    private function getCheckDateValue($checkDate, $formatToCheck, $label)
    {
        $date_column = $this->date_column;
        $data = $this->data;
        if ($this->preaggregated) {
            // Since the column has been preaggregated, we only need one record that matches the search
            $valueData = $data->first(function ($value) use ($checkDate, $date_column, $formatToCheck) {
                return $checkDate == date($formatToCheck, strtotime($value->$date_column));
            });
            $value = $valueData !== null ? $valueData->aggregate : 0;
        } else {
            // Set the data represented. Return the relevant value.
            $valueData = $data->filter(function ($value) use ($checkDate, $date_column, $formatToCheck) {
                return $checkDate == date($formatToCheck, strtotime($value->$date_column));
            });

            if ($valueData !== null) {
                // Do an aggregation, otherwise count the number of records.
                $value = $this->aggregate_column ? $valueData->{$this->aggregate_type}($this->aggregate_column) : $valueData->count();
            } else {
                $value = 0;
            }

            // Store the datasets by label.
            $this->value_data[$label] = $valueData;
        }

        return $value;
    }
}
