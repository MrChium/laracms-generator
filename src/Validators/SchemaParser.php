<?php
/**
 * LaraCMS - CMS based on laravel
 *
 * @category  LaraCMS
 * @package   Laravel
 * @author    Cmspackage <qqiu@qq.com>
 * @date      2018/11/17 12:12:00
 * @copyright Copyright 2018 LaraCMS
 * @license   https://opensource.org/licenses/MIT
 * @github    https://github.com/myqqiu/laracms
 * @link      https://www.laracms.cn
 * @version   Release 1.0
 */

namespace Cmspackage\Laracms\Generator\Validators;

class SchemaParser
{

    /**
     * The parsed schema.
     *
     * @var array
     */
    private $schema = [];

    /**
     * Parse the command line migration schema.
     * Ex: name:string, age:integer:nullable
     *
     * @param  string $schema
     * @return array
     */
    public function parse($schema)
    {
        $fields = $this->splitIntoFields($schema);

        foreach ($fields as $field) {
            $segments = $this->parseSegments($field);

            $this->addField($segments);
        }

        return $this->schema;
    }

    /**
     * Add a field to the schema array.
     *
     * @param  array $field
     * @return $this
     */
    private function addField($field)
    {
        $this->schema[] = $field;

        return $this;
    }

    /**
     * Get an array of fields from the given schema.
     *
     * @param  string $schema
     * @return array
     */
    private function splitIntoFields($schema)
    {
        return preg_split('/,\s?(?![^()]*\))/', $schema);
    }

    /**
     * Get the segments of the schema field.
     *
     * @param  string $field
     * @return array
     */
    private function parseSegments($field)
    {
        $segments = explode(':', $field);

        $name = array_shift($segments);
        $arguments = $segments;
        // Do we have arguments being used here?
        // Like: string(100)
        return compact('name', 'arguments');
    }

}
