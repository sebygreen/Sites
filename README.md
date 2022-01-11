# Local User Root GUI
A small interface for a local Apache developement environment.

![Screenshot](preview.png)

## Context
A few years ago, I stumbled upon a blog article explaining to me how I good go about setting up a local Apache, PHP and MySQL development server on my machine. This article is the main inspiration for this project.

## Requirements
This small package is comprised of some php files that serve as an interface for the default 'localhost' page, configured during the following of [this](https://getgrav.org/blog/macos-monterey-apache-multiple-php-versions) post. My personal setup has the '~/Sites' directory (masOS) as the main folder, as recomends this article.

## httpd.conf Modifications
I had to make some modifications to the httpd configuration, specifically regarding virtal hosts. This is mainly to allow for the default (home.test for me) url to be served along side the wildcarded project folders the serve my projects.

This is the state of my current httpd-vhosts.conf file.
```apacheconf
<VirtualHost *:80>
    DocumentRoot "/Users/[your_user]/Sites"
    ServerName localhost
    ServerAlias home.test
    ErrorLog "/usr/local/var/log/httpd/error_log"
    CustomLog "/usr/local/var/log/httpd/access_log" common
</VirtualHost>

<Directory "/Users/[your_user]/Sites">
    Allow From All
    AllowOverride All
    Options +Indexes
    Require all granted
</Directory>

<Virtualhost *:80>
    VirtualDocumentRoot "/Users/[your_user]/Sites/%1"
    ServerAlias *.test
    UseCanonicalName Off
</Virtualhost>
```
My configuration will allow 'home.test' to be served, as well as '[folder_name].test'.

## Installation
All that is needed, is too install and configure the local server, and drop the php files into said folder. From there, creating a static project only requires the creation of a new folder. The favicon will be picked up automatically.

Editing the links can be done in the index.php file.
