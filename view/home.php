<?php
session_start();

$currentLang = isset($_GET['lang']) ? $_GET['lang'] : 'en';
$langFilePath = __DIR__ . '/../lang/' . $currentLang . '.php';

if (file_exists($langFilePath)) {
    include $langFilePath;
} 
?>

<!DOCTYPE html>
<html lang=<?php echo $currentLang ?>>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        JobEase
    </title>

    <link rel="stylesheet" href="/assets/styles/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <header>


        <nav class="navbar navbar-expand-md navbar-dark">
            <div class="container">
                <!-- Brand/logo -->
                <a class="navbar-brand" href="#">
                    <i class="fas fa-code"></i>
                    <h1>JobEase &nbsp &nbsp</h1>
                </a>

                <!-- Toggler/collapsibe Button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar links -->
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Features</a>
                        </li>
                        <?php if (isset($_SESSION['id'])) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="?route=notification">Notifications</a>

                            </li>
                            <?php
                        }
                        ?>
                        <li class="nav-link ">
                            <div class="dropdown">
                                <a class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Language
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="?lang=fr">FR</a>
                                    <a class="dropdown-item" href="?lang=en">EN</a>
                                </div>
                            </div>
                        </li>

                        <span class="nav-item active">
                            <a class="nav-link" href="#">EN</a>
                        </span>
                        <li class="nav-item">
                            <?php if (isset($_SESSION['id'])) { ?>
                                <a class="nav-link" href="?route=logout">Logout</a>
                            <?php } else { ?>
                                <a class="nav-link" href="?route=login">Login</a>


                            <?php } ?>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </header>




    <section class="search">
        <h2><?php echo $lang['title']; ?></h2>
        <form class="form-inline" method="post" onsubmit="event.preventDefault(); filterjob();">
            <div class="form-group mb-2">
                <input type="text" id="title" placeholder="Keywords">


            </div>
            <div class="form-group mx-sm-3 mb-2">
                <input type="text" id="location" placeholder="Location">
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <input type="text" id="company" placeholder="Company">
            </div>
            <a href="?route=search">
                <button type="submit" class="btn btn-primary mb-2">
                    <?php echo $lang['search']; ?>
                </button>
            </a>


        </form>
    </section>

    <div id="results">

        <!--------------------------  card  --------------------->
        <section class="light">
            <h2 class="text-center py-3"><?php echo $lang['latest']; ?></h2>
            <div class="container py-2">
                <?php foreach ($allOffres as $offre): ?>


                <article class="postcard light green">
                    <a class="postcard__img_link" href="#">
                        <?php
                        $imagePath = "/assets/img/" . $offre['image_path'];
                        ?>
                        <img class="postcard__img" src="<?php echo $imagePath; ?>" alt="Image Title" />
                    </a>
                    <div class="postcard__text t-dark">
                        <h3 class="postcard__title green"><a href="#">
                                <?php echo $offre['title']; ?>
                            </a></h3>
                        <div class="postcard__subtitle small">
                            <time datetime="2020-05-25 12:00:00">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <?php echo $offre['company']; ?>
                            </time>
                        </div>
                        <div class="postcard__bar"></div>
                        <div class="postcard__preview-txt">
                            <?php echo $offre['description']; ?>
                        </div>
                        <ul class="postcard__tagbox">
                            <li class="tag__item"><i class="fas fa-tag mr-2"></i>
                                <?php echo $offre['location']; ?>
                            </li>
                            <li class="tag__item"><i class="fas fa-clock mr-2"></i>55 mins.</li>
                            <li class="tag__item play green">
                                <a
                                    href="<?php echo isset($_SESSION['id']) ? '?route=postuleroffre&id=' . $offre['job_id'] : '?route=login'; ?>">
                                    <i class="fas fa-play mr-2"></i>
                                    <?php echo isset($_SESSION['id']) ? 'POSTULER' : 'APPLY NOW'; ?>
                                </a>


                            </li>
                        </ul>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </section>
    </div>




    <footer>
        <p>© 2023 JobEase </p>
    </footer>
</body>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

<script src="/assets/js/script.js"></script>

</html>