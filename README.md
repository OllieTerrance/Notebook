# Notebook

Notebook is a lightweight UI for browsing Markdown documents.  It reads in `.md` files from the working directory, creating pages of rendered documents.  A table of contents is also generated in the left sidebar.

## Requirements

* [Parsedown](http://parsedown.org)

## Server setup

The `notes.php` script needs to accept all requests for your site domain or subdirectory.  It will match URLs (expecting, for example, `/notes/<note>`) if a corresponding `<note>.md` file exists, or generate a 404 otherwise.

Add your notes to the directory accessible on your site.  Copy or symlink to `notes.php` and the `res` directory.

Configuring all requests to go to the same script will vary by server software.  Example for `/notes/` with nginx:

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

## Custom author/footer

Instead of linking directly to `notes.php`, create a separate file of that name:

```php
<?php
$author = "Your Name";
$footer = "A short sentence for the footer.";
require_once "/path/to/notes.php";
```
