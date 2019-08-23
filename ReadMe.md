# Health checks
Health checks can be found under the `__health` endpoint. Each health check tests a part of the site continually, and in doing so indicates the overall health of the site.

Health checks in this package conform to the FT Health Check Standard.

## Installation
Add this to your `app/config/routing.yml` config file:
```yml 
FT\HealthCheckBundle:
    resource: "@HealthCheckBundle/Resources/config/routing.yml"
    prefix:   /
```

## Creating a health check
To create a health check you can copy this code under `src/[Your bundle]/Healthchecks/PlaceholderHealthCheck.php`

```php

<?php

namespace YourBundle\HealthCheck;

use FT\HealthCheckBundle\HealthCheck\HealthCheck;
use FT\HealthCheckBundle\Interfaces\HealthCheckHandlerInterface;

class PlaceholderHealthCheck implements HealthCheckHandlerInterface
{
    const HEALTH_CHECK_ID = 'HealthCheck';

    public function __construct(){
        //Inject services as need be to run the healthcheck
    }

    /**
     * @inheritDoc
     */
    public function runHealthCheck(): HealthCheck
    {
        //Run your health check and gather results
        $ok = true;

        $healthCheck = new HealthCheck();

        //See FT\HealthCheckBundle\HealthCheck\HealthCheck for more details on what each of these methods do.

        return $healthCheck
        /* [REQUIRED] An identifier for this check, unique for the given System Code.  Must only consist of lowercase alphanumeric characters and hyphens. */
        ->withId(self::HEALTH_CHECK_ID)

        /* [REQUIRED] Human readable name for the health check (Must be unique) */
        ->withName('The health Check name')

        /* [REQUIRED] Whether the check is currently passing.*/
        ->withOk($ok)

        /* [REQUIRED] An expression of the scale of impact that the problem will cause.  Must be an integer set to one of the following values:
          - 1 (high): Critical Issue with serious impact to the editorial team or user (e.g database is down).
          - 2 (Medium): Serious issue that can be tolerated for a short duration of time. This can involve lowed redundancy or minimal user impact.
          - 3 (low): Minor fault. No end user impact and no major risk caused by this alert.
        */
        ->withSeverity(3)

        /* [REQUIRED] A set of steps that may be carried out by a support engineer to further diagnose and potentially resolve the issue. */
        ->withPanicGuide("Oh no something went wrong... Here is how to possibly fix it!")

        /* [REQUIRED] Technical summary which may include information about the test being done, the potential problem from a technical perspective, and the systems that are involved, giving context to the issue.

        This is the most freeform alert property, and can be used by the alert author to pass over any relevant technical information to help the reader understand the way the application is set up.
        */
        ->withTechnicalSummary("A call to the __placeholder endpoint gave back a 404 error.")

        /*
         [REQUIRED] Description of the effect of the problem on the business operations of the FT, which features are affected, and how it might affect our internal users or external customers.

        It should consist of a few sentences, not more than a short paragraph and should make sense to anyone in IT and the relevant Business unit.

         There can be cases where this is simply “None” in the case of a redundant system failure.

        The business impact must be understandable to a non-technical reader.*/
        ->withBusinessImpact('Users will not be able to see the component and the editorial team cannot edit the component.')
        
        /* Console output, exception message or debug data generated by the test. */
        ->withCheckOutput('Pinging /__placeholder... Response gave non 200 status code! (404)');
    }

    /**
     * @inheritDoc
     */
    public function getHealthCheckId(): string
    {
        //Set this to an identifier unique to the health check
        return self::HEALTH_CHECK_ID;
    }

    /**
     * @inheritDoc
     */
    public function getHealthCheckInterval(): int
    {
        //Set this to how often this health check should be run in seconds. (if 0 will result in health check running every time a request to the __health endpoint is made)
        return 10;
    }
}
```
And add to your `src/[Your Bundle]/Resources/config/services.yml` a service definition for the healthcheck. Change the priority to make health checks appear higher or lower in the __health endpoint. (The larger the priority the higher the check will appear in the list of healthchecks).
```yml
services:
    # Health Checks
    app.placeholder.health_check:
        class: YourBundle\HealthCheck\PlaceholderHealthCheck
        tags: [{ name: health_check, priority: 20 }]
```

## Useful links
- [FT health check formatter for viewing healthchecks in chrome ](https://github.com/Financial-Times/health-status-formatter)