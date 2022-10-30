<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webroot</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>

    <div class="content-container">
        <header>
            <h1>Apache webroot</h1>
            <div id="information">
                <p id="site-version">Version <span>0.6.1</span></p>
                <p id="apache-version"><?= apache_get_version(); ?> <span>&bull;</span> phpversion()</p>
            </div>

            <div id="links">
                <?php
                class Link
                {
                    // Properties
                    public $url;
                    public $turl;
                    public $name;
                    // Constructor
                    public function __construct($url, $name)
                    {
                        $regex = '/(?:(?:http|ftp|https):\/\/)([\w.,@?^=%&:~+#-]+)/i';

                        $this->url = $url;
                        $this->name = $name;
                        preg_match($regex, $url, $turl);
                        $this->turl = $turl[1];
                    }
                }

                // Links to edit. URL, name
                $github = new Link('https://github.com', 'Github');
                $speedtest = new Link('https://speedtest.net', 'Speedtest');
                $getgrav = new Link('https://getgrav.org/blog/macos-monterey-apache-multiple-php-versions', 'GetGrav');

                // Main link array
                $links = [$github, $speedtest, $getgrav];

                foreach ($links as $link) {
                    echo
                    '<a target="_blank" href="' . $link->url . '">
                                <div class="header-link">
                                    <img src="https://icon.horse/icon/' . $link->turl . '" alt="' . $link->turl . ' icon">
                                    <p>' . $link->name . '</p>
                                </div>
                            </a>';
                }
                ?>
            </div>
        </header>
        <section>
            <h2>Projects</h2>
            <div id="projects">
                <?php
                function nameToIcon($name)
                {
                    $imgs = glob("./$name/favicon.{png,ico}", GLOB_BRACE);
                    if ($imgs != null) {
                        $path = $imgs[0];
                    } else {
                        $path = "./folder.svg";
                    }
                    return $path;
                }

                function nameToSize($name)
                {
                    $size = 0;
                    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($name)) as $file) {
                        $size += $file->getSize();
                    }
                    return sizeToSymbol($size);
                }

                function sizeToSymbol($bytes)
                {
                    $symbols = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
                    $exp = floor(log($bytes) / log(1024));

                    return sprintf('%.2f ' . $symbols[$exp], ($bytes / pow(1024, floor($exp))));
                }


                class Project
                {
                    //Properties
                    public $name;
                    public $url;
                    public $icon;
                    public $size;

                    // Constructor
                    public function __construct($name)
                    {
                        $this->name = $name;
                        $this->url = "http://$name.test";
                        $this->icon = nameToIcon($name);
                        $this->size = nameToSize($name);
                    }
                }

                $dirs = array_filter(glob('*'), 'is_dir');
                $projects = array();
                foreach ($dirs as $dir) {
                    array_push($projects, new Project($dir));
                }

                foreach ($projects as $project) {
                    echo
                    '<div class="site-link">
                        <div class="left">
                            <img src="' . $project->icon . '" alt="' . $project->name . ' icon">
                            <h3>' . $project->name . '</h3>
                            <h4>' . $project->url . '</h4>
                        </div>
                        <div class="right">
                            <a target="_blank" href="' . $project->url . '">
                                <div>
                                    <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                                        <title>Code</title>
                                        <path
                                            d="M160 389a20.91 20.91 0 01-13.82-5.2l-128-112a21 21 0 010-31.6l128-112a21 21 0 0127.66 31.61L63.89 256l109.94 96.19A21 21 0 01160 389zM352 389a21 21 0 01-13.84-36.81L448.11 256l-109.94-96.19a21 21 0 0127.66-31.61l128 112a21 21 0 010 31.6l-128 112A20.89 20.89 0 01352 389z"
                                        />
                                    </svg>
                                </div>
                            </a>
                            <p>' . $project->size . '</p>
                        </div>
                    </div>';
                }
                ?>
            </div>

        </section>

    </div>

</body>

</html>
