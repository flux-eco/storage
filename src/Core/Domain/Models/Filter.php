<?php

namespace FluxEco\Storage\Core\Domain\Models;


use Exception;

class Filter
{
    private array $filter;

    private function __construct(array $filter) {
        $this->filter = $filter;
    }

    public static function new(?array $filter = null, array $schema): ?self {

        if(is_null($filter) === true) {
            return null;
        }

        $validatedFilter = [];

        //todo as a own component
        if($filter !== null) {

            foreach($filter as $key => $value) {

                switch($schema['properties'][$key]['type']) {
                    case "string":
                        $validatedFilter[$key] = filter_var($value, FILTER_SANITIZE_STRING);
                        break;
                    case "number":
                        if(filter_var($value, FILTER_VALIDATE_INT) !== true) {
                            throw new Exception('Filter value is not an integer '.$value);
                        }
                        $validatedFilter[$key] = $value;
                        break;
                    case "boolean":
                        if(filter_var($value, FILTER_VALIDATE_BOOLEAN) !== true) {
                            throw new Exception('Filter value is not a boolean '.$value);
                        }
                        $validatedFilter[$key] = $value;
                        break;
                    default:
                        $validatedFilter[$key] = filter_var($value, FILTER_SANITIZE_STRING);;
                        break;
                }

            }

        }
        return new self($validatedFilter);
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return $this->filter;
    }

}