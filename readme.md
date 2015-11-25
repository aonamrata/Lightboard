
Light Bulb (multi user game)

1. Clone this project on your local from https://github.com/aonamrata/Lightboard.git
2. Set a Vhost on apache/nginix server . EG:
```
Listen 90
NameVirtualHost *:90

<VirtualHost *:90>
    
    DocumentRoot "PATH TO /public_html"
    ServerName lightboard.local
	DirectoryIndex index.php
	<Directory "PATH TO /public_html">
		Require local
	</Directory>
</VirtualHost>

```

3. Create the tables by executing: mydatabase.sql
-- the creds are used in lightbox.php and locking.php

4. All set. You can access the site using 