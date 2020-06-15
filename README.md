# International House Helsinki

## Details for SSH/SFTP

```
USER: ihhelsinki
HOST: ihhelsinki.fi-h.seravo.com
PORT: 10220
```

## Configure SSH-access to production
Please see [Docs](https://seravo.com/docs/get-started/configure-ssh/) to configure your keys to the production.

## Set a production-remote

```
$ git remote add production ssh://ihhelsinki@ihhelsinki.fi-h.seravo.com:10220/data/wordpress
```

After you have committed your changes you can deploy them to `production` origin:

```
$ git push --force production master
```

## Documentation

You can find technical documentation at https://seravo.com/docs/

## Source code

This site is based on our open sourced WordPress layout: https://github.com/Seravo/wordpress

## How to get help

### Option 1: Open an issue in github

Open a new issue at https://github.com/Seravo/wordpress/issues/

### Option 2: Email us

Send email at help@seravo.com
