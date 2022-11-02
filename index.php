<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webroot</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script src="script.js"></script>
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
                            <div class="link">
                                <p>' . $link->name . '</p>
                                <img src="https://icon.horse/icon/' . $link->turl . '" alt="' . $link->turl . ' icon">
                            </div>
                        </a>';
                    }
                    ?>
                </div>
            </div>
            <div id="right">
                <a class="button" target="_blank" href="/info.php">phpinfo();</a>
                <button class="button" id="theme-toggle" title="Toggles light & dark themes." aria-label="auto" aria-live="polite">
                    <svg class="sun-moon" aria-hidden="true" width="22" height="22" viewBox="0 0 24 24">
                        <mask class="moon" id="moon-mask">
                            <rect x="0" y="0" width="100%" height="100%" fill="white" />
                            <circle cx="24" cy="10" r="6" fill="black" />
                        </mask>
                        <circle class="sun" cx="12" cy="12" r="6" mask="url(#moon-mask)" fill="currentColor" />
                        <g class="sun-beams" stroke="currentColor">
                            <line x1="12" y1="1" x2="12" y2="3" />
                            <line x1="12" y1="21" x2="12" y2="23" />
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
                            <line x1="1" y1="12" x2="3" y2="12" />
                            <line x1="21" y1="12" x2="23" y2="12" />
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
                        </g>
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
                        $path = '<img src="' . $imgs[0] . '" alt="' . $name . ' icon">';
                    } else {
                        $path = '<svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path d="M408,96H252.11a23.89,23.89,0,0,1-13.31-4L211,73.41A55.77,55.77,0,0,0,179.89,64H104a56.06,56.06,0,0,0-56,56v24H464C464,113.12,438.88,96,408,96Z"></path>
                                    <path d="M423.75,448H88.25a56,56,0,0,1-55.93-55.15L16.18,228.11l0-.28A48,48,0,0,1,64,176h384.1a48,48,0,0,1,47.8,51.83l0,.28L479.68,392.85A56,56,0,0,1,423.75,448ZM479.9,226.55h0Z"></path>
                                </svg>';
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
                    '<div class="project">
                        <div class="left">
                            ' . $project->icon . '
                            <h3>' . $project->name . '</h3>
                            <h4>' . $project->url . '</h4>
                        </div>
                        <div class="right">
                            <a class="link-alt" target="_blank" href="' . $project->url . '">
                                    <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" class="ionicon" height="24" width="24" viewBox="0 0 512 512">
                                        <circle cx="256" cy="256" r="64" />
                                        <path
                                            d="M490.84 238.6c-26.46-40.92-60.79-75.68-99.27-100.53C349 110.55 302 96 255.66 96c-42.52 0-84.33 12.15-124.27 36.11-40.73 24.43-77.63 60.12-109.68 106.07a31.92 31.92 0 00-.64 35.54c26.41 41.33 60.4 76.14 98.28 100.65C162 402 207.9 416 255.66 416c46.71 0 93.81-14.43 136.2-41.72 38.46-24.77 72.72-59.66 99.08-100.92a32.2 32.2 0 00-.1-34.76zM256 352a96 96 0 1196-96 96.11 96.11 0 01-96 96z"
                                        />
                                    </svg>
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
