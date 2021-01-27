# processor-strip-null

[![Build Status](https://dev.azure.com/keboola-dev/processor-strip-null/_apis/build/status/keboola.processor-strip-null?branchName=main)](https://dev.azure.com/keboola-dev/processor-strip-null/_build/latest?definitionId=60&branchName=main)

Strips [Null terminator character](https://en.wikipedia.org/wiki/Null_character) from data. Takes all CSV files 
(or sliced tables) in `/data/in/tables` and `/data/in/files`, removes all null terminators and stores 
them in `/data/out/tables` or `/data/out/files`. Manifests (if present) are copied without any change. 
Sliced files are supported.

# Usage
The processor has no configuration options:

## Cleanup

```
{
    "definition": {
        "component": "keboola.processor-strip-null"
    },
    "parameters": {}
}
```

For more information about processors, please refer to [the developers documentation](https://developers.keboola.com/extend/component/processors/).

## Development

Clone this repository and init the workspace with following command:

```
git clone https://github.com/keboola/processor-iconv
cd processor-iconv
docker-compose build
docker-compose run --rm dev composer install --no-scripts
```

Run the test suite using this command:

```
docker-compose run --rm dev composer tests
```

# Integration

For information about deployment and integration with KBC, please refer to the [deployment section of developers documentation](https://developers.keboola.com/extend/component/deployment/)
