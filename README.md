# dot-notation
Dot notation support for JSON-like syntax for easily creating arrays in PHP.

## Installation
Add the latest version of dot-notation to your ```composer.json```

```json
{
    "require": {
        "pecee/dot-notation": "1.*"
    },
    "require-dev": {
        "pecee/dot-notation": "1.*"
    }
}
```

## Example

This example returns an array from a basic dot formatted string, simular to the JSON syntax:

```php
$d = new \Pecee\DotNotation(['one' => ['two' => 2]]);
echo $d->getValues();
```

**output:**

```php
['one' => ['two' => 2]]
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
