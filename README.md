# test-oauth-currencies

## Usage

> *Pay attention, docker and docker-compose must be installed to use commands below.*
>
> *All commands should be run in UNIX-like terminal.*


### Install project
```shell
$ git clone [repo]
$ make init && make start
```

### oauth
[enter](http://localhost:8000)

### For avoid oauth login open
[currencies](http://localhost:8000/currencies?userData%5Bsurname%5D=test&userData%5Bemail%5D=test%40gmail.com&userData%5Bphone%5D=123&userData%5Baccount_id%5D=1&userData%5Bfirstname%5D=test&accessToken=test)