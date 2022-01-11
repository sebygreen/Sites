<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Web Root</title>
        <link href="style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>

        <div class="content-container">
            <header>
                <h1>User Web Root</h1>
                <div id="information">
                    <p id="site-version">Version <span>0.1.0</span></p>
                    <p id="apache-version"><?= apache_get_version(); ?></p>
                </div>
                
                <div id="links">
                    <?php
                        class Link {
                            // Properties
                            public $url;
                            public $turl;
                            public $name;
                            // Constructor
                            public function __construct($url, $name) {
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
                            '<a target="_blank" href="'.$link->url.'">
                                <div class="header-link">
                                    <img src="https://icon.horse/icon/'.$link->turl.'" alt="'.$link->turl.' icon">
                                    <p>'.$link->name.'</p>
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
                        function nameToIcon($name) {
                            $imgs = glob("./$name/favicon.{png,ico}", GLOB_BRACE);

                            if ($imgs != '') {
                                $path = $imgs[0];
                            }
                            else {
                                $path = "./favicon.ico";
                            }
                            return $path;
                        }

                        function nameToSize($name) {
                            $size = 0;
                            foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($name)) as $file){
                                $size+=$file->getSize();
                            }
                            return sizeToSymbol($size);
                        }

                        function sizeToSymbol($bytes) {
                            $symbols = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
                            $exp = floor(log($bytes)/log(1024));
                        
                            return sprintf('%.2f '.$symbols[$exp], ($bytes/pow(1024, floor($exp))));
                        }


                        class Project {
                            //Properties
                            public $name;
                            public $url;
                            public $icon;
                            public $size;

                            // Constructor
                            public function __construct($name) {
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
                                <img src="'.$project->icon.'" alt="'.$project->name.' icon">
                                <div class="site-metadata">
                                    <h3>'.$project->name.'</h3>
                                    <h4>'.$project->url.'</h4>
                                    <p>'.$project->size.'</p>
                                </div>
                                <a target="_blank" href="'.$project->url.'">
                                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <g stroke-linecap="round" stroke-width="2" stroke="#fff" fill="none" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8 -4 8-11 8 -11-8-11-8Z"/>
                                            <path d="M12 9a3 3 0 1 0 0 6 3 3 0 1 0 0-6Z"/>
                                        </g>
                                    </svg>
                                </a>
                            </div>';
                        }
                    ?>
                </div>
                
            </section>

        </div>
        
    </body>
</html>