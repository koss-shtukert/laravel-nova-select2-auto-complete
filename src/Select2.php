<?php namespace Koss\LaravelNovaSelect2;

use Illuminate\Support\Str;
use Laravel\Nova\Fields\Select;
use ReflectionClass;

/**
 * Class Select2
 *
 * @package Koss\Select2
 */
class Select2 extends Select
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'select2';

    /**
     * Select2 constructor.
     *
     * @param string      $name
     * @param string|null $attribute
     * @param mixed|null  $resolveCallback
     */
    public function __construct(string $name, ?string $attribute = null, ?mixed $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->setDefaultMeta();
    }

    /**
     * Set the options for the select menu.
     *
     * @param  array $options
     * @return $this
     */
    public function options($options)
    {
        return $this->withMeta([
            'options' => collect($options ?? [])->map(function ($label, $value) {
                return ['text' => $label, 'id' => $value];
            })->values()->all(),
        ]);
    }

    /**
     * Display values using their corresponding specified labels.
     *
     * @return $this
     */
    public function displayUsingLabels()
    {
        return $this->displayUsing(function ($value) {
            return $value;
        });
    }

    /**
     * Set the configuration for the select2.
     *
     * @param $config
     * @return $this
     */
    public function configuration($config)
    {
        return $this->withMeta([
            'config' => $config,
        ]);
    }

    /**
     * @param null $resource
     * @return mixed
     * @throws \ReflectionException
     */
    public function showAsLink($resource = null)
    {
        if ($resource) {
            $resource = new ReflectionClass($resource);
            $resource = Str::lower(Str::plural(Str::kebab($resource->getShortName())));
        }

        return $this->withMeta([
            'showAsLink'     => true,
            'linkToResource' => $resource
        ]);
    }

    /**
     * @return void
     */
    private function setDefaultMeta()
    {
        $this->withMeta([
            'options'        => [],
            'config'         => [],
            'showAsLink'     => false,
            'linkToResource' => null
        ]);
    }
}
