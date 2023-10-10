<?php
require_once __DIR__ . "/lib/config.php";
require_once __DIR__ . "/lib/pdo.php";
require_once __DIR__ . "/lib/article.php";
require_once __DIR__ . "/lib/session.php";
require_once __DIR__ . "/templates/header.php";


//@todo On doit récupérer l'id en paramètre d'url et appeler la fonction getArticleById récupérer l'article

$id = $_GET['id'];
$article = getArticleById($pdo, $id);
if ($article['image'] == null) {
    $article['image'] = "assets/images/default-article.jpg";
}
?>


<div class="row flex-lg-row-reverse align-items-center g-5 py-5">
    <div class="col-10 col-sm-8 col-lg-6">
        <img src="<?php echo _ARTICLES_IMAGES_FOLDER_.$article['image'] ?>" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
    </div>
    <div class="col-lg-6">
        <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3"><?php echo $article['title']?></h1>
        <p class="lead"><?php echo $article['content'] ?></p>
    </div>
</div>


<?php require_once __DIR__ . "/templates/footer.php"; ?>