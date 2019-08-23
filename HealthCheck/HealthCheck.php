<?php

namespace FT\HealthCheckBundle\HealthCheck;

use \DateTime;

/**
 * This class represents the data that makes up a single FT health check.
 */
class HealthCheck
{   
    /**
     * Internal container for health check data 
     *
     * @var array
     */
    protected $check;

    public function __construct()
    {
        //Define optional params
        $this->check = [
            'lastUpdated' => new DateTime(),
            'checkOutput' => '',
            'panicGuide' => ''
        ];
    }

    /**
     * An identifier for this check, unique for the given System Code.  Must only consist of lowercase alphanumeric characters and hyphens.
     *
     * @param string $id
     * @return HealthCheck
     */
    public function withId(string $id): HealthCheck
    {
        $this->check['id'] = $id;
        return $this;
    }

    /**
     * Human readable name for the health check (Must be unique)
     *
     * @param string $name
     * @return HealthCheck
     */
    public function withName(string $name): HealthCheck
    {
        $this->check['name'] = $name;
        return $this;
    }

    /**
     * Whether the check is currently passing.
     *
     * @param boolean $ok
     * @return HealthCheck
     */
    public function withOk(bool $ok): HealthCheck
    {
        $this->check['ok'] = $ok;
        return $this;
    }

    /**
     * An expression of the scale of impact that the problem will cause.  Must be an integer set to one of the following values:
     *  - 1 (high): Critical Issue with serious impact to the editorial team or user (e.g database is down).
     *  - 2 (Medium): Serious issue that can be tolerated for a short duration of time. This can involve lowed redundancy or minimal user impact.
     *  - 3 (low): Minor fault. No end user impact and no major risk caused by this alert.
     * @param integer $severity
     * @return HealthCheck
     */
    public function withSeverity(int $severity): HealthCheck
    {
        $this->check['severity'] = $severity;
        return $this;
    }

    /**
     * Description of the effect of the problem on the business operations of the FT; which features are affected, and how it might affect our internal users or external customers.
     * It should consist of a few sentences, not more than a short paragraph and should make sense to anyone in IT and the relevant Business unit.
     * There can be cases where this is simply “None” in the case of a redundant system failure.
     * The business impact must be understandable to a non-technical reader.
     *
     * @param string $businessImpact
     * @return HealthCheck
     */
    public function withBusinessImpact(string $businessImpact): HealthCheck
    {
        $this->check['businessImpact'] = $businessImpact;
        return $this;
    }

    /**
     * Technical summary which may include information about the test being done, the potential problem from a technical perspective, and the systems that are involved, giving context to the issue.
     * This is the most freeform alert property, and can be used by the alert author to pass over any relevant technical information to help the reader understand the way the application is set up.
     *
     * @param string $technicalSummary
     * @return HealthCheck
     */
    public function withTechnicalSummary(string $technicalSummary): HealthCheck
    {
        $this->check['technicalSummary'] = $technicalSummary;
        return $this;
    }

    /**
     * A set of steps that may be carried out by a support engineer to further diagnose and potentially resolve the issue.
     *
     * @param string $panicGuide
     * @return HealthCheck
     */
    public function withPanicGuide(string $panicGuide): HealthCheck
    {
        $this->check['panicGuide'] = $panicGuide;
        return $this;
    }

    /**
     *  Console output, exception message or debug data generated by the test.
     *
     * @param string $checkOutput
     * @return HealthCheck
     */
    public function withCheckOutput(string $checkOutput): HealthCheck
    {
        $this->check['checkOutput'] = $checkOutput;
        return $this;
    }

    /**
     * The time and date at which the check was last assessed. (Defaults to the time that a test was created)
     *
     * @param DateTime $panicGuide
     * @return HealthCheck
     */
    public function withLastUpdated(DateTime $lastUpdated): HealthCheck
    {
        $this->check['lastUpdated'] = $lastUpdated;
        return $this;
    }

    /**
     * Gets if the health check passed or not
     *
     * @return bool
     */
    public function passed() : bool{
        return $this->check['ok'];
    }

    /**
     * Returns an associative array containing all the relevant data surrounding the health check
     *
     * @return array
     */
    public function getHealthCheckArray(): array
    {
        $check = $this->check;

        if($check['lastUpdated'] instanceof DateTime){
            $check['lastUpdated'] = $check['lastUpdated']->format(DateTime::ATOM);
        }

        return $check;
    }
}
