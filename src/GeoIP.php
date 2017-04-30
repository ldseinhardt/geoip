<?php

namespace GeoIP;

class GeoIP extends \GeoIp2\Database\Reader
{
	private $ipAddress;

	private $country;

	private $countryCode;

	private $state;

	private $stateAbbr;

	private $city;

	private $postalCode;

	private $latitude;

	private $longitude;

	private $accuracyRadius;

	private $timeZone;

	public function __construct($ipAddress)
	{
		$database = __DIR__ . '/../db/GeoLite2-City.mmdb';

		if (!file_exists($database)) {
			throw new \Exception('Geo database not found');
		}

		parent::__construct($database);

		$this->setIP($ipAddress);
	}

	public function getIP()
	{
		return $this->ipAddress;
	}

	public function setIP($ipAddress)
	{
		$this->ipAddress = $ipAddress;

		$this->lookup();
	}

	public function lookup($ipAddress = null)
	{
		if ($ipAddress) {
			$this->setIP($ipAddress);
		}

		$record = $this->city($this->ipAddress);

		$this->country = empty($record->country->names['pt-BR'])
			? $record->country->name : $record->country->names['pt-BR'];

		$this->countryCode = $record->country->isoCode;

		$this->state = empty($record->mostSpecificSubdivision->names['pt-BR'])
			? $record->mostSpecificSubdivision->name : $record->mostSpecificSubdivision->names['pt-BR'];

		$this->stateAbbr = $record->mostSpecificSubdivision->isoCode;

		$this->city = empty($record->city->names['pt-BR'])
			? $record->city->name : $record->city->names['pt-BR'];

		$this->postalCode = $record->postal->code;

		$this->latitude = $record->location->latitude;

		$this->longitude = $record->location->longitude;

		$this->accuracyRadius = $record->location->accuracyRadius;

		$this->timeZone = $record->location->timeZone;

		return get_object_vars($this);
	}

	public function __get($attribute)
	{
		return get_object_vars($this)[$attribute] ?? null;
	}

	public function __toString()
	{
		return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);
	}
}