Introduction
============

Notebook is a lightweight UI for browsing Markdown documents.  It uses PHP and [Parsedown](http://parsedown.org) (which must be downloaded separately to `lib/php/parsedown.php`) to read in `.md` files from the same directory.  A table of contents is also generated in the left sidebar.


Server setup
============

The `notes.php` script needs to accept all requests for your site domain or subdirectory.  It will match URLs (by default, expecting `/notes/<note>`) if a corresponding `<note>.md` file exists, or generate a 404 otherwise.

Configuring all requests to go to the same script will vary by server software.  Example for nginx:

```
location ~ ^/notes/notes.php$ {
    # enable PHP FastCGI
}
location ~ ^/notes/res/ {
    # noop (handle normally)
}
location ~ ^/notes/ {
    # redirect to notes.php
    rewrite .* /notes/notes.php last;
}
```
