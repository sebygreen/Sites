# localhost Web Server GUI
A small interface for a local Apache developement environment.

![Screenshot](preview.png)

## Context
A few years ago, I stumbled upon a blog entry explaining to me how I could go about setting up a local Apache, PHP and MySQL development server on my machine. This article is the main inspiration for this project.

## Requirements
This small package is comprised of some files that serve as an interface for a local Apache web server. There are many different ways to go about setting up a local server. I followed and currently run [this](https://getgrav.org/blog/macos-monterey-apache-multiple-php-versions) proposed setup.

My personal setup has the '~/Sites' directory (macOS) as the main web folder, as recommends the article. Said folder is where this interface lives, as well as all my ongoing project directories.

### httpd-vhosts.conf
I had to make some modifications to the ```httpd``` configuration, specifically regarding virtual hosts. This is mainly to allow for the default ('home.test' for me) URL to be served alongside the wildcarded project folders that serve my projects.

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
My configuration will allow 'home.test' to be served, as well as '[project_name].test'.

## Installation
All that is needed, is too install and configure the local server environment, and drop the php files into your newly created local web root folder. From there, creating a new static project only requires the creation of a new folder containing an ```index.html``` at minimum, and the homepage should pick up the project from the same directory. A ```favicon.ico``` or ```favicon.png``` will be picked up automatically as well, if there is one.

Editing the links can be done in the index.php file.
