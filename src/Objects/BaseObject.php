<?php declare(strict_types=1);

namespace KeironLowe\Chirp\Objects;

class BaseObject
{


    /**
     * The object data.
     *
     * @var array<mixed>
     */
    protected $data;


    /**
     * Creates a new instance of BaseObject
     *
     * @param array<mixed> $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }


    /**
     * Returns the raw data object.
     *
     * @return array<mixed>
     */
    public function getRawData(): array
    {
        return $this->data;
    }


    /**
     * Returns the requested snake_case as camelCase property
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        $property = $this->camelCaseToSnakeCase($name);
        return $this->data[$property] ?? null;
    }


    /**
     * Sets the property on our instance.
     *
     * @param string $name
     * @param mixed $data
     * @return mixed
     */
    public function __set(string $name, $data)
    {
        $property = $this->camelCaseToSnakeCase($name);
        return $this->data[$property] = $data;
    }


    /**
     * Converts a snake case string to camel case.
     *
     * @param string $name
     * @return string
     */
    private function camelCaseToSnakeCase(string $name): string
    {
        return strtolower(preg_replace('/\B([A-Z])/', '_$1', $name));
    }
}
