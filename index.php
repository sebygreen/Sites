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
            <div id="left">
                <h1>Apache webroot</h1>
                <div id="information">
                    <p id="site-version">Version <span>0.6.1</span></p>
                    <p id="apache-version"><?= $_SERVER["SERVER_SOFTWARE"]; ?> <span>&bull;</span> PHP <?= phpversion(); ?></p>
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
            </div>
            <div id="right">
                <a target="_blank" href="/info.php">phpinfo()</a>
                <button>
                    <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                        <title>Sunny</title>
                        <path d="M256 118a22 22 0 01-22-22V48a22 22 0 0144 0v48a22 22 0 01-22 22zM256 486a22 22 0 01-22-22v-48a22 22 0 0144 0v48a22 22 0 01-22 22zM369.14 164.86a22 22 0 01-15.56-37.55l33.94-33.94a22 22 0 0131.11 31.11l-33.94 33.94a21.93 21.93 0 01-15.55 6.44zM108.92 425.08a22 22 0 01-15.55-37.56l33.94-33.94a22 22 0 1131.11 31.11l-33.94 33.94a21.94 21.94 0 01-15.56 6.45zM464 278h-48a22 22 0 010-44h48a22 22 0 010 44zM96 278H48a22 22 0 010-44h48a22 22 0 010 44zM403.08 425.08a21.94 21.94 0 01-15.56-6.45l-33.94-33.94a22 22 0 0131.11-31.11l33.94 33.94a22 22 0 01-15.55 37.56zM142.86 164.86a21.89 21.89 0 01-15.55-6.44l-33.94-33.94a22 22 0 0131.11-31.11l33.94 33.94a22 22 0 01-15.56 37.55zM256 358a102 102 0 11102-102 102.12 102.12 0 01-102 102z" />
                    </svg>
                </button>
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
                                        <title>Eye</title>
                                        <circle cx="256" cy="256" r="64" />
                                        <path
                                            d="M490.84 238.6c-26.46-40.92-60.79-75.68-99.27-100.53C349 110.55 302 96 255.66 96c-42.52 0-84.33 12.15-124.27 36.11-40.73 24.43-77.63 60.12-109.68 106.07a31.92 31.92 0 00-.64 35.54c26.41 41.33 60.4 76.14 98.28 100.65C162 402 207.9 416 255.66 416c46.71 0 93.81-14.43 136.2-41.72 38.46-24.77 72.72-59.66 99.08-100.92a32.2 32.2 0 00-.1-34.76zM256 352a96 96 0 1196-96 96.11 96.11 0 01-96 96z"
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
