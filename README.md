# QueryBuilder

Proof of concept stage

## Features
1. A number of advantages over strings manipulation
2. Different converters (MySQL, PostgreSQL, Oracle, etc)
3. `pure` and `pretty` modes

## Implemenations mailstones

1. Domain models which are used to create SQL query
2. The models understand a _raw sql fragments_
3. `Query` class takes a completed _raw sql query_ and transforms it into the domain models for future monipulations

## TODO
1. API
2. Validation