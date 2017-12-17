# pecee/dot-notation
Dot notation support for JSON-like syntax for easily creating and mapping arrays in PHP.

## Installation
Run the following command in terminal to add the latest version of pecee/dot-notation library to your project.

```
composer require pecee/dot-notation
```

## Examples

This example returns an array from a basic dot formatted string, similar to the JSON syntax:

```php
$d = new \Pecee\DotNotation(['one' => ['two' => 2]]);
$d->set('one.two', 3);
echo $d->getValues();
```

**Output:**

```php
array ('one' => ['two' => 3]);
```

### Easily map one array to another

```php
class CustomerMapper {

    protected $customer;

    public function __construct(array $values) {
    
        // Map fields (from -> to)
    
        $this->customer = $this->map($values, [
            'customerId' => 'id',
            'relationshipStatus' => 'relationship_status',
            'customerGender' => 'gender',
            'meta.name' => 'name',
        ]);
    }

    protected function map(array $input, array $mapping) {
        $output = array();
    
        foreach($mapping as $before => $after) {
    
            $map = new DotNotation($input);
            $value = $map->get($before);
    
            $map = new DotNotation($output);
            $map->set($after, $value);
            $output = $map->getValues();
        }
    
        return $output;
    }
    
    protected function getCustomer() {
        return $this->customer;
    }
}

// Example:

$mapper = new CustomerMapper([
    'customerId' => 123456,
    'relationshipStatus' => 'single',
    'customerGender' => 'male',
    'meta' => ['name' => 'Peter']
]);

$customer = $mapper->getCustomer();
```

**Output:**

```php
array(
    'id' => 123456,
    'relationship_status' => 'single',
    'gender' => 'male',
    'name' => 'Peter',
);
```

### Credits
elfet

## The MIT License (MIT)

Copyright (c) 2016 Simon Sessingø / pecee

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.