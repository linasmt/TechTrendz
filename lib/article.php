<?php

function getArticleById(PDO $pdo, int $id): array|bool
{
    $query = $pdo->prepare("SELECT * FROM articles WHERE id = :id");
    $query->bindValue(":id", $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function getArticles(PDO $pdo, int $limit = null, int $page = null): array|bool
{

    /*
        @todo faire la requête de récupération des articles
        La requête sera différente selon les paramètres passés, commencer par le BASE de base
    */

    if ($limit == null) {
        $query = $pdo->prepare("SELECT * FROM articles");
    }
    elseif ( $page == null) {
        $query = $pdo->prepare("SELECT * FROM articles LIMIT :limit");
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
    }
    else {
        $offset = 0;
        for ($i = 1; $i < $page; $i++) {
            $offset = $offset + 10;
        }
        $query = $pdo->prepare("SELECT * FROM articles LIMIT :limit OFFSET :offset");
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->bindValue(":offset", $offset, PDO::PARAM_INT);
    }

    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getTotalArticles(PDO $pdo): int|bool
{
    /*
        @todo récupérer le nombre total d'article (avec COUNT)
    */
    $query = $pdo->prepare("SELECT COUNT(*) as total FROM articles");
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}

function saveArticle(PDO $pdo, string $title, string $content, string|null $image, int $category_id, int $id = null): bool
{
    if ($id === null) {
        /*
            @todo si id est null, alors on fait une requête d'insection
        */
        $query = $pdo->prepare("INSERT INTO articles (title, content, image, category_id) VALUES (:title, :content, :image, :category_id)");
    } else {
        /*
            @todo sinon, on fait un update
        */

        $query = $pdo->prepare("UPDATE articles SET title = :title, content = :content, image = :image, category_id = :category_id WHERE id = :id");
        $query->bindValue(":id", $id, PDO::PARAM_INT);
    }

    // @todo on bind toutes les valeurs communes
    $query->bindValue(":title", $title);
    $query->bindValue(":content", $content);
    $query->bindValue(":image", $image);
    $query->bindValue(":category_id", $category_id);
    return $query->execute();
}

function deleteArticle(PDO $pdo, int $id): bool
{

    /*
        @todo Faire la requête de suppression
    */
    $query = $pdo->prepare("DELETE FROM articles WHERE id = :id");
    $query->bindValue(":id", $id, PDO::PARAM_INT);

    $query->execute();
    if ($query->rowCount() > 0) {
        return true;
    } else {
        return false;
    }


}